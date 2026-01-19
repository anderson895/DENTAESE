<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Store;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class AppointmentController extends Controller
{







public function changeTime(Request $request, Appointment $appointment)
{
    $request->validate([
        'appointment_time' => 'required',
        'booking_end_time' => 'required|after:appointment_time',
    ]);

    $appointment->update([
        'appointment_time' => $request->appointment_time,
        'booking_end_time' => $request->booking_end_time,
    ]);

    return response()->json(['message' => 'Time updated']);
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
        ->get(['users.id', 'users.name','users.lastname', 'users.contact_number','users.profile_image']); // columns from users table

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

    $dayName = strtolower(Carbon::parse($date)->format('D'));
    $openDays = is_array($store->open_days) ? $store->open_days : json_decode($store->open_days, true);

    if (!in_array($dayName, $openDays ?? [])) {
        return response()->json(['slots' => [], 'booked_slots' => []]);
    }

    $opening = Carbon::parse($store->opening_time);
    $closing = Carbon::parse($store->closing_time);
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

   while ($currentSlot->lt($closing)) {
    $slotEnd = $currentSlot->copy()->addMinutes($slotDuration);

    $overlapping = $bookings->first(function ($booking) use ($currentSlot, $slotEnd) {
        $bookingStart = Carbon::parse($booking->appointment_time);
        $bookingEnd = Carbon::parse($booking->booking_end_time);
        return $currentSlot->lt($bookingEnd) && $slotEnd->gt($bookingStart);
    });

    if (!$overlapping) {
        $availableSlots[] = $currentSlot->format('H:i');
        $currentSlot->addMinutes($slotDuration);
    } else {
        // Jump to the end of the overlapping booking
        $currentSlot = Carbon::parse($overlapping->booking_end_time);
    }
}


    return response()->json([
        'status' => 'success',
        'slots' => $availableSlots,
        'booked_slots' => $bookedSlots
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

    while ($currentSlot->lt($closing)) {
        $slotEnd = $currentSlot->copy()->addMinutes($slotDuration);

        // Check if this slot overlaps with any existing booking
        $overlapping = $bookings->first(function ($booking) use ($currentSlot, $slotEnd) {
            $bookingStart = Carbon::parse($booking->appointment_time);
            $bookingEnd = Carbon::parse($booking->booking_end_time);
            return $currentSlot->lt($bookingEnd) && $slotEnd->gt($bookingStart);
        });

        if (!$overlapping) {
            $availableSlots[] = $currentSlot->format('H:i');
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

    $day = strtolower(Carbon::parse($validated['appointment_date'])->format('D'));
    if (!in_array($day, $store->open_days ?? [])) {
        return response()->json(['status' => 'error', 'message' => 'Store is closed on this day.']);
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

    if ($appointmentEnd->format('H:i') > $store->closing_time->format('H:i')) {
        return response()->json(['status' => 'error', 'message' => 'Booking ends after store closing time.']);
    }

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

    // If walk-in or emergency, set date and time to today automatically
    if ($type === 'walkin' || $type === 'emergency') {
        $request->merge([
            'appointment_date' => now()->format('Y-m-d'),
            'appointment_time' => now()->format('H:i'), // current time
        ]);
    }

    // Validation
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'store_id' => 'required|exists:stores,id',
        'service_id' => 'required|exists:services,id',
        'dentist_id' => 'required|exists:users,id',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required|date_format:H:i',
        'desc' =>'required',
    ]);

    $store = Store::findOrFail($request->store_id);
    $user = User::findOrFail($request->user_id);
    $service = Service::findOrFail($request->service_id);

    // Check if store is open that day
    $day = strtolower(Carbon::parse($request->appointment_date)->format('D'));
    if (!in_array($day, $store->open_days ?? [])) {
        return back()->withErrors(['appointment_date' => 'Store is closed on this day.']);
    }

    $booking_end = Carbon::parse($request->appointment_time)->addMinutes($service->approx_time);

    // Check if time is within hours
    if (
        $request->appointment_time < $store->opening_time->format('H:i') ||
        $request->appointment_time > $store->closing_time->format('H:i')
    ) {
        return back()->withErrors(['appointment_time' => 'Time is outside of store hours.']);
    }

    // Check if time slot is already taken
    $alreadyBooked = Appointment::where('store_id', $store->id)
        ->where('dentist_id', $request->dentist_id)
        ->where('status', '!=', 'cancelled')
        ->where('appointment_date', $request->appointment_date)
        ->where('appointment_time', $request->appointment_time)
        ->exists();

    if ($alreadyBooked) {
        return back()->withErrors(['appointment_time' => 'This time slot is already booked.']);
    }

    if ($booking_end->format('H:i') > $store->closing_time->format('H:i')) {
        return back()->withErrors(['appointment_time' => 'Booking ends after store closing time.']);
    }

    // Only check pending appointments if NOT emergency
    if ($type !== 'emergency') {
        $userHasPending = Appointment::where('user_id', $user->id)
            ->whereNotIn('status', ['completed', 'no_show','cancelled'])
            ->exists();

        if ($userHasPending) {
            return response()->json([
                'status'=>'error',
                'message' => $user->lastname . ", ". $user->name . ' has Pending Appointment.'
            ]);
        }
    }

    $service_ids = [$service->id];

    // Create the appointment
    if ($type === 'walkin' || $type === 'emergency') {
        $appointment = Appointment::create([
            'store_id' => $store->id,
            'user_id' => $user->id,
            'dentist_id' => $request->dentist_id,
            'service_ids' => $service_ids,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'booking_end_time' => $booking_end->format('H:i'),
            'desc'=> $request->desc,
            'status' => $type === 'emergency' ? 'approved' : 'approved', // emergency also approved immediately
        ]);

        return response()->json([
            'status' => 'redirect',
            'url' => route('appointments.view', $appointment->id)
        ]);
    }

    if ($type === 'normal') {
        Appointment::create([
            'store_id' => $store->id,
            'user_id' => $user->id,
            'dentist_id' => $request->dentist_id,
            'service_ids' => $service_ids,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'booking_end_time' => $booking_end->format('H:i'),
            'desc'=> $request->desc,
            'status' => 'pending',
        ]);

        return response()->json(['status'=>'success','message' =>'Appointment created successfully']);
    }
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
