@php
    $isReadonly = isset($readonly) && $readonly;
    $u = $patientinfo->user ?? auth()->user();
    $age = '';
    if (!empty($patientinfo->birthdate)) {
        $age = \Carbon\Carbon::parse($patientinfo->birthdate)->age;
    } elseif (!empty($u?->birth_date)) {
        $age = \Carbon\Carbon::parse($u->birth_date)->age;
    }
    $firstLogin = !($patientinfo->profile_completed ?? false);

    $conditions = [
        'High Blood Pressure','Low Blood Pressure','Epilepsy / Convulsions','AIDS or HIV Infection',
        'Sexually Transmitted Disease','Stomach Troubles / Ulcers','Fainting Seizure','Rapid Weight Loss',
        'Radiation Therapy','Joint Replacement / Implant','Heart Surgery','Heart Attack',
        'Thyroid Problem','Heart Disease','Heart Murmur','Hepatitis / Liver Disease',
        'Rheumatic Fever','Hay Fever / Allergies','Respiratory Problems','Hepatitis / Jaundice',
        'Tuberculosis','Swollen Ankles','Kidney Disease','Diabetes',
        'Chest Pain','Stroke','Cancer / Tumors','Anemia',
        'Angina','Asthma','Emphysema','Bleeding Problems',
        'Blood Diseases','Head Injuries','Arthritis / Rheumatism','Other',
    ];

    $checkedConditions = old('medical_conditions', $patientinfo->medical_conditions ?? []) ?: [];
@endphp

<style>
    /* Bordered input fields */
    .pda-input {
        display: block;
        width: 100%;
        border: 1px solid #d1d5db;       /* gray-300 */
        border-radius: 0.375rem;          /* rounded-md */
        background: #ffffff;
        padding: 0.5rem 0.75rem;          /* py-2 px-3 */
        font-size: 0.875rem;              /* text-sm */
        color: #1f2937;                   /* gray-800 */
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .pda-input:focus {
        outline: none;
        border-color: #3b82f6;            /* blue-500 */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    .pda-input[readonly],
    .pda-input:disabled {
        background: #f9fafb;              /* gray-50 */
        color: #6b7280;                   /* gray-500 */
    }
    /* Narrow variant for short fields like Blood Type / Blood Pressure */
    .pda-input.pda-input-narrow {
        width: 12rem;                     /* ~192px */
        flex: 0 0 12rem;
    }

    /* Labels stacked above inputs */
    #patient-form label.text-xs {
        display: block;
        margin-bottom: 0.25rem;
        font-weight: 500;
        font-size: 0.75rem;
        color: #4b5563;                   /* gray-600 */
    }

    /* Section title bars */
    .pda-section-title {
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.025em;
        color: #1f2937;
        border-bottom: 1px solid #d1d5db;
        padding-bottom: 0.25rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    /* Yes/No question rows */
    .pda-yn-row {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.5rem 0;
        font-size: 0.875rem;
        border-bottom: 1px solid #f3f4f6; /* gray-100 */
    }
    .pda-yn-label { flex: 1; color: #374151; }
    .pda-yn-radios { display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0; }
    .pda-yn-radios label {
        display: flex; align-items: center; gap: 0.25rem;
        font-size: 0.75rem; color: #4b5563;
    }

    /* Detail follow-up inputs */
    .pda-detail { margin-top: 0.5rem; margin-left: 1.5rem; font-size: 0.75rem; color: #6b7280; }
    .pda-detail input {
        display: block;
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background: #ffffff;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        color: #1f2937;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .pda-detail input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    /* Conditions checklist grid */
    .pda-cond-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.25rem 1rem;
        font-size: 0.875rem;
    }
    @media (min-width: 768px) {
        .pda-cond-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    .pda-cond-grid label { display: flex; align-items: center; gap: 0.5rem; color: #374151; }
    .pda-cond-grid input[type="checkbox"] { width: 1rem; height: 1rem; }

    /* Print: revert to flat lines for the formal PDA look */
    @media print {
        .pda-input,
        .pda-detail input {
            border: 0 !important;
            border-bottom: 1px solid #555 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            padding: 0 2px !important;
            background: transparent !important;
        }
    }
</style>

<div class="max-w-5xl mx-auto p-6 bg-white shadow rounded-lg print:shadow-none">

    @if(auth()->user()->account_type == 'admin')
        <button onclick="printDiv('printable-patient')" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 print:hidden">
            Print Patient Info
        </button>
    @endif

    {{-- Personalized Clinic Header (print only) --}}
    <div class="hidden print:block">
        @include('partials.print-header', [
            'title' => 'Patient Information Record',
        ])
    </div>

    {{-- PDA Header --}}
    <div class="flex items-center gap-4 mb-4 border-b pb-3">
        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs text-center leading-tight">PDA</div>
        <div>
            <h1 class="text-xl font-bold text-gray-800">PHILIPPINE DENTAL ASSOCIATION</h1>
            <p class="text-sm text-gray-500">Dental Chart &mdash; Patient Information Record</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <form id="patient-form" class="space-y-4" data-first-login="{{ $firstLogin ? '1' : '0' }}">
        @csrf
        <input type="hidden" name="user_id" value="{{ $patientinfo->user_id ?? auth()->id() }}">

        {{-- ============ PATIENT INFORMATION ============ --}}
        <h3 class="pda-section-title">PATIENT INFORMATION RECORD</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-xs text-gray-500">Last Name</label>
                <input type="text" name="last_name" class="pda-input" value="{{ old('last_name', $patientinfo->last_name ?? $u?->lastname) }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">First Name</label>
                <input type="text" name="first_name" class="pda-input" value="{{ old('first_name', $patientinfo->first_name ?? $u?->name) }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Middle Name</label>
                <input type="text" name="middle_name" class="pda-input" value="{{ old('middle_name', $patientinfo->middle_name ?? $u?->middlename) }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="text-xs text-gray-500">Birthdate (mm/dd/yy)</label>
                <input type="date" name="birthdate" class="pda-input" value="{{ old('birthdate', optional($patientinfo->birthdate)->format('Y-m-d') ?? $u?->birth_date) }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Age</label>
                <input type="text" id="age-display" class="pda-input" value="{{ $age }}" readonly>
            </div>
            <div>
                <label class="text-xs text-gray-500">Sex</label>
                <select name="sex" class="pda-input">
                    <option value="">--</option>
                    <option value="M" {{ old('sex', $patientinfo->sex ?? '') == 'M' ? 'selected' : '' }}>Male</option>
                    <option value="F" {{ old('sex', $patientinfo->sex ?? '') == 'F' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div>
                <label class="text-xs text-gray-500">Nickname</label>
                <input type="text" name="nickname" class="pda-input" value="{{ old('nickname', $patientinfo->nickname ?? '') }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-gray-500">Religion</label>
                <input type="text" name="religion" class="pda-input" value="{{ old('religion', $patientinfo->religion ?? '') }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Nationality</label>
                <input type="text" name="nationality" class="pda-input" value="{{ old('nationality', $patientinfo->nationality ?? '') }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-gray-500">Home Address</label>
                <input type="text" name="home_address" class="pda-input" value="{{ old('home_address', $patientinfo->home_address ?? $u?->current_address) }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Home No.</label>
                <input type="text" name="home_no" class="pda-input" value="{{ old('home_no', $patientinfo->home_no ?? '') }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-gray-500">Occupation</label>
                <input type="text" name="occupation" class="pda-input" value="{{ old('occupation', $patientinfo->occupation ?? '') }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Office No.</label>
                <input type="text" name="office_no" class="pda-input" value="{{ old('office_no', $patientinfo->office_no ?? '') }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-xs text-gray-500">Dental Insurance</label>
                <input type="text" name="dental_insurance" class="pda-input" value="{{ old('dental_insurance', $patientinfo->dental_insurance ?? '') }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Fax No.</label>
                <input type="text" name="fax_no" class="pda-input" value="{{ old('fax_no', $patientinfo->fax_no ?? '') }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Effective Date</label>
                <input type="date" name="effective_date" class="pda-input" value="{{ old('effective_date', optional($patientinfo->effective_date)->format('Y-m-d') ?? '') }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-gray-500">Cell/Mobile No.</label>
                <input type="text" name="contact_number" class="pda-input" value="{{ old('contact_number', $patientinfo->contact_number ?? $u?->contact_number) }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Email Address</label>
                <input type="email" name="email" class="pda-input" value="{{ old('email', $patientinfo->email ?? $u?->email) }}">
            </div>
        </div>

        {{-- For minors --}}
        <div class="mt-4 p-3 border border-dashed border-gray-300 rounded">
            <p class="text-xs italic text-gray-600 mb-2">For minors:</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500">Parent / Guardian's Name</label>
                    <input type="text" name="parent_guardian_name" class="pda-input" value="{{ old('parent_guardian_name', $patientinfo->parent_guardian_name ?? '') }}">
                </div>
                <div>
                    <label class="text-xs text-gray-500">Occupation</label>
                    <input type="text" name="parent_guardian_occupation" class="pda-input" value="{{ old('parent_guardian_occupation', $patientinfo->parent_guardian_occupation ?? '') }}">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
            <div>
                <label class="text-xs text-gray-500">Whom may we thank for referring you?</label>
                <input type="text" name="referred_by" class="pda-input" value="{{ old('referred_by', $patientinfo->referred_by ?? '') }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">What is your reason for dental consultation?</label>
                <input type="text" name="reason_for_consultation" class="pda-input" value="{{ old('reason_for_consultation', $patientinfo->reason_for_consultation ?? '') }}">
            </div>
        </div>

        {{-- ============ DENTAL HISTORY ============ --}}
        <h3 class="pda-section-title">DENTAL HISTORY</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-gray-500">Previous Dentist: Dr.</label>
                <input type="text" name="previous_dentist" class="pda-input" value="{{ old('previous_dentist', $patientinfo->previous_dentist ?? '') }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Last Dental Visit</label>
                <input type="text" name="last_dental_visit" class="pda-input" value="{{ old('last_dental_visit', $patientinfo->last_dental_visit ?? '') }}">
            </div>
        </div>

        {{-- ============ MEDICAL HISTORY ============ --}}
        <h3 class="pda-section-title">MEDICAL HISTORY</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-gray-500">Name of Physician: Dr.</label>
                <input type="text" name="physician_name" class="pda-input" value="{{ old('physician_name', $patientinfo->physician_name ?? '') }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Specialty (if applicable)</label>
                <input type="text" name="physician_specialty" class="pda-input" value="{{ old('physician_specialty', $patientinfo->physician_specialty ?? '') }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Office Address</label>
                <input type="text" name="physician_office_address" class="pda-input" value="{{ old('physician_office_address', $patientinfo->physician_office_address ?? '') }}">
            </div>
            <div>
                <label class="text-xs text-gray-500">Office Number</label>
                <input type="text" name="physician_contact" class="pda-input" value="{{ old('physician_contact', $patientinfo->physician_contact ?? '') }}">
            </div>
        </div>

        {{-- Yes/No Questions --}}
        <div class="mt-4 border border-gray-200 rounded">
            @php
                $yn = [
                    ['key' => 'in_good_health',         'label' => '1. Are you in good health?',                                                'detailKey' => null,                       'detailLabel' => null],
                    ['key' => 'under_treatment',        'label' => '2. Are you under medical treatment now?',                                   'detailKey' => 'under_treatment_details',  'detailLabel' => 'If so, what is the condition being treated?'],
                    ['key' => 'had_illness_operation',  'label' => '3. Have you ever had serious illness or surgical operation?',               'detailKey' => 'illness_operation_details','detailLabel' => 'If so, what illness or operation?'],
                    ['key' => 'hospitalized',           'label' => '4. Have you ever been hospitalized?',                                       'detailKey' => 'hospitalized_details',     'detailLabel' => 'If so, when and why?'],
                    ['key' => 'taking_medication',      'label' => '5. Are you taking any prescription/non-prescription medication?',          'detailKey' => 'medication_details',       'detailLabel' => 'If so, please specify'],
                    ['key' => 'tobacco_use',            'label' => '6. Do you use tobacco products?',                                           'detailKey' => null,                       'detailLabel' => null],
                    ['key' => 'substance_use',          'label' => '7. Do you use alcohol, cocaine or other dangerous drugs?',                  'detailKey' => null,                       'detailLabel' => null],
                ];
            @endphp

            @foreach($yn as $row)
                <div class="px-3 py-2 border-b border-gray-100">
                    <div class="pda-yn-row">
                        <span class="pda-yn-label">{{ $row['label'] }}</span>
                        <span class="pda-yn-radios">
                            <label><input type="radio" name="{{ $row['key'] }}" value="1" {{ old($row['key'], $patientinfo->{$row['key']} ?? null) ? 'checked' : '' }}> Yes</label>
                            <label><input type="radio" name="{{ $row['key'] }}" value="0" {{ (old($row['key'], $patientinfo->{$row['key']} ?? null) === 0 || old($row['key'], $patientinfo->{$row['key']} ?? null) === false || old($row['key'], $patientinfo->{$row['key']} ?? null) === '0') ? 'checked' : '' }}> No</label>
                        </span>
                    </div>
                    @if($row['detailKey'])
                        <div class="pda-detail">
                            <label>{{ $row['detailLabel'] }}</label>
                            <input type="text" name="{{ $row['detailKey'] }}" value="{{ old($row['detailKey'], $patientinfo->{$row['detailKey']} ?? '') }}">
                        </div>
                    @endif
                </div>
            @endforeach

            {{-- 8. Allergies --}}
            <div class="px-3 py-2 border-b border-gray-100">
                <div class="pda-yn-row">
                    <span class="pda-yn-label">8. Are you allergic to any of the following:</span>
                    <span class="pda-yn-radios">
                        <label><input type="radio" name="allergic" value="1" {{ old('allergic', $patientinfo->allergic ?? null) ? 'checked' : '' }}> Yes</label>
                        <label><input type="radio" name="allergic" value="0" {{ (old('allergic', $patientinfo->allergic ?? null) === false || old('allergic', $patientinfo->allergic ?? null) === '0' || old('allergic', $patientinfo->allergic ?? null) === 0) ? 'checked' : '' }}> No</label>
                    </span>
                </div>
                <div class="ml-6 mt-2 grid grid-cols-2 md:grid-cols-3 gap-2 text-xs text-gray-700">
                    <label class="flex items-center gap-2"><input type="checkbox" name="allergic_lidocaine" value="1" {{ old('allergic_lidocaine', $patientinfo->allergic_lidocaine ?? false) ? 'checked' : '' }}> Local Anesthetic (e.g. Lidocaine)</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="allergic_penicillin" value="1" {{ old('allergic_penicillin', $patientinfo->allergic_penicillin ?? false) ? 'checked' : '' }}> Penicillin / Antibiotics</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="allergic_sulfa" value="1" {{ old('allergic_sulfa', $patientinfo->allergic_sulfa ?? false) ? 'checked' : '' }}> Sulfa drugs</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="allergic_aspirin" value="1" {{ old('allergic_aspirin', $patientinfo->allergic_aspirin ?? false) ? 'checked' : '' }}> Aspirin</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="allergic_latex" value="1" {{ old('allergic_latex', $patientinfo->allergic_latex ?? false) ? 'checked' : '' }}> Latex</label>
                    <label class="flex items-center gap-2 col-span-2 md:col-span-1">
                        <span>Others:</span>
                        <input type="text" name="allergic_others" class="pda-input flex-1 text-xs py-1" value="{{ old('allergic_others', $patientinfo->allergic_others ?? '') }}">
                    </label>
                </div>
            </div>

            {{-- 9. Bleeding Time --}}
            <div class="px-3 py-2 border-b border-gray-100">
                <div class="pda-yn-row">
                    <span class="pda-yn-label">9. Bleeding Time</span>
                    <span class="pda-yn-radios">
                        <label><input type="radio" name="bleeding_time" value="1" {{ old('bleeding_time', $patientinfo->bleeding_time ?? null) ? 'checked' : '' }}> Yes</label>
                        <label><input type="radio" name="bleeding_time" value="0" {{ (old('bleeding_time', $patientinfo->bleeding_time ?? null) === false || old('bleeding_time', $patientinfo->bleeding_time ?? null) === '0' || old('bleeding_time', $patientinfo->bleeding_time ?? null) === 0) ? 'checked' : '' }}> No</label>
                    </span>
                </div>
            </div>

            {{-- 10. For women only --}}
            <div class="px-3 py-2 border-b border-gray-100">
                <div class="pda-yn-row">
                    <span class="pda-yn-label">10. For women only:</span>
                </div>
                <div class="ml-6 space-y-1">
                    <div class="pda-yn-row">
                        <span class="pda-yn-label">Are you pregnant?</span>
                        <span class="pda-yn-radios">
                            <label><input type="radio" name="pregnant" value="1" {{ old('pregnant', $patientinfo->pregnant ?? null) ? 'checked' : '' }}> Yes</label>
                            <label><input type="radio" name="pregnant" value="0" {{ (old('pregnant', $patientinfo->pregnant ?? null) === false || old('pregnant', $patientinfo->pregnant ?? null) === '0' || old('pregnant', $patientinfo->pregnant ?? null) === 0) ? 'checked' : '' }}> No</label>
                        </span>
                    </div>
                    <div class="pda-yn-row">
                        <span class="pda-yn-label">Are you nursing?</span>
                        <span class="pda-yn-radios">
                            <label><input type="radio" name="nursing" value="1" {{ old('nursing', $patientinfo->nursing ?? null) ? 'checked' : '' }}> Yes</label>
                            <label><input type="radio" name="nursing" value="0" {{ (old('nursing', $patientinfo->nursing ?? null) === false || old('nursing', $patientinfo->nursing ?? null) === '0' || old('nursing', $patientinfo->nursing ?? null) === 0) ? 'checked' : '' }}> No</label>
                        </span>
                    </div>
                    <div class="pda-yn-row">
                        <span class="pda-yn-label">Are you taking birth control pills?</span>
                        <span class="pda-yn-radios">
                            <label><input type="radio" name="birth_control_pills" value="1" {{ old('birth_control_pills', $patientinfo->birth_control_pills ?? null) ? 'checked' : '' }}> Yes</label>
                            <label><input type="radio" name="birth_control_pills" value="0" {{ (old('birth_control_pills', $patientinfo->birth_control_pills ?? null) === false || old('birth_control_pills', $patientinfo->birth_control_pills ?? null) === '0' || old('birth_control_pills', $patientinfo->birth_control_pills ?? null) === 0) ? 'checked' : '' }}> No</label>
                        </span>
                    </div>
                </div>
            </div>

            {{-- 11. Blood Type --}}
            <div class="px-3 py-2 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="pda-yn-label whitespace-nowrap">11. Blood Type</span>
                    <input type="text" name="blood_type" class="pda-input pda-input-narrow" value="{{ old('blood_type', $patientinfo->blood_type ?? '') }}">
                </div>
            </div>

            {{-- 12. Blood Pressure --}}
            <div class="px-3 py-2 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="pda-yn-label whitespace-nowrap">12. Blood Pressure</span>
                    <input type="text" name="blood_pressure" class="pda-input pda-input-narrow" value="{{ old('blood_pressure', $patientinfo->blood_pressure ?? '') }}">
                </div>
            </div>

            {{-- 13. Conditions checklist --}}
            <div class="px-3 py-3">
                <p class="text-sm font-semibold text-gray-700 mb-2">13. Do you have or have you had any of the following? Check which apply.</p>
                <div class="pda-cond-grid">
                    @foreach($conditions as $condition)
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="{{ $condition }}" {{ in_array($condition, $checkedConditions) ? 'checked' : '' }}>
                            <span>{{ $condition }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="pt-4 flex justify-end gap-3">
            @if($firstLogin && auth()->user()->account_type == 'patient')
                <a href="/logouts" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded">Cancel</a>
            @endif
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                {{ $firstLogin ? 'Submit & Continue' : 'Save' }}
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    (function () {
        const form = document.getElementById('patient-form');
        if (!form) return;

        // Auto-update Age display from birthdate
        const bday = form.querySelector('input[name="birthdate"]');
        const ageOut = document.getElementById('age-display');
        function recalcAge() {
            if (!bday || !ageOut || !bday.value) return;
            const bd = new Date(bday.value);
            if (isNaN(bd)) return;
            const today = new Date();
            let age = today.getFullYear() - bd.getFullYear();
            const m = today.getMonth() - bd.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < bd.getDate())) age--;
            ageOut.value = age >= 0 ? age : '';
        }
        if (bday) bday.addEventListener('change', recalcAge);

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(form);
            const isFirstLogin = form.dataset.firstLogin === '1';

            axios.post("{{ route('patient-records') }}", formData)
                .then(function (response) {
                    if (response.data.status === 'success') {
                        if (response.data.redirect) {
                            window.location.href = response.data.redirect;
                            return;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: response.data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(function (error) {
                    let message = 'Something went wrong.';
                    if (error.response && error.response.data) {
                        if (error.response.data.message) {
                            message = error.response.data.message;
                        } else if (error.response.data.errors) {
                            message = Object.values(error.response.data.errors).flat().join('\n');
                        }
                    }
                    Swal.fire({ icon: 'error', title: 'Error', text: message });
                });
        });
    })();
</script>
