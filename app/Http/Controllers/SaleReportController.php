<?php

namespace App\Http\Controllers;

use App\Models\medicines;
use App\Models\MedicineMovement;
use App\Models\Sale;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    //
    
public function index(Request $request)
{

     // Get branch from session
    $activeBranchId = session('active_branch_id');

    // For sales
    $from = $request->filled('from') ? Carbon::parse($request->from) : now()->startOfMonth();
    $to = $request->filled('to') ? Carbon::parse($request->to) : now()->endOfMonth();

    $cashierId  = $request->input('cashier_id');
    $patientId  = $request->input('patient_id');
    $medicineId = $request->input('medicine_id');

    $salesQuery = Sale::with(['user', 'patient', 'items.medicine'])
        ->whereBetween('created_at', [$from, $to]);

    if ($activeBranchId) {
        $salesQuery->where('store_id', $activeBranchId); //  filter by branch
    }

    if ($cashierId) {
        $salesQuery->where('user_id', $cashierId);
    }

    if ($patientId) {
        $salesQuery->where('patient_id', $patientId);
    }

    if ($medicineId) {
        $salesQuery->whereHas('items', function ($q) use ($medicineId) {
            $q->where('medicine_id', $medicineId);
        });
    }

    $sales = $salesQuery->get();

    // Filter dropdown sources
    $store = $activeBranchId ? Store::find($activeBranchId) : null;
    $cashiers = $store
        ? $store->staff()->get(['users.id', 'users.name', 'users.lastname'])
        : collect();
    $patients = User::where('account_type', 'patient')
        ->orderBy('lastname')->orderBy('name')
        ->get(['id', 'name', 'lastname']);
    $medicinesList = medicines::orderBy('name')->get(['id', 'name']);

    // For inventory
    $invFrom = $request->filled('inv_from') ? Carbon::parse($request->inv_from) : now()->startOfMonth();
    $invTo = $request->filled('inv_to') ? Carbon::parse($request->inv_to) : now()->endOfMonth();

    $movementsQuery = MedicineMovement::with(['medicine', 'batch'])
        ->whereBetween('created_at', [$invFrom, $invTo]);

    if ($activeBranchId) {
        $movementsQuery->where('store_id', $activeBranchId); //  filter by branch
    }

    $movements = $movementsQuery->get();

    return view('admin.reports.sales', compact(
        'sales', 'from', 'to', 'movements', 'invFrom', 'invTo',
        'cashiers', 'patients', 'medicinesList',
        'cashierId', 'patientId', 'medicineId'
    ));
}

}
