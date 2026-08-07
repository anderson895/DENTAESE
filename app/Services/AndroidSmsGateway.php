<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Driver para sa "SMS Gateway for Android" (sms-gate.app).
 *
 * Isang Android phone na may SIM ang nagpapadala ng SMS. Dahil person-to-person
 * ang mensahe mula sa totoong subscriber SIM, WALANG kailangang registered
 * Sender ID — kaya gumagana ito kahit hindi pa aprubado ang Semaphore sender
 * name. Ang makikita ng pasyente ay ang numero ng SIM, hindi ang "DENTAEASE".
 *
 * Local Server mode: POST http://<ip-ng-telepono>:8080/message, Basic Auth.
 */
class AndroidSmsGateway extends SmsGateway
{
    protected function deliver(string $recipient, string $message, string $channel, ?string $code): bool
    {
        $baseUrl  = rtrim((string) config('services.android_sms.url'), '/');
        $username = (string) config('services.android_sms.username');
        $password = (string) config('services.android_sms.password');

        if ($baseUrl === '') {
            $this->lastError = 'ANDROID_SMS_URL is not set.';
            return false;
        }

        // Walang server-side templating ang Android gateway, kaya dito na
        // pinapalitan ang {otp}. Hindi ito naaapektuhan ang naitatalang mensahe.
        if ($channel === 'otp' && $code !== null) {
            $message = str_replace('{otp}', $code, $message);
        }

        $response = Http::timeout((int) config('services.android_sms.timeout', 15))
            ->withBasicAuth($username, $password)
            ->acceptJson()
            ->post($baseUrl . '/message', [
                'textMessage'  => ['text' => $message],
                'phoneNumbers' => ['+' . $recipient],
            ]);

        if ($response->failed()) {
            $this->lastError = 'HTTP ' . $response->status() . ' - ' . trim($response->body());
            Log::error('Android SMS gateway rejected.', [
                'number' => $recipient,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;
        }

        return true;
    }
}
