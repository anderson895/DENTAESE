<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Thin wrapper around the Semaphore (semaphore.co) SMS gateway.
 *
 * Sending is best-effort: hindi kailanman nagta-throw ang class na ito, kaya
 * hindi nasisira ang booking o signup kapag down ang SMS gateway. Naka-log
 * lang ang failure at nagbabalik ng false.
 */
class SemaphoreSms
{
    private const BASE_URL = 'https://api.semaphore.co/api/v4';

    /** Raw reason ng huling pagkabigo, para maipakita ng sms:test command. */
    public ?string $lastError = null;

    /**
     * Send a standard SMS (1 credit per 160 chars).
     */
    public function send(?string $number, string $message): bool
    {
        return $this->dispatch('messages', $number, $message);
    }

    /**
     * Send an OTP over the dedicated OTP channel (2 credits, no rate limit).
     * Ang {otp} placeholder sa message ay pinapalitan ng Semaphore ng $code.
     */
    public function sendOtp(?string $number, string $message, string|int $code): bool
    {
        return $this->dispatch('otp', $number, $message, ['code' => (string) $code]);
    }

    private function dispatch(string $endpoint, ?string $number, string $message, array $extra = []): bool
    {
        $this->lastError = null;

        if (!config('services.semaphore.enabled')) {
            $this->lastError = 'SEMAPHORE_SMS_ENABLED is false.';
            Log::info('Semaphore SMS disabled, skipping send.', ['number' => $number]);
            return false;
        }

        $apiKey = config('services.semaphore.key');
        if (blank($apiKey)) {
            $this->lastError = 'SEMAPHORE_API_KEY is not set.';
            Log::warning('Semaphore SMS skipped: SEMAPHORE_API_KEY is not set.');
            return false;
        }

        $recipient = self::normalize($number);
        if ($recipient === null) {
            $this->lastError = 'Invalid PH mobile number: ' . $number;
            Log::warning('Semaphore SMS skipped: invalid PH mobile number.', ['number' => $number]);
            return false;
        }

        $payload = array_merge([
            'apikey'  => $apiKey,
            'number'  => $recipient,
            'message' => $message,
        ], $extra);

        $senderName = config('services.semaphore.sender_name');
        if (filled($senderName)) {
            $payload['sendername'] = $senderName;
        }

        try {
            $response = Http::timeout((int) config('services.semaphore.timeout', 10))
                ->asForm()
                ->post(self::BASE_URL . '/' . $endpoint, $payload);

            // BABALA: nagbabalik ang Semaphore ng HTTP 200 kahit may error
            // (hal. {"sendername":["The selected sendername is invalid."]}),
            // kaya hindi sapat ang status code — kailangang suriin ang body.
            if (!$this->accepted($response->json())) {
                $this->lastError = $response->body();
                Log::error('Semaphore SMS rejected.', [
                    'endpoint' => $endpoint,
                    'number'   => $recipient,
                    'status'   => $response->status(),
                    'body'     => $response->body(),
                ]);
                return false;
            }

            Log::info('Semaphore SMS sent.', [
                'endpoint' => $endpoint,
                'number'   => $recipient,
            ]);

            return true;
        } catch (\Throwable $e) {
            $this->lastError = $e->getMessage();
            Log::error('Semaphore SMS exception: ' . $e->getMessage(), [
                'endpoint' => $endpoint,
                'number'   => $recipient,
            ]);
            return false;
        }
    }

    /**
     * Tanging tinatanggap na sagot ay isang non-empty na listahan ng mensahe
     * na may message_id. Anumang ibang hugis ay error payload.
     */
    private function accepted(mixed $body): bool
    {
        if (!is_array($body) || $body === [] || !array_is_list($body)) {
            return false;
        }

        foreach ($body as $entry) {
            if (!is_array($entry) || !isset($entry['message_id'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Normalize a Philippine mobile number to Semaphore's 639XXXXXXXXX format.
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

        // Already 639171234567 (also covers +63 and 0063 prefixes after stripping)
        if (strlen($digits) === 12 && str_starts_with($digits, '639')) {
            return $digits;
        }

        if (strlen($digits) === 14 && str_starts_with($digits, '00639')) {
            return substr($digits, 2);
        }

        return null;
    }
}
