<?php

namespace App\Services;

use App\Models\SmsLog;
use Illuminate\Support\Facades\Log;

/**
 * Karaniwang balangkas ng lahat ng SMS driver.
 *
 * Best-effort ang pagpapadala: hindi kailanman nagta-throw palabas, kaya hindi
 * nasisira ang booking o signup kapag may problema sa gateway. Bawat tangka ay
 * naitatala sa sms_logs, kahit naka-off ang pagpapadala.
 */
abstract class SmsGateway
{
    protected ?string $lastError = null;

    /** Dahilan ng huling pagkabigo, ipinapakita ng sms:test command. */
    public function lastError(): ?string
    {
        return $this->lastError;
    }

    public function send(?string $number, string $message, ?string $purpose = null): bool
    {
        return $this->dispatch($number, $message, $purpose, 'messages', null);
    }

    /**
     * Ang {otp} placeholder sa message ang pinapalitan ng aktwal na code sa
     * oras ng pagpapadala. Sinasadyang hindi ito pinapalitan sa naitatalang
     * mensahe para walang buhay na OTP na naiimbak sa database.
     */
    public function sendOtp(?string $number, string $message, string|int $code, ?string $purpose = null): bool
    {
        return $this->dispatch($number, $message, $purpose, 'otp', (string) $code);
    }

    /** Isinasagawa ng bawat driver ang aktwal na paghahatid. */
    abstract protected function deliver(string $recipient, string $message, string $channel, ?string $code): bool;

    protected function dispatch(
        ?string $number,
        string $message,
        ?string $purpose,
        string $channel,
        ?string $code
    ): bool {
        $this->lastError = null;

        // Una ang number check para laging may naitatalang recipient sa log,
        // kahit naka-off ang pagpapadala.
        $recipient = static::normalize($number);

        $record = fn (string $status) => $this->record([
            'purpose'    => $purpose,
            'recipient'  => $recipient,
            'raw_number' => $number,
            'message'    => $message,
            'channel'    => $channel,
            'status'     => $status,
            'error'      => $this->lastError,
        ]);

        if ($recipient === null) {
            $this->lastError = 'Invalid PH mobile number: ' . $number;
            Log::warning('SMS skipped: invalid PH mobile number.', ['number' => $number]);
            $record('failed');
            return false;
        }

        if (!config('services.sms.enabled')) {
            $this->lastError = 'SMS_ENABLED is false.';
            Log::info('SMS disabled, skipping send.', ['number' => $recipient]);
            $record('skipped');
            return false;
        }

        try {
            $sent = $this->deliver($recipient, $message, $channel, $code);
        } catch (\Throwable $e) {
            $this->lastError = $e->getMessage();
            Log::error('SMS exception: ' . $e->getMessage(), ['number' => $recipient]);
            $record('failed');
            return false;
        }

        if ($sent) {
            Log::info('SMS sent.', ['driver' => static::class, 'number' => $recipient]);
        }

        $record($sent ? 'sent' : 'failed');
        return $sent;
    }

    private function record(array $attributes): void
    {
        try {
            SmsLog::create($attributes);
        } catch (\Throwable $e) {
            Log::warning('Could not write sms_logs row: ' . $e->getMessage());
        }
    }

    /**
     * Normalize a Philippine mobile number to 639XXXXXXXXX.
     * Tinatanggap ang 09171234567, 9171234567, +639171234567, 639171234567,
     * at may spaces/dashes. Nagbabalik ng null kapag hindi valid.
     */
    public static function normalize(?string $raw): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $raw);

        if ($digits === '') {
            return null;
        }

        // 09171234567 -> 639171234567
        if (strlen($digits) === 11 && str_starts_with($digits, '09')) {
            return '63' . substr($digits, 1);
        }

        // 9171234567 -> 639171234567
        if (strlen($digits) === 10 && str_starts_with($digits, '9')) {
            return '63' . $digits;
        }

        // Already 639171234567 (also covers +63 after stripping)
        if (strlen($digits) === 12 && str_starts_with($digits, '639')) {
            return $digits;
        }

        if (strlen($digits) === 14 && str_starts_with($digits, '00639')) {
            return substr($digits, 2);
        }

        return null;
    }
}
