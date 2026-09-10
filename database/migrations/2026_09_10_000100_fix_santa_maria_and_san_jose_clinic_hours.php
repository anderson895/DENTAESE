<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * 21:00-23:00 ang nakatakdang oras ng Santa Maria at San Jose Del Monte, kaya
 * dalawang slot lang (9PM at 10PM) ang lumalabas sa booking — at wala nang
 * matitira kapag lampas 10:30PM na. Test data ito, hindi tunay na oras ng
 * klinika. Ginagawa itong 09:00-18:00 tulad ng Prenza 1.
 *
 * Tinutugma muna ang lumang halaga bago palitan, para hindi mabura ang oras
 * kung naitama na ito sa Branch > Schedule bago tumakbo ang migration.
 */
return new class extends Migration
{
    private const OLD = ['opening_time' => '21:00:00', 'closing_time' => '23:00:00'];
    private const NEW = ['opening_time' => '09:00:00', 'closing_time' => '18:00:00'];

    public function up(): void
    {
        $this->swapHours(self::OLD, self::NEW);
    }

    public function down(): void
    {
        $this->swapHours(self::NEW, self::OLD);
    }

    private function swapHours(array $from, array $to): void
    {
        DB::table('stores')
            ->where(function ($q) {
                $q->where('name', 'like', 'Santa Maria%')
                  ->orWhere('name', 'like', 'San Jose%');
            })
            ->where('opening_time', $from['opening_time'])
            ->where('closing_time', $from['closing_time'])
            ->update($to);
    }
};
