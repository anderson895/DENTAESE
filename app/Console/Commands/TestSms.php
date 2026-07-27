<?php

namespace App\Console\Commands;

use App\Services\SemaphoreSms;
use Illuminate\Console\Command;

class TestSms extends Command
{
    protected $signature = 'sms:test {number : PH mobile number, e.g. 09171234567}
                                     {--message= : Custom message body}';

    protected $description = 'Send a test SMS through Semaphore to verify credentials and sender name';

    public function handle(SemaphoreSms $sms): int
    {
        $number = $this->argument('number');
        $normalized = SemaphoreSms::normalize($number);

        if ($normalized === null) {
            $this->error("Invalid PH mobile number: {$number}");
            return self::FAILURE;
        }

        $this->line("Sending to {$normalized} as sender '" . config('services.semaphore.sender_name') . "'...");

        $ok = $sms->send(
            $number,
            $this->option('message') ?: 'DentalEase: This is a test message. SMS notifications are working.'
        );

        if (!$ok) {
            $this->error('Send failed. Semaphore replied:');
            $this->line('  ' . ($sms->lastError ?? 'unknown error'));
            return self::FAILURE;
        }

        $this->info('Sent. Check the handset (delivery may take a few seconds).');
        return self::SUCCESS;
    }
}
