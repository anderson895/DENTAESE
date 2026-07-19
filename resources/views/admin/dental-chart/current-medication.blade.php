@php
    $medAuthUser       = auth()->user();
    $medIsReceptionist = $medAuthUser && $medAuthUser->position === 'Receptionist';
@endphp

<div class="bg-white p-6 rounded shadow">
    <div class="flex items-center mt-2 mb-4">
        <h2 class="text-xl font-bold">Current Status</h2>
        <button
            @click="tab='info'"
            class="ml-auto px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Next
        </button>
    </div>

    <div class="border-l-4 border-blue-500 bg-blue-50 px-4 py-3 mb-4 text-sm text-gray-700">
        Monitor patient's current medication intake and compliance for
        <strong>{{ $appointment->user->name }} {{ $appointment->user->lastname }}</strong>.
    </div>

    <table class="w-full border-collapse border border-gray-300 text-sm mb-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2 text-left">Medicine Name</th>
                <th class="border px-3 py-2 text-left">Dosage</th>
                <th class="border px-3 py-2 text-left">Frequency</th>
                <th class="border px-3 py-2 text-left">Start Date</th>
                <th class="border px-3 py-2 text-left">End Date</th>
                <th class="border px-3 py-2 text-left">Status</th>
                @if(!$medIsReceptionist)
                    <th class="border px-3 py-2 text-center w-24">Action</th>
                @endif
            </tr>
        </thead>
        <tbody id="current-med-tbody">
            @forelse($currentMedications as $med)
                <tr data-id="{{ $med->id }}">
                    <td class="border px-3 py-2">{{ $med->medicine_name }}</td>
                    <td class="border px-3 py-2">{{ $med->dosage ?? '—' }}</td>
                    <td class="border px-3 py-2">{{ $med->frequency ?? '—' }}</td>
                    <td class="border px-3 py-2">{{ $med->start_date ? $med->start_date->format('F j, Y') : '—' }}</td>
                    <td class="border px-3 py-2">{{ $med->end_date ? $med->end_date->format('F j, Y') : '—' }}</td>
                    <td class="border px-3 py-2">
                        @if($med->status === 'Active')
                            <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Active</span>
                        @else
                            <span class="inline-block bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-semibold">Completed</span>
                        @endif
                    </td>
                    @if(!$medIsReceptionist)
                        <td class="border px-3 py-2 text-center whitespace-nowrap">
                            <button type="button"
                                    class="edit-medication text-blue-600 hover:underline text-xs font-semibold mr-2"
                                    data-med="{{ json_encode($med->only(['id','medicine_name','dosage','frequency','notes']) + ['start_date' => optional($med->start_date)->format('Y-m-d'), 'end_date' => optional($med->end_date)->format('Y-m-d')]) }}">
                                Edit
                            </button>
                            <button type="button"
                                    class="delete-medication text-red-600 hover:underline text-xs font-semibold"
                                    data-id="{{ $med->id }}">
                                Delete
                            </button>
                        </td>
                    @endif
                </tr>
            @empty
                <tr id="current-med-empty">
                    <td colspan="{{ $medIsReceptionist ? 6 : 7 }}" class="text-center text-gray-500 py-4">
                        No current medication recorded for this patient.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3 class="font-semibold text-gray-700 mb-2">Medication Notes</h3>
    <div class="border rounded bg-gray-50 px-4 py-3 mb-4 text-sm text-gray-700">
        @php
            $medNotesEmpty = $currentMedications->every(fn ($m) => trim((string) $m->notes) === '');
        @endphp
        <span id="medication-notes-empty" class="text-gray-500 italic {{ $medNotesEmpty ? '' : 'hidden' }}">No medication notes.</span>
        <ul id="medication-notes-list" class="list-disc pl-5 space-y-1 {{ $medNotesEmpty ? 'hidden' : '' }}">
            @foreach($currentMedications as $noteMed)
                @continue(trim((string) $noteMed->notes) === '')
                <li data-note-id="{{ $noteMed->id }}">{{ $noteMed->notes }}</li>
            @endforeach
        </ul>
    </div>

    @if(!$medIsReceptionist)
        <button type="button" id="open-medication-modal"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">
            Update Medication
        </button>
    @endif
</div>

@if(!$medIsReceptionist)
<!-- Add / Edit Medication Modal -->
<div id="medication-modal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-[550px] max-h-[90vh] overflow-y-auto p-6 relative">
        <button type="button" id="close-medication-modal"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>

        <h2 id="medication-modal-title" class="text-xl font-bold mb-4">Add Medication</h2>

        <form id="medicationForm">
            <input type="hidden" id="medication-id" value="">

            <div class="mb-3">
                <label class="block font-semibold text-sm mb-1">Medicine Name <span class="text-red-500">*</span></label>
                <input type="text" id="medication-name" list="medication-name-options"
                       class="w-full border rounded p-2" placeholder="e.g. Amoxicillin (MG)" required>
                <datalist id="medication-name-options">
                    @foreach($medicines as $m)
                        <option value="{{ $m->name }} ({{ $m->unit }})"></option>
                    @endforeach
                </datalist>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block font-semibold text-sm mb-1">Dosage</label>
                    <input type="text" id="medication-dosage" class="w-full border rounded p-2" placeholder="e.g. 500mg">
                </div>
                <div>
                    <label class="block font-semibold text-sm mb-1">Frequency</label>
                    <select id="medication-frequency" class="w-full border rounded p-2">
                        <option value="">-- Select --</option>
                        <option value="1x daily">1x daily</option>
                        <option value="2x daily">2x daily</option>
                        <option value="3x daily">3x daily</option>
                        <option value="4x daily">4x daily</option>
                        <option value="every 4 hours">Every 4 hours</option>
                        <option value="every 6 hours">Every 6 hours</option>
                        <option value="every 8 hours">Every 8 hours</option>
                        <option value="as needed">As needed (PRN)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block font-semibold text-sm mb-1">Start Date</label>
                    <input type="date" id="medication-start" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold text-sm mb-1">End Date</label>
                    <input type="date" id="medication-end" class="w-full border rounded p-2">
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-sm mb-1">Notes</label>
                <textarea id="medication-notes" rows="3" class="w-full border rounded p-2"
                          placeholder="e.g. Take after meals to avoid stomach upset"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" id="cancel-medication-modal"
                        class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">Cancel</button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-semibold">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const modal      = document.getElementById('medication-modal');
    const modalTitle = document.getElementById('medication-modal-title');
    const form       = document.getElementById('medicationForm');

    const fields = {
        id:        document.getElementById('medication-id'),
        name:      document.getElementById('medication-name'),
        dosage:    document.getElementById('medication-dosage'),
        frequency: document.getElementById('medication-frequency'),
        start:     document.getElementById('medication-start'),
        end:       document.getElementById('medication-end'),
        notes:     document.getElementById('medication-notes'),
    };

    function openModal(med = null) {
        fields.id.value        = med ? med.id : '';
        fields.name.value      = med ? (med.medicine_name || '') : '';
        fields.dosage.value    = med ? (med.dosage || '') : '';
        fields.frequency.value = med ? (med.frequency || '') : '';
        fields.start.value     = med ? (med.start_date || '') : '';
        fields.end.value       = med ? (med.end_date || '') : '';
        fields.notes.value     = med ? (med.notes || '') : '';
        modalTitle.textContent = med ? 'Edit Medication' : 'Add Medication';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('open-medication-modal')?.addEventListener('click', () => openModal());
    document.getElementById('close-medication-modal').addEventListener('click', closeModal);
    document.getElementById('cancel-medication-modal').addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

    // Edit / Delete buttons — delegated so rows added dynamically (e.g. from RX tab) also work
    document.getElementById('current-med-tbody').addEventListener('click', function (e) {
        const editBtn = e.target.closest('.edit-medication');
        if (editBtn) {
            openModal(JSON.parse(editBtn.dataset.med));
            return;
        }

        const delBtn = e.target.closest('.delete-medication');
        if (!delBtn) return;

        const id = delBtn.dataset.id;
        Swal.fire({
            title: 'Remove Medication?',
            text: 'This medication will be removed from the patient\'s current medication list.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove'
        }).then((result) => {
            if (!result.isConfirmed) return;
            $.ajax({
                url: `/patient-medications/${id}`,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function (res) {
                    Swal.fire('Removed', res.message, 'success').then(() => {
                        window.location.href = "{{ route('appointments.view', ['id' => $appointment->id]) }}?tab=medication";
                    });
                },
                error: function (xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message || 'Failed to remove medication.', 'error');
                }
            });
        });
    });

    // ---------------------------------------------------------------------
    // Live-append a medication row (used by the RX tab when a medicine is
    // prescribed, so the Current Medication tab updates without a reload).
    // ---------------------------------------------------------------------
    function formatMedDate(ymd) {
        if (!ymd) return '—';
        const d = new Date(ymd.slice(0, 10) + 'T00:00:00');
        return d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }

    window.addMedicationRow = function (med) {
        const tbody = document.getElementById('current-med-tbody');
        document.getElementById('current-med-empty')?.remove();

        const start = med.start_date ? med.start_date.slice(0, 10) : '';
        const end   = med.end_date ? med.end_date.slice(0, 10) : '';
        const today = new Date().toISOString().slice(0, 10);
        const isActive = !end || end >= today;

        const tr = document.createElement('tr');
        tr.dataset.id = med.id;

        const cells = [med.medicine_name, med.dosage || '—', med.frequency || '—', formatMedDate(start), formatMedDate(end)];
        cells.forEach(text => {
            const td = document.createElement('td');
            td.className = 'border px-3 py-2';
            td.textContent = text;
            tr.appendChild(td);
        });

        const statusTd = document.createElement('td');
        statusTd.className = 'border px-3 py-2';
        const badge = document.createElement('span');
        badge.className = isActive
            ? 'inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold'
            : 'inline-block bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-semibold';
        badge.textContent = isActive ? 'Active' : 'Completed';
        statusTd.appendChild(badge);
        tr.appendChild(statusTd);

        const actionTd = document.createElement('td');
        actionTd.className = 'border px-3 py-2 text-center whitespace-nowrap';

        const editBtn = document.createElement('button');
        editBtn.type = 'button';
        editBtn.className = 'edit-medication text-blue-600 hover:underline text-xs font-semibold mr-2';
        editBtn.dataset.med = JSON.stringify({
            id: med.id,
            medicine_name: med.medicine_name,
            dosage: med.dosage,
            frequency: med.frequency,
            notes: med.notes,
            start_date: start,
            end_date: end,
        });
        editBtn.textContent = 'Edit';

        const delBtn = document.createElement('button');
        delBtn.type = 'button';
        delBtn.className = 'delete-medication text-red-600 hover:underline text-xs font-semibold';
        delBtn.dataset.id = med.id;
        delBtn.textContent = 'Delete';

        actionTd.appendChild(editBtn);
        actionTd.appendChild(delBtn);
        tr.appendChild(actionTd);

        tbody.appendChild(tr);

        // Append note bullet if the medication has notes
        if (med.notes && med.notes.trim() !== '') {
            document.getElementById('medication-notes-empty')?.classList.add('hidden');
            const notesList = document.getElementById('medication-notes-list');
            notesList.classList.remove('hidden');
            const li = document.createElement('li');
            li.dataset.noteId = med.id;
            li.textContent = med.notes;
            notesList.appendChild(li);
        }
    };

    // Remove a row + note bullet by medication id (used when an RX entry is removed)
    window.removeMedicationRow = function (id) {
        document.querySelector(`#current-med-tbody tr[data-id="${id}"]`)?.remove();
        document.querySelector(`#medication-notes-list li[data-note-id="${id}"]`)?.remove();
        const notesList = document.getElementById('medication-notes-list');
        if (notesList && notesList.children.length === 0) {
            notesList.classList.add('hidden');
            document.getElementById('medication-notes-empty')?.classList.remove('hidden');
        }
    };

    // Save (add or update)
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const id = fields.id.value;
        const payload = {
            _token: '{{ csrf_token() }}',
            user_id: '{{ $appointment->user_id }}',
            appointment_id: '{{ $appointment->id }}',
            medicine_name: fields.name.value,
            dosage: fields.dosage.value,
            frequency: fields.frequency.value,
            start_date: fields.start.value,
            end_date: fields.end.value,
            notes: fields.notes.value,
        };

        $.ajax({
            url: id ? `/patient-medications/${id}` : '/patient-medications',
            type: id ? 'PUT' : 'POST',
            data: payload,
            success: function (res) {
                Swal.fire('Saved', res.message, 'success').then(() => {
                    window.location.href = "{{ route('appointments.view', ['id' => $appointment->id]) }}?tab=medication";
                });
            },
            error: function (xhr) {
                let msg = xhr.responseJSON?.message || 'Failed to save medication.';
                const errs = xhr.responseJSON?.errors;
                if (errs) msg = Object.values(errs).flat().join(' ');
                Swal.fire('Error', msg, 'error');
            }
        });
    });
})();
</script>
@endif
