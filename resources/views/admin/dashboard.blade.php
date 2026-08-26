@extends('layout.navigation')

@section('title','Dashboard')
@section('main-content')

<!-- Content -->
<div class="p-6 overflow-y-auto">

    {{-- ================= GREETING (lahat ng view) ================= --}}
    @php
        $now  = now();
        $hour = (int) $now->format('G');
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
        $me = auth()->user();
        // Dr. + apelyido para sa dentista; pangalan lang para sa iba.
        $who = $me->position === 'Dentist' ? 'Dr. ' . $me->lastname : $me->name;
        $isAdminView = session('active_branch_id') == 'admin';

        // Mahahaba ang pangalan ng branch ("Prenza 1 Santiago-Amancio Branch") at
        // nagkakapatong sa x-axis. Tinatanggap ng ApexCharts ang array bilang
        // isang category — bawat elemento ay isang linya.
        $wrapLabel = fn ($n) => explode("\n", wordwrap((string) $n, 16, "\n", false));
    @endphp
    <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $greeting }}, {{ $who }}! 👋</h1>
            <p class="text-sm text-gray-500 mt-1">Here's what's happening in your clinic today.</p>
        </div>
        <div class="flex items-center gap-5 text-sm text-gray-500">
            @if ($isAdminView)
                {{-- Nakapirming panahon: ganito ang saklaw ng lahat ng KPI at
                     per-branch chart sa ibaba (AdminController). Label lang ito,
                     hindi pang-filter — huwag gawing mukhang mapipili. --}}
                <span class="flex items-center gap-2 border border-gray-200 rounded-md px-3 py-1.5 bg-white">
                    <i class="fa-regular fa-calendar text-gray-400"></i>{{ $now->format('F Y') }}
                </span>
            @else
                <span class="flex items-center gap-2">
                    <i class="fa-regular fa-calendar text-gray-400"></i>{{ $now->format('l, F j, Y') }}
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-regular fa-clock text-gray-400"></i>
                    {{-- Ang epoch ng server ang simula, para sundin ang Asia/Manila
                         kahit mali ang orasan ng PC na ginagamit. --}}
                    <span id="dashClock" data-epoch="{{ $now->getTimestamp() }}">{{ $now->format('h:i A') }}</span>
                </span>
            @endif
        </div>
    </div>

    @include('admin.partials.pending-approvals')

    @if ($isAdminView)
    {{-- ================= ADMIN KPI CARDS ================= --}}
    {{-- Ang tatlong pang-pera ay may sparkline ng 12 buwan at pagbabago
         kumpara sa nakaraang buwan. Itinatago ang badge kapag null ang
         pagbabago — Enero o zero ang nakaraan, kaya walang masasabing
         porsiyento (tingnan ang AdminController::$pctChange). --}}
    @php
        $kpis = [
            ['label' => 'Total Sales',              'value' => $monthlySalesTotal,
             'series' => $monthlySalesArr,   'change' => $salesChange,
             'icon' => 'fa-solid fa-peso-sign', 'tone' => 'purple'],
            ['label' => 'Appointment Earnings',     'value' => $monthlyAppointmentTotal,
             'series' => $monthlyEarningsArr, 'change' => $earningsChange,
             'icon' => 'fa-regular fa-calendar-check', 'tone' => 'blue'],
            ['label' => 'Total Earnings All Branches', 'value' => $monthlySalesTotal + $monthlyAppointmentTotal,
             'series' => $combinedArr,       'change' => $combinedChange,
             'icon' => 'fa-solid fa-building-columns', 'tone' => 'green'],
        ];
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

        <a href="/useraccount" class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-sm transition block">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center mb-3">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="text-2xl font-bold text-gray-800 leading-none">{{ $staffTotal }}</div>
            <div class="text-sm text-gray-500 mt-1">Total Staff</div>
            <div class="text-xs text-gray-400 mt-1">
                {{ $doctorCount }} dentists · {{ $receptionistCount }} receptionists · {{ $adminCount }} admins
            </div>
            <div class="text-xs text-primary font-medium mt-3">View Staff &rarr;</div>
        </a>

        <a href="/patientaccount" class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-sm transition block">
            <div class="w-11 h-11 rounded-xl bg-green-50 text-green-500 flex items-center justify-center mb-3">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="text-2xl font-bold text-gray-800 leading-none">{{ $patientCount }}</div>
            <div class="text-sm text-gray-500 mt-1">Patients</div>
            <div class="text-xs text-gray-400 mt-1">Across {{ $branchCount }} branches</div>
            <div class="text-xs text-primary font-medium mt-3">View Patients &rarr;</div>
        </a>

        @foreach ($kpis as $i => $kpi)
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <div class="w-11 h-11 rounded-xl bg-{{ $kpi['tone'] }}-50 text-{{ $kpi['tone'] }}-500 flex items-center justify-center mb-3">
                    <i class="{{ $kpi['icon'] }}"></i>
                </div>
                <div class="text-xl font-bold text-gray-800 leading-none">₱{{ number_format($kpi['value'], 2) }}</div>
                <div class="text-sm text-gray-500 mt-1">{{ $kpi['label'] }}</div>
                <div class="text-xs text-gray-400">({{ $now->format('F Y') }})</div>
                <div class="flex items-end justify-between gap-2 mt-2">
                    <div class="flex-1 min-w-0 kpi-spark"
                         data-series="{{ json_encode($kpi['series']) }}"
                         data-tone="{{ $kpi['tone'] }}"></div>
                    @if (!is_null($kpi['change']))
                        <span class="shrink-0 text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $kpi['change'] >= 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                            {{ $kpi['change'] >= 0 ? '↑' : '↓' }} {{ abs($kpi['change']) }}%
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    @endif
@if ($isAdminView)

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <div class="flex items-center justify-between gap-2 mb-2">
                <h3 class="font-semibold text-sm text-gray-700">Sales per Branch ({{ $now->format('F Y') }})</h3>
                <a href="{{ route('reports.sales') }}"
                   class="text-xs font-medium text-primary border border-gray-200 rounded-md px-3 py-1 hover:bg-gray-50">View Report</a>
            </div>
            <div id="salesPerBranchChart"></div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <div class="flex items-center justify-between gap-2 mb-2">
                <h3 class="font-semibold text-sm text-gray-700">Appointments per Branch ({{ $now->format('F Y') }})</h3>
                <a href="{{ route('reports.appointments') }}"
                   class="text-xs font-medium text-primary border border-gray-200 rounded-md px-3 py-1 hover:bg-gray-50">View Report</a>
            </div>
            <div id="appointmentsPerBranchChart"></div>
        </div>
    </div>

    {{-- Dalawang y-axis: piso sa kaliwa, bilang sa kanan. Magkaibang unit sila,
         kaya iisang axis ay magpapalabas ng patag na linya sa isa sa kanila. --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between gap-2 mb-2">
            <h3 class="font-semibold text-sm text-gray-700">Total Accumulated Sales &amp; Appointments (Monthly)</h3>
            <span class="text-xs text-gray-500 border border-gray-200 rounded-md px-3 py-1">{{ $now->format('Y') }}</span>
        </div>
        <div id="totalAccumulatedChart"></div>
    </div>
@endif

@if (session('active_branch_id') != "admin")

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
<script>
// ================= ADMIN CHARTS (ApexCharts) =================
// Lahat ay nakabantay sa element: sa branch view ay wala ang mga ito, kaya
// tahimik lang itong lalaktaw imbes na magbato ng error sa console.
(function () {
    if (typeof ApexCharts === 'undefined') return;

    const MONTHS = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const peso = (v) => '₱' + Number(v).toLocaleString('en-PH', { maximumFractionDigits: 0 });

    // SALES PER BRANCH
    const salesEl = document.getElementById('salesPerBranchChart');
    if (salesEl) new ApexCharts(salesEl, {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        series: [{ name: 'Sales', data: {!! json_encode($salesPerBranch->pluck('total')->map(fn ($v) => (float) $v)) !!} }],
        xaxis: {
            categories: {!! json_encode($salesPerBranch->pluck('name')->map($wrapLabel)) !!},
            labels: { style: { fontSize: '10px' } }
        },
        yaxis: { title: { text: 'Sales (₱)' }, labels: { formatter: (v) => Math.round(v).toLocaleString() } },
        colors: ['#3b82f6'],
        plotOptions: { bar: { borderRadius: 4, columnWidth: '45%' } },
        dataLabels: { enabled: true, formatter: peso, offsetY: -20, style: { colors: ['#374151'], fontSize: '11px' } },
        legend: { show: false },
        tooltip: { y: { formatter: peso } },
        noData: { text: 'No sales this month' }
    }).render();

    // APPOINTMENTS PER BRANCH
    const apptEl = document.getElementById('appointmentsPerBranchChart');
    if (apptEl) new ApexCharts(apptEl, {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        series: [{ name: 'Appointments', data: {!! json_encode($appointmentsPerBranch->pluck('total')->map(fn ($v) => (int) $v)) !!} }],
        xaxis: {
            categories: {!! json_encode($appointmentsPerBranch->pluck('name')->map($wrapLabel)) !!},
            labels: { style: { fontSize: '10px' } }
        },
        yaxis: { title: { text: 'Appointments' }, labels: { formatter: (v) => Math.round(v) } },
        colors: ['#10b981'],
        plotOptions: { bar: { borderRadius: 4, columnWidth: '45%' } },
        dataLabels: { enabled: true, offsetY: -20, style: { colors: ['#374151'], fontSize: '11px' } },
        legend: { show: false },
        noData: { text: 'No appointments this month' }
    }).render();

    // TOTAL ACCUMULATED — dalawang y-axis: piso sa kaliwa, bilang sa kanan.
    // Magkaibang unit sila; sa iisang axis ay lalapat sa zero ang bilang.
    const accEl = document.getElementById('totalAccumulatedChart');
    if (accEl) new ApexCharts(accEl, {
        chart: { type: 'area', height: 340, toolbar: { show: false } },
        series: [
            { name: 'Sales (₱)',    data: {!! json_encode($monthlySalesArr->map(fn ($v) => (float) $v)) !!} },
            { name: 'Appointments', data: {!! json_encode($monthlyAppointmentsArr->map(fn ($v) => (int) $v)) !!} }
        ],
        xaxis: { categories: MONTHS },
        yaxis: [
            { title: { text: 'Sales (₱)' }, labels: { formatter: (v) => Math.round(v).toLocaleString() } },
            { opposite: true, title: { text: 'Appointments' }, labels: { formatter: (v) => Math.round(v) } }
        ],
        colors: ['#3b82f6', '#10b981'],
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.35, opacityTo: 0.05 } },
        dataLabels: { enabled: false },
        markers: { size: 4 },
        legend: { position: 'top', horizontalAlign: 'left' },
        tooltip: { shared: true, intersect: false }
    }).render();

    // SPARKLINE sa bawat KPI card — 12 buwan ng kasaysayan sa likod ng numero.
    document.querySelectorAll('.kpi-spark').forEach(function (el) {
        const tones = { purple: '#a855f7', blue: '#3b82f6', green: '#22c55e' };
        new ApexCharts(el, {
            chart: { type: 'line', height: 44, sparkline: { enabled: true } },
            series: [{ name: 'Monthly', data: JSON.parse(el.dataset.series).map(Number) }],
            stroke: { curve: 'smooth', width: 2 },
            colors: [tones[el.dataset.tone] || '#3b82f6'],
            tooltip: { enabled: false }
        }).render();
    });
})();
</script>

@endsection
