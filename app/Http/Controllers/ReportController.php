<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function appointmentsReport(Request $request)
    {
        $branchId = session('active_branch_id');

        $startDate = $request->start_date ?? Carbon::today()->toDateString();
        $endDate   = $request->end_date   ?? Carbon::today()->toDateString();

        $query = Appointment::with(['user', 'dentist'])
            ->where('store_id', $branchId)
            ->whereDate('appointment_date', '>=', $startDate)
            ->whereDate('appointment_date', '<=', $endDate);

        // Status filter — default to completed/cancelled/no_show
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        } else {
            $query->whereIn('status', ['completed', 'cancelled', 'no_show']);
        }

        // Dentist (staff) filter
        if ($request->filled('dentist_id')) {
            $query->where('dentist_id', $request->input('dentist_id'));
        }

        // Patient name filter (search by first/last name)
        if ($request->filled('patient_name')) {
            $term = $request->input('patient_name');
            $query->whereHas('user', function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('lastname', 'like', "%{$term}%")
                  ->orWhere('middlename', 'like', "%{$term}%");
            });
        }

        // Payment type filter
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->input('payment_type'));
        }

        // Service filter — service_ids is a JSON column, do JSON_CONTAINS
        if ($request->filled('service_id')) {
            $serviceId = (int) $request->input('service_id');
            $query->whereRaw('JSON_CONTAINS(service_ids, ?)', [json_encode($serviceId)]);
        }

        $appointments = $query->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();


        foreach ($appointments as $appt) {
            $serviceIds = is_string($appt->service_ids)
                ? json_decode($appt->service_ids, true)
                : $appt->service_ids;

            $appt->service_names = is_array($serviceIds) ? Service::whereIn('id', $serviceIds)->pluck('name')->toArray() : [];
            $appt->amount = $appt->total_price;
        }


        $totalCompleted = $appointments->where('status', 'completed')->sum('amount');
        $totalCash      = $appointments->where('payment_type', 'CASH')->sum('amount');
        $totalGcash     = $appointments->where('payment_type', 'GCASH')->sum('amount');

        $store = \App\Models\Store::find($branchId);

        // Filter dropdown sources
        $dentists = collect();
        if ($store) {
            $dentists = $store->staff()
                ->wherePivot('position', 'dentist')
                ->get(['users.id', 'users.name', 'users.lastname']);
        }
        $services = Service::orderBy('name')->get();

        return view('admin.reports.daily-appointments', compact(
            'appointments',
            'startDate',
            'endDate',
            'totalCompleted',
            'totalCash',
            'totalGcash',
            'store',
            'dentists',
            'services'
        ));
    }
}
