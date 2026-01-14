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

    $appointments = Appointment::with(['user', 'dentist'])
    ->where('store_id', $branchId)
    ->whereIn('status', ['completed', 'cancelled', 'no_show']) 
    ->whereDate('appointment_date', '>=', $startDate)
    ->whereDate('appointment_date', '<=', $endDate)
    ->orderBy('appointment_date')
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

        return view('admin.reports.daily-appointments', compact(
            'appointments', 
            'startDate', 
            'endDate', 
            'totalCompleted',
            'totalCash',
            'totalGcash'
        ));
    }
}
