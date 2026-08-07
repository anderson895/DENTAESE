<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'purpose',
        'recipient',
        'raw_number',
        'message',
        'channel',
        'status',
        'error',
    ];

    /** Mababasang label ng purpose para sa admin table. */
    public function purposeLabel(): string
    {
        return match ($this->purpose) {
            'appointment_booked'      => 'Appointment Booked',
            'appointment_confirmed'   => 'Appointment Confirmed',
            'appointment_rescheduled' => 'Appointment Rescheduled',
            'appointment_cancelled'   => 'Appointment Cancelled',
            'signup_otp'              => 'Signup OTP',
            'password_reset_otp'      => 'Password Reset OTP',
            default                   => $this->purpose ?: 'Other',
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'sent'    => 'bg-green-100 text-green-800',
            'failed'  => 'bg-red-100 text-red-800',
            default   => 'bg-gray-100 text-gray-700',
        };
    }
}
