@extends('layout.navigation')

@section('title', 'Appointment Details')

@section('main-content')


<style>
    [x-cloak] { display: none !important; }
</style>
<div x-data="{ tab: localStorage.getItem('activeTab') || 'info', openReceiptModal: true }" 
     x-init="$watch('tab', value => localStorage.setItem('activeTab', value))">

    <h1 class="text-2xl font-bold mb-4">Appointment #{{ $appointment->id }}</h1>

    <!-- Tabs -->
    <div class="flex border-b mb-4">
        <button @click="tab='info'" :class="tab==='info' ? 'text-blue-500 font-bold border-b-2 border-blue-500' : 'text-gray-500'" class="py-2 px-4">Dental Chart</button>
        <button @click="tab='checkin'" :class="tab==='checkin' ? 'text-blue-500 font-bold border-b-2 border-blue-500' : 'text-gray-500'" class="py-2 px-4">Check-in</button>
        <button @click="tab='rx'" :class="tab==='rx' ? 'text-blue-500 font-bold border-b-2 border-blue-500' : 'text-gray-500'" class="py-2 px-4">RX</button>
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
            @click="tab='rx'"
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

        <p><strong>Dentist:</strong> {{ $appointment->dentist->name ?? 'N/A' }}</p>

        @php
            use Carbon\Carbon;

            $date  = Carbon::parse($appointment->appointment_date)->format('F j, Y');
            $start = Carbon::parse($appointment->appointment_time)->format('g:i A');
            $end   = Carbon::parse($appointment->booking_end_time)->format('g:i A');
        @endphp

        <p><strong>Date:</strong> {{ $date }}</p>
        <p><strong>Time:</strong> {{ $start }} - {{ $end }}</p>
        <p><strong>Branch:</strong> {{ $appointment->store->name ?? 'N/A' }}</p>
        <p><strong>Description:</strong> {{ $appointment->desc }}</p>

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

            {{-- TOTAL PRICE --}}
            <div class="mt-4">
                <label class="block font-semibold">Total Price (₱)</label>
                <input type="number"
                       name="total_price"
                       value=""
                       step="0.01"
                       min="0"
                       class="w-full border rounded p-2 " >
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
            </div>
            <!-- <div class="mt-6">
                @if ($appointment->status === 'completed')
                    <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded font-semibold">
                        Completed
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
            </div> -->

        </form>
    </div>
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


    <!-- MODAL CONTENT -->
    <div
        class="bg-white rounded-lg shadow-lg w-[700px] p-6 relative z-10"
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
            <div style="text-align:center; line-height:1.4;">
                <strong>Santiago – Amancio Dental Clinic</strong><br>
                <span style="font-size:10pt;">
                    {{ $appointment->store->address ?? 'N/A' }}<br>
                    {{ $appointment->store->name ?? 'N/A' }}
                </span>
            </div>

            <hr style="margin:10px 0;">

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
                        {{ $appointment->service_name }}
                    </span>
                </div>
            </div>

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

        <!-- PRINT BUTTON -->
        <div class="mt-6 flex justify-end no-print">
            <button
                onclick="printCheckinReceipt()"
                class="bg-green-600 text-white px-4 py-2 rounded"
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
<script>
function printCheckinReceipt() {
    const receipt = document.getElementById('ack-receipt-print');
    if (!receipt) return;

    const printWindow = window.open('', '_blank', 'width=900,height=600');

    const doc = printWindow.document;

    // Title
    const title = doc.createElement('title');
    title.textContent = 'Check-in Receipt';
    doc.head.appendChild(title);

    // Print styles
    const style = doc.createElement('style');
    style.textContent = `
        @media print {
            @page { margin: 10mm; }
            body {
                font-family: system-ui, sans-serif;
                margin: 0;
            }
        }
    `;
    doc.head.appendChild(style);

    // Tailwind (optional)
    const tailwind = doc.createElement('link');
    tailwind.rel = 'stylesheet';
    tailwind.href = 'https://cdn.jsdelivr.net/npm/tailwindcss@3.4.0/dist/tailwind.min.css';
    doc.head.appendChild(tailwind);

    // Content
    const clone = receipt.cloneNode(true);
    doc.body.appendChild(clone);

    // Wait for styles & content
    setTimeout(() => {
        printWindow.focus();
        printWindow.print();
    }, 500);
}
</script>




<script>
$(document).on('input', 'input[name="total_price"]', function () {
    let value = parseFloat($(this).val());

    if (!value || value <= 0) {
        // $('#receipt-sum-amount').text('_________');
        $('#receipt-sum-words').text('__________________________');
        return;
    }

    // Format number ₱
    let formattedAmount = value.toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    // $('#receipt-sum-amount').text(formattedAmount);

    // OPTIONAL: words (simple version)
    $('#receipt-sum-words').text(formattedAmount + ' PESOS ONLY');
});
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
                        Swal.fire(
                            'Success',
                            res.message ?? 'Appointment completed successfully!',
                            'success'
                        ).then(() => {

                            // UI-only update (Blade remains untouched)
                            if ($('#status').val() === 'completed') {
                                $('#action-buttons').replaceWith(`
                                    <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded font-semibold">
                                        Completed
                                    </span>
                                `);
                            }

                            window.dispatchEvent(new CustomEvent('open-receipt'));
                        });
                    }
                }); 
            });
        });

    });
</script>





<script>
    function printDiv(divId) {
        const redirectUrl = "{{ route('appointments.view', ['id' => $appointment->id]) }}";
    
        // Clone the div to preserve structure
        const contentDiv = document.getElementById(divId);
        const clone = contentDiv.cloneNode(true);
    
        // Copy current values for all inputs/selects/textarea
        const originalInputs = contentDiv.querySelectorAll('input, select, textarea');
        const clonedInputs = clone.querySelectorAll('input, select, textarea');
    
        originalInputs.forEach((input, index) => {
            if (input.type === 'checkbox' || input.type === 'radio') {
                clonedInputs[index].checked = input.checked;
            } else {
                clonedInputs[index].value = input.value;
            }
        });
        const originalBody = document.body.innerHTML;
        document.body.innerHTML = `
        
            <style>
                @media print {
                    @page { margin: 0; }
                    body { margin: 1mm; font-family: system-ui, sans-serif; }
                    .no-print { display: none !important; }
                }
                body { font-family: system-ui, sans-serif; margin: 5mm; }
            </style>
        `;
        document.body.appendChild(clone);
        window.print();
        setTimeout(() => {
            window.location.href = redirectUrl;
        }, 200);
    }
    </script>
    

   
@endsection
