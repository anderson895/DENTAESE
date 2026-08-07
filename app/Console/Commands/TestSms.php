<?php

namespace App\Console\Commands;

use App\Services\SmsGateway;
use Illuminate\Console\Command;

class TestSms extends Command
{
    protected $signature = 'sms:test {number : PH mobile number, e.g. 09171234567}
                                     {--message= : Custom message body}';

    protected $description = 'Send a test SMS through the configured gateway';

    public function handle(SmsGateway $sms): int
    {
        $number = $this->argument('number');
        $normalized = SmsGateway::normalize($number);

        if ($normalized === null) {
            $this->error("Invalid PH mobile number: {$number}");
            return self::FAILURE;
        }

        $driver = config('services.sms.driver');
        $via = $driver === 'android'
            ? 'Android gateway at ' . (config('services.android_sms.url') ?: '(ANDROID_SMS_URL not set)')
            : "Semaphore as sender '" . config('services.semaphore.sender_name') . "'";

        $this->line("Sending to {$normalized} via {$via}...");

        if (!config('services.sms.enabled')) {
            $this->warn('SMS_ENABLED is false — walang aktwal na ipapadala, itatala lang sa sms_logs.');
        }

        $ok = $sms->send(
            $number,
            $this->option('message') ?: 'This is a test message. SMS notifications are working.'
        );

        if (!$ok) {
            $this->error('Send failed. Gateway replied:');
            $this->line('  ' . ($sms->lastError() ?? 'unknown error'));
            return self::FAILURE;
        }

        $this->info('Sent. Check the handset (delivery may take a few seconds).');
        return self::SUCCESS;
    }
}
