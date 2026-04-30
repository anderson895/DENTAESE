@extends('layout.navigation')

@section('title', 'Reports')
@section('main-content')

<style>
/* PRINT STYLE */
@media print {

    /* Hide everything except the report */
    body * {
        visibility: hidden;
    }

    #print-section, #print-section * {
        visibility: visible;
    }

    #print-section {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    /* Hide buttons and form when printing */
    .no-print {
        display: none !important;
    }

    .print-header {
        display: block !important;
    }
}
</style>

<div class="container mx-auto p-6">

    <div class="flex justify-between items-center mb-4 no-print">
        <h1 class="text-2xl font-bold">Appointments Report</h1>

        <!-- PRINT BUTTON -->
        <button onclick="window.print()"
            class="bg-green-600 px-4 py-2 text-white rounded hover:bg-green-700">
            Print Report
        </button>
    </div>

    {{-- FILTERS --}}
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end no-print bg-white p-4 rounded shadow">

        <div>
            <label class="font-semibold block">Start Date:</label>
            <input type="date" name="start_date" value="{{ $startDate }}"
                   class="border p-2 rounded w-full">
        </div>

        <div>
            <label class="font-semibold block">End Date:</label>
            <input type="date" name="end_date" value="{{ $endDate }}"
                   class="border p-2 rounded w-full">
        </div>

        <div>
            <label class="font-semibold block">Patient Name:</label>
            <input type="text" name="patient_name" value="{{ request('patient_name') }}"
                   placeholder="Search name..."
                   class="border p-2 rounded w-full">
        </div>

        <div>
            <label class="font-semibold block">Service:</label>
            <select name="service_id" class="border p-2 rounded w-full">
                <option value="">-- All Services --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-semibold block">Dentist (Staff):</label>
            <select name="dentist_id" class="border p-2 rounded w-full">
                <option value="">-- All Dentists --</option>
                @foreach($dentists as $d)
                    <option value="{{ $d->id }}" {{ request('dentist_id') == $d->id ? 'selected' : '' }}>
                        {{ $d->name }} {{ $d->lastname }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-semibold block">Status:</label>
            <select name="status" class="border p-2 rounded w-full">
                <option value="">-- All (completed, cancelled, no-show) --</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
            </select>
        </div>

        <div>
            <label class="font-semibold block">Payment Type:</label>
            <select name="payment_type" class="border p-2 rounded w-full">
                <option value="">-- All --</option>
                <option value="CASH" {{ request('payment_type') == 'CASH' ? 'selected' : '' }}>CASH</option>
                <option value="GCASH" {{ request('payment_type') == 'GCASH' ? 'selected' : '' }}>GCASH</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded h-10">
                Filter
            </button>
            <a href="{{ route('reports.appointments') }}" class="bg-gray-400 text-white px-5 py-2 rounded h-10 flex items-center">
                Reset
            </a>
        </div>
    </form>

    <!-- PRINT AREA -->
    <div id="print-section">

        <!-- Personalized Clinic Header (visible on print) -->
        <div class="text-center mb-6 print-header" style="display:none;">
            <h1 class="text-2xl font-bold">SANTIAGO-AMANCIO DENTAL CLINIC</h1>
            <p class="text-sm text-gray-600">{{ $store->name ?? '' }} &bull; {{ $store->address ?? '' }}</p>
            <hr class="mt-2 border-2">
        </div>

        <h2 class="text-xl font-bold mb-3">
            Appointments from {{ $startDate }} to {{ $endDate }}
        </h2>



        <table class="w-full border-collapse">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">ID</th>
            <th class="border p-2">Client Name</th>
            <th class="border p-2">Services</th>
            <th class="border p-2">Assigned Staff</th>
            <th class="border p-2">Date</th>
            <th class="border p-2">Time</th>
            <th class="border p-2">Status</th>
            <th class="border p-2">Payment Type</th>
            <th class="border p-2">Amount</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($appointments as $appt)
            <tr>
                <td class="border p-2 text-center">{{ $appt->id }}</td>

                <td class="border p-2">
                    {{ $appt->user->lastname }}, {{ $appt->user->name }}
                </td>

                <td class="border p-2">
                    {{ implode(', ', $appt->service_names) }}
                </td>

                <td class="border p-2">
                    {{ $appt->dentist->name ?? 'N/A' }}
                </td>

                <td class="border p-2 text-center">
                    {{ \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y') }}
                </td>

                <td class="border p-2 text-center">
                    {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}
                </td>

                <td class="border p-2 text-center font-bold
                    @if($appt->status === 'completed') text-green-600
                    @elseif(in_array($appt->status, ['cancelled','no_show'])) text-red-600
                    @endif
                ">
                    {{ ucfirst(str_replace('_',' ', $appt->status)) }}
                </td>

                <td class="border p-2 text-center">
                    {{ $appt->payment_type }}
                </td>

                <td class="border p-2 text-center">
                    ₱{{ number_format($appt->amount, 2) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center p-4 text-gray-500">
                    No appointments found in this date range.
                </td>
            </tr>
        @endforelse
    </tbody>

 <tfoot>
    <tr class="bg-gray-100 font-bold">
        <td colspan="8" class="border p-2 text-right">Total Completed:</td>
        <td class="border p-2 text-center">₱{{ number_format($totalCompleted, 2) }}</td>
    </tr>
    <tr class="bg-gray-100 font-bold">
        <td colspan="8" class="border p-2 text-right">Total Cash:</td>
        <td class="border p-2 text-center">₱{{ number_format($totalCash, 2) }}</td>
    </tr>
    <tr class="bg-gray-100 font-bold">
        <td colspan="8" class="border p-2 text-right">Total GCash:</td>
        <td class="border p-2 text-center">₱{{ number_format($totalGcash, 2) }}</td>
    </tr>
</tfoot>

</table>

    </div> <!-- END PRINT SECTION -->

</div>
@endsection
