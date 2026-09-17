<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Ang naunang backfill (2026_09_10_000000) ay `whereNull` lang ang hinahanap,
 * pero hindi pala laging NULL ang oras ng bagong branch — puwedeng '00:00:00'
 * ang naipapasok kapag hindi ipinasa ng Add Branch ang column. Nalalampasan ito
 * ng backfill, tapos 00:00-00:00 ang nababasa ng booking: hindi mas huli ang
 * sara sa bukas, kaya walang mabuong timeslot. Ito ang nangyari sa Santa Rosa 1.
 *
 * Sinasaklaw nito ang lahat ng paraan para maging walang saysay ang oras — NULL,
 * pareho, o baligtad — at ibinabalik sa 09:00-18:00. Napapalitan naman ito sa
 * Branch > Schedule, at may validation na ngayon doon para hindi na maulit.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('stores')
            ->where(function ($q) {
                $q->whereNull('opening_time')
                  ->orWhereNull('closing_time')
                  ->orWhereColumn('closing_time', '<=', 'opening_time');
            })
            ->update(['opening_time' => '09:00:00', 'closing_time' => '18:00:00']);
    }

    public function down(): void
    {
        // Hindi na matukoy kung alin ang dating sira at alin ang tunay na
        // nakatakda, at mas masama ang branch na hindi mabu-book kaysa may
        // default na oras — kaya walang ibinabalik dito.
    }
};
