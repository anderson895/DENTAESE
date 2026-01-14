@extends('layout.navigation')

@section('title','Dashboard')
@section('main-content')

<!-- Content -->
<div class="p-6 overflow-y-auto">
    @if (auth()->user()->position === 'admin')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">

   <!-- STAFF CARD -->
<a href="/useraccount"
   class="bg-white rounded-md border border-gray-200 p-6 shadow-md hover:shadow-lg transition duration-300 block">

    <!-- Header -->
    <div class="mb-5">
        <div class="text-3xl font-semibold text-primary">{{ $staffTotal }}</div>
        <div class="text-sm font-medium text-gray-400">Total Staff</div>
    </div>

    <!-- Role Breakdown -->
    <div class="grid grid-cols-3 gap-3">

        <!-- Doctors -->
        <div class="flex items-center gap-2 p-3 rounded-md bg-gray-50 border">
            <div class="text-blue-500 text-xl">👨‍⚕️</div>
            <div>
                <div class="text-lg font-semibold text-gray-800">{{ $doctorCount }}</div>
                <div class="text-xs text-gray-500">Doctors</div>
            </div>
        </div>

        <!-- Receptionists -->
        <div class="flex items-center gap-2 p-3 rounded-md bg-gray-50 border">
            <div class="text-green-500 text-xl">🧑‍💼</div>
            <div>
                <div class="text-lg font-semibold text-gray-800">{{ $receptionistCount }}</div>
                <div class="text-xs text-gray-500">Receptionists</div>
            </div>
        </div>

        <!-- Admins -->
        <div class="flex items-center gap-2 p-3 rounded-md bg-gray-50 border">
            <div class="text-purple-500 text-xl">🛡️</div>
            <div>
                <div class="text-lg font-semibold text-gray-800">{{ $adminCount }}</div>
                <div class="text-xs text-gray-500">Admins</div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="mt-4 text-accent font-medium text-sm hover:underline text-right">
        View Staff
    </div>
</a>


    <!-- NEW USERS FOR APPROVAL -->
<a href="/userverify"
   class="bg-white rounded-md border border-gray-200 p-6 shadow-md hover:shadow-lg transition duration-300 block relative">

    <div>
        <div class="text-3xl font-semibold text-primary">
            {{ \App\Models\newuser::where('account_type', 'patient')->count() }}
        </div>
        <div class="text-sm font-medium text-gray-400">
            New Users for Approval
        </div>
    </div>


    <div class="absolute bottom-4 right-4 text-accent font-medium text-sm hover:underline">
        View 
    </div>
</a>
<!-- PATIENTS -->
<a href="/patientaccount"
   class="bg-white rounded-md border border-gray-200 p-6 shadow-md hover:shadow-lg transition duration-300 block relative">

    <div>
        <div class="text-3xl font-semibold text-primary">
            {{ \App\Models\User::where('account_type', 'patient')->count() }}
        </div>
        <div class="text-sm font-medium text-gray-400">
            Patients
        </div>
    </div>

  
    <div class="absolute bottom-4 right-4 text-accent font-medium text-sm hover:underline">
        View
    </div>
</a>

</div>
@endif
   @if (auth()->user()->position === 'admin')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

    <!-- SALES THIS MONTH -->
    <div class="bg-white rounded-md border p-6 shadow hover:shadow-lg">
        <div class="text-2xl font-semibold text-primary">
            ₱{{ number_format($monthlySalesTotal, 2) }}
        </div>
        <div class="text-sm text-gray-400">Total Sales (This Month)</div>
    </div>

    <!-- APPOINTMENT EARNINGS -->
    <div class="bg-white rounded-md border p-6 shadow hover:shadow-lg">
        <div class="text-2xl font-semibold text-primary">
            ₱{{ number_format($monthlyAppointmentTotal, 2) }}
        </div>
        <div class="text-sm text-gray-400">Appointment Earnings (This Month)</div>
    </div>

    <!-- ACCUMULATED TOTAL -->
    <div class="bg-white rounded-md border p-6 shadow hover:shadow-lg">
        <div class="text-2xl font-semibold text-primary">
            ₱{{ number_format($monthlySalesTotal + $monthlyAppointmentTotal, 2) }}
        </div>
        <div class="text-sm text-gray-400">Total Earnings All Branches (This Month)</div>
    </div>

</div>
<script>
    console.log(@json(session('active_branch_id')));
</script>

@endif
 @if (session('active_branch_id') == "admin")

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- SALES PER BRANCH -->
    <div class="bg-white rounded-md border p-6 shadow hover:shadow-lg">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Sales per Branch (This Month)</h3>
        <canvas id="salesPerBranchChart"></canvas>
    </div>

    <!-- APPOINTMENTS PER BRANCH -->
    <div class="bg-white rounded-md border p-6 shadow hover:shadow-lg">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Appointments per Branch (This Month)</h3>
        <canvas id="appointmentsPerBranchChart"></canvas>
    </div>
</div>

<!-- TOTAL ACCUMULATED SALES & APPOINTMENTS -->
<div class="bg-white rounded-md border p-6 shadow hover:shadow-lg mb-6">
    <h3 class="text-lg font-semibold mb-4 text-gray-700">Total Accumulated Sales & Appointments (Monthly)</h3>
    <canvas id="totalAccumulatedChart"></canvas>
</div>

{{-- <canvas id="monthlySalesChart"></canvas>
<canvas id="monthlyAppointmentsChart"></canvas> --}}
@endif
 @if (session('active_branch_id') != "admin")
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="p-6 relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-50  w-full shadow-lg rounded">
            <div class="rounded-t mb-0 px-0 border-0">
                <div class="flex flex-wrap items-center px-4 py-2">
                    <div class="relative w-full max-w-full flex-grow flex-1">
                        <h3 class="font-semibold text-base ">Expiring Soon Inventory</h3>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                    <table class="items-center w-full bg-transparent border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 py-3 text-xs uppercase font-semibold text-left">Item</th>
                                <th class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 py-3 text-xs uppercase font-semibold text-left">Stocks</th>
                                <th class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 py-3 text-xs uppercase font-semibold text-left min-w-140-px">Expiration</th>
                            </tr>
                        </thead>
                      <tbody>
                        @forelse ($expiringSoon as $batch)
                            <tr class="text-gray-700 dark:text-gray-100">
                                <th class="border-t-0 px-4 py-4 text-left text-xs">
                                    {{ $batch->medicine->name }}
                                </th>
                                <td class="border-t-0 px-4 py-4 text-xs">
                                    {{ $batch->quantity }}
                                </td>
                                <td class="border-t-0 px-4 py-4 text-xs">
                                    Exp: {{ \Carbon\Carbon::parse($batch->expiry_date)->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500 text-xs">
                                    No medicines expiring soon 🎉
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-md p-6 rounded-md">
            <div class="flex justify-between mb-4 items-start">
                <div class="font-medium">Appointment Today</div>
            </div>
            <div class="overflow-hidden">
                <table class="w-full min-w-[540px]">
                    <tbody>
                        @forelse ($appointmentsToday as $appointment)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-100">
                                <div class="flex items-center">
                                    <a href="#" class="text-gray-600 text-sm font-medium hover:text-primary ml-2 truncate">
                                        {{ $appointment->user->name ?? 'Unknown' }}
                                    </a>
                                </div>
                            </td>
                            <td class="py-2 px-4 border-b border-gray-100">
                                <span class="text-[13px] font-medium text-gray-400">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('m-d-Y') }} {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                </span>
                            </td>
                            <td class="py-2 px-4 border-b border-gray-100">
                                <span class="text-[13px] font-medium text-gray-400">
                                    {{ $appointment->service_name }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-2 px-4 text-center text-gray-400 text-sm">No appointments for today.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white border border-gray-200 shadow-md p-6 rounded-md lg:col-span-2">
            <div class="flex items-center gap-2">
                <div class="font-medium">Appointment Count</div>
                <select id="appointmentFilter" class="ml-4 border rounded px-2 py-1 text-sm text-gray-600">
                    <option value="daily">Today</option>
                    <option value="weekly">This Week</option>
                    <option value="monthly">This Month</option>
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div class="rounded-md border border-dashed border-gray-200 p-4">
                    <div class="text-xl font-semibold text-primary" id="active-count">0</div>
                    <span class="text-gray-400 text-sm">Active</span>
                </div>
                <div class="rounded-md border border-dashed border-gray-200 p-4">
                    <div class="text-xl font-semibold text-primary" id="completed-count">0</div>
                    <span class="text-gray-400 text-sm">Completed</span>
                </div>
                <div class="rounded-md border border-dashed border-gray-200 p-4">
                    <div class="text-xl font-semibold text-primary" id="canceled-count">0</div>
                    <span class="text-gray-400 text-sm">Canceled</span>
                </div>
                <div class="rounded-md border border-dashed border-gray-200 p-4">
                    <div class="text-xl font-semibold text-primary" id="noshow-count">0</div>
                    <span class="text-gray-400 text-sm">No Show</span>
                </div>
            </div>
            <div>
                <canvas id="order-chart"></canvas>
            </div>
        </div>
    </div>
    @endif
</div>
<!-- End Content -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function loadAppointmentStats(filter = 'daily') {
    $.ajax({
        url: '/dashboard/appointment-stats',
        data: { filter: filter },
        success: function(data) {
            $('#active-count').text(data.active);
            $('#completed-count').text(data.completed);
            $('#canceled-count').text(data.canceled);
            $('#noshow-count').text(data.nowshow);
        }
    });
}

$('#appointmentFilter').on('change', function () {
    const selected = $(this).val();
    loadAppointmentStats(selected);
});

// Initial load
$(document).ready(function () {
    loadAppointmentStats();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
//     const salesPerBranchCtx = document.getElementById('salesPerBranchChart');

// new Chart(document.getElementById('salesPerBranchChart'), {
//     type: 'bar',
//     data: {
//         labels: {!! json_encode($salesPerBranch->pluck('name')) !!},
//         datasets: [{
//             label: 'Sales',
//             data: {!! json_encode($salesPerBranch->pluck('total')) !!}
//         }]
//     }
// });

// new Chart(document.getElementById('appointmentsPerBranchChart'), {
//     type: 'bar',
//     data: {
//         labels: {!! json_encode($appointmentsPerBranch->pluck('name')) !!},
//         datasets: [{
//             label: 'Appointments',
//             data: {!! json_encode($appointmentsPerBranch->pluck('total')) !!}
//         }]
//     }
// });

// new Chart(document.getElementById('totalAccumulatedChart'), {
//     type: 'line',
//     data: {
//         labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
//         datasets: [
//             {
//                 label: 'Sales',
//                 data: {!! json_encode($monthlySales->pluck('total')) !!}
//             },
//             {
//                 label: 'Appointments',
//                 data: {!! json_encode($monthlyAppointments->pluck('total')) !!}
//             }
//         ]
//     }
// });


// SALES PER BRANCH
new Chart(document.getElementById('salesPerBranchChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($salesPerBranch->pluck('name')) !!},
        datasets: [{
            label: 'Sales (₱)',
            data: {!! json_encode($salesPerBranch->pluck('total')) !!},
            backgroundColor: '#3B82F6' // Tailwind blue-500
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: { beginAtZero: true, title: { display: true, text: 'Sales (₱)' } },
            x: { title: { display: true, text: 'Branch' } }
        }
    }
});

// APPOINTMENTS PER BRANCH
new Chart(document.getElementById('appointmentsPerBranchChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($appointmentsPerBranch->pluck('name')) !!},
        datasets: [{
            label: 'Appointments',
            data: {!! json_encode($appointmentsPerBranch->pluck('total')) !!},
            backgroundColor: '#10B981' // Tailwind green-500
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: { beginAtZero: true, title: { display: true, text: 'Appointments' } },
            x: { title: { display: true, text: 'Branch' } }
        }
    }
});

// TOTAL ACCUMULATED SALES & APPOINTMENTS (LINE)
new Chart(document.getElementById('totalAccumulatedChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [
            {
                label: 'Sales (₱)',
                data: {!! json_encode($monthlySalesArr) !!}, // make sure this is 12 months
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                tension: 0.3,
                fill: true
            },
            {
                label: 'Appointments',
                data: {!! json_encode($monthlyAppointmentsArr) !!}, // 12 months
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                tension: 0.3,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: { beginAtZero: true },
            x: { title: { display: true, text: 'Month' } }
        }
    }
});

</script>

@endsection
