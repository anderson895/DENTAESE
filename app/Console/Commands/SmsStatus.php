<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SmsStatus extends Command
{
    protected $signature = 'sms:status';

    protected $description = 'Show Semaphore credit balance and sender name approval status';

    public function handle(): int
    {
        $apiKey = config('services.semaphore.key');

        if (blank($apiKey)) {
            $this->error('SEMAPHORE_API_KEY is not set in .env');
            return self::FAILURE;
        }

        try {
            $account = $this->fetch('account', $apiKey);
            $senders = $this->fetch('account/sendernames', $apiKey);
        } catch (\Throwable $e) {
            $this->error('Could not read Semaphore account: ' . $e->getMessage());
            return self::FAILURE;
        }

        $this->line('Account : ' . ($account['status'] ?? '?') . ' | credits: ' . ($account['credit_balance'] ?? '?'));
        $this->line('Configured sender name: ' . (config('services.semaphore.sender_name') ?: '(none)'));
        $this->newLine();

        if (empty($senders)) {
            $this->warn('No sender names on this account. SMS sending will fail until one is approved.');
            return self::SUCCESS;
        }

        $this->table(
            ['Sender Name', 'Status', 'Created'],
            collect($senders)->map(fn ($s) => [
                $s['name'] ?? '?', $s['status'] ?? '?', $s['created'] ?? '?',
            ])->all()
        );

        // Ang Semaphore ay nagsasauli ng "Active" (hindi "Approved") kapag
        // aprubado na. Ang isinusuri ay ang sender name na aktuwal na gagamitin
        // ng .env — puwedeng Active ang isa habang Banned ang iba sa listahan.
        $configured = (string) config('services.semaphore.sender_name');

        $active = collect($senders)->first(
            fn ($s) => strcasecmp($s['name'] ?? '', $configured) === 0
                && in_array(strtolower($s['status'] ?? ''), ['active', 'approved'], true)
        );

        $active
            ? $this->info("Sender name '{$configured}' is approved. SMS sending should work.")
            : $this->warn("Configured sender name '{$configured}' is not approved yet. Sends will keep failing.");

        return self::SUCCESS;
    }

    /**
     * Kailangang sumabog kapag hindi 2xx — kung hindi, mukhang "walang sender
     * name" ang isang 429 rate-limit, na mali at nakakalito.
     */
    private function fetch(string $path, string $apiKey): array
    {
        $response = Http::timeout(10)
            ->get('https://api.semaphore.co/api/v4/' . $path, ['apikey' => $apiKey]);

        if ($response->failed()) {
            throw new \RuntimeException(
                'HTTP ' . $response->status() . ' from /' . $path . ' - ' . trim($response->body())
            );
        }

        return (array) $response->json();
    }
}
