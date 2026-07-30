<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Driver para sa Semaphore (semaphore.co) SMS gateway.
 *
 * Kailangan nito ng aprubadong Sender Name sa Semaphore account. Habang walang
 * approved sender name, tinatanggihan ng API ang lahat ng padala.
 */
class SemaphoreSms extends SmsGateway
{
    private const BASE_URL = 'https://api.semaphore.co/api/v4';

    protected function deliver(string $recipient, string $message, string $channel, ?string $code): bool
    {
        $apiKey = config('services.semaphore.key');
        if (blank($apiKey)) {
            $this->lastError = 'SEMAPHORE_API_KEY is not set.';
            return false;
        }

        $payload = [
            'apikey'  => $apiKey,
            'number'  => $recipient,
            'message' => $message,
        ];

        // Pinapalitan ng Semaphore mismo ang {otp} placeholder gamit ang code.
        if ($channel === 'otp' && $code !== null) {
            $payload['code'] = $code;
        }

        $senderName = config('services.semaphore.sender_name');
        if (filled($senderName)) {
            $payload['sendername'] = $senderName;
        }

        $response = Http::timeout((int) config('services.semaphore.timeout', 10))
            ->asForm()
            ->post(self::BASE_URL . '/' . $channel, $payload);

        // BABALA: nagbabalik ang Semaphore ng HTTP 200 kahit may error
        // (hal. {"sendername":["The selected sendername is invalid."]}),
        // kaya hindi sapat ang status code — kailangang suriin ang body.
        if (!$this->accepted($response->json())) {
            $this->lastError = $response->body();
            Log::error('Semaphore SMS rejected.', [
                'channel' => $channel,
                'number'  => $recipient,
                'status'  => $response->status(),
                'body'    => $response->body(),
            ]);
            return false;
        }

        return true;
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
}
