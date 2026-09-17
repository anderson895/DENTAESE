@php
    $rxAuthUser       = auth()->user();
    $rxIsReceptionist = $rxAuthUser && $rxAuthUser->position === 'Receptionist';
@endphp

<div class="flex items-center mt-2 mb-4">
        <button onclick="window.printRx()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Print Rx</button>

        <!-- Next button (right) -->
        <button
            @click="tab='pos'"
            class="ml-auto px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700"
        >
            Next
        </button>
</div>

    <!-- Input area hidden in print and for receptionists (read-only) -->
    @if(!$rxIsReceptionist)
    <div class="mb-4 no-print">
        {{-- Dropdown sa halip na malayang pagta-type: ang gamot ay dapat galing
             sa talaan ng imbentaryo, kaya wala nang maling baybay o gamot na
             hindi naman umiiral. --}}
        <div class="flex gap-2 mb-2">
            <div class="w-full">
                <label class="text-xs font-semibold text-gray-600">Medicine</label>
                <select id="selected-medicine-id" class="border p-2 rounded w-full bg-white">
                    <option value="">-- Select Medicine --</option>
                    @foreach($medicines as $medicine)
                        <option value="{{ $medicine->id }}">{{ $medicine->name }} ({{ $medicine->unit }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-2">
            <div>
                <label class="text-xs font-semibold text-gray-600">Quantity</label>
                <input type="text" id="medicine-qty" maxlength="50" placeholder="e.g. 10 tablets" class="border p-2 rounded w-full">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Frequency</label>
                <select id="medicine-freq" class="border p-2 rounded w-full">
                    <option value="">-- Select --</option>
                    <option value="1x a day">1x a day</option>
                    <option value="2x a day">2x a day</option>
                    <option value="3x a day">3x a day</option>
                    <option value="4x a day">4x a day</option>
                    <option value="every 4 hours">Every 4 hours</option>
                    <option value="every 6 hours">Every 6 hours</option>
                    <option value="every 8 hours">Every 8 hours</option>
                    <option value="as needed">As needed (PRN)</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Time</label>
                <input type="text" id="medicine-time" maxlength="50" placeholder="e.g. morning and evening" class="border p-2 rounded w-full">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Duration</label>
                <input type="text" id="medicine-duration" maxlength="50" placeholder="e.g. for 2 weeks" class="border p-2 rounded w-full">
            </div>
        </div>
        <button type="button" id="add-medicine" class="bg-blue-600 text-white px-4 py-2 rounded w-full md:w-auto">+ Add Medicine</button>
    </div>
    @endif
<div id="receipt-content" class="p-6 max-w-3xl mx-auto bg-white shadow rounded">
    @include('partials.print-header', [
        'title'   => 'Prescription (Rx)',
        'meta'    => ($appointment->store->name ?? '').' — '.($appointment->store->address ?? ''),
        'address' => $appointment->store->address ?? null,
    ])

    <div class="flex justify-between mb-4">
        <div>
            <p><strong>Patient Name:</strong> <span id="patient_name">{{ $appointment->user->lastname ?? 'N/A' }}, {{ $appointment->user->name ?? 'N/A' }} {{ $appointment->user->middlename ?? 'N/A' }} {{ $appointment->user->suffix ?? '' }}</span></p>
            <p><strong>Age:</strong> <span id="patient_age">{{ $appointment->user->birth_date ? \Carbon\Carbon::parse($appointment->user->birth_date)->age : 'N/A' }}</span></p>
        </div>
        <div>
            <p><strong>Date:</strong> {{ now()->format('F j, Y') }}</p>
        </div>
    </div>

    <hr class="border-2 mb-4">

    <h2 class="font-bold mb-2">Rx</h2>

    <!-- Rx list -->
    <div id="rx-list" class="mb-4">
        {{-- Medicines will be appended here --}}
    </div>



    <div class="text-right">
        <p>______________________________</p>
        <p>{{$appointment->dentist->name}} {{$appointment->dentist->middlename}}. {{$appointment->dentist->lastname}} {{$appointment->dentist->suffix ?? ''}} ,DMD</p>
    </div>
</div>


<script>
const medicines = @json($medicines);
const RX_CSRF_TOKEN = '{{ csrf_token() }}';
const RX_PATIENT_ID = {{ $appointment->user_id }};
const RX_APPOINTMENT_ID = {{ $appointment->id }};

// Parse a free-text duration like "for 2 weeks" into an end date (Y-m-d), or null if unparseable
function rxParseDurationToEndDate(duration) {
    const m = (duration || '').toLowerCase().match(/(\d+)\s*(day|week|month)/);
    if (!m) return null;
    const n = parseInt(m[1], 10);
    const d = new Date();
    if (m[2] === 'day') d.setDate(d.getDate() + n);
    if (m[2] === 'week') d.setDate(d.getDate() + n * 7);
    if (m[2] === 'month') d.setMonth(d.getMonth() + n);
    return d.toISOString().slice(0, 10);
}

// Auto-record the prescribed medicine to the patient's Current Medication list
function rxSyncToCurrentMedication(rxDiv, med, qty, freq, time, duration) {
    const notes = [qty, time, duration].filter(Boolean).join(', ');

    fetch('/patient-medications', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': RX_CSRF_TOKEN,
        },
        body: JSON.stringify({
            user_id: RX_PATIENT_ID,
            appointment_id: RX_APPOINTMENT_ID,
            medicine_name: `${med.name} (${med.unit})`,
            dosage: null,
            frequency: (freq || '').replace(' a day', ' daily') || null,
            start_date: new Date().toISOString().slice(0, 10),
            end_date: rxParseDurationToEndDate(duration),
            notes: notes || null,
        }),
    })
    .then(r => r.ok ? r.json() : Promise.reject(r))
    .then(res => {
        // Remember the medication id on the RX entry so removing it also removes the record
        rxDiv.dataset.medId = res.medication.id;
        if (window.addMedicationRow) window.addMedicationRow(res.medication);
        if (window.Swal) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Added to Current Medication',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
            });
        }
    })
    .catch(() => console.warn('Failed to sync prescribed medicine to Current Medication.'));
}

// Dropdown ng gamot — ang halaga nito ay id mula sa talaan ng imbentaryo.
const selectedMedId = document.getElementById('selected-medicine-id');

// Add medicine
const addMedicineBtn = document.getElementById('add-medicine');
if (addMedicineBtn) {
addMedicineBtn.addEventListener('click', function() {
    const medId = selectedMedId.value;
    const qty = document.getElementById('medicine-qty').value;
    const freq = document.getElementById('medicine-freq').value;
    const time = document.getElementById('medicine-time').value;
    const duration = document.getElementById('medicine-duration').value;
    const rxList = document.getElementById('rx-list');

    if (!medId) {
        selectedMedId.focus();
        if (window.Swal) Swal.fire('No medicine selected', 'Please choose a medicine from the list.', 'warning');
        else alert('Please choose a medicine from the list.');
        return;
    }

    const med = medicines.find(m => m.id == medId);
    if (!med) return;

    // Build prescription line: e.g. "Ascorbic Acid (MG), 10 tablets, 2x a day, morning and evening, for 2 weeks"
    let details = [];
    if (qty) details.push(qty);
    if (freq) details.push(freq);
    if (time) details.push(time);
    if (duration) details.push(duration);

    const div = document.createElement('div');
    div.classList.add('mb-2', 'flex', 'items-start', 'gap-2');
    div.innerHTML = `
        <button type="button" class="text-red-500 remove-medicine no-print font-bold">×</button>
        <div>
            <strong>${med.name} (${med.unit})</strong>
            ${details.length ? '<br><span class="text-sm text-gray-700">' + details.join(', ') + '</span>' : ''}
        </div>
    `;

    rxList.appendChild(div);

    // Also save to the patient's Current Medication list (monitored by the doctor)
    rxSyncToCurrentMedication(div, med, qty, freq, time, duration);

    // Clear inputs
    selectedMedId.value = '';
    document.getElementById('medicine-qty').value = '';
    document.getElementById('medicine-freq').value = '';
    document.getElementById('medicine-time').value = '';
    document.getElementById('medicine-duration').value = '';
});
} // end if (addMedicineBtn)

// Remove medicine (delegate)
const rxListEl = document.getElementById('rx-list');
if (rxListEl) {
rxListEl.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-medicine')) {
        const row = e.target.parentElement;
        const medId = row.dataset.medId;

        // Also remove the auto-recorded entry from Current Medication
        if (medId) {
            fetch(`/patient-medications/${medId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': RX_CSRF_TOKEN,
                },
            })
            .then(() => { if (window.removeMedicationRow) window.removeMedicationRow(medId); })
            .catch(() => {});
        }

        row.remove();
    }
});
}

// Print function — hindi na sinisira ang pahina, kaya wala nang redirect pabalik.
window.printRx = function () {
    window.printSection('receipt-content', {
        paper: 'Letter',
        scale: 80,
        title: 'Prescription (RX)',
    });
};
</script>
