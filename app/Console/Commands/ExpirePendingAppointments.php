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
        $expired = Appointment::with(['user', 'store'])
            ->where('status', 'pending')
            ->whereDate('appointment_date', '<', now()->toDateString())
            ->get();

        if ($expired->isEmpty()) {
            $this->info('No lapsed pending appointments to expire.');
            return;
        }

        foreach ($expired as $appointment) {
            $appointment->update(['status' => 'cancelled']);

            if ($appointment->user) {
                $date   = Carbon::parse($appointment->appointment_date)->format('M d, Y');
                $branch = $appointment->store->name ?? 'the clinic';

                $appointment->user->notify(new AppointmentNotification([
                    'title'   => 'Appointment Cancelled',
                    'message' => "Your appointment on {$date} at {$branch} was not approved in time and has been automatically cancelled. We apologize for the inconvenience — you may book a new appointment anytime.",
                ]));
            }
        }

        $this->info("Auto-cancelled {$expired->count()} lapsed pending appointment(s).");
    }
}
