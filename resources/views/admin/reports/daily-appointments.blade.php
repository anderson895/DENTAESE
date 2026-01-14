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

    {{-- DATE RANGE FILTER --}}
    <form method="GET" class="mb-6 flex gap-4 items-end no-print">

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

        <button class="bg-blue-600 text-white px-5 py-2 rounded h-10">
            Filter
        </button>
    </form>

    <!-- PRINT AREA -->
    <div id="print-section">

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
