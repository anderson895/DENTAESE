<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function index(Request $request, $storeId)
    {
        $query = Sale::with('patient', 'user', 'items.batch.medicine', 'items.medicine')
            ->where('store_id', $storeId);

        // Date filter
        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to = Carbon::parse($request->to)->endOfDay();
            $query->whereBetween('created_at', [$from, $to]);
        }

        // Patient name filter
        if ($request->filled('patient')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->patient . '%')
                  ->orWhere('lastname', 'like', '%' . $request->patient . '%');
            });
        }

        // Cashier name filter
        if ($request->filled('cashier')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cashier . '%')
                  ->orWhere('lastname', 'like', '%' . $request->cashier . '%');
            });
        }

        // Medicine name filter
        if ($request->filled('medicine')) {
            $query->whereHas('items.medicine', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->medicine . '%');
            });
        }

        $sales = $query->latest()->paginate(15);
        $store = Store::find($storeId);
        return view('admin.transactions.index', compact('sales', 'storeId', 'store'));
    }
}
