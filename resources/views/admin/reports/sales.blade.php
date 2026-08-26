@extends('layout.navigation')

@section('title', 'Reports')
@section('main-content')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

{{-- Ang aktibong tab lang ang ipinipirint, sa pamamagitan ng printSection(). --}}
<script>
    function printActiveReport(tab) {
        const titles = { sales: 'Sales Report', inventory: 'Inventory Movement' };
        window.printSection(tab + '-printable', {
            paper: 'Letter',
            scale: 80,
            title: titles[tab] || 'Report',
        });
    }
</script>

{{-- Panatilihin ang aktibong tab pagkatapos mag-filter (GET reload) --}}
<div x-data="{ tab: '{{ request('tab') === 'inventory' ? 'inventory' : 'sales' }}' }">

    <!-- Tabs -->
    <div class="flex gap-2 border-b mb-4">
        <button 
            @click="tab = 'sales'" 
            :class="tab === 'sales' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" 
            class="px-4 py-2 font-semibold">
            Sales Report
        </button>
        <button 
            @click="tab = 'inventory'" 
            :class="tab === 'inventory' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" 
            class="px-4 py-2 font-semibold">
            Inventory Movement
        </button>
    </div>

    <!-- Tab Content -->
    <div id="tab-content">
        <!-- Sales Report -->
        <div x-show="tab === 'sales'" id="sales-printable">
            <div class="hidden print:block">
                @include('partials.print-header', ['title' => 'Sales Report', 'meta' => 'Period: '.$from->format('M d, Y').' – '.$to->format('M d, Y')])
            </div>
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold print:hidden">Sales Report</h1>
                <button onclick="printActiveReport('sales')"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 print:hidden">
                    Print
                </button>
            </div>

            <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-3 items-end print:hidden bg-white p-4 rounded shadow">
                {{-- Manatili sa Sales Report tab pagkatapos mag-filter --}}
                <input type="hidden" name="tab" value="sales">
                {{-- Panatilihin ang mga filter ng Inventory Movement tab --}}
                @foreach(['inv_from', 'inv_to'] as $invParam)
                    @if(request()->filled($invParam))
                        <input type="hidden" name="{{ $invParam }}" value="{{ request($invParam) }}">
                    @endif
                @endforeach
                <div>
                    <label class="block text-sm font-semibold">From:</label>
                    <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="border rounded px-2 py-1 w-full">
                </div>
                <div>
                    <label class="block text-sm font-semibold">To:</label>
                    <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="border rounded px-2 py-1 w-full">
                </div>
                <div>
                    <label class="block text-sm font-semibold">Cashier:</label>
                    <select name="cashier_id" class="border rounded px-2 py-1 w-full">
                        <option value="">-- All Cashiers --</option>
                        @foreach($cashiers as $c)
                            <option value="{{ $c->id }}" {{ (string)$cashierId === (string)$c->id ? 'selected' : '' }}>
                                {{ trim(($c->lastname ?? '').', '.($c->name ?? '')) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold">Patient:</label>
                    <select name="patient_id" class="border rounded px-2 py-1 w-full">
                        <option value="">-- All Patients --</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ (string)$patientId === (string)$p->id ? 'selected' : '' }}>
                                {{ trim(($p->lastname ?? '').', '.($p->name ?? '')) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold">Medicine:</label>
                    <select name="medicine_id" class="border rounded px-2 py-1 w-full">
                        <option value="">-- All Medicines --</option>
                        @foreach($medicinesList as $m)
                            <option value="{{ $m->id }}" {{ (string)$medicineId === (string)$m->id ? 'selected' : '' }}>
                                {{ $m->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
                    <a href="{{ route('reports.sales') }}" class="px-4 py-2 bg-gray-400 text-white rounded flex items-center">Reset</a>
                </div>
            </form>

            <table class="table-auto border-collapse border border-gray-300 w-full">
                <thead>
                    <tr>
                        <th class="border px-2 py-1">Sale ID</th>
                        <th class="border px-2 py-1">Date</th>
                        <th class="border px-2 py-1">Cashier</th>
                        <th class="border px-2 py-1">Patient</th>
                        <th class="border px-2 py-1">Medicine</th>
                        <th class="border px-2 py-1">Qty</th>
                        <th class="border px-2 py-1">Price</th>
                        <th class="border px-2 py-1">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $shownTotal = 0; @endphp
                    @forelse($sales as $sale)
                        @php
                            $items = $medicineId
                                ? $sale->items->where('medicine_id', $medicineId)
                                : $sale->items;
                        @endphp
                        @foreach($items as $item)
                            @php $shownTotal += $item->subtotal; @endphp
                            <tr>
                                <td class="border px-2 py-1">{{ $sale->id }}</td>
                                <td class="border px-2 py-1">{{ $sale->created_at->format('Y-m-d') }}</td>
                                <td class="border px-2 py-1">{{ $sale->user->name }}</td>
                                <td class="border px-2 py-1">{{ $sale->patient?->name ?? 'Walk-in' }}</td>
                                <td class="border px-2 py-1">{{ $item->medicine->name }}</td>
                                <td class="border px-2 py-1">{{ $item->quantity }}</td>
                                <td class="border px-2 py-1">{{ number_format($item->price, 2) }}</td>
                                <td class="border px-2 py-1">{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8" class="border p-3 text-center text-gray-500">No sales found for the selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
                
            </table>
            <div class="mt-4 text-right font-bold text-lg">
        Grand Total: {{ number_format($medicineId ? $shownTotal : $sales->sum('total_amount'), 2) }}
    </div>
        </div>

<!-- Inventory Movement -->
<div x-show="tab === 'inventory'" id="inventory-printable">
    <div class="hidden print:block">
        @include('partials.print-header', ['title' => 'Inventory Movement', 'meta' => 'Period: '.request('inv_from', now()->startOfMonth()->format('Y-m-d')).' – '.request('inv_to', now()->endOfMonth()->format('Y-m-d'))])
    </div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold print:hidden">Inventory Movement</h1>
        <button onclick="printActiveReport('inventory')"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 print:hidden">
            Print
        </button>
    </div>

    <!-- Date Range Filter -->
    <form method="GET" class="mb-4 flex gap-2 items-center print:hidden">
        {{-- Manatili sa Inventory Movement tab pagkatapos mag-filter --}}
        <input type="hidden" name="tab" value="inventory">
        {{-- Panatilihin ang mga filter ng Sales Report tab --}}
        @foreach(['from', 'to', 'cashier_id', 'patient_id', 'medicine_id'] as $salesParam)
            @if(request()->filled($salesParam))
                <input type="hidden" name="{{ $salesParam }}" value="{{ request($salesParam) }}">
            @endif
        @endforeach
        <label>
            From:
            <input type="date" name="inv_from" value="{{ request('inv_from', now()->startOfMonth()->format('Y-m-d')) }}" class="border rounded px-2 py-1">
        </label>
        <label>
            To:
            <input type="date" name="inv_to" value="{{ request('inv_to', now()->endOfMonth()->format('Y-m-d')) }}" class="border rounded px-2 py-1">
        </label>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 print:hidden">
            Filter
        </button>
    </form>

    @php
        // Apply date filtering in controller instead of view, 
        // but we keep fallback here just in case
        $groupedMovements = $movements->groupBy('type');
    @endphp

    @foreach (['stock_in' => 'Stock In', 'stock_out' => 'Stock Out', 'expired' => 'Expired'] as $type => $label)
        <h2 class="text-xl font-semibold mt-6 mb-2">{{ $label }}</h2>
        <table class="table-auto border-collapse border border-gray-300 w-full mb-6">
            <thead>
                <tr>
                    <th class="border px-2 py-1">Date</th>
                    <th class="border px-2 py-1">Medicine</th>
                    <th class="border px-2 py-1">Batch</th>
                    <th class="border px-2 py-1">Quantity</th>
                    <th class="border px-2 py-1">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalQty = 0;
                @endphp
                @forelse ($groupedMovements[$type] ?? [] as $movement)
                    <tr>
                        <td class="border px-2 py-1">{{ $movement->created_at->format('Y-m-d') }}</td>
                        <td class="border px-2 py-1">{{ $movement->medicine?->name ?? '—' }}</td>
                        <td class="border px-2 py-1">{{ $movement->batch?->medicine_id ?? 'N/A' }}</td>
                        <td class="border px-2 py-1">{{ $movement->quantity }}</td>
                        <td class="border px-2 py-1">{{ $movement->remarks }}</td>
                    </tr>
                    @php
                        $totalQty += $movement->quantity;
                    @endphp
                @empty
                    <tr>
                        <td colspan="5" class="border px-2 py-2 text-center text-gray-500">No {{ $label }} records</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right font-bold px-2 py-1">Total</td>
                    <td class="border px-2 py-1 font-bold">{{ $totalQty }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    @endforeach
</div>


    </div>
</div>
@endsection
