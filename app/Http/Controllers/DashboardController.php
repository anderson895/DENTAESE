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

    // Kasama ang 'arrived': aktibo pa rin ang pasyenteng naka-check-in na.
    // Noong 'approved' lang ang binibilang, walang card na sumasaklaw sa
    // 'arrived', kaya may appointment na hindi lumilitaw kahit saan sa hanay
    // at hindi nagtutugma ang kabuuan nito sa hanay ng Appointment Type.
    $active = (clone $query)->whereIn('status', ['approved', 'arrived'])->count();
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

    // Ibang dimensyon ito sa status — ang isang scheduled ay puwedeng completed
    // din. Hiwalay ang hanay nila sa dashboard para hindi magmukhang dapat
    // silang magsama-sama sa iisang total. Sumusunod ito sa period filter:
    // makatuwiran ang "ilang walk-in ngayong araw".
    $scheduled = (clone $query)->where('appointment_type', 'scheduled')->count();
    $walkin    = (clone $query)->where('appointment_type', 'walkin')->count();
    $emergency = (clone $query)->where('appointment_type', 'emergency')->count();

    // Lahat ng appointment sa napiling panahon, anuman ang status. Katumbas
    // ito ng scheduled + walkin + emergency, kaya may pantasteng tugma ang
    // dalawang hanay sa dashboard.
    $total = (clone $query)->count();

    return response()->json([
        'total' => $total,
        'active' => $active,
        'completed' => $completed,
        'canceled' => $canceled,
        'noshow' => $noshow,
        'pending' => $pending,
        'scheduled' => $scheduled,
        'walkin' => $walkin,
        'emergency' => $emergency,
    ]);
}

    
}
