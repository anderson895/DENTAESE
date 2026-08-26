@extends('layout.navigation')

@section('title','Suspended & Deleted Medicines')
@section('main-content')

<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Suspended &amp; Deleted Medicines</h1>
    <a href="{{ route('inventory') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
        &larr; Back to Inventory
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
@endif

{{-- ================= SUSPENDED / EXPIRED BATCHES ================= --}}
<div class="bg-white rounded shadow p-4 mb-8">
    <h2 class="text-lg font-bold mb-3">Suspended &amp; Expired Batches</h2>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">Medicine</th>
                    <th class="border px-4 py-2">Batch #</th>
                    <th class="border px-4 py-2">Quantity</th>
                    <th class="border px-4 py-2">Expiration</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($batches as $batch)
                    @php
                        // Awtomatikong sinususpinde ng POS ang batch kapag naubos ang laman
                        // (POSController::store). Ibang usapin ito sa sadyang pagsuspinde,
                        // kaya hiwalay ang label — at walang Reactivate dahil walang
                        // maibabalik: bagong batch ang tama para sa bagong stock, may
                        // sarili itong expiration date.
                        $depleted = $batch->status === 'suspended' && $batch->quantity <= 0;
                    @endphp
                    <tr class="text-center">
                        <td class="border px-4 py-2 text-left">{{ $batch->medicine->name ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $batch->id }}</td>
                        <td class="border px-4 py-2">{{ $batch->quantity }}</td>
                        <td class="border px-4 py-2">
                            {{ $batch->expiration_date ? \Carbon\Carbon::parse($batch->expiration_date)->format('M d, Y') : '—' }}
                        </td>
                        <td class="border px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($batch->status === 'expired') bg-red-100 text-red-700
                                @elseif($depleted) bg-gray-100 text-gray-600
                                @else bg-yellow-100 text-yellow-700 @endif">
                                {{ $depleted ? 'Depleted' : ucfirst($batch->status) }}
                            </span>
                        </td>
                        <td class="border px-4 py-2">
                            @if($batch->status === 'expired')
                                <span class="text-gray-400 text-sm italic">Expired stock</span>
                            @elseif($depleted)
                                <span class="text-gray-400 text-sm italic">Walang stock — magdagdag ng bagong batch</span>
                            @else
                                <form method="POST" action="{{ route('batch.reactivate', $batch->id) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                        Reactivate
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border px-4 py-6 text-center text-gray-500">
                            No suspended or expired batches.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ================= DELETED MEDICINES ================= --}}
<div class="bg-white rounded shadow p-4">
    <h2 class="text-lg font-bold mb-3">Deleted Medicines</h2>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">Name</th>
                    <th class="border px-4 py-2">Unit</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Deleted At</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deletedMedicines as $medicine)
                    <tr class="text-center">
                        <td class="border px-4 py-2 text-left">{{ $medicine->name }}</td>
                        <td class="border px-4 py-2">{{ $medicine->unit }}</td>
                        <td class="border px-4 py-2">{{ number_format((float) $medicine->price, 2) }}</td>
                        <td class="border px-4 py-2">
                            {{ $medicine->deleted_at ? $medicine->deleted_at->format('M d, Y h:i A') : '—' }}
                        </td>
                        <td class="border px-4 py-2">
                            <form method="POST" action="{{ route('medicines.restore', $medicine->id) }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                    Restore
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-6 text-center text-gray-500">
                            No deleted medicines.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
