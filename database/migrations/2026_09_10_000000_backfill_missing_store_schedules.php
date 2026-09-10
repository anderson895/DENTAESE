<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Pangalan at address lang ang isinesave ng Add Branch, kaya NULL ang open_days,
 * opening_time at closing_time ng bagong branch. Binabasa iyon ng booking bilang
 * "sarado sa lahat ng araw", kaya walang available timeslot kahit kailan —
 * ito ang nangyari sa bagong Santa Rosa branch.
 *
 * Naayos na ang BranchController na maglagay ng default; dito naman inaayos ang
 * mga naunang branch na wala pang schedule. Ang may nakatakda nang oras ay hindi
 * ginagalaw.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('stores')
            ->where(function ($q) {
                $q->whereNull('open_days')->orWhere('open_days', '')->orWhere('open_days', '[]');
            })
            ->update(['open_days' => json_encode(['mon', 'tue', 'wed', 'thu', 'fri', 'sat'])]);

        DB::table('stores')->whereNull('opening_time')->update(['opening_time' => '09:00:00']);
        DB::table('stores')->whereNull('closing_time')->update(['closing_time' => '18:00:00']);
    }

    public function down(): void
    {
        // Hindi na maibabalik kung alin ang dating NULL at alin ang tunay na
        // nakatakda, at mas masama ang branch na walang schedule kaysa may
        // default — kaya walang ibinabalik dito.
    }
};
