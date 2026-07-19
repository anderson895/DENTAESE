<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Store;
use App\Models\Service;
use App\Models\User;
use App\Models\DoctorSchedule;
use App\Models\StoreScheduleOverride;
use Illuminate\Support\Facades\Auth;
class AppointmentController extends Controller
{







public function changeTime(Request $request, Appointment $appointment)
{
    $request->validate([
        'appointment_date' => 'required|date',
        'appointment_time' => 'required',
        'booking_end_time' => 'required|after:appointment_time',
    ]);

    $appointment->update([
        'appointment_date' => $request->appointment_date,
        'appointment_time' => $request->appointment_time,
        'booking_end_time' => $request->booking_end_time,
    ]);

    return response()->json(['message' => 'Date & time updated']);
}









    //

    public function getSchedule(Store $store)
{
    return response()->json([
        'status' => 'success',
        'name' => $store->name,
        'address' => $store->address,
        'opening_time' => optional($store->opening_time)->format('H:i'),
        'closing_time' => optional($store->closing_time)->format('H:i'),
        'open_days' => $store->open_days ?? [],
    ]);
}

public function getServiceDetail(Service $service)
{
    return response()->json([
        'status' => 'success',
        'name' => $service->name,
        'desc' => $service->description,
        'type' => $service->type,
        'time' => $service->approx_time,
        'price' => $service->approx_price,

       
    ]);
}
public function getDentists($branchId)
{
    $store = Store::find($branchId);

    if (!$store) {
        return response()->json([
            'status' => 'error',
            'message' => 'Store not found'
        ], 404);
    }

    $dentists = $store->staff()
        ->wherePivot('position', 'dentist')
        ->get(['users.id', 'users.name', 'users.middlename', 'users.lastname', 'users.suffix', 'users.contact_number', 'users.profile_image']); // columns from users table

    return response()->json([
        'status' => 'success',
        'dentists' => $dentists,
    ]);
}
public function getDentistSlots($branchId, $dentistId, Request $request)
{
    $date = $request->input('date');

    if (!$date || !strtotime($date)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid date provided.'
        ], 400);
    }

    $store = Store::findOrFail($branchId);
    $dentist = User::findOrFail($dentistId);

    // Honor per-date clinic open/closed override; fallback to weekly open_days
    $clinicOverride = StoreScheduleOverride::where('store_id', $store->id)
        ->where('schedule_date', $date)->first();
    if ($clinicOverride) {
        if (!$clinicOverride->is_open) {
            return response()->json([
                'status' => 'success',
                'slots' => [],
                'booked_slots' => [],
                'reason' => 'clinic_closed',
                'message' => 'The clinic is closed on this date. Please choose another date.',
            ]);
        }
    } else {
        $dayName = strtolower(Carbon::parse($date)->format('D'));
        $openDays = is_array($store->open_days) ? $store->open_days : json_decode($store->open_days, true);
        if (!in_array($dayName, $openDays ?? [])) {
            return response()->json([
                'status' => 'success',
                'slots' => [],
                'booked_slots' => [],
                'reason' => 'clinic_closed',
                'message' => 'The clinic is closed on this day. Please choose another date.',
            ]);
        }
    }

    // Honor doctor schedule override for this date (off / custom hours)
    $docSchedule = DoctorSchedule::where('dentist_id', $dentistId)
        ->where('schedule_date', $date)
        ->first();
    if ($docSchedule && $docSchedule->status === 'off') {
        $dentistName = trim($dentist->name . ' ' . $dentist->lastname) ?: 'The selected dentist';
        return response()->json([
            'status' => 'success',
            'slots' => [],
            'booked_slots' => [],
            'reason' => 'dentist_off',
            'message' => "{$dentistName} is on day off on this date. Please choose another date or dentist.",
        ]);
    }

    $opening = Carbon::parse(
        ($docSchedule && $docSchedule->start_time)
            ? $docSchedule->start_time
            : (($clinicOverride && $clinicOverride->opening_time) ? $clinicOverride->opening_time : $store->opening_time)
    );
    $closing = Carbon::parse(
        ($docSchedule && $docSchedule->end_time)
            ? $docSchedule->end_time
            : (($clinicOverride && $clinicOverride->closing_time) ? $clinicOverride->closing_time : $store->closing_time)
    );
    $slotDuration = 60; // minutes

    $bookings = Appointment::where('store_id', $store->id)
        ->where('dentist_id', $dentistId)
        ->where('appointment_date', $date)
        ->where('status', '!=', 'cancelled')
        ->orderBy('appointment_time')
        ->get(['appointment_time', 'booking_end_time']);

    $bookedSlots = [];
    foreach ($bookings as $booking) {
        $start = Carbon::parse($booking->appointment_time);
        $end = Carbon::parse($booking->booking_end_time);
        while ($start->lt($end)) {
            $bookedSlots[] = $start->format('H:i');
            $start->addMinutes($slotDuration);
        }
    }

    $availableSlots = [];
    $currentSlot = $opening->copy();

    // Hide past slots when booking for today
    $isToday = Carbon::parse($date)->isToday();
    $now = Carbon::now();

   while ($currentSlot->lt($closing)) {
    $slotEnd = $currentSlot->copy()->addMinutes($slotDuration);

    $overlapping = $bookings->first(function ($booking) use ($currentSlot, $slotEnd) {
        $bookingStart = Carbon::parse($booking->appointment_time);
        $bookingEnd = Carbon::parse($booking->booking_end_time);
        return $currentSlot->lt($bookingEnd) && $slotEnd->gt($bookingStart);
    });

    if (!$overlapping) {
        // Skip if the slot end has already passed (today only)
        if (!$isToday || $slotEnd->setDateFrom($now)->gt($now)) {
            $availableSlots[] = $currentSlot->format('H:i');
        }
        $currentSlot->addMinutes($slotDuration);
    } else {
        // Jump to the end of the overlapping booking
        $currentSlot = Carbon::parse($overlapping->booking_end_time);
    }
}


    // No selectable slots even though the clinic is open and the dentist is on
    // duty — explain whether everything is booked or simply unavailable today.
    $reason = null;
    $message = null;
    if (empty($availableSlots)) {
        if (count($bookedSlots) > 0) {
            $reason = 'fully_booked';
            $message = 'All time slots are already booked on this date. Please choose another date.';
        } else {
            $reason = 'no_slots';
            $message = 'No available time slots for this date. Please choose another date.';
        }
    }

    return response()->json([
        'status' => 'success',
        'slots' => $availableSlots,
        'booked_slots' => $bookedSlots,
        'reason' => $reason,
        'message' => $message,
    ]);
}



public function getAvailableSlots(Request $request, Store $store)
{
    $date = $request->input('date');

    if (!$date) {
        return response()->json(['error' => 'Date is required'], 422);
    }

    $dayName = strtolower(Carbon::parse($date)->format('D'));

    // Check if store is open that day
    if (!in_array($dayName, $store->open_days ?? [])) {
        return response()->json(['slots' => []]); // store closed
    }

    $opening = Carbon::parse($store->opening_time);
    $closing = Carbon::parse($store->closing_time);
    $slotDuration = 60; // minutes

    // Get all bookings on that day
    $bookings = Appointment::where('store_id', $store->id)
        ->where('appointment_date', $date)
        ->where('status', '!=', 'cancelled')
        ->orderBy('appointment_time')
        ->get(['appointment_time', 'booking_end_time']);

    $availableSlots = [];
    $currentSlot = $opening->copy();

    // Hide past slots when booking for today
    $isToday = Carbon::parse($date)->isToday();
    $now = Carbon::now();

    while ($currentSlot->lt($closing)) {
        $slotEnd = $currentSlot->copy()->addMinutes($slotDuration);

        // Check if this slot overlaps with any existing booking
        $overlapping = $bookings->first(function ($booking) use ($currentSlot, $slotEnd) {
            $bookingStart = Carbon::parse($booking->appointment_time);
            $bookingEnd = Carbon::parse($booking->booking_end_time);
            return $currentSlot->lt($bookingEnd) && $slotEnd->gt($bookingStart);
        });

        if (!$overlapping) {
            // Skip if the slot end has already passed (today only)
            if (!$isToday || $slotEnd->setDateFrom($now)->gt($now)) {
                $availableSlots[] = $currentSlot->format('H:i');
            }
            $currentSlot = $slotEnd; // Continue after this slot
        } else {
            // Skip to end of overlapping booking
            $currentSlot = Carbon::parse($overlapping->booking_end_time);
        }
    }

    return response()->json(['slots' => $availableSlots]);
}


public function appointment(Request $request)
{
    $validated = $request->validate([
        'store_id' => 'required|exists:stores,id',
        'service_ids' => 'required|array',
        'dentist_id' => 'required|exists:users,id',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required|date_format:H:i',
        'desc' => 'nullable|string',
    ]);

    $store = Store::findOrFail($validated['store_id']);
    $services = Service::whereIn('id', $validated['service_ids'] ?? [])->get();
    $totalApproxTime = $services->sum('approx_time');

    // Per-date clinic override takes precedence over weekly open_days
    $clinicOverride = StoreScheduleOverride::where('store_id', $store->id)
        ->where('schedule_date', $validated['appointment_date'])->first();
    if ($clinicOverride) {
        if (!$clinicOverride->is_open) {
            return response()->json(['status' => 'error', 'message' => 'Clinic is closed on this date.']);
        }
    } else {
        $day = strtolower(Carbon::parse($validated['appointment_date'])->format('D'));
        if (!in_array($day, $store->open_days ?? [])) {
            return response()->json(['status' => 'error', 'message' => 'Store is closed on this day.']);
        }
    }

    // Doctor schedule override (off-day) blocks booking
    $docSchedule = DoctorSchedule::where('dentist_id', $validated['dentist_id'])
        ->where('schedule_date', $validated['appointment_date'])->first();
    if ($docSchedule && $docSchedule->status === 'off') {
        return response()->json(['status' => 'error', 'message' => 'Selected dentist is off on this date.']);
    }

   // Check for overlapping appointments
$appointmentStart = Carbon::parse($validated['appointment_time']);
$appointmentEnd = (clone $appointmentStart)->addMinutes($totalApproxTime);

// Find the next appointment for the same dentist and date
$nextBooking = Appointment::where('store_id', $store->id)
    ->where('dentist_id', $validated['dentist_id'])
    ->where('status', '!=', 'cancelled')
    ->where('appointment_date', $validated['appointment_date'])
    ->whereTime('appointment_time', '>=', $validated['appointment_time'])
    ->orderBy('appointment_time', 'asc')
    ->first();

if ($nextBooking) {
    $nextStart = Carbon::parse($nextBooking->appointment_time);

    // Overlap check
    if ($nextStart->lessThan($appointmentEnd)) {
        $message = 'This time slot overlaps with another appointment.';

      
        if ($nextStart->greaterThan($appointmentStart)) {
            $remainingMinutes = $appointmentStart->diffInMinutes($nextStart);
            $message .= " The remaining available time before the next booking is {$remainingMinutes} minutes.";
        }

        return response()->json(['status' => 'error', 'message' => $message]);
    }
}

    $closingForCheck = ($clinicOverride && $clinicOverride->closing_time)
        ? Carbon::parse($clinicOverride->closing_time)
        : $store->closing_time;
    if ($appointmentEnd->format('H:i') > Carbon::parse($closingForCheck)->format('H:i')) {
        return response()->json(['status' => 'error', 'message' => 'Booking ends after store closing time.']);
    }

    // Clean up lapsed pending appointments first so they never block new bookings
    Appointment::expireLapsedPending();

    $userHasPending = Appointment::where('user_id', auth()->id())
        ->whereNotIn('status', ['completed', 'no_show', 'cancelled'])
        ->exists();

    if ($userHasPending) {
        return response()->json(['status' => 'error', 'message' => 'You have a pending appointment.']);
    }

    $appointment = Appointment::create([
        'store_id' => $store->id,
        'user_id' => auth()->id(),
        'dentist_id' => $validated['dentist_id'],
        'service_ids' => $validated['service_ids'] ?? [],
        'appointment_date' => $validated['appointment_date'],
        'appointment_time' => $validated['appointment_time'],
        'booking_end_time' => $appointmentEnd->format('H:i'),
        'desc' => $validated['desc'],
        'status' => 'pending',
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Appointment created successfully.',
        'data' => $appointment,
    ]);
}



public function appointmentadmin(Request $request)
{
    $type = $request->appt_type;

    // If walk-in or emergency, set date and time to now
    if (in_array($type, ['walkin', 'emergency'])) {
        $request->merge([
            'appointment_date' => now()->format('Y-m-d'),
            'appointment_time' => now()->format('H:i'),
        ]);
    }

    // Validation
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'store_id' => 'required|exists:stores,id',
        'service_id' => 'required|exists:services,id',
        'dentist_id' => 'required|exists:users,id',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required|date_format:H:i',
        'desc' => 'nullable|string',
    ]);

    $store = Store::findOrFail($validated['store_id']);
    $user = User::findOrFail($validated['user_id']);
    $service = Service::findOrFail($validated['service_id']);

    $appointmentDate = Carbon::parse($validated['appointment_date']);
    $appointmentTime = Carbon::parse($appointmentDate->format('Y-m-d') . ' ' . $validated['appointment_time']);
    $bookingEnd = $appointmentTime->copy()->addMinutes($service->approx_time);

    // Per-date clinic override (calendar-based) takes precedence
    $clinicOverride = StoreScheduleOverride::where('store_id', $store->id)
        ->where('schedule_date', $appointmentDate->toDateString())->first();
    if ($clinicOverride) {
        if (!$clinicOverride->is_open) {
            return response()->json([
                'status' => 'error',
                'message' => 'Clinic is closed on this date.'
            ]);
        }
    } else {
        $dayOfWeek = strtolower($appointmentDate->format('D'));
        if (!in_array($dayOfWeek, $store->open_days ?? [])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Store is closed on this day.'
            ]);
        }
    }

    // Doctor schedule override
    $docSchedule = DoctorSchedule::where('dentist_id', $validated['dentist_id'])
        ->where('schedule_date', $appointmentDate->toDateString())->first();
    if ($docSchedule && $docSchedule->status === 'off') {
        return response()->json([
            'status' => 'error',
            'message' => 'Selected dentist is off on this date.'
        ]);
    }

    // Use override hours if present, otherwise default store hours
    $openingTime = ($docSchedule && $docSchedule->start_time)
        ? Carbon::parse($docSchedule->start_time)
        : (($clinicOverride && $clinicOverride->opening_time)
            ? Carbon::parse($clinicOverride->opening_time)
            : $store->opening_time);
    $closingTime = ($docSchedule && $docSchedule->end_time)
        ? Carbon::parse($docSchedule->end_time)
        : (($clinicOverride && $clinicOverride->closing_time)
            ? Carbon::parse($clinicOverride->closing_time)
            : $store->closing_time);

    $storeOpening = Carbon::parse($appointmentDate->format('Y-m-d') . ' ' . Carbon::parse($openingTime)->format('H:i'));
    $storeClosing = Carbon::parse($appointmentDate->format('Y-m-d') . ' ' . Carbon::parse($closingTime)->format('H:i'));

    // Adjust walk-in/emergency appointments if before opening
    if (in_array($type, ['walkin', 'emergency']) && $appointmentTime < $storeOpening) {
        $appointmentTime = $storeOpening->copy();
        $bookingEnd = $appointmentTime->copy()->addMinutes($service->approx_time);
    }

    // Check if appointment is within store hours
    if ($appointmentTime < $storeOpening || $bookingEnd > $storeClosing) {
        return response()->json([
            'status' => 'error',
            'message' => 'Appointment time is outside of store hours.',
            'debug' => [
                'appointment_date' => $appointmentDate->toDateString(),
                'appointment_time' => $appointmentTime->format('H:i'),
                'booking_end' => $bookingEnd->format('H:i'),
                'store_opening' => $storeOpening->format('H:i'),
                'store_closing' => $storeClosing->format('H:i'),
                'comparison_result' => [
                    'appointmentTime >= storeOpening' => $appointmentTime->gte($storeOpening),
                    'bookingEnd <= storeClosing' => $bookingEnd->lte($storeClosing)
                ]
            ]
        ]);
    }

    // Check if time slot is already booked (skip for emergency)
    if ($type !== 'emergency') {
        $alreadyBooked = Appointment::where('store_id', $store->id)
            ->where('dentist_id', $validated['dentist_id'])
            ->where('status', '!=', 'cancelled')
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $appointmentTime->format('H:i'))
            ->exists();

        if ($alreadyBooked) {
            return response()->json([
                'status' => 'error',
                'message' => 'This time slot is already booked.'
            ]);
        }
    }

    // Only check pending appointments if NOT emergency
    if ($type !== 'emergency') {
        // Clean up lapsed pending appointments first so they never block new bookings
        Appointment::expireLapsedPending();

        $userHasPending = Appointment::where('user_id', $user->id)
            ->whereNotIn('status', ['completed', 'no_show', 'cancelled'])
            ->exists();

        if ($userHasPending) {
            return response()->json([
                'status' => 'error',
                'message' => "{$user->lastname}, {$user->name} has a pending appointment."
            ]);
        }
    }

    $service_ids = [$service->id];

    // Create the appointment
    $status = match($type) {
        'normal'    => 'pending',
        'walkin'    => 'arrived',
        'emergency'    => 'arrived',
        default     => 'approved',
    };

    $appointmentType = match($type) {
        'walkin'    => 'walkin',
        'emergency' => 'emergency',
        default     => 'scheduled',
    };

    $appointment = Appointment::create([
        'store_id' => $store->id,
        'user_id' => $user->id,
        'dentist_id' => $validated['dentist_id'],
        'service_ids' => $service_ids,
        'appointment_date' => $validated['appointment_date'],
        'appointment_time' => $appointmentTime->format('H:i'),
        'booking_end_time' => $bookingEnd->format('H:i'),
        'desc' => $validated['desc'],
        'status' => $status,
        'appointment_type' => $appointmentType,
    ]);

    // Redirect immediately for walk-in/emergency
    if (in_array($type, ['walkin', 'emergency'])) {
        return response()->json([
            'status' => 'redirect',
            'url' => route('appointments.view', $appointment->id)
        ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Appointment created successfully'
    ]);
}








// public function index()
// {
//     $stores = Store::all(); // or however you're fetching branches

//     $incompleteAppointments = Appointment::with('dentist', 'store')
//         ->where('user_id', Auth::id())
//         ->where('status', '!=', 'completed') // or just `pending`, adjust based on your DB
//         ->orderBy('appointment_date', 'desc')
//         ->get();

//     return view('booking.index', compact('stores', 'incompleteAppointments'));
// }

public function showProfile()
{
    $incompleteAppointments = Appointment::with(['user', 'dentist', 'store'])
        ->where('user_id', auth()->id())
        ->where('status', '!=', 'completed') 
        ->where('status', '!=', 'cancelled')// show only non-completed ones
        ->orderBy('appointment_date', 'desc')
        ->get();

    $stores = Store::all(); 
    $services = Service::all();
    return view('client.cbooking', compact('incompleteAppointments', 'stores', 'services'));
}


public function nextApprovedAppointment($dentistId, Request $request)
{
    $date = $request->query('date');
    $time = $request->query('time');

    $next = Appointment::where('dentist_id', $dentistId)
        ->where('appointment_date', $date)
       ->whereIn('status', ['approved', 'pending'])

        ->whereTime('appointment_time', '>', $time) 
        ->orderBy('appointment_time', 'asc')
        ->first();

    return response()->json([
        'next_time' => $next ? Carbon::parse($next->appointment_time)->format('H:i') : null
    ]);
}

public function updateServices(Request $request)
{
    $appt = Appointment::findOrFail($request->id);

 
    $appt->service_ids = $request->services; 
    $appt->save();

    return response()->json(['success' => true]);
}


}
