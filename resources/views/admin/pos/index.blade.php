@extends('layout.navigation')

@section('title', 'POS - Store ' . $storeId)

@section('main-content')
<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-7xl mx-auto p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Medicines List (Left Side) -->
    <div class="lg:col-span-2 space-y-4">
        <div class="flex flex-row justify-between items-center flex-wrap gap-3">
            <div class="flex items-center gap-3 mb-4">
                @if(!empty($appointmentId))
                    <a href="{{ route('appointments.view', ['id' => $appointmentId, 'tab' => 'pos']) }}"
                       class="inline-flex items-center px-3 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Back to Appointment
                    </a>
                @endif
                <h1 class="text-3xl font-bold text-sky-600">Point of Sale</h1>
            </div>
            <div class="flex gap-2 items-center">
                <div class="relative">
                    <input type="text" id="posSearch" placeholder="Type to search medicine..."
                        class="border rounded-lg p-2 w-72 focus:ring-2 focus:ring-sky-400"
                        autocomplete="off"
                        onkeyup="filterMedicines()"
                        onfocus="showPosSuggestions()"
                        onblur="setTimeout(hidePosSuggestions, 150)">
                    <div id="posSuggestions" class="absolute z-20 bg-white border rounded-lg w-72 max-h-72 overflow-y-auto hidden shadow-lg mt-1"></div>
                </div>
                <button
                onclick="window.location='{{ route('transactions.index', ['storeId' => session('active_branch_id')]) }}'"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition">
                Transaction History
                </button>
            </div>
        </div>
       

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($medicines as $medicine)
                <div class="bg-white rounded-xl shadow border p-4 flex flex-col justify-between medicine-card" data-name="{{ strtolower($medicine['name']) }}">
                    <div>
                        <h2 class="text-lg font-semibold text-sky-700">{{ $medicine['name'] }}</h2>
                        <p class="text-sm text-gray-600">{{ $medicine['unit'] }}</p>
                        <p class="mt-2 text-lg font-bold text-sky-600">₱{{ number_format($medicine['price'], 2) }}</p>
                        <p class="text-sm text-gray-500">Available: 
                            <span class="font-semibold text-sky-700">{{ $medicine['available_quantity'] }}</span>
                        </p>
                    </div>

                    <form method="POST" action="{{ route('pos.add', $storeId) }}" class="mt-3 flex gap-2">
                        @csrf
                        <input type="hidden" name="medicine_id" value="{{ $medicine['id'] }}">
                        <input type="hidden" name="patient_id" class="patient_id_mirror" value="{{ $preselectedPatientId ?? '' }}">
                        <input type="number" name="quantity" min="1"
                            max="{{ $medicine['available_quantity'] }}"
                            class="w-20 p-2 border rounded-lg text-center focus:ring-2 focus:ring-sky-400">
                        <button class="flex-1 px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                            Add
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Cart + Checkout (Right Side) -->
    <div class="bg-white rounded-2xl shadow-lg border border-sky-200 p-6 sticky top-6 h-fit">
        <h2 class="text-xl font-bold text-sky-700 mb-4">Cart</h2>

        @php $cart = session('cart', []); @endphp
        <div class="space-y-3 mb-4">
            @forelse($cart as $i => $item)
                <div class="flex justify-between items-center bg-sky-50 p-3 rounded-lg shadow">
                    <div>
                        <p class="font-semibold">{{ $item['medicine_name'] }}</p>
                        <p class="text-sm text-gray-600">₱{{ number_format($item['price'],2) }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Update -->
                        <form method="POST" action="{{ route('pos.update', $storeId) }}" class="flex items-center gap-1">
                            @csrf
                            <input type="hidden" name="index" value="{{ $i }}">
                            <input type="hidden" name="patient_id" class="patient_id_mirror" value="{{ $preselectedPatientId ?? '' }}">
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                min="1" max="999"
                                class="w-14 p-1 border rounded-lg text-center">
                            <button class="px-2 py-1 bg-sky-500 text-white rounded hover:bg-sky-600">⟳</button>
                        </form>

                        <!-- Remove -->
                        <form method="POST" action="{{ route('pos.remove', $storeId) }}">
                            @csrf
                            <input type="hidden" name="index" value="{{ $i }}">
                            <input type="hidden" name="patient_id" class="patient_id_mirror" value="{{ $preselectedPatientId ?? '' }}">
                            <button class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">✕</button>
                        </form>
                    </div>

                    <span class="font-bold">₱{{ number_format($item['subtotal'], 2) }}</span>
                </div>
            @empty
                <p class="text-gray-500">No items added yet.</p>
            @endforelse
        </div>

        <!-- Total + Checkout -->
        <div class="border-t pt-4">
            <p class="text-lg font-bold text-sky-800 mb-4">
                Total: ₱{{ number_format(collect($cart)->sum('subtotal'), 2) }}
            </p>
            <form method="POST" action="{{ route('pos.checkout', $storeId) }}" class="space-y-3" id="checkoutForm">
                @csrf
                @php
                    $presel = $preselectedPatientId ?? null;
                    $patients = \App\Models\User::where('account_type', 'patient')
                        ->orderBy('lastname')->orderBy('name')
                        ->get(['id', 'name', 'lastname']);
                    $preselPatient = $presel ? $patients->firstWhere('id', $presel) : null;
                @endphp
                <label for="patient_search" class="block text-sm font-medium">Customer (Patient)</label>
                <div class="relative">
                    <input type="text" id="patient_search"
                        value="{{ $preselPatient ? trim($preselPatient->lastname.', '.$preselPatient->name) : '' }}"
                        placeholder="Walk-in"
                        autocomplete="off"
                        class="border rounded p-2 w-full pr-8 focus:ring-2 focus:ring-sky-400">
                    <button type="button" id="patient_clear"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 text-lg leading-none {{ $preselPatient ? '' : 'hidden' }}"
                        aria-label="Clear">&times;</button>
                    <input type="hidden" name="patient_id" id="patient_id" value="{{ $presel }}">
                    <div id="patient_suggestions"
                        class="absolute z-30 bg-white border rounded w-full max-h-60 overflow-y-auto hidden shadow-lg mt-1"></div>
                </div>

                <label for="payment_method" class="block text-sm font-medium">Payment Method</label>
                <select name="payment_method" id="payment_method" class="border rounded p-2 w-full">
                    <option value="cash">Cash</option>
                    <option value="gcash">GCash</option>
                </select>

                <label for="amount_given" class="block text-sm font-medium">
                    Amount Given <span class="text-red-600">*</span>
                </label>
                <input type="number" step="0.01" name="amount_given" id="amount_given" required
                    class="border rounded p-2 w-full" placeholder="₱0.00"
                    oninput="calcChange()">

                <div id="changeDisplay" class="text-sm font-semibold text-green-700 hidden">
                    Change: ₱<span id="changeAmount">0.00</span>
                </div>

                <button id="checkoutBtn" class="w-full px-6 py-3 bg-sky-600 text-white rounded-2xl hover:bg-sky-700 transition">
                    Checkout
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ✅ Receipt Modal -->
<div x-data="{ open: false, receipt: @js(session('receipt')) }" x-init="if(receipt){ open=true }">
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-lg shadow-lg w-3/4 max-w-2xl p-6 relative">
            <!-- Close -->
            <button @click="open=false" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">✖</button>
            
            <div id="receipt-modal">
                <!-- Header -->
                @include('partials.print-header', [
                    'title'   => 'POS Receipt',
                    'meta'    => ($store->name ?? '').' — '.($store->address ?? ''),
                    'address' => $store->address ?? null,
                ])
                <!-- Info -->
                <div class="flex justify-between mb-4 text-sm">
                    <div>
                        <p><strong>Patient:</strong> <span x-text="receipt?.patient?.name ?? 'Walk-in'"></span></p>
                    </div>
                    <div>
                        <p><strong>Receipt No:</strong> <span x-text="receipt?.id"></span></p>
                        <p><strong>Date:</strong> <span x-text="new Date(receipt?.created_at).toLocaleDateString()"></span></p>
                    </div>
                </div>
                <!-- Table -->
                <table class="w-full border border-gray-400 text-sm mb-4">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1 text-left">Description</th>
                            <th class="border px-2 py-1 text-center">Qty</th>
                            <th class="border px-2 py-1 text-right">Unit Price</th>
                            <th class="border px-2 py-1 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in receipt.items" :key="item.id">
                            <tr>
                                <td class="border px-2 py-1" x-text="item.medicine.name"></td>
                                <td class="border px-2 py-1 text-center" x-text="item.quantity"></td>
                                <td class="border px-2 py-1 text-right"> ₱<span x-text="parseFloat(item.price).toFixed(2)"></span> </td>
                                <td class="border px-2 py-1 text-right"> ₱<span x-text="parseFloat(item.subtotal).toFixed(2)"></span> </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <!-- Total -->
                <div class="text-right font-bold text-lg border-t pt-2 foot">
                    <span>Total: ₱<span x-text="parseFloat(receipt.total_amount).toFixed(2)"></span></span>
                    <div class="text-sm font-normal mt-1">
                        {{-- Huwag ipalit ang total kapag walang naitalang bayad — iyon ay
                             pagsasabing nagbayad nang tama ang pasyente gayong walang talaan.
                             Puwede pa ring null ang mga lumang benta bago ito ginawang sapilitan. --}}
                        <p>Amount Given: <span x-text="receipt.amount_given != null ? '₱' + parseFloat(receipt.amount_given).toFixed(2) : '—'"></span></p>
                        <p>Change: <span x-text="receipt.change_amount != null ? '₱' + parseFloat(receipt.change_amount).toFixed(2) : '—'"></span></p>
                    </div>
                </div>
                <!-- Seller -->
                <div class="text-right mt-8 foot">
                    <p>__________________________</p>
                    <p><span x-text="receipt?.user?.name"></span>, DMD</p>
                </div>
            </div>
            <!-- Print -->
            <div class="mt-6 text-right">
                <button onclick="window.printReceipt('receipt-modal', 'POS Receipt')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"> 🖨 Print </button>
            </div>
        </div>
    </div>
</div>

<script>
{{-- Nasa partials/print-scripts ang window.printReceipt — 4x6 ang default na papel. --}}
const POS_MEDICINES = @json($medicines->values());

function filterMedicines() {
    const query = document.getElementById('posSearch').value.toLowerCase().trim();
    // Filter cards
    document.querySelectorAll('.medicine-card').forEach(card => {
        const name = card.getAttribute('data-name');
        card.style.display = name.includes(query) ? '' : 'none';
    });
    // Update suggestions dropdown
    const dropdown = document.getElementById('posSuggestions');
    if (!dropdown) return;
    if (!query) {
        dropdown.classList.add('hidden');
        dropdown.innerHTML = '';
        return;
    }
    const matches = POS_MEDICINES.filter(m => (m.name || '').toLowerCase().includes(query)).slice(0, 8);
    if (matches.length === 0) {
        dropdown.innerHTML = '<div class="px-3 py-2 text-sm text-gray-500">No match.</div>';
        dropdown.classList.remove('hidden');
        return;
    }
    dropdown.innerHTML = matches.map(m =>
        `<div class="pos-suggestion px-3 py-2 hover:bg-sky-50 cursor-pointer flex justify-between text-sm" data-name="${(m.name||'').replace(/"/g,'&quot;')}">
            <span><strong>${m.name}</strong> <span class="text-gray-500">(${m.unit ?? ''})</span></span>
            <span class="text-sky-600">₱${parseFloat(m.price).toFixed(2)}</span>
        </div>`
    ).join('');
    dropdown.classList.remove('hidden');
    dropdown.querySelectorAll('.pos-suggestion').forEach(el => {
        el.addEventListener('mousedown', (e) => {
            e.preventDefault();
            const input = document.getElementById('posSearch');
            input.value = el.getAttribute('data-name');
            filterMedicines();
            dropdown.classList.add('hidden');
        });
    });
}

function showPosSuggestions() {
    const q = document.getElementById('posSearch').value;
    if (q && q.trim().length > 0) filterMedicines();
}
function hidePosSuggestions() {
    const dd = document.getElementById('posSuggestions');
    if (dd) dd.classList.add('hidden');
}

@php
    $posPatients = $patients->map(fn($p) => [
        'id' => $p->id,
        'name' => trim(($p->lastname ?? '').', '.($p->name ?? '')),
    ])->values();
@endphp
const POS_PATIENTS = @json($posPatients);

(function () {
    const input = document.getElementById('patient_search');
    const hidden = document.getElementById('patient_id');
    const clearBtn = document.getElementById('patient_clear');
    const dropdown = document.getElementById('patient_suggestions');
    if (!input || !dropdown) return;

    function syncMirrors() {
        document.querySelectorAll('.patient_id_mirror').forEach(el => { el.value = hidden.value; });
    }

    function render(matches) {
        if (matches.length === 0) {
            dropdown.innerHTML = '<div class="px-3 py-2 text-sm text-gray-500">No matching patient. Leave blank for Walk-in.</div>';
        } else {
            dropdown.innerHTML = matches.slice(0, 8).map(p =>
                `<div class="patient-suggestion px-3 py-2 hover:bg-sky-50 cursor-pointer text-sm" data-id="${p.id}" data-name="${p.name.replace(/"/g,'&quot;')}">${p.name}</div>`
            ).join('');
        }
        dropdown.classList.remove('hidden');
        dropdown.querySelectorAll('.patient-suggestion').forEach(el => {
            el.addEventListener('mousedown', (e) => {
                e.preventDefault();
                input.value = el.getAttribute('data-name');
                hidden.value = el.getAttribute('data-id');
                syncMirrors();
                clearBtn.classList.remove('hidden');
                dropdown.classList.add('hidden');
            });
        });
    }

    input.addEventListener('input', () => {
        const q = input.value.toLowerCase().trim();
        // typing invalidates a previously selected ID until they pick again
        hidden.value = '';
        syncMirrors();
        clearBtn.classList.toggle('hidden', input.value.length === 0);
        if (!q) {
            render(POS_PATIENTS);
            return;
        }
        render(POS_PATIENTS.filter(p => p.name.toLowerCase().includes(q)));
    });

    input.addEventListener('focus', () => {
        const q = input.value.toLowerCase().trim();
        render(q ? POS_PATIENTS.filter(p => p.name.toLowerCase().includes(q)) : POS_PATIENTS);
    });

    input.addEventListener('blur', () => {
        setTimeout(() => dropdown.classList.add('hidden'), 150);
    });

    clearBtn.addEventListener('click', () => {
        input.value = '';
        hidden.value = '';
        syncMirrors();
        clearBtn.classList.add('hidden');
        input.focus();
    });
})();

const POS_TOTAL = {{ collect($cart)->sum('subtotal') }};

function calcChange() {
    const givenRaw = document.getElementById('amount_given').value;
    const given = parseFloat(givenRaw) || 0;
    const changeEl = document.getElementById('changeDisplay');
    const changeAmt = document.getElementById('changeAmount');
    const btn = document.getElementById('checkoutBtn');

    // Bawal mag-checkout kapag blangko o kulang ang amount given. Dating
    // `givenRaw !== ''`, kaya ang blangko ay itinuturing na ayos.
    const insufficient = givenRaw === '' || given < POS_TOTAL;

    if (givenRaw !== '' && given > 0) {
        changeEl.classList.remove('hidden');
        const change = given - POS_TOTAL;
        changeAmt.textContent = change >= 0 ? change.toFixed(2) : '0.00';
        changeEl.className = change >= 0
            ? 'text-sm font-semibold text-green-700'
            : 'text-sm font-semibold text-red-600';
        if (change < 0) changeAmt.textContent = 'Insufficient (' + Math.abs(change).toFixed(2) + ' short)';
    } else {
        changeEl.classList.add('hidden');
    }

    if (btn) {
        btn.disabled = insufficient;
        btn.classList.toggle('opacity-50', insufficient);
        btn.classList.toggle('cursor-not-allowed', insufficient);
    }
}

// Panghuling harang kung sakaling ma-bypass ang disabled state
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkoutForm');
    if (!form) return;
    form.addEventListener('submit', function (e) {
        const givenRaw = document.getElementById('amount_given').value;
        const given = parseFloat(givenRaw) || 0;

        if (givenRaw === '') {
            e.preventDefault();
            const msg = 'Please enter the amount given before checking out.';
            if (window.Swal) {
                Swal.fire('Amount Required', msg, 'warning');
            } else {
                alert(msg);
            }
            return;
        }

        if (given < POS_TOTAL) {
            e.preventDefault();
            const short = (POS_TOTAL - given).toFixed(2);
            if (window.Swal) {
                Swal.fire('Insufficient Amount', 'Amount given (₱' + given.toFixed(2) + ') is less than the total (₱' + POS_TOTAL.toFixed(2) + '). Short by ₱' + short + '.', 'warning');
            } else {
                alert('Amount given is less than the total. Short by ₱' + short + '.');
            }
        }
    });

    // Simulan nang naka-disable ang Checkout habang blangko pa ang field —
    // `oninput` lang ang tumatawag sa calcChange(), kaya hindi ito tumatakbo
    // hangga't walang tina-type.
    calcChange();
});
</script>
@endsection
