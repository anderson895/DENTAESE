<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Daily reminder: pending appointments happening tomorrow
// (patients + assigned dentists + branch receptionists)
Schedule::command('appointments:remind-pending')->dailyAt('08:00');

// Auto-cancel pending appointments whose date has passed without approval
// (minute 0 para tumama sa hourly cron ng Hostinger)
Schedule::command('appointments:expire-pending')->dailyAt('01:00');
