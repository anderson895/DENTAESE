<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\User;
use App\Notifications\AppointmentNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendPendingAppointmentReminders extends Command
{
    protected $signature = 'appointments:remind-pending';

    protected $description = 'Notify patients and branch staff about appointments happening tomorrow that are still pending approval';

    public function handle()
    {
        $tomorrow = now()->addDay();

        $pending = Appointment::with(['user', 'dentist', 'store'])
            ->whereDate('appointment_date', $tomorrow->toDateString())
            ->where('status', 'pending')
            ->get();

        if ($pending->isEmpty()) {
            $this->info('No pending appointments scheduled for tomorrow.');
            return;
        }

        $dateLabel = $tomorrow->format('M d, Y');

        // ── 1) Remind each patient that their appointment is still pending ──
        foreach ($pending as $appointment) {
            if (!$appointment->user) {
                continue;
            }

            $time   = Carbon::parse($appointment->appointment_time)->format('h:i A');
            $branch = $appointment->store->name ?? 'the clinic';

            $this->notifyOnce($appointment->user, 'Appointment Still Pending', "Reminder: Your appointment tomorrow ({$dateLabel} at {$time}) at {$branch} is still PENDING approval. Please wait for confirmation or contact the clinic.");
        }

        // ── 2) Notify each assigned dentist of their own unapproved appointments ──
        foreach ($pending->whereNotNull('dentist_id')->groupBy('dentist_id') as $dentistAppointments) {
            $dentist = $dentistAppointments->first()->dentist;
            if (!$dentist) {
                continue;
            }

            $count = $dentistAppointments->count();
            $this->notifyOnce($dentist, 'Unapproved Appointments for Tomorrow', "You still have {$count} unapproved appointment(s) scheduled for tomorrow ({$dateLabel}). Please review and approve them.");
        }

        // ── 3) Notify each branch's receptionists of unapproved appointments ──
        foreach ($pending->groupBy('store_id') as $storeAppointments) {
            $store = $storeAppointments->first()->store;
            if (!$store) {
                continue;
            }

            $count = $storeAppointments->count();
            $receptionists = $store->staff()->where('users.position', 'Receptionist')->get();

            foreach ($receptionists as $receptionist) {
                $this->notifyOnce($receptionist, 'Unapproved Appointments for Tomorrow', "There are still {$count} unapproved appointment(s) at {$store->name} scheduled for tomorrow ({$dateLabel}). Please review and approve them.");
            }
        }

        $this->info("Reminders sent for {$pending->count()} pending appointment(s) on {$dateLabel}.");
    }

    /**
     * Send a database notification, skipping duplicates for the same day
     * (safe kahit ma-run nang paulit-ulit ang command sa isang araw).
     */
    private function notifyOnce(User $user, string $title, string $message): void
    {
        $alreadySent = $user->notifications()
            ->where('created_at', '>=', now()->startOfDay())
            ->where('data->title', $title)
            ->where('data->message', $message)
            ->exists();

        if ($alreadySent) {
            return;
        }

        $user->notify(new AppointmentNotification([
            'title'   => $title,
            'message' => $message,
        ]));
    }
}
