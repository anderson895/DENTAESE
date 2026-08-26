@extends('layout.navigation')

@section('title','Dashboard')
@section('main-content')

<!-- Content -->
<div class="p-6 overflow-y-auto">
    @if (auth()->user()->position === 'admin')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

   <!-- STAFF CARD -->
<a href="/useraccount"
   class="bg-white rounded-md border border-gray-200 p-6 shadow-md hover:shadow-lg transition duration-300 block lg:col-span-2">

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
    <div class="bg-white rounded-md border p-6 shadow">
        <div class="text-2xl font-semibold text-primary">
            ₱{{ number_format($monthlySalesTotal, 2) }}
        </div>
        <div class="text-sm text-gray-400">Total Sales (This Month)</div>
    </div>

    <!-- APPOINTMENT EARNINGS -->
    <div class="bg-white rounded-md border p-6 shadow">
        <div class="text-2xl font-semibold text-primary">
            ₱{{ number_format($monthlyAppointmentTotal, 2) }}
        </div>
        <div class="text-sm text-gray-400">Appointment Earnings (This Month)</div>
    </div>

    <!-- ACCUMULATED TOTAL -->
    <div class="bg-white rounded-md border p-6 shadow">
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
    <div class="bg-white rounded-md border p-6 shadow">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Sales per Branch (This Month)</h3>
        <canvas id="salesPerBranchChart"></canvas>
    </div>

    <!-- APPOINTMENTS PER BRANCH -->
    <div class="bg-white rounded-md border p-6 shadow">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Appointments per Branch (This Month)</h3>
        <canvas id="appointmentsPerBranchChart"></canvas>
    </div>
</div>

<!-- TOTAL ACCUMULATED SALES & APPOINTMENTS -->
<div class="bg-white rounded-md border p-6 shadow mb-6">
    <h3 class="text-lg font-semibold mb-4 text-gray-700">Total Accumulated Sales & Appointments (Monthly)</h3>
    <canvas id="totalAccumulatedChart"></canvas>
</div>

{{-- <canvas id="monthlySalesChart"></canvas>
<canvas id="monthlyAppointmentsChart"></canvas> --}}
@endif
 @if (session('active_branch_id') != "admin")

    {{-- ================= GREETING ================= --}}
    @php
        $now  = now();
        $hour = (int) $now->format('G');
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
        $me = auth()->user();
        // Dr. + apelyido para sa dentista; pangalan lang para sa iba.
        $who = $me->position === 'Dentist' ? 'Dr. ' . $me->lastname : $me->name;
    @endphp
    <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $greeting }}, {{ $who }}! 👋</h1>
            <p class="text-sm text-gray-500 mt-1">Here's what's happening in your clinic today.</p>
        </div>
        <div class="flex items-center gap-5 text-sm text-gray-500">
            <span class="flex items-center gap-2">
                <i class="fa-regular fa-calendar text-gray-400"></i>{{ $now->format('l, F j, Y') }}
            </span>
            <span class="flex items-center gap-2">
                <i class="fa-regular fa-clock text-gray-400"></i>
                {{-- Ang epoch ng server ang simula, para sundin ang Asia/Manila
                     kahit mali ang orasan ng PC na ginagamit. --}}
                <span id="dashClock" data-epoch="{{ $now->getTimestamp() }}">{{ $now->format('h:i A') }}</span>
            </span>
        </div>
    </div>

    {{-- PENDING APPOINTMENTS FOR APPROVAL --}}
    <div class="bg-white border-l-4 border-yellow-400 border border-gray-200 shadow-md p-6 rounded-md mb-6">
        <div class="flex justify-between items-center mb-4">
            <div class="font-medium flex items-center gap-2">
                <i class="fa-solid fa-hourglass-half text-yellow-500"></i>
                Pending Appointments — For Approval
                <span class="text-xs px-2 py-0.5 rounded-full {{ $pendingApprovals->count() ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-500' }} font-semibold">
                    {{ $pendingApprovals->count() }}
                </span>
            </div>
            <a href="{{ route('admin.booking', ['status' => 'pending']) }}" class="text-sm text-primary hover:underline font-medium">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[540px]">
                <tbody>
                    @forelse ($pendingApprovals->take(5) as $pendingAppointment)
                    <tr class="hover:bg-yellow-50 cursor-pointer transition"
                        onclick="window.location='{{ route('admin.booking', ['status' => 'pending']) }}'">
                        <td class="py-2 px-4 border-b border-gray-100">
                            <span class="text-gray-600 text-sm font-medium">
                                {{ $pendingAppointment->user->full_name ?? 'Unknown' }}
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b border-gray-100">
                            <span class="text-[13px] font-medium text-gray-400">
                                {{ \Carbon\Carbon::parse($pendingAppointment->appointment_date)->format('M d, Y') }}
                                {{ \Carbon\Carbon::parse($pendingAppointment->appointment_time)->format('h:i A') }}
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b border-gray-100">
                            <span class="text-[13px] font-medium text-gray-400">{{ $pendingAppointment->service_name }}</span>
                        </td>
                        <td class="py-2 px-4 border-b border-gray-100 text-right">
                            <span class="text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-800 font-semibold">Pending</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-2 px-4 text-center text-gray-400 text-sm">No pending appointments for approval. 🎉</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    {{-- Wala rito ang Pending: nasa banner na sa itaas, at hindi ito sumusunod
         sa period filter kaya hindi ito kauri ng apat na ito. Ang Total ay
         hindi link — walang "lahat ng status" na filter ang booking list, kaya
         hindi magtutugma ang bilang sa listahang bubukas. --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                <i class="fa-regular fa-calendar text-lg"></i>
            </div>
            <div class="min-w-0">
                <div class="text-2xl font-bold text-gray-800 leading-none" id="total-count">0</div>
                <div class="text-sm text-gray-600 mt-1">Total Appointments</div>
                <div class="text-xs text-gray-400 period-label">Today</div>
            </div>
        </div>

        <a href="{{ route('admin.booking', ['status' => 'approved,arrived']) }}"
           class="bg-white border border-gray-200 rounded-xl p-4 flex items-center gap-3 hover:border-green-400 hover:shadow-sm transition">
            <div class="w-11 h-11 rounded-xl bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                <i class="fa-regular fa-square-check text-lg"></i>
            </div>
            <div class="min-w-0">
                <div class="text-2xl font-bold text-gray-800 leading-none" id="active-count">0</div>
                <div class="text-sm text-gray-600 mt-1">Active</div>
                <div class="text-xs text-gray-400">Approved + Arrived</div>
            </div>
        </a>

        <a href="{{ route('admin.booking', ['status' => 'completed']) }}"
           class="bg-white border border-gray-200 rounded-xl p-4 flex items-center gap-3 hover:border-purple-400 hover:shadow-sm transition">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center shrink-0">
                <i class="fa-regular fa-clipboard text-lg"></i>
            </div>
            <div class="min-w-0">
                <div class="text-2xl font-bold text-gray-800 leading-none" id="completed-count">0</div>
                <div class="text-sm text-gray-600 mt-1">Completed</div>
                <div class="text-xs text-gray-400 period-label">Today</div>
            </div>
        </a>

        <a href="{{ route('admin.booking', ['status' => 'cancelled']) }}"
           class="bg-white border border-gray-200 rounded-xl p-4 flex items-center gap-3 hover:border-orange-400 hover:shadow-sm transition">
            <div class="w-11 h-11 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                <i class="fa-regular fa-circle-xmark text-lg"></i>
            </div>
            <div class="min-w-0">
                <div class="text-2xl font-bold text-gray-800 leading-none" id="canceled-count">0</div>
                <div class="text-sm text-gray-600 mt-1">Cancelled</div>
                <div class="text-xs text-gray-400 period-label">Today</div>
            </div>
        </a>

        <a href="{{ route('admin.booking', ['status' => 'no_show']) }}"
           class="bg-white border border-gray-200 rounded-xl p-4 flex items-center gap-3 hover:border-teal-400 hover:shadow-sm transition">
            <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-500 flex items-center justify-center shrink-0">
                <i class="fa-regular fa-eye-slash text-lg"></i>
            </div>
            <div class="min-w-0">
                <div class="text-2xl font-bold text-gray-800 leading-none" id="noshow-count">0</div>
                <div class="text-sm text-gray-600 mt-1">No Show</div>
                <div class="text-xs text-gray-400 period-label">Today</div>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <div class="rounded-t mb-0 px-0 border-0">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                    <h3 class="font-semibold text-base flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-red-500"></i>Expiring Soon Inventory
                    </h3>
                    <a href="{{ route('inventory') }}"
                       class="text-xs font-medium text-primary border border-gray-200 rounded-md px-3 py-1 hover:bg-gray-50">View All</a>
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
                            <tr class="text-gray-700 dark:text-gray-100 hover:bg-gray-100 cursor-pointer transition"
                                onclick="window.location='{{ route('inventory') }}?search={{ urlencode($batch->medicine->name) }}'">
                                <th class="border-t-0 px-4 py-4 text-left text-xs text-gray-500">
                                    {{ $batch->medicine->name }}
                                </th>
                                <td class="border-t-0 px-4 py-4 text-xs text-gray-500">
                                    {{ $batch->quantity }}
                                </td>
                                <td class="border-t-0 px-4 py-4 text-xs text-gray-500">
                                    Exp: {{ \Carbon\Carbon::parse($batch->expiry_date)->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-10">
                                    <i class="fa-solid fa-box-open text-3xl text-gray-300"></i>
                                    <div class="text-sm text-gray-500 mt-2">No medicines expiring soon</div>
                                    <div class="text-xs text-gray-400">You're all set! 🎉</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <div class="flex justify-between mb-4 items-center">
                <h3 class="font-semibold text-base flex items-center gap-2">
                    <i class="fa-regular fa-calendar text-blue-500"></i>Appointment Today
                </h3>
            </div>
            <div class="overflow-hidden">
                <table class="w-full min-w-[540px]">
                    <tbody>
                        @forelse ($appointmentsToday as $appointment)
                        <tr class="hover:bg-gray-50 cursor-pointer transition"
                            onclick="window.location='{{ route('appointments.view', $appointment->id) }}'">
                            <td class="py-2 px-4 border-b border-gray-100">
                                <div class="flex items-center">
                                    <span class="text-gray-600 text-sm font-medium hover:text-primary ml-2 truncate">
                                        {{ $appointment->user->name ?? 'Unknown' }}
                                    </span>
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
                            <td colspan="3" class="py-10 px-4 text-center">
                                <i class="fa-regular fa-calendar-check text-3xl text-gray-300"></i>
                                <div class="text-sm text-gray-500 mt-2">No appointments for today.</div>
                                <div class="text-xs text-gray-400">Enjoy your free time!</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= APPOINTMENT TYPE ================= --}}
    {{-- Ibang dimensyon ito sa status sa itaas — ang isang scheduled ay puwede
         ring completed — kaya hiwalay ang hanay. Kung pinagsama, magmumukhang
         dapat silang magsama-sama sa iisang total. --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
            <div class="font-semibold text-sm text-gray-700 lg:w-40 shrink-0">Appointment Type</div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-1">
                <a href="{{ route('admin.booking', ['type' => 'scheduled']) }}"
                   class="rounded-lg bg-blue-50 p-4 flex items-center gap-3 hover:bg-blue-100 transition">
                    <i class="fa-regular fa-calendar text-blue-500 text-lg"></i>
                    <div>
                        <div class="text-lg font-bold text-blue-600 leading-none" id="scheduled-count">0</div>
                        <div class="text-sm text-blue-700">Scheduled</div>
                    </div>
                </a>
                <a href="{{ route('admin.booking', ['type' => 'walkin']) }}"
                   class="rounded-lg bg-green-50 p-4 flex items-center gap-3 hover:bg-green-100 transition">
                    <i class="fa-solid fa-person-walking text-green-500 text-lg"></i>
                    <div>
                        <div class="text-lg font-bold text-green-600 leading-none" id="walkin-count">0</div>
                        <div class="text-sm text-green-700">Walk-in</div>
                    </div>
                </a>
                <a href="{{ route('admin.booking', ['type' => 'emergency']) }}"
                   class="rounded-lg bg-red-50 p-4 flex items-center gap-3 hover:bg-red-100 transition">
                    <i class="fa-solid fa-truck-medical text-red-500 text-lg"></i>
                    <div>
                        <div class="text-lg font-bold text-red-600 leading-none" id="emergency-count">0</div>
                        <div class="text-sm text-red-700">Emergency</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- ================= CHARTS ================= --}}
    {{-- Iisang tugon ng /dashboard/appointment-stats ang pinagmumulan ng mga
         card sa itaas at ng dalawang chart, kaya sabay silang nag-a-update
         kapag pinalitan ang period filter. Hindi kasama ang Pending sa status
         chart — hindi ito naka-scope sa panahon, kaya maling ihanay sa apat. --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <div class="flex items-center justify-between gap-2 mb-2">
                <div class="font-semibold text-sm text-gray-700">
                    Status Breakdown
                    <span class="text-gray-400 text-xs font-normal">(excludes Pending)</span>
                </div>
                <select id="appointmentFilter" class="border border-gray-200 rounded-md px-2 py-1 text-sm text-gray-600">
                    <option value="daily">Today</option>
                    <option value="weekly">This Week</option>
                    <option value="monthly">This Month</option>
                </select>
            </div>
            <div id="statusChart"></div>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <div class="font-semibold text-sm text-gray-700 mb-2">Appointment Type</div>
            <div id="typeChart"></div>
        </div>
    </div>
    @endif
</div>
<!-- End Content -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
let statusChart = null;
let typeChart = null;

function renderAppointmentCharts(data) {
    if (typeof ApexCharts === 'undefined') return;

    const statusValues = [data.active, data.completed, data.canceled, data.noshow].map(Number);
    const typeValues = [data.scheduled, data.walkin, data.emergency].map(Number);

    // Walang maipapakitang singsing ang donut kapag puro zero — ipasa ang
    // walang laman para lumabas ang noData na mensahe.
    const typeSeries = typeValues.reduce((a, b) => a + b, 0) ? typeValues : [];

    if (statusChart) {
        statusChart.updateSeries([{ name: 'Appointments', data: statusValues }]);
    } else {
        statusChart = new ApexCharts(document.querySelector('#statusChart'), {
            chart: { type: 'bar', height: 260, toolbar: { show: false } },
            series: [{ name: 'Appointments', data: statusValues }],
            xaxis: { categories: ['Active', 'Completed', 'Cancelled', 'No Show'] },
            yaxis: { labels: { formatter: (v) => Math.round(v) } },
            colors: ['#0ea5e9', '#22c55e', '#f97316', '#ef4444'],
            plotOptions: { bar: { distributed: true, borderRadius: 4, columnWidth: '55%' } },
            dataLabels: { enabled: true },
            legend: { show: false },
            noData: { text: 'No appointments for this period' }
        });
        statusChart.render();
    }

    if (typeChart) {
        typeChart.updateSeries(typeSeries);
    } else {
        typeChart = new ApexCharts(document.querySelector('#typeChart'), {
            chart: { type: 'donut', height: 260 },
            series: typeSeries,
            labels: ['Scheduled', 'Walk-in', 'Emergency'],
            colors: ['#3b82f6', '#22c55e', '#ef4444'],
            dataLabels: { enabled: false },
            plotOptions: {
                pie: { donut: { size: '68%', labels: {
                    show: true,
                    value: { fontSize: '22px', fontWeight: 700 },
                    total: { show: true, label: 'Total', formatter: (w) =>
                        w.globals.seriesTotals.reduce((a, b) => a + b, 0) }
                } } }
            },
            legend: {
                position: 'right',
                markers: { radius: 12 },
                // Ipinapakita ang aktwal na bilang at porsiyento sa tabi ng label.
                formatter: function (label, opts) {
                    const v = opts.w.globals.series[opts.seriesIndex];
                    const sum = opts.w.globals.series.reduce((a, b) => a + b, 0);
                    return label + '  ' + v + ' (' + (sum ? Math.round(v / sum * 100) : 0) + '%)';
                }
            },
            noData: { text: 'No appointments for this period' }
        });
        typeChart.render();
    }
}

const PERIOD_LABELS = { daily: 'Today', weekly: 'This Week', monthly: 'This Month' };

function loadAppointmentStats(filter = 'daily') {
    $('.period-label').text(PERIOD_LABELS[filter] || 'Today');

    $.ajax({
        url: '/dashboard/appointment-stats',
        data: { filter: filter },
        success: function(data) {
            renderAppointmentCharts(data);
            $('#total-count').text(data.total);
            $('#active-count').text(data.active);
            $('#completed-count').text(data.completed);
            $('#canceled-count').text(data.canceled);
            $('#noshow-count').text(data.noshow);
            $('#scheduled-count').text(data.scheduled);
            $('#walkin-count').text(data.walkin);
            $('#emergency-count').text(data.emergency);
        }
    });
}

// Buhay na orasan. Ang epoch ng server ang simula, kaya Asia/Manila pa rin ang
// sinusundan kahit mali ang oras ng PC — ang lumipas na oras lang ang mula sa browser.
(function () {
    const el = document.getElementById('dashClock');
    if (!el) return;
    const serverMs = Number(el.dataset.epoch) * 1000;
    const startedAt = Date.now();
    setInterval(function () {
        const t = new Date(serverMs + (Date.now() - startedAt));
        let h = t.getHours();
        const ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12 || 12;
        el.textContent = String(h).padStart(2, '0') + ':' +
            String(t.getMinutes()).padStart(2, '0') + ' ' + ampm;
    }, 1000);
})();

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
const salesPerBranchEl = document.getElementById('salesPerBranchChart');
if (salesPerBranchEl) new Chart(salesPerBranchEl, {
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
const appointmentsPerBranchEl = document.getElementById('appointmentsPerBranchChart');
if (appointmentsPerBranchEl) new Chart(appointmentsPerBranchEl, {
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
const totalAccumulatedEl = document.getElementById('totalAccumulatedChart');
if (totalAccumulatedEl) new Chart(totalAccumulatedEl, {
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
