<?php

namespace App\Services;

use App\Models\Appointment;
use Carbon\Carbon;

/**
 * Sentralisadong SMS templates para sa appointment lifecycle.
 * Ginagamit ng AppointmentController (booking) at AdminBookingController
 * (approve / reschedule / cancel).
 */
class AppointmentSms
{
    public function __construct(private SmsGateway $sms) {}

    public function booked(Appointment $appointment): bool
    {
        return $this->send($appointment, 'appointment_booked', sprintf(
            'Hi %s, your appointment request at %s on %s at %s has been received. Please wait for the clinic to confirm.',
            $this->firstName($appointment),
            $this->storeName($appointment),
            $this->date($appointment),
            $this->time($appointment->appointment_time)
        ));
    }

    public function approved(Appointment $appointment): bool
    {
        return $this->send($appointment, 'appointment_confirmed', sprintf(
            'Hi %s, your appointment at %s is CONFIRMED on %s, %s. Please arrive 10 minutes early.',
            $this->firstName($appointment),
            $this->storeName($appointment),
            $this->date($appointment),
            $this->timeRange($appointment)
        ));
    }

    public function rescheduled(Appointment $appointment): bool
    {
        return $this->send($appointment, 'appointment_rescheduled', sprintf(
            'Hi %s, your appointment at %s has been RESCHEDULED to %s, %s. See you then!',
            $this->firstName($appointment),
            $this->storeName($appointment),
            $this->date($appointment),
            $this->timeRange($appointment)
        ));
    }

    public function cancelled(Appointment $appointment): bool
    {
        return $this->send($appointment, 'appointment_cancelled', sprintf(
            'Hi %s, your appointment at %s on %s at %s has been CANCELLED. You may book again anytime.',
            $this->firstName($appointment),
            $this->storeName($appointment),
            $this->date($appointment),
            $this->time($appointment->appointment_time)
        ));
    }

    private function send(Appointment $appointment, string $purpose, string $message): bool
    {
        return $this->sms->send($appointment->user?->contact_number, $message, $purpose);
    }

    private function firstName(Appointment $appointment): string
    {
        return $appointment->user?->name ?: 'there';
    }

    private function storeName(Appointment $appointment): string
    {
        return $appointment->store?->name ?: 'the clinic';
    }

    private function date(Appointment $appointment): string
    {
        return Carbon::parse($appointment->appointment_date)->format('M j, Y');
    }

    private function timeRange(Appointment $appointment): string
    {
        return $this->time($appointment->appointment_time)
            . ' - ' . $this->time($appointment->booking_end_time);
    }

    private function time(?string $value): string
    {
        return $value ? Carbon::parse($value)->format('g:i A') : '';
    }
}
