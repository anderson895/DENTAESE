<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\medicine_batches;
use App\Models\MedicineMovement;
use App\Models\Store;
use App\Models\Appointment;

use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    //

      public function index(Request $request, $storeId)
    {
       $medicines = medicine_batches::with('medicine')
    ->where('store_id', $storeId)
    ->where('quantity', '>', 0)
    ->where('status', 'active')
    // Manu-mano lang ang pagmarka ng 'expired', kaya may mga batch na lipas
    // na ang petsa pero 'active' pa rin. Hindi puwedeng maibenta ang mga ito.
    ->whereDate('expiration_date', '>=', today())
    ->get()
    ->groupBy('medicine_id')
    ->map(function ($batches) {
        $medicine = $batches->first()->medicine;
        return [
            'id' => $medicine->id,
            'name' => $medicine->name,
            'unit' => $medicine->unit,
            'price' => $medicine->price,
            'available_quantity' => $batches->sum('quantity'),
        ];
    });

    $store = Store::find($storeId);
    $preselectedPatientId = $request->input('patient_id') ?: session('pos_patient_id');
    $appointmentId        = $request->input('appointment_id') ?: session('pos_appointment_id');

    if ($request->has('appointment_id')) {
        $aid = $request->input('appointment_id');
        if ($aid === '' || $aid === null) {
            session()->forget('pos_appointment_id');
        } else {
            session()->put('pos_appointment_id', $aid);
        }
    }

    return view('admin.pos.index', compact('medicines', 'storeId', 'store', 'preselectedPatientId', 'appointmentId'));
    }

    private function rememberPatient(Request $request): void
    {
        if ($request->has('patient_id')) {
            $pid = $request->input('patient_id');
            if ($pid === '' || $pid === null) {
                session()->forget('pos_patient_id');
            } else {
                session()->put('pos_patient_id', $pid);
            }
        }
    }

    // Add to cart 
  public function addToCart(Request $request, $storeId)
{
    $request->validate([
        'medicine_id' => 'required|integer',
        'quantity'    => 'required|integer|min:1',
    ]);

    $this->rememberPatient($request);

    // Dito pinipili ang aktuwal na ibebenta, kaya dito rin dapat ang salain —
    // hindi sapat ang listahan sa index(). Walang status filter dati, at dahil
    // FIFO ito (pinakamalapit mag-expire ang una), ang lipas at suspendidong
    // batch pa mismo ang unang naibebenta.
    $batch = medicine_batches::where('medicine_id', $request->medicine_id)
        ->where('store_id', $storeId)
        ->where('status', 'active')
        ->whereDate('expiration_date', '>=', today())
        ->where('quantity', '>=', $request->quantity)
        ->orderBy('expiration_date', 'asc') // FIFO
        ->first();

    if (!$batch) {
        return back()->withErrors([
            'stock' => 'Not enough usable stock — expired and suspended batches are excluded.',
        ]);
    }

    $medicine = $batch->medicine;

    // Get current cart
    $cart = session()->get('cart', []);

    // Check for duplicates
    $exists = collect($cart)->firstWhere('medicine_id', $request->medicine_id);
    if ($exists) {
        return back()->withErrors(['cart' => 'This item is already in the cart!']);
    }

    // Add to cart
    $cart[] = [
        'medicine_id'   => $request->medicine_id,
        'medicine_name' => $medicine->name, 
        'batch_id'      => $batch->id,
        'quantity'      => $request->quantity,
        'price'         => $batch->medicine->price,
        'subtotal'      => $batch->medicine->price * $request->quantity,
    ];

    session()->put('cart', $cart);

    return redirect()->route('pos.index', $storeId)->with('success', 'Item added to cart!');
}


    // Checkout and save sale
    public function checkout(Request $request, $storeId)
{
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return back()->withErrors(['cart' => 'Cart is empty!']);
    }

    // Muling suriin ang bawat batch bago itala ang benta. Nasa session ang
    // cart, kaya puwedeng nag-iba na ang lagay mula nang idagdag ito: lumipas
    // na ang expiry, may ibang cashier na nakaubos, sinuspinde ang batch, o
    // nagpalit ng branch ang gumagamit. Hindi sapat ang tseke sa addToCart().
    foreach ($cart as $item) {
        $batch = medicine_batches::find($item['batch_id']);
        $name  = $item['medicine_name'] ?? 'This item';

        if (! $batch || $batch->store_id != $storeId || $batch->status !== 'active') {
            $error = "{$name} is no longer available for sale. Please remove it from the cart.";
        } elseif (\Carbon\Carbon::parse($batch->expiration_date)->toDateString() < today()->toDateString()) {
            $error = "{$name} (Batch #{$batch->id}) has expired and cannot be sold.";
        } elseif ($batch->quantity < $item['quantity']) {
            $error = "{$name} only has {$batch->quantity} left, but the cart has {$item['quantity']}.";
        } else {
            continue;
        }

        return back()->withErrors(['cart' => $error])->withInput();
    }

    $cartTotal = collect($cart)->sum('subtotal');

    // Kailangan ang Amount Given sa lahat ng paraan ng bayad — ito ang tanging
    // talaan ng aktuwal na natanggap. Dati ay filled() ang bantay, kaya ang
    // BLANGKO ay lumalaktaw sa buong tseke: nakakapag-checkout nang walang
    // naitalang bayad, at ipinapalit pa ng resibo ang total na parang bayad na.
    if (! $request->filled('amount_given')) {
        return back()->withErrors([
            'amount_given' => 'Amount given is required.',
        ])->withInput();
    }

    if (floatval($request->amount_given) < $cartTotal) {
        $short = number_format($cartTotal - floatval($request->amount_given), 2);
        return back()->withErrors([
            'amount_given' => "Amount given is less than the total (₱{$short} short). Please enter the full amount.",
        ])->withInput();
    }

    $sale = null;

    // Kapag binuksan ang POS mula sa isang appointment ("Open POS for this
    // Patient"), itali ang bentahan doon para siguradong lumalabas ang gamot
    // sa Treatment Record at sa panghuling resibo.
    $appointmentId = session('pos_appointment_id');

    DB::transaction(function () use ($cart, $storeId, $request, $appointmentId, &$sale) {
        $totalAmount = collect($cart)->sum('subtotal');
        // Garantisadong may laman na — at hindi na puwedeng maging null ang "0",
        // na dating nangyayari dahil falsy ang "0" sa PHP.
        $amountGiven  = floatval($request->amount_given);
        $changeAmount = max(0, $amountGiven - $totalAmount);

        $sale = Sale::create([
            'store_id'       => $storeId,
            'user_id'        => auth()->id(),
            'patient_id'     => $request->patient_id,
            'appointment_id' => $appointmentId,
            'total_amount'   => $totalAmount,
            'amount_given'   => $amountGiven,
            'change_amount'  => $changeAmount,
            'payment_method' => $request->payment_method,
            'status'         => 'completed',
        ]);

        foreach ($cart as $item) {
            SaleItem::create([
                'sale_id'           => $sale->id,
                'medicine_id'       => $item['medicine_id'],
               
                'medicine_batch_id' => $item['batch_id'],
                'quantity'          => $item['quantity'],
                'price'             => $item['price'],
                'subtotal'          => $item['subtotal'],
            ]);

            // Update stock
            $batch = medicine_batches::find($item['batch_id']);
            $batch->decrement('quantity', $item['quantity']);
            if ($batch->quantity <= 0) {
                $batch->status = 'suspended';
                $batch->save();
            }

            MedicineMovement::create([
                'medicine_id'       => $item['medicine_id'],
                'store_id'          => $storeId,
                'medicine_batch_id' => $item['batch_id'],
                'type'              => 'stock_out',
                // Positibo ang itinatala — ang `type` na ang nagsasabi kung
                // papasok o palabas. Lahat ng ibang movement (stock_in, Manual
                // Decrease, suspended, expired) ay positibo rin, at nagkakamali
                // ang kabuuan sa ulat kapag naghalo ang sign.
                'quantity'          => $item['quantity'],
                'remarks'           => "Sale #{$sale->id}",
            ]);
        }
    });


    session()->forget('cart');
    session()->forget('pos_patient_id');

    // If POS was opened from a specific appointment ("Open POS for this Patient"),
    // return to that appointment's POS tab so the user can see the recorded purchase.
    $appointmentId = session()->pull('pos_appointment_id');
    if ($appointmentId) {
        $appointment = Appointment::find($appointmentId);
        if ($appointment) {
            return redirect()->route('appointments.view', ['id' => $appointment->id, 'tab' => 'pos'])
                ->with('success', 'Sale recorded for this appointment.');
        }
    }

  return redirect()->route('pos.index', $storeId)
    ->with('receipt', $sale->load('items.medicine', 'patient', 'user'));
}

    public function updateCart(Request $request, $storeId)
{
    $request->validate([
        'index' => 'required|integer',
        'quantity' => 'required|integer|min:1',
    ]);

    $this->rememberPatient($request);

    $cart = session()->get('cart', []);
    if (!isset($cart[$request->index])) {
        return back()->withErrors(['cart' => 'Item not found in cart!']);
    }

    $item = $cart[$request->index];

    // Check stock availability
    $batch = medicine_batches::find($item['batch_id']);
    if (!$batch || $batch->quantity < $request->quantity) {
        return back()->withErrors(['cart' => 'Not enough stock available!']);
    }

    // Update quantity + subtotal
    $cart[$request->index]['quantity'] = $request->quantity;
    $cart[$request->index]['subtotal'] = $item['price'] * $request->quantity;

    session()->put('cart', $cart);

    return back()->with('success', 'Cart updated!');
}

// Remove item from cart
public function removeFromCart(Request $request, $storeId)
{
    $request->validate([
        'index' => 'required|integer',
    ]);

    $this->rememberPatient($request);

    $cart = session()->get('cart', []);
    if (isset($cart[$request->index])) {
        unset($cart[$request->index]);
        session()->put('cart', array_values($cart));
    }

    return back()->with('success', 'Item removed from cart!');
}

}
