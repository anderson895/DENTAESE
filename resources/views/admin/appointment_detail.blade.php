@extends('layout.navigation')

@section('title', 'Appointment Details')

@section('main-content')


<style>
    [x-cloak] { display: none !important; }
</style>
@php
    $authPosition  = auth()->user()->position ?? '';
    $isReceptionist = $authPosition === 'Receptionist';
    // Receptionist always lands on "checkin" first; Dentist/Admin land on Current Status
    // (first tab) and may persist their last-active tab via localStorage.
    $defaultTab = $isReceptionist ? 'checkin' : 'medication';
@endphp
<div x-data="{
        tab: (new URLSearchParams(window.location.search).get('tab')) || (@js($isReceptionist) ? @js($defaultTab) : (localStorage.getItem('activeTab') || @js($defaultTab))),
        openReceiptModal: false
     }"
     x-init="$watch('tab', value => { if (!@js($isReceptionist)) localStorage.setItem('activeTab', value); })">

    <h1 class="text-2xl font-bold mb-4">Appointment #{{ $appointment->id }}</h1>

    <!-- Tabs -->
    <div class="flex border-b mb-4">
        <button @click="tab='medication'" :class="tab==='medication' ? 'text-blue-500 font-bold border-b-2 border-blue-500' : 'text-gray-500'" class="py-2 px-4">Current Status</button>
        <button @click="tab='info'" :class="tab==='info' ? 'text-blue-500 font-bold border-b-2 border-blue-500' : 'text-gray-500'" class="py-2 px-4">Dental Chart</button>
        <button @click="tab='rx'" :class="tab==='rx' ? 'text-blue-500 font-bold border-b-2 border-blue-500' : 'text-gray-500'" class="py-2 px-4">RX</button>
        <button @click="tab='pos'" :class="tab==='pos' ? 'text-blue-500 font-bold border-b-2 border-blue-500' : 'text-gray-500'" class="py-2 px-4">POS</button>
        <button @click="tab='checkin'" :class="tab==='checkin' ? 'text-blue-500 font-bold border-b-2 border-blue-500' : 'text-gray-500'" class="py-2 px-4">Check-in</button>
        <button @click="tab='treatment'" :class="tab==='treatment' ? 'text-blue-500 font-bold border-b-2 border-blue-500' : 'text-gray-500'" class="py-2 px-4">Treatment Record</button>
        <button @click="tab='patient'" :class="tab==='patient' ? 'text-blue-500 font-bold border-b-2 border-blue-500' : 'text-gray-500'" class="py-2 px-4">Patient Information</button>
    </div>

    <div x-show="tab==='patient'" x-cloak>
        <div id="printable-patient">
            @include('client.patient_record', ['patient'=> $patient])
        </div>
       
    </div>
    
    <div x-show="tab==='rx'" x-cloak>
        <div id="printable-rx">
            @include('admin.dental-chart.rx', ['medicines'=> $medicines, 'appointment'=>$appointment])
        </div>
    </div>

    <!-- Tab Contents -->
    <div x-show="tab==='checkin'">
    <div class="w-full mx-auto bg-white p-6 rounded shadow">

    <div class="flex items-center mt-2">
        
        <h2 class="text-2xl font-bold mb-4">Finalize Payment</h2>
        <!-- Next button (right) -->
        <button
            @click="tab='treatment'"
            class="ml-auto px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700"
        >
            Next
        </button>
    </div>

     

        

        <p>
            <strong>Client:</strong>
            {{ $appointment->user->lastname ?? 'N/A' }},
            {{ $appointment->user->name ?? 'N/A' }}
            {{ $appointment->user->middlename ?? 'N/A' }}
            {{ $appointment->user->suffix ?? '' }}
        </p>

        @php
            use Carbon\Carbon;

            $date  = Carbon::parse($appointment->appointment_date)->format('F j, Y');
            $start = Carbon::parse($appointment->appointment_time)->format('g:i A');
            $end   = Carbon::parse($appointment->booking_end_time)->format('g:i A');
            $arrived = $appointment->arrived_at ? Carbon::parse($appointment->arrived_at)->format('g:i A') : null;
        @endphp

        <div class="mt-2 mb-2">
            <strong>Dentist:</strong>
            @if(in_array($appointment->status, ['pending', 'approved', 'arrived']) && (auth()->user()->position === 'Receptionist' || auth()->user()->position === 'admin'))
                <select id="changeDentistSelect"
                        data-id="{{ $appointment->id }}"
                        class="border rounded p-1 ml-2">
                    @foreach($branchDentists as $d)
                        <option value="{{ $d->id }}" {{ $appointment->dentist_id == $d->id ? 'selected' : '' }}>
                            {{ $d->name }} {{ $d->lastname }}
                        </option>
                    @endforeach
                </select>
                <button id="saveDentistBtn" type="button" class="ml-2 px-3 py-1 bg-blue-600 text-white rounded text-sm">Save</button>
            @else
                {{ $appointment->dentist->name ?? 'N/A' }} {{ $appointment->dentist->lastname ?? '' }}
            @endif
        </div>

        <p><strong>Date:</strong> {{ $date }}</p>
        <p><strong>Time:</strong> {{ $start }} - {{ $end }}</p>
        @php $apptType = $appointment->appointment_type ?? 'scheduled'; @endphp
        <p>
            <strong>Appointment Status:</strong>
            <span class="px-2 py-0.5 rounded text-sm font-semibold
                {{ $apptType === 'walkin' ? 'bg-green-100 text-green-700' : ($apptType === 'emergency' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                {{ $apptType === 'walkin' ? 'Walk-in' : ucfirst($apptType) }}
            </span>
        </p>
        <p>
            <strong>Arrived at:</strong>
            @if(in_array($apptType, ['walkin', 'emergency']))
                <span class="text-gray-500 italic">Not applicable</span>
            @elseif($arrived)
                <span class="text-green-700 font-semibold">{{ $arrived }}</span>
            @else
                <span class="text-gray-500 italic">Not yet arrived</span>
            @endif
        </p>
        <p><strong>Branch:</strong> {{ $appointment->store->name ?? 'N/A' }}</p>

        <form id="finalizeAppointmentForm"
              data-id="{{ $appointment->id }}"
              enctype="multipart/form-data"
              method="POST">
            @csrf

            {{-- NOTE --}}
            <div class="mt-4">
                <label class="block font-semibold">Note</label>
                <textarea name="work_done"
                          rows="4"
                          class="w-full border rounded p-2"
                          ></textarea>
            </div>

            {{-- SERVICES --}}
            <div class="mt-4">
                <label class="block font-semibold mb-1">Service Done</label>

                <ul class="list-disc ml-5">
                    @foreach ($serviceNames as $index => $service)
                        <li>
                            {{ $service }}
                            <!-- – ₱{{ number_format($servicePrices[$index], 2) }} -->
                        </li>
                    @endforeach
                </ul>
            </div>

            @php
                // Medicines bought for this visit (mula sa POS sales na nakatali sa appointment)
                $checkinSales = \App\Models\Sale::with('items.medicine')
                    ->forAppointment($appointment)
                    ->get();
                $checkinMedicineTotal = $checkinSales->sum('total_amount');
                $checkinMedicineQty   = $checkinSales->flatMap->items->sum('quantity');

                // Ang amount_given ang naghahati: may halaga = nakolekta na sa
                // POS; NULL = sinadyang i-bill dito. Dapat tumugma ito sa
                // AdminBookingController, kung hindi ay iba ang ipinapakitang
                // babayaran sa aktuwal na sinisingil.
                $checkinPaidTotal   = $checkinSales->whereNotNull('amount_given')->sum('total_amount');
                $checkinUnpaidTotal = $checkinSales->whereNull('amount_given')->sum('total_amount');
            @endphp

            {{-- MEDICINES BOUGHT --}}
            <div class="mt-4">
                <label class="block font-semibold mb-1">Medicines Bought ({{ $checkinMedicineQty }} item{{ $checkinMedicineQty == 1 ? '' : 's' }})</label>
                @if($checkinSales->count())
                    <ul class="list-disc ml-5 text-sm">
                        @foreach($checkinSales as $sale)
                            @foreach($sale->items as $item)
                                <li>
                                    {{ $item->medicine->name ?? '—' }}
                                    ({{ $item->quantity }} × ₱{{ number_format($item->price, 2) }})
                                    — ₱{{ number_format($item->subtotal ?? ($item->quantity * $item->price), 2) }}
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 italic">No medicines bought for this visit.</p>
                @endif
            </div>

            {{-- SERVICE PRICE --}}
            <div class="mt-4">
                <label class="block font-semibold">Service Price (₱)</label>
                <input type="number"
                       name="total_price"
                       id="service_price_input"
                       value="{{ $appointment->total_price }}"
                       step="0.01"
                       min="0"
                       class="w-full border rounded p-2 " >
            </div>

            {{-- Hinahati ang gamot: ang bayad na sa POS ay pang-alam lang, ang
                 hindi pa bayad ay kasama sa Amount Due. --}}
            @if ($checkinPaidTotal > 0)
                <div class="mt-4">
                    <label class="block font-semibold">
                        Medicines
                        <span class="text-green-600 text-xs font-normal">— already paid at POS</span>
                    </label>
                    <input type="text"
                           value="{{ number_format($checkinPaidTotal, 2) }}"
                           class="w-full border rounded p-2 bg-gray-100 text-gray-500"
                           readonly>
                    <p class="text-xs text-gray-400 mt-1">Not included in the amount due below.</p>
                </div>
            @endif

            <div class="mt-4">
                <label class="block font-semibold">
                    Medicines to Collect (₱)
                    <span class="text-gray-400 text-xs font-normal">— billed to this appointment</span>
                </label>
                <input type="text"
                       id="medicine_total_display"
                       value="{{ number_format($checkinUnpaidTotal, 2) }}"
                       data-amount="{{ $checkinUnpaidTotal }}"
                       class="w-full border rounded p-2 bg-gray-100"
                       readonly>
            </div>

            {{-- PAYMENT TYPE --}}
            <div class="mt-4">
                <label class="block font-semibold">Payment Type</label>
                <select class="w-full border rounded p-2"
                        name="paytype"
                        id="paytype"
                        required>
                    <option value="GCASH">GCASH</option>
                    <option value="CASH">CASH</option>
                </select>
            </div>

            {{-- AMOUNT DUE — serbisyo lang. Kailangang tumugma ito sa
                 AdminBookingController::$grandTotal; kung hindi, iba ang
                 ipinapakita sa aktuwal na sinisingil. --}}
            <div class="mt-4">
                <label class="block font-semibold">Amount Due (₱) <span class="text-gray-400 text-xs font-normal">— service + unpaid medicines</span></label>
                <input type="text"
                       id="grand_total_display"
                       value="{{ number_format((float) $appointment->total_price + $checkinUnpaidTotal, 2) }}"
                       class="w-full border rounded p-2 bg-gray-100 font-semibold"
                       readonly>
            </div>

            {{-- AMOUNT GIVEN --}}
            <div class="mt-4">
                <label class="block font-semibold">Amount Given (₱)</label>
                <input type="number"
                       name="amount_given"
                       id="amount_given_input"
                       value="{{ $appointment->amount_given }}"
                       step="0.01"
                       min="0"
                       class="w-full border rounded p-2">
                <p id="amount_given_error" class="text-red-600 text-sm mt-1 hidden"></p>
            </div>

            {{-- CHANGE (SUKLI) --}}
            <div class="mt-4">
                <label class="block font-semibold">Change / Sukli (₱)</label>
                <input type="text"
                       id="change_display"
                       value="{{ $appointment->change_amount !== null ? number_format((float) $appointment->change_amount, 2) : '0.00' }}"
                       class="w-full border rounded p-2 bg-gray-100 font-semibold text-green-700"
                       readonly>
                <input type="hidden" name="change_amount" id="change_amount_input" value="{{ $appointment->change_amount }}">
            </div>

            {{-- RECEIPT --}}
            <div class="mt-4" hidden>
                <label class="block font-semibold">Upload Payment Receipt</label>
                <input type="file"
                       name="payment_receipt"
                       accept="image/*"
                       class="w-full border rounded p-2"
                       id="payment_receipt_input">

                <div class="mt-2">
                    <img id="receipt_preview"
                         src="#"
                         alt="Receipt Preview"
                         class="max-w-xs rounded border hidden" />
                </div>
            </div>

            <input type="hidden" name="status" id="status" value="completed">

            {{-- ACTION BUTTONS --}}

            <div class="mt-6">
                @if ($appointment->status === 'completed')
                    <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded font-semibold">
                        Paid
                    </span>
                @elseif ($appointment->status === 'no_show')
                    <span class="inline-block bg-red-100 text-red-700 px-4 py-2 rounded font-semibold">
                        No Show
                    </span>
                @else
                    <div class="flex flex-row gap-5" id="action-buttons">
                        <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded"
                                data-status="completed">
                            Complete
                        </button>

                        <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded"
                                data-status="no_show">
                            No Show
                        </button>
                    </div>
                @endif
            </div>

        </form>
    </div>
</div>


    <div x-show="tab==='pos'" x-cloak>
        <div class="bg-white p-6 rounded shadow">
            <div class="flex items-center mt-2 mb-4">
                <h2 class="text-xl font-bold">POS — Medicine Purchase</h2>
                <button
                    @click="tab='checkin'"
                    class="ml-auto px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Next
                </button>
            </div>

            <p class="text-sm text-gray-600 mb-4">
                Open the POS to record medicine purchases for
                <strong>{{ $appointment->user->name }} {{ $appointment->user->lastname }}</strong>.
                The total will be carried over automatically to the Treatment Record and the final receipt.
            </p>

            @php
                $patientSales = \App\Models\Sale::with('items.medicine')
                    ->forAppointment($appointment)
                    ->get();
                $patientMedicineTotal = $patientSales->sum('total_amount');
            @endphp

            <div class="mb-4">
                <a href="{{ route('pos.index', ['store' => $appointment->store_id, 'patient_id' => $appointment->user_id, 'appointment_id' => $appointment->id]) }}"
                   class="inline-block bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded">
                    Open POS for this Patient
                </a>
            </div>

            <h3 class="font-semibold text-gray-700 mb-2">Medicine Purchases for this Visit</h3>
            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2 text-left">Receipt #</th>
                        <th class="border px-3 py-2 text-left">Items</th>
                        <th class="border px-3 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patientSales as $sale)
                        <tr>
                            <td class="border px-3 py-2">{{ $sale->id }}</td>
                            <td class="border px-3 py-2">
                                <ul class="list-disc pl-4">
                                    @foreach($sale->items as $item)
                                        <li>
                                            {{ $item->medicine->name ?? '—' }}
                                            ({{ $item->quantity }} × ₱{{ number_format($item->price, 2) }})
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="border px-3 py-2 text-right">₱{{ number_format($sale->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-4">
                                No medicine purchases yet for this visit.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($patientMedicineTotal > 0)
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="2" class="border px-3 py-2 text-right font-semibold">Medicine Total</td>
                            <td class="border px-3 py-2 text-right font-semibold">₱{{ number_format($patientMedicineTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    <div x-show="tab==='medication'" x-cloak>
        @include('admin.dental-chart.current-medication', ['currentMedications' => $currentMedications, 'medicines' => $medicines, 'appointment' => $appointment])
    </div>

    <div x-show="tab==='treatment'" x-cloak>
        <div id="printable-treatment">
            @include('admin.dental-chart.treatment-record', ['record' => $record])
        </div>
    </div>
    
    <div x-show="tab==='info'" x-cloak>
        <div id="printable-info">
            @include('admin.dental-chart.index', ['patient'=> $patient])
        </div>
     
    </div>
    
    
</div>

<!-- Modal -->
<div
    x-data="{ openReceiptModal: false }"
    x-cloak
    x-show="openReceiptModal"
    @open-receipt.window="openReceiptModal = true"
    @close-receipt.window="openReceiptModal = false"
    @keydown.escape.window="openReceiptModal = false"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 no-print"
>


    <!-- MODAL CONTENT (compact + fully visible on screen) -->
    <div
        class="bg-white rounded-lg shadow-lg w-[640px] max-w-[95vw] max-h-[90vh] overflow-y-auto p-4 text-sm relative z-10"
        @click.stop
    >

        <!-- CLOSE BUTTON -->
        <button
        @click="openReceiptModal = false; localStorage.setItem('activeTab', 'rx'); location.reload();"
        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 no-print"
    >
        ✕
    </button>


        <!-- ================= RECEIPT ================= -->
        <div id="ack-receipt-print" class="print-area">

            <!-- HEADER -->
            @include('partials.print-header', [
                'title'   => 'Acknowledgement Receipt',
                'meta'    => ($appointment->store->name ?? '').' — '.($appointment->store->address ?? ''),
                'address' => $appointment->store->address ?? null,
            ])

            <!-- TITLE -->
            <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
                <strong>ACKNOWLEDGEMENT RECEIPT</strong>
                <span>
                    Date:
                    <span style="border-bottom:1px solid #000; padding:0 40px;">
                        {{ now()->format('m/d/Y') }}
                    </span>
                </span>
            </div>

            <!-- BODY -->
            <div style="line-height:2;">
                <div>
                    Received from
                    <span style="border-bottom:1px solid #000; display:inline-block; width:75%;">
                        {{ $appointment->user->name }}
                        {{ $appointment->user->lastname }}
                        {{ $appointment->user->suffix }}
                    </span>
                </div>

                <div>
                    Address at
                    <span style="border-bottom:1px solid #000; display:inline-block; width:78%;">
                        {{ $appointment->user->current_address }}
                    </span>
                </div>

                <div>
                    the sum of
                    <span id="receipt-sum-words"
                        style="border-bottom:1px solid #000; display:inline-block; width:78%;">
                        ____________________________
                    </span>
                </div>

                <div>
                    ( ₱
                    <span id="receipt-sum-amount"
                        style="border-bottom:1px solid #000; display:inline-block; width:120px;">
                    </span>
                    ) in full / partial payment for
                    <span style="border-bottom:1px solid #000; display:inline-block; width:45%;">
                        {{ $serviceNames->implode(', ') }}
                    </span>
                </div>
            </div>

            @php
                $combinedSales = \App\Models\Sale::with('items.medicine')
                    ->forAppointment($appointment)
                    ->get();
                $combinedMedTotal = $combinedSales->sum('total_amount');
                $combinedTreatmentTotal = (float) ($appointment->total_price ?? 0);
                $combinedGrandTotal = $combinedTreatmentTotal + $combinedMedTotal;
            @endphp

            @if($combinedSales->count() > 0 || $combinedTreatmentTotal > 0)
                <hr style="margin:14px 0;">
                <div style="font-size:11pt;">
                    <strong>Itemized Charges</strong>
                    <table style="width:100%; border-collapse:collapse; margin-top:6px; font-size:10pt;">
                        <thead>
                            <tr>
                                <th style="border:1px solid #000; padding:3px; text-align:left;">Description</th>
                                <th style="border:1px solid #000; padding:3px; text-align:right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($combinedTreatmentTotal > 0)
                                <tr>
                                    <td style="border:1px solid #000; padding:3px;">Treatment / Services</td>
                                    <td style="border:1px solid #000; padding:3px; text-align:right;">₱{{ number_format($combinedTreatmentTotal, 2) }}</td>
                                </tr>
                            @endif
                            @foreach($combinedSales as $sale)
                                @foreach($sale->items as $item)
                                    <tr>
                                        <td style="border:1px solid #000; padding:3px;">
                                            Medicine: {{ $item->medicine->name ?? '—' }}
                                            ({{ $item->quantity }} × ₱{{ number_format($item->price, 2) }})
                                        </td>
                                        <td style="border:1px solid #000; padding:3px; text-align:right;">₱{{ number_format($item->subtotal ?? ($item->quantity * $item->price), 2) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td style="border:1px solid #000; padding:3px; text-align:right; font-weight:bold;">Grand Total</td>
                                <td style="border:1px solid #000; padding:3px; text-align:right; font-weight:bold;">₱{{ number_format($combinedGrandTotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #000; padding:3px; text-align:right;">Amount Given</td>
                                <td style="border:1px solid #000; padding:3px; text-align:right;">₱<span id="receipt-given-amount">{{ number_format((float) $appointment->amount_given, 2) }}</span></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #000; padding:3px; text-align:right; font-weight:bold;">Change (Sukli)</td>
                                <td style="border:1px solid #000; padding:3px; text-align:right; font-weight:bold;">₱<span id="receipt-change-amount">{{ number_format((float) $appointment->change_amount, 2) }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- SIGNATURE -->
            <div style="margin-top:40px; text-align:right;">
                <strong>By:</strong>
                <div style="border-top:1px solid #000; width:220px; margin-left:auto; padding-top:5px;">
                    {{ Auth::user()->name }} {{ Auth::user()->lastname }}
                </div>
                <div style="font-size:10pt;">
                    {{ Auth::user()->position }}
                </div>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="mt-6 flex justify-end gap-3 no-print">
            <button
                @click="openReceiptModal = false; localStorage.setItem('activeTab', 'rx'); location.reload();"
                class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded"
            >
                Close
            </button>
            <button
                onclick="printCheckinReceipt()"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
            >
                Print
            </button>
        </div>

    </div>
</div>





</div>





{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('open_receipt'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        window.dispatchEvent(new CustomEvent('open-receipt'));
    });
</script>
@endif
@if(session('success'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: @json(session('success')),
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
</script>
@endif
<script>
function printCheckinReceipt() {
    // Default na 4x6 ang papel ng lahat ng resibo — nasa partials/print-scripts.
    window.printReceipt('ack-receipt-print', 'Acknowledgement Receipt');
}
</script>




<script>
$(document).on('click', '#saveDentistBtn', function () {
    const select = $('#changeDentistSelect');
    const id = select.data('id');
    const dentistId = select.val();

    Swal.fire({
        title: 'Change Dentist?',
        text: 'Reassign this appointment to the selected dentist?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, save'
    }).then((result) => {
        if (!result.isConfirmed) return;

        $.ajax({
            url: `/appointments/${id}/change-dentist`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                dentist_id: dentistId,
            },
            success: function (res) {
                Swal.fire('Saved', res.message, 'success');
            },
            error: function (xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Failed to update dentist.', 'error');
            }
        });
    });
});

// Serbisyo + gamot na hindi pa bayad. Ang bayad na sa POS ay wala sa
// #medicine_total_display, kaya hindi ito nadodoble. Dapat tumugma ito sa
// AdminBookingController::$grandTotal, kung hindi ay hindi magkakasundo ang
// ipinapakita sa UI at ang aktuwal na tinatanggap ng server.
function currentGrandTotal() {
    const servicePrice = parseFloat($('#service_price_input').val()) || 0;
    const unpaidMeds   = parseFloat($('#medicine_total_display').data('amount')) || 0;
    return servicePrice + unpaidMeds;
}

function peso(value) {
    return value.toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

// Ginagawang salita ang halaga para sa linyang "the sum of" ng resibo,
// hal. 500 → "Five Hundred Pesos Only".
const AMOUNT_ONES = ['Zero','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten',
    'Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen'];
const AMOUNT_TENS = ['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];
const AMOUNT_SCALES = [
    { value: 1000000000, name: 'Billion' },
    { value: 1000000,    name: 'Million' },
    { value: 1000,       name: 'Thousand' },
];

function amountBelowThousandToWords(n) {
    let words = [];
    if (n >= 100) {
        words.push(AMOUNT_ONES[Math.floor(n / 100)], 'Hundred');
        n %= 100;
    }
    if (n >= 20) {
        words.push(AMOUNT_TENS[Math.floor(n / 10)]);
        n %= 10;
        if (n) words.push(AMOUNT_ONES[n]);
    } else if (n > 0) {
        words.push(AMOUNT_ONES[n]);
    }
    return words.join(' ');
}

function amountToWords(n) {
    n = Math.floor(Math.abs(n));
    if (n === 0) return 'Zero';

    let words = [];
    AMOUNT_SCALES.forEach(scale => {
        if (n >= scale.value) {
            words.push(amountBelowThousandToWords(Math.floor(n / scale.value)), scale.name);
            n %= scale.value;
        }
    });
    if (n > 0) words.push(amountBelowThousandToWords(n));

    return words.join(' ');
}

function pesoInWords(amount) {
    const pesos    = Math.floor(Math.abs(amount));
    const centavos = Math.round((Math.abs(amount) - pesos) * 100);

    let words = amountToWords(pesos) + (pesos === 1 ? ' Peso' : ' Pesos');
    if (centavos > 0) {
        words += ' and ' + amountToWords(centavos) + (centavos === 1 ? ' Centavo' : ' Centavos');
    }
    return words + ' Only';
}

function refreshPaymentTotals() {
    const grandTotal     = currentGrandTotal();
    const formattedTotal = peso(grandTotal);

    $('#grand_total_display').val(formattedTotal);

    if (grandTotal > 0) {
        $('#receipt-sum-amount').text(formattedTotal);
        $('#receipt-sum-words').text(pesoInWords(grandTotal));
    } else {
        $('#receipt-sum-amount').text('');
        $('#receipt-sum-words').text('__________________________');
    }

    refreshChange();
}

// Kalkulahin ang sukli at harangan ang kulang na bayad
function refreshChange() {
    const grandTotal = currentGrandTotal();
    const givenRaw   = $('#amount_given_input').val();
    const given      = parseFloat(givenRaw) || 0;
    const hasAmount  = givenRaw !== '' && givenRaw !== null;
    const change     = given - grandTotal;
    const short      = hasAmount && change < 0;

    $('#change_display').val(short ? '0.00' : peso(Math.max(0, change)));
    $('#change_amount_input').val(short ? '' : Math.max(0, change).toFixed(2));

    const err = $('#amount_given_error');
    if (short) {
        err.text('Amount given is less than the total (₱' + peso(Math.abs(change)) + ' short).').removeClass('hidden');
    } else {
        err.addClass('hidden');
    }

    // Update receipt change line
    $('#receipt-change-amount').text(short ? '0.00' : peso(Math.max(0, change)));
    $('#receipt-given-amount').text(hasAmount ? peso(given) : '0.00');

    // Huwag payagang i-complete kapag kulang ang bayad
    const completeBtn = $('#action-buttons button[data-status="completed"]');
    completeBtn.prop('disabled', short)
               .toggleClass('opacity-50 cursor-not-allowed', short);

    return !short;
}

$(document).on('input', '#service_price_input', refreshPaymentTotals);
$(document).on('input', '#amount_given_input', refreshChange);
$(document).ready(refreshPaymentTotals);
    $(document).ready(function () {
                $('#payment_receipt_input').on('change', function (event) {
            const [file] = this.files;
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#receipt_preview')
                        .attr('src', e.target.result)
                        .removeClass('hidden'); // show preview
                };
                reader.readAsDataURL(file);
            }
        });

        
       $('#finalizeAppointmentForm button[type="submit"]').on('click', function (e) {
            e.preventDefault();

            // Clear previous validation errors
            $('.form-error').remove();
            $('input, textarea, select')
                .removeClass('border-red-500 ring-1 ring-red-500');

            const button = $(this);
            const status = button.data('status');

            // Bawal i-complete kapag kulang ang amount given sa total
            if (status === 'completed' && !refreshChange()) {
                Swal.fire('Insufficient Amount', $('#amount_given_error').text(), 'warning');
                return;
            }

            $('#status').val(status); // set hidden input

            const form = $('#finalizeAppointmentForm')[0];
            const id = $(form).data('id');
            const formData = new FormData(form);

            let confirmText = status === 'no_show'
                ? 'Are you sure you want to mark this appointment as No Show?'
                : 'Are you sure you want to finalize this appointment?';

            Swal.fire({
                title: 'Confirm Action',
                text: confirmText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: `/appointments/${id}/settle`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        // Clear local drafts on successful save
                        try {
                            localStorage.removeItem('appt_draft_{{ $appointment->id }}');
                            localStorage.removeItem('rx_draft_{{ $appointment->id }}');
                        } catch (e) {}

                        Swal.fire(
                            'Success',
                            res.message ?? 'Appointment completed successfully!',
                            'success'
                        ).then(() => {

                            // UI-only update (Blade remains untouched)
                            const newStatus = $('#status').val();
                            if (newStatus === 'completed') {
                                $('#action-buttons').replaceWith(`
                                    <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded font-semibold">
                                        Paid
                                    </span>
                                `);
                                // Receipt is only shown for completed (paid) appointments
                                window.dispatchEvent(new CustomEvent('open-receipt'));
                            } else if (newStatus === 'no_show') {
                                // No receipt for No Show — reload so the whole page
                                // (status, buttons, tables) reflects the new status.
                                location.reload();
                            }
                        });
                    },
                    error: function (xhr) {
                        let msg = xhr.responseJSON?.message || 'Failed to finalize appointment.';
                        const errs = xhr.responseJSON?.errors;
                        if (errs) {
                            msg = Object.values(errs).flat().join(' ');
                        }
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });
        });

    });
</script>





<script>
    // Back-compat: nasa partials/print-scripts.blade.php na ang totoong printer.
    // Hindi na sinisira ang pahina kaya wala nang reload/redirect pagkatapos.
    function printDiv(divId) {
        window.printSection(divId, { paper: 'Letter', scale: 80 });
    }
    </script>

<script>
// =========================================================================
// Local draft persistence for Check-in form + RX list, scoped per appointment.
// Restores values when the user leaves and comes back (e.g. via POS).
// =========================================================================
(function () {
    const APPT_KEY = 'appt_draft_{{ $appointment->id }}';
    const RX_KEY   = 'rx_draft_{{ $appointment->id }}';

    function checkinFields() {
        return [
            document.querySelector('#finalizeAppointmentForm textarea[name="work_done"]'),
            document.querySelector('#finalizeAppointmentForm select[name="paytype"]'),
            document.querySelector('#finalizeAppointmentForm input[name="total_price"]'),
        ].filter(Boolean);
    }

    function saveCheckinDraft() {
        const data = {};
        checkinFields().forEach(el => { data[el.name] = el.value; });
        try { localStorage.setItem(APPT_KEY, JSON.stringify(data)); } catch (e) {}
    }

    function restoreCheckinDraft() {
        let data;
        try { data = JSON.parse(localStorage.getItem(APPT_KEY) || '{}'); } catch (e) { return; }
        checkinFields().forEach(el => {
            if (data[el.name] !== undefined && data[el.name] !== '' && !el.value) {
                el.value = data[el.name];
            }
        });
    }

    function saveRxDraft() {
        const list = document.getElementById('rx-list');
        if (!list) return;
        try { localStorage.setItem(RX_KEY, list.innerHTML); } catch (e) {}
    }

    function restoreRxDraft() {
        const list = document.getElementById('rx-list');
        if (!list) return;
        const html = localStorage.getItem(RX_KEY);
        if (html && !list.innerHTML.trim()) {
            list.innerHTML = html;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        restoreCheckinDraft();
        restoreRxDraft();

        checkinFields().forEach(el => {
            el.addEventListener('input', saveCheckinDraft);
            el.addEventListener('change', saveCheckinDraft);
        });

        const rxList = document.getElementById('rx-list');
        if (rxList) {
            new MutationObserver(saveRxDraft).observe(rxList, { childList: true, subtree: true, attributes: true });
        }
    });
})();
</script>

@endsection
