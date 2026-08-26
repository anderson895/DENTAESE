<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Appointment;

class DashboardController extends Controller
{
    //

    public function getAppointmentStats(Request $request)
{
    $filter = $request->input('filter', 'daily');
    $branchId = session('active_branch_id'); 

    $query = Appointment::where('store_id', $branchId);

    if ($filter === 'daily') {
        $query->whereDate('appointment_date', Carbon::today());
    } elseif ($filter === 'weekly') {
        $query->whereBetween('appointment_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    } elseif ($filter === 'monthly') {
        $query->whereMonth('appointment_date', Carbon::now()->month);
    }

    $active = (clone $query)->where('status', 'approved')->count();
    $completed = (clone $query)->where('status', 'completed')->count();
    $canceled = (clone $query)->where('status', 'cancelled')->count();
    $noshow = (clone $query)->where('status', 'no_show')->count();

    // Work queue ang Pending, hindi istatistika ng panahon: kailangan pa ring
    // aprubahan NGAYON ang appointment sa susunod na linggo. Sinasadyang hindi
    // ito sumusunod sa filter — kung "Today" ang saklaw nito, nagpapakita ito
    // ng 0 samantalang may 1 sa banner sa itaas at may 1 sa listahang bubukas
    // kapag pinindot ang card. Katugma ito ng AdminController::$pendingApprovals.
    $pending = Appointment::where('store_id', $branchId)
        ->where('status', 'pending')
        ->whereDate('appointment_date', '>=', Carbon::today())
        ->count();

    return response()->json([
        'active' => $active,
        'completed' => $completed,
        'canceled' => $canceled,
        'noshow' => $noshow,
        'pending' => $pending,
    ]);
}

    
}
