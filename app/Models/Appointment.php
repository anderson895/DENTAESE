<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Appointment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'store_id',
        'user_id',
        'service_name',
        'dentist_id',
        'appointment_date',
        'appointment_time',
        'booking_end_time',
        'work_done',
        'total_price',
        'amount_given',
        'change_amount',
        'payment_type',
        'payment_image',
        'desc',
        'status',
        'appointment_type',
        'service_ids',
        'arrived_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'service_ids' => 'array',
    ];

    /**
     * Auto-cancel lapsed pending appointments (date already passed, or the
     * booking window today already ended without approval) and notify patients.
     *
     * Inline fallback for the scheduled `appointments:expire-pending` command
     * so stale pendings are cleaned up kahit hindi tumatakbo ang cron.
     */
    public static function expireLapsedPending(): int
    {
        $now = now();

        $expired = static::with(['user', 'store'])
            ->where('status', 'pending')
            ->where(function ($q) use ($now) {
                $q->whereDate('appointment_date', '<', $now->toDateString())
                  ->orWhere(function ($q2) use ($now) {
                      $q2->whereDate('appointment_date', $now->toDateString())
                         ->whereTime('booking_end_time', '<', $now->format('H:i:s'));
                  });
            })
            ->get();

        foreach ($expired as $appointment) {
            $appointment->update(['status' => 'cancelled']);

            if ($appointment->user) {
                try {
                    $date   = \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y');
                    $branch = $appointment->store->name ?? 'the clinic';

                    $appointment->user->notify(new \App\Notifications\AppointmentNotification([
                        'title'   => 'Appointment Cancelled',
                        'message' => "Your appointment on {$date} at {$branch} was not approved in time and has been automatically cancelled. You may book a new appointment anytime.",
                    ]));
                } catch (\Throwable $e) {
                    // Notification failure should never block the cleanup
                }
            }
        }

        return $expired->count();
    }

    // Relationship: belongs to a store (branch)
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Relationship: belongs to a user (customer/patient)
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function dentist()
{
    return $this->belongsTo(User::class, 'dentist_id')->withTrashed();
}
}
