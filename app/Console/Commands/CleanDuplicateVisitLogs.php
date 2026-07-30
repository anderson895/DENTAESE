<?php

namespace App\Console\Commands;

use App\Models\daily_logs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanDuplicateVisitLogs extends Command
{
    protected $signature = 'logs:clean-duplicates {--apply : Actually delete the duplicates (default is dry-run)}';

    protected $description = 'Find (and optionally remove) duplicate visit logs — more than one log for the same user on the same day. Keeps the earliest log of each day.';

    public function handle()
    {
        $groups = DB::table('daily_logs')
            ->selectRaw('user_id, DATE(scanned_at) as log_date, COUNT(*) as total, MIN(id) as keep_id')
            ->groupBy('user_id', 'log_date')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        if ($groups->isEmpty()) {
            $this->info('No duplicate visit logs found.');
            return self::SUCCESS;
        }

        $redundant = $groups->sum(fn ($g) => $g->total - 1);

        $this->warn("Found {$groups->count()} duplicated user/day group(s), {$redundant} redundant log(s).");
        $this->table(
            ['User ID', 'Date', 'Logs', 'Keeping log ID'],
            $groups->map(fn ($g) => [$g->user_id, $g->log_date, $g->total, $g->keep_id])->all()
        );

        if (!$this->option('apply')) {
            $this->newLine();
            $this->info('Dry-run only — nothing was deleted.');
            $this->line('Re-run with --apply to remove the redundant logs:');
            $this->line('  php artisan logs:clean-duplicates --apply');
            return self::SUCCESS;
        }

        $deleted = 0;
        foreach ($groups as $group) {
            $deleted += daily_logs::where('user_id', $group->user_id)
                ->whereDate('scanned_at', $group->log_date)
                ->where('id', '!=', $group->keep_id)
                ->delete();
        }

        $this->info("Deleted {$deleted} duplicate visit log(s). The earliest log of each day was kept.");

        return self::SUCCESS;
    }
}
