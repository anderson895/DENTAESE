<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Store;
use App\Models\User;
use App\Mail\AppointmentApprovedMail;
use App\Mail\AppointmentRescheduledMail;
use App\Models\MedicalForm;
use App\Models\medicines;
use App\Models\PatientRecord;
use App\Models\PatientMedication;
use App\Models\Service;
use App\Models\StoreStaff;
use App\Services\AppointmentSms;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AppointmentNotification;
   use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;


class AdminBookingController extends Controller
{
    //


public function showBookings(Request $request)
{
    $user = auth()->user();

    // Fallback auto-cancel of lapsed pending appointments (in case cron is down)
    Appointment::expireLapsedPending();

    $stores = Store::all();
    $services = Service::all();
    $clients = User::where('account_type', 'patient')->orderBy('name')->get();

    $query = Appointment::with('user')
        ->where('store_id', session('active_branch_id'));

    // Status filter - default to active statuses if no filter
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    } else {
        $query->whereIn('status', ['pending', 'approved','arrived']);
    }

    if ($user->position === 'Dentist') {
        $query->where('dentist_id', $user->id);
    }

    if (($user->position === 'Receptionist' || $user->position === 'admin') && $request->filled('dentist_id')) {
        $query->where('dentist_id', $request->input('dentist_id'));
    }

    if ($request->filled('date')) {
        $query->whereDate('appointment_date', $request->input('date'));
    }

    //  determine column type 
    $colType = Schema::getColumnType('appointments', 'appointment_date'); 

    if (in_array($colType, ['date','datetime','timestamp'])) {
      
        $query->orderBy('appointment_date', 'asc')
              ->orderBy('appointment_time', 'asc');
    } else {
        
        $query->orderByRaw("STR_TO_DATE(appointment_date, '%Y-%m-%d') asc")
              ->orderByRaw("STR_TO_DATE(appointment_time, '%H:%i') asc");
    }

  
    Log::debug('Appointments SQL', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);

    $appointments = $query->get();

    // dentist list for receptionist and admin
    $dentists = [];
    if ($user->position === 'Receptionist' || $user->position === 'admin') {
        $store = Store::find(session('active_branch_id'));
        if ($store) {
            $dentists = $store->staff()
                ->wherePivot('position', 'dentist')
                ->get(['users.id', 'users.name']);
        }
    }


$appointments->transform(function ($appointment) {
    $serviceIds = is_string($appointment->service_ids)
        ? json_decode($appointment->service_ids, true)
        : $appointment->service_ids;

    $serviceIds = $serviceIds ?: [];

    $appointment->service_list = \App\Models\Service::whereIn('id', $serviceIds)
        ->pluck('name')
        ->toArray();

    return $appointment;
});


    return view('admin.booking', compact('appointments', 'dentists','services', 'stores','clients'));
}


public function approveBooking(Request $request, $id)
{
    $request->validate([
        'appointment_time' => 'required|date_format:H:i',
        'booking_end_time' => 'required|date_format:H:i|after:appointment_time',
    ]);

    $appointment = Appointment::findOrFail($id);

    $isReschedule = $appointment->status === 'approved'; 

    $appointment->update([
        'appointment_time' => $request->appointment_time,
        'booking_end_time' => $request->booking_end_time,
        'status' => 'approved',
    ]);

    //  Send different emails depending on action
    if ($isReschedule) {
        Mail::to($appointment->user->email)->send(new AppointmentRescheduledMail($appointment));
    } else {
        Mail::to($appointment->user->email)->send(new AppointmentApprovedMail($appointment));
    }

    //  Notification logic
    $title = $isReschedule ? 'Appointment Rescheduled' : 'Appointment Approved';
       $message = $isReschedule
    ? 'Your appointment time has been changed at ' . $appointment->store->name . 
      ' to ' . Carbon::parse($appointment->appointment_date)->format('F j, Y') . 
      ' (' . Carbon::parse($appointment->appointment_time)->format('g:i A') . 
      ' - ' . Carbon::parse($appointment->booking_end_time)->format('g:i A') . ')'
    : 'Your appointment has been approved at ' . $appointment->store->name . 
      ' on ' . Carbon::parse($appointment->appointment_date)->format('F j, Y') . 
      ' (' . Carbon::parse($appointment->appointment_time)->format('g:i A') . 
      ' - ' . Carbon::parse($appointment->booking_end_time)->format('g:i A') . ')';

    $appointment->user->notify(new AppointmentNotification([
        'title' => $title,
        'message' => $message,
    ]));

    //  SMS via Semaphore (best-effort, hindi nakaka-block ng approval)
    $sms = app(AppointmentSms::class);
    $isReschedule ? $sms->rescheduled($appointment) : $sms->approved($appointment);

    //  Response with custom message
    return response()->json([
        'message' => $isReschedule ? 'Appointment time updated successfully.' : 'Appointment approved successfully.',
        'status' => $isReschedule ? 'rescheduled' : 'approved',
    ]);
}


public function view($id)
{
    // Get the appointment with related user and store
    $appointment = Appointment::with('user', 'store', 'dentist')->findOrFail($id);

    $patient = $appointment->user;


    $record = $patient->appointment()
        ->whereIn('status', ['completed'])
        ->get();

    // Ensure patient record exists
    $patientinfo = PatientRecord::firstOrCreate(
        ['user_id' => $patient->id],
        ['user_id' => $patient->id]
    );
    $medicines = medicines::get();

    // Current medications the patient is taking (monitored by the doctor)
    $currentMedications = PatientMedication::where('user_id', $patient->id)
        ->orderByDesc('start_date')
        ->orderByDesc('id')
        ->get();

   $serviceNames = \App\Models\Service::whereIn('id', $appointment->service_ids ?? [])
    ->pluck('name');

    $servicePrices = \App\Models\Service::whereIn('id', $appointment->service_ids ?? [])
        ->pluck('approx_price');

    $totalPrice = $servicePrices->sum();

    // Dentists available at this branch (for changeable doctor on check-in)
    $branchDentists = collect();
    if ($appointment->store) {
        $branchDentists = $appointment->store->staff()
            ->wherePivot('position', 'dentist')
            ->get(['users.id', 'users.name', 'users.lastname']);
    }


    return view('admin.appointment_detail', compact(
        'appointment',
        'record',
        'patient',
        'patientinfo',
        'medicines',
        'currentMedications',
        'serviceNames',
        'servicePrices',
        'totalPrice',
        'branchDentists'
    ));


}

public function changeDentist(Request $request, $id)
{
    $request->validate([
        'dentist_id' => 'required|exists:users,id',
    ]);

    $appointment = Appointment::findOrFail($id);
    $appointment->update(['dentist_id' => $request->dentist_id]);

    return response()->json([
        'status' => 'success',
        'message' => 'Dentist updated successfully.',
        'dentist_name' => $appointment->dentist->name ?? '',
    ]);
}

public function settle(Request $request, $id)
{
    $appointment = Appointment::findOrFail($id);

    if ($request->status === 'no_show') {
        $appointment->update(['status' => 'no_show']);

        $when = Carbon::parse($appointment->appointment_date)->format('M d, Y')
            . ' at ' . Carbon::parse($appointment->appointment_time)->format('g:i A');
        $patient = $appointment->user;
        $patientName = $patient ? trim($patient->lastname . ', ' . $patient->name) : 'A patient';

        \App\Services\Notifier::user(
            $patient,
            'Appointment Marked as No Show',
            "You were marked as a no-show for your appointment on {$when}. Please book again if you still need the service.",
            route('CBookingo')
        );

        \App\Services\Notifier::branchStaff(
            $appointment->store_id,
            'Appointment No Show',
            "{$patientName} was marked as a no-show for {$when}.",
            route('admin.booking.history')
        );

        return response()->json(['message' => 'Marked as No Show.']);
    }

    $validated = $request->validate([
        'work_done' => 'nullable|string',
        'paytype' => 'required|string',
        'total_price' => 'required|numeric',
        'amount_given' => 'nullable|numeric|min:0',
        'payment_receipt' => 'nullable|image|max:2048',
    ]);

    // Kabuuang babayaran = serbisyo + gamot na binili sa araw na ito
    $medicineTotal = \App\Models\Sale::where('patient_id', $appointment->user_id)
        ->where('store_id', $appointment->store_id)
        ->whereDate('created_at', $appointment->appointment_date)
        ->sum('total_amount');

    $grandTotal = (float) $validated['total_price'] + (float) $medicineTotal;

    // Bawal tapusin ang bayad kapag kulang ang ibinigay na halaga
    if ($request->filled('amount_given') && (float) $validated['amount_given'] < $grandTotal) {
        $short = number_format($grandTotal - (float) $validated['amount_given'], 2);
        return response()->json([
            'message' => "Amount given is less than the total (₱{$short} short). Please enter the full amount.",
        ], 422);
    }

    $data = [
        'payment_type' => $validated['paytype'],
        'total_price' => $validated['total_price'],
        'status' => 'completed',
    ];

    if ($request->filled('amount_given')) {
        $data['amount_given']  = $validated['amount_given'];
        $data['change_amount'] = max(0, (float) $validated['amount_given'] - $grandTotal);
    }

    if (!empty($validated['work_done'])) {
        $data['work_done'] = $validated['work_done'];
    }

    if ($request->hasFile('payment_receipt')) {
        $file = $request->file('payment_receipt');
        $filename = uniqid('receipt_') . '.' . $file->getClientOriginalExtension();
        $file->storeAs('payment_receipts', $filename, 'public');
        $data['payment_image'] = $filename;
    }

    $appointment->update($data);

    return response()->json([
        'status' => 'success',
        'message' => 'Appointment finalized successfully.'
    ]);
}



public function fetch()
{
    $appointments = Appointment::with('user')
        ->where('store_id', session('active_branch_id'))
        ->where('dentist_id', auth()->id())
        ->whereIn('status', ['pending', 'approved','arrived'])
        ->get();

    return view('admin.partials.appointments-table', compact('appointments'));
}
public function cancelBooking($id)
{
    $appointment = Appointment::findOrFail($id);

    if ($appointment->status !== 'pending') {
        return response()->json(['message' => 'Only pending appointments can be cancelled.'], 400);
    }

    $appointment->status = 'cancelled';
    $appointment->save();

    $when = Carbon::parse($appointment->appointment_date)->format('M d, Y')
        . ' at ' . Carbon::parse($appointment->appointment_time)->format('g:i A');
    $patient = $appointment->user;
    $patientName = $patient ? trim($patient->lastname . ', ' . $patient->name) : 'A patient';

    \App\Services\Notifier::user(
        $patient,
        'Appointment Cancelled',
        "Your appointment at {$appointment->store->name} on {$when} has been cancelled by the clinic.",
        route('CBookingo')
    );

    \App\Services\Notifier::branchStaff(
        $appointment->store_id,
        'Appointment Cancelled',
        "The appointment of {$patientName} on {$when} was cancelled.",
        route('admin.booking')
    );

    app(AppointmentSms::class)->cancelled($appointment);

    return response()->json(['message' => 'Appointment cancelled.']);
}



public function showHistory(Request $request)
{
    $allowedStatuses = ['completed', 'cancelled', 'no_show'];

    $query = Appointment::with(['user', 'dentist'])
        ->where('store_id', session('active_branch_id'))
        ->whereIn('status', $allowedStatuses);

    // Dentist can only see their own appointments
    if (auth()->user()->position === 'Dentist') {
        $query->where('dentist_id', auth()->id());
    } elseif ($request->filled('dentist_id')) {
        $query->where('dentist_id', $request->input('dentist_id'));
    }

    if ($request->filled('status') && in_array($request->input('status'), $allowedStatuses, true)) {
        $query->where('status', $request->input('status'));
    }

    // Date filters
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('appointment_date', [
            $request->input('start_date'),
            $request->input('end_date'),
        ]);
    } elseif ($request->filled('start_date')) {
        $query->whereDate('appointment_date', '>=', $request->input('start_date'));
    } elseif ($request->filled('end_date')) {
        $query->whereDate('appointment_date', '<=', $request->input('end_date'));
    }

    $appointments = $query->get();

    // Dentist dropdown options for current branch (hidden for dentist role)
    $dentists = collect();
    if (auth()->user()->position !== 'Dentist') {
        $store = Store::find(session('active_branch_id'));
        if ($store) {
            $dentists = $store->staff()
                ->wherePivot('position', 'dentist')
                ->get(['users.id', 'users.name']);
        }
    }

    // 🔴 IMPORTANT: load all services for modal multi-select
    $services = Service::all();

    return view('admin.booking_history', compact('appointments', 'services', 'dentists'));
}


// UPDATE APPOINTMENT HISTORY
public function updateHistory(Request $request, Appointment $appointment)
{
    $request->validate([
        'desc' => 'nullable|string',
        'work_done' => 'nullable|string',
        'total_price' => 'nullable|numeric',
        'status' => 'required|string',
        'service_ids' => 'nullable|array',
    ]);

    $oldStatus = $appointment->status;

    $appointment->update([
        'desc' => $request->desc,
        'work_done' => $request->work_done,
        'total_price' => $request->total_price,
        'status' => $request->status,
        'service_ids' => $request->service_ids,
    ]);

    $patient = $appointment->user;
    $patientName = $patient ? trim($patient->lastname . ', ' . $patient->name) : 'A patient';
    $when = Carbon::parse($appointment->appointment_date)->format('M d, Y');

    $statusNote = $oldStatus !== $appointment->status
        ? " Status changed from " . ucfirst($oldStatus) . " to " . ucfirst($appointment->status) . "."
        : '';

    \App\Services\Notifier::branchStaff(
        $appointment->store_id,
        'Appointment History Updated',
        "The record of {$patientName} for {$when} was updated.{$statusNote}",
        route('admin.booking.history')
    );

    return response()->json(['success' => true]);
}



public function modalDetails($id)
{
   
       // get the user (patient)
    $user = User::findOrFail($id);

    // get all completed / finalized appointments of this user
    $completedAppointments = $user->appointment()
        ->whereIn('status', ['completed', 'no_show', 'cancelled'])
        ->get();

    // if you need the latest or specific appointment
    $appointment = $user->appointment()
        ->with('store')
        ->where('status' , 'completed')
        ->latest()
        ->first();

    // livewire dental chart
    $patient = $user;

    // Only completed/finalized appointments for this patient
    $record = $patient->appointment()
        ->whereIn('status', ['completed'])
        ->get();

    $medicines = medicines::get();


    // ensure patientinfo exists
    $patientinfo = PatientRecord::firstOrCreate(
        ['user_id' => $user->id],
        ['user_id' => $user->id]
    );

    // Current medications the patient is taking (monitored by the doctor)
    $currentMedications = PatientMedication::where('user_id', $user->id)
        ->orderByDesc('start_date')
        ->orderByDesc('id')
        ->get();

    return view('admin.partials.usermodaldetail', compact(
        'user',
        'completedAppointments',
        'appointment',
        'record',
        'patient',
        'patientinfo',
        'medicines',
        'currentMedications'
    ));
}
}