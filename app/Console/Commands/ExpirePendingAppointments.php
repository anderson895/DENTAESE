<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Notifications\AppointmentNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpirePendingAppointments extends Command
{
    protected $signature = 'appointments:expire-pending';

    protected $description = 'Auto-cancel pending appointments whose date has already passed without approval, and notify the patient';

    public function handle()
    {
        // Shared logic lives on the model so web requests can also
        // trigger the cleanup as a fallback when cron is down.
        $count = Appointment::expireLapsedPending();

        if ($count === 0) {
            $this->info('No lapsed pending appointments to expire.');
            return;
        }

        $this->info("Auto-cancelled {$count} lapsed pending appointment(s).");
    }
}
