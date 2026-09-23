<?php

namespace App\Http\Controllers;

use App\Models\medicine_batches;
use App\Models\MedicineMovement;
use App\Models\medicines;
use App\Models\Unit;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class InventoryController extends Controller
{
    /**
     * Ilang araw bago ang expiration ituturing nang "malapit nang mag-expire".
     * Kasintugma ng "Expiring medicines" sa dashboard (isang buwan).
     */
    public const EXPIRY_WARNING_DAYS = 30;

    /** Sa ilang natitirang piraso ituturing nang kaunti na ang stock. */
    public const LOW_STOCK_THRESHOLD = 10;

    //
       public function inventory(){
        $units = Unit::orderBy('name')->get();
        return view('admin.inventory', compact('units'));
    }

    // ─────────────────────────────────────────────
    // UNIT MANAGEMENT (add / edit / delete)
    // ─────────────────────────────────────────────
    public function unitList()
    {
        return response()->json([
            'status' => 'success',
            'data'   => Unit::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function unitStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:units,name',
        ]);

        $unit = Unit::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Unit added successfully.',
            'data'    => $unit,
        ]);
    }

    public function unitUpdate(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:units,name,' . $unit->id,
        ]);

        $oldName = $unit->name;
        $unit->update($validated);

        // Panatilihing tugma ang mga gamot na gumagamit ng lumang pangalan ng unit
        medicines::where('unit', $oldName)->update(['unit' => $validated['name']]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Unit updated successfully.',
        ]);
    }

    // ─────────────────────────────────────────────
    // SUSPENDED / DELETED MEDICINE LIST
    // ─────────────────────────────────────────────
    public function archivedList()
    {
        $branchId = session('active_branch_id');

        // Suspended at expired na batches ng kasalukuyang branch
        $batchQuery = medicine_batches::with('medicine')
            ->whereIn('status', ['suspended', 'expired'])
            ->latest('updated_at');

        if ($branchId && $branchId !== 'admin') {
            $batchQuery->where('store_id', $branchId);
        }

        // Mga gamot na binura (soft deleted)
        $deletedMedicines = medicines::onlyTrashed()
            ->orderByDesc('deleted_at')
            ->get();

        return view('admin.inventory-archived', [
            'batches'          => $batchQuery->get(),
            'deletedMedicines' => $deletedMedicines,
        ]);
    }

    public function restoreMedicine($id)
    {
        $medicine = medicines::onlyTrashed()->findOrFail($id);
        $medicine->restore();

        return back()->with('success', "\"{$medicine->name}\" has been restored.");
    }

    public function reactivateBatch($id)
    {
        try {
            DB::beginTransaction();

            $batch = medicine_batches::findOrFail($id);
            $batch->status = 'active';
            $batch->save();

            MedicineMovement::create([
                'store_id'          => $batch->store_id,
                'medicine_id'       => $batch->medicine_id,
                'medicine_batch_id' => $batch->id,
                'type'              => 'reactivated',
                'quantity'          => $batch->quantity,
                'remarks'           => 'Batch reactivated',
            ]);

            DB::commit();

            return back()->with('success', "Batch #{$batch->id} has been reactivated.");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to reactivate batch: ' . $e->getMessage());
        }
    }

    public function unitDestroy($id)
    {
        $unit = Unit::findOrFail($id);

        // Huwag payagang burahin ang unit na ginagamit pa ng mga gamot
        $inUse = medicines::where('unit', $unit->name)->count();
        if ($inUse > 0) {
            return response()->json([
                'status'  => 'error',
                'message' => "Cannot delete \"{$unit->name}\" — it is still used by {$inUse} medicine(s).",
            ], 422);
        }

        $unit->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Unit deleted successfully.',
        ]);
    }

     public function InventoryList(Request $request){

        $perPage = 10;

        $search = $request->input('search');
        $statusFilter = $request->input('stock_status');
        $branchId = session('active_branch_id');

        // Kapag "admin" ang napiling branch, walang tiyak na store na masusukat
        // kaya walang stock at status na maipapakita — gaya ng dating asal.
        $hasBranch = is_numeric($branchId);

        $today     = now()->toDateString();
        $warnUntil = now()->addDays(self::EXPIRY_WARNING_DAYS)->toDateString();

        // Ang binibilang na stock ay galing lang sa aktibong batch ng branch
        // na kasalukuyang nakabukas.
        $activeAtBranch = fn ($q) => $q->where('store_id', $branchId)->where('status', 'active');
        $onHand = fn ($q) => $activeAtBranch($q)->where('quantity', '>', 0);

        $query = medicines::query()
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->withSum(['batches as total_quantity' => $activeAtBranch], 'quantity')
            ->withCount([
                'batches as expired_batches' => fn ($q) => $onHand($q)
                    ->whereDate('expiration_date', '<', $today),
                'batches as near_expiry_batches' => fn ($q) => $onHand($q)
                    ->whereDate('expiration_date', '>=', $today)
                    ->whereDate('expiration_date', '<=', $warnUntil),
            ])
            ->withMin(['batches as nearest_expiration' => $onHand], 'expiration_date');

        // Sinasala sa SQL para tama pa rin ang pagination kada pahina.
        if ($hasBranch && $statusFilter) {
            $stockOnHand = '(select coalesce(sum(quantity), 0) from medicine_batches'
                . ' where medicine_batches.medicine_id = medicines.id'
                . ' and medicine_batches.store_id = ?'
                . " and medicine_batches.status = 'active')";

            switch ($statusFilter) {
                case 'out_of_stock':
                    $query->whereRaw("{$stockOnHand} <= 0", [$branchId]);
                    break;
                case 'low_stock':
                    $query->whereRaw("{$stockOnHand} > 0", [$branchId])
                          ->whereRaw("{$stockOnHand} <= ?", [$branchId, self::LOW_STOCK_THRESHOLD]);
                    break;
                case 'expired':
                    $query->whereHas('batches', fn ($q) => $onHand($q)
                        ->whereDate('expiration_date', '<', $today));
                    break;
                case 'near_expiry':
                    $query->whereHas('batches', fn ($q) => $onHand($q)
                        ->whereDate('expiration_date', '>=', $today)
                        ->whereDate('expiration_date', '<=', $warnUntil));
                    break;
            }
        }

        $item = $query->paginate($perPage);

        $item->getCollection()->transform(function ($medicine) use ($hasBranch) {
            $total = (int) ($medicine->total_quantity ?? 0);
            $medicine->total_quantity = $total;
            $medicine->stock_labels = $hasBranch ? $this->stockLabels($medicine, $total) : [];
            return $medicine;
        });

        return response()->json([
            'status' => 'success',
            'data' => $item->items(),
            'pagination' => [
                'total' => $item->total(),
                'per_page' => $item->perPage(),
                'current_page' => $item->currentPage(),
                'last_page' => $item->lastPage(),
                'next_page_url' => $item->nextPageUrl(),
                'prev_page_url' => $item->previousPageUrl(),
            ]
        ]);

    }

    /**
     * Mga babalang ididikit sa isang gamot. Maaaring sabay-sabay ang ilan —
     * puwedeng kaunti na ang natitira at malapit pa itong mag-expire — kaya
     * listahan ang ibinabalik at hindi iisang estado lang.
     */
    private function stockLabels($medicine, int $total): array
    {
        $labels = [];

        if (($medicine->expired_batches ?? 0) > 0) {
            $labels[] = ['key' => 'expired', 'text' => 'Expired', 'tone' => 'red'];
        }

        if ($total <= 0) {
            $labels[] = ['key' => 'out_of_stock', 'text' => 'Out of Stock', 'tone' => 'gray'];
        } elseif ($total <= self::LOW_STOCK_THRESHOLD) {
            $labels[] = ['key' => 'low_stock', 'text' => "Low Stock ({$total})", 'tone' => 'orange'];
        }

        if (($medicine->near_expiry_batches ?? 0) > 0) {
            $labels[] = ['key' => 'near_expiry', 'text' => 'Near Expiry', 'tone' => 'yellow'];
        }

        if (empty($labels)) {
            $labels[] = ['key' => 'in_stock', 'text' => 'In Stock', 'tone' => 'green'];
        }

        return $labels;
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:50',
        'unit' => 'required|string|max:50',
        'price' => 'required|numeric',
        'description' => 'nullable|string|max:255',
        'batch_quantity' => 'nullable|integer|min:1',
        'batch_expiration_date' => 'nullable|date',
    ]);

    $medicine = medicines::create([
        'name' => $request->name,
        'unit' => $request->unit,
        'price' => $request->price,
        'description' => $request->description,
    ]);

    // Create initial batch if quantity and expiration provided
    if ($request->filled('batch_quantity') && $request->filled('batch_expiration_date')) {
        \App\Models\medicine_batches::create([
            'medicine_id' => $medicine->id,
            'store_id' => session('active_branch_id'),
            'quantity' => $request->batch_quantity,
            'expiration_date' => $request->batch_expiration_date,
            'status' => 'active',
        ]);
    }

    return response()->json(['status' => 'success','message'=>'Medicine added']);
}

public function update(Request $request, medicines $medicine)
{
    $request->validate([
        'name'        => 'required|string|max:50',
        'unit'        => 'required|string|max:50',
        'price'       => 'required|numeric',
        'description' => 'nullable|string|max:255',
    ]);

    $medicine->update($request->only(['name', 'unit', 'price', 'description']));

    return response()->json(['status' => 'success', 'message' => 'Medicine updated']);
}

public function destroy(medicines $medicine)
{
    // Only ACTIVE batches with remaining stock should block deletion.
    // Expired/suspended batches are hidden from the inventory UI and represent
    // unusable stock, so they must not prevent removing a medicine that shows
    // as empty across all branches.
    $hasStock = $medicine->batches()
        ->where('status', 'active')
        ->where('quantity', '>', 0)
        ->exists();
    if ($hasStock) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Cannot delete: this medicine still has active batches with stock. Mark them expired or stock-out first.',
        ], 422);
    }

    $hasSales = \App\Models\SaleItem::where('medicine_id', $medicine->id)->exists();
    if ($hasSales) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Cannot delete: this medicine has sales history. Deletion would erase those records.',
        ], 422);
    }

    $medicine->delete();

    return response()->json(['status' => 'success', 'message' => 'Medicine deleted']);
}

public function show(medicines $medicine)
{
    $batches = $medicine->batches()
        ->where('store_id', Auth::user()->store_id)
        ->orderBy('expiration_date')
        ->get();

    return view('medicines.show', compact('medicine', 'batches'));
}

public function addBatch(Request $request, medicines $medicine)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'expiration_date' => 'required|date',
    ]);

    medicines::create([
        'medicine_id' => $medicine->id,
        'store_id' => Auth::user()->store_id,
        'quantity' => $request->quantity,
        'expiration_date' => $request->expiration_date,
    ]);

    return back()->with('success', 'Batch added successfully.');
}

public function showbatch(medicines $medicine)
{
    if (session('active_branch_id')=='admin') {
        $batches = $medicine->batches()
        // filter by branch
        ->with('store')
        ->where('status', 'active') // only show active
        ->orderBy('expiration_date', 'asc')
        ->get();
    } else {
        $batches = $medicine->batches()
    ->where('store_id', session('active_branch_id')) // filter by branch
    ->where('status', 'active') // only show active
    ->orderBy('expiration_date', 'asc')
    ->get();
    }
    
   

    return view('admin.medicines.show', compact('medicine', 'batches'));
}

public function storebatch(Request $request, medicines $medicine)
{
    $branchid ="{{session('active_branch_id')}}"; 
  
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'expiration_date' => 'required|date',
    ]);

   
    try {
        DB::beginTransaction();

        // Create batch
        $batch = $medicine->batches()->create([
            'store_id'       => $request->store_id,
            'quantity'       => $request->quantity,
            'expiration_date'=> $request->expiration_date,
            'status'         => 'active',
        ]);

        // Log movement
        MedicineMovement::create([
            'store_id'          => $request->store_id,
            'medicine_id'       => $medicine->id,
            'medicine_batch_id' => $batch->id,
            'type'              => 'stock_in',
            'quantity'          => $request->quantity,
            'remarks'           => 'New Batch',
        ]);

        DB::commit();

        return back()->with('success', 'Batch added successfully.');
    } 
    catch (\Exception $e) {
        DB::rollBack();

       
        \Log::error('Error adding batch: ' . $e->getMessage());

        return back()->with(['error' => 'An error occurred while adding the batch. Please try again.'. $e->getMessage()]);
    }
}

public function stockIn(Request $request, $id)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            DB::beginTransaction();
    
            $batch = medicine_batches::findOrFail($id);
            $batch->quantity += $request->quantity;
            $batch->save();

            MedicineMovement::create([
                'store_id'          => $batch->store_id,
                'medicine_id'       => $batch->medicine_id,
                'medicine_batch_id' => $batch->id,
                'type'              => 'stock_in',
                'quantity'          => $request->quantity,
                'remarks'           => 'Manual Add',
            ]);
    
            DB::commit();
    
            return back()->with('success', "Stock increased by {$request->quantity} for Batch #{$batch->id}");
        } catch (\Throwable $e) {
            DB::rollBack();

         
            \Log::error('Error suspend batch: ' . $e->getMessage());
    
            return back()->with(['error' => 'An error occurred while adding the batch. Please try again.'. $e->getMessage()]);
        }
       
    }

    /**
     * Stock Out - Decrease batch quantity
     */
    public function stockOut(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();
            $batch = medicine_batches::findOrFail($id);

        if ($request->quantity > $batch->quantity) {
            return back()->with('error', 'Not enough stock to remove.');
        }

        $batch->quantity -= $request->quantity;
        $batch->save();
        
        MedicineMovement::create([
            'store_id'          => $batch->store_id,
            'medicine_id'       => $batch->medicine_id,
            'medicine_batch_id' => $batch->id,
            'type'              => 'stock_out',
            'quantity'          => $request->quantity,
            'remarks'           => 'Manual Decrease',
        ]);

        DB::commit();

        return back()->with('success', "Stock decreased by {$request->quantity} for Batch #{$batch->id}");
        } catch (\Throwable $e) {
            DB::rollBack();

         
            \Log::error('Error suspend batch: ' . $e->getMessage());
    
            return back()->with(['error' => 'An error occurred while adding the batch. Please try again.'. $e->getMessage()]);
        }

       
    }

    /**
     * Suspend - Mark batch as suspended
     */
    public function suspend($id)
    {
        try {
            DB::beginTransaction();
            $batch = medicine_batches::findOrFail($id);
            $batch->status = 'suspended'; 
            $batch->save();
            
            MedicineMovement::create([
                'store_id'          => $batch->store_id,
                'medicine_id'       => $batch->medicine_id,
                'medicine_batch_id' => $batch->id,
                'type'              => 'suspended',
                'quantity'          => $batch->quantity,
                'remarks'           => 'Manual Suspended',
            ]);
    
            DB::commit();
            return back()->with('success', "Batch #{$batch->id} has been suspended.");
        } catch (\Throwable $e) {
            DB::rollBack();

         
            \Log::error('Error suspend batch: ' . $e->getMessage());
    
            return back()->with(['error' => 'An error occurred while adding the batch. Please try again.'. $e->getMessage()]);
        }
     
    }

    public function expired($id)
    {
        try {
       
            DB::beginTransaction();
            $batch = medicine_batches::findOrFail($id);
            $batch->status = 'expired'; 
            $batch->save();
            
            MedicineMovement::create([
                'store_id'          => $batch->store_id,
                'medicine_id'       => $batch->medicine_id,
                'medicine_batch_id' => $batch->id,
                'type'              => 'expired',
                'quantity'          => $batch->quantity,
                'remarks'           => 'Manual Expired',
            ]);
    
            DB::commit();

            \App\Services\Notifier::staffAndAdmins(
                $batch->store_id,
                'Medicine Marked as Expired',
                "\"{$batch->medicine->name}\" (Batch #{$batch->id}, qty {$batch->quantity}) has been marked as expired.",
                route('inventory.archived')
            );

            return back()->with('success', "Batch #{$batch->id} has been mark expired.");
        } catch (\Throwable $e) {
            DB::rollBack();

         
            \Log::error('Error expired batch: ' . $e->getMessage());
    
            return back()->with(['error' => 'An error occurred while adding the batch. Please try again.'. $e->getMessage()]);
        }
        
    }
}
