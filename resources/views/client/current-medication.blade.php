{{-- Read-only Current Medication view for the patient (client profile) --}}
<div class="bg-white p-6 rounded-xl shadow-sm">
    <h2 class="text-xl font-bold mb-4">Current Medication</h2>

    <div class="border-l-4 border-blue-500 bg-blue-50 px-4 py-3 mb-4 text-sm text-gray-700">
        {{ $medIntro ?? "These are the medications prescribed and monitored by your dentist. Please follow the dosage, frequency, and notes below." }}
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
            </tr>
        </thead>
        <tbody>
            @forelse($currentMedications as $med)
                <tr>
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
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-4">
                        No current medication recorded.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3 class="font-semibold text-gray-700 mb-2">Medication Notes</h3>
    <div class="border rounded bg-gray-50 px-4 py-3 text-sm text-gray-700">
        @php
            $clientMedNotes = $currentMedications->pluck('notes')->filter(fn ($n) => trim((string) $n) !== '');
        @endphp
        @if($clientMedNotes->isEmpty())
            <span class="text-gray-500 italic">No medication notes.</span>
        @else
            <ul class="list-disc pl-5 space-y-1">
                @foreach($clientMedNotes as $note)
                    <li>{{ $note }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
