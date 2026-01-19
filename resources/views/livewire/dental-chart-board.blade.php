<div class="space-y-6">
     @if (auth()->user()->account_type == 'admin')
    <div class="flex items-center mt-2">
        <!-- Print button (left) -->
        <button
            onclick="printDiv('printable-info')"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 print:hidden"
        >
            Print Dental Chart
        </button>

        <!-- Next button (right) -->
        <button
            @click="tab='checkin'"
            class="ml-auto px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700"
        >
            Next
        </button>
    </div>
@endif

{{-- PATIENT INFO --}}
<div>
    <p><strong>Name:</strong> {{ $patient->lastname }}, {{ $patient->name }} {{ $patient->middlename }} {{ $patient->suffix ?? '' }}</p>
    <p><strong>Address:</strong> {{ $patient->current_address }}</p>
    <p><strong>Birthdate:</strong> {{ $patient->birth_date }}</p>
    <p><strong>Contact:</strong> {{ $patient->contact_number }}</p>
    <p><strong>Email:</strong> {{ $patient->email }}</p>
</div>

{{-- SVG STYLE --}}
<style>
.slice,.inner-slice{
    fill:#fff;
    stroke:#000;
    stroke-width:2;
    cursor:pointer
}
.slice:hover,.inner-slice:hover{
    fill:#e5e7eb
}


</style>


<div class="mt-6 p-4 border rounded-lg bg-gray-50 flex flex-col">
    <div class="flex flex-row justify-between">
        <!-- Condition -->  
        <div class="mb-4">
            <h4 class="text-xs font-semibold mb-1">Condition</h4>
            <ul class="text-xs space-y-1">
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#ffffff; border-color:#000000"></span>✓ - Present Teeth</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#ef4444; border-color:#000000"></span>D - Decayed (Caries Indicated for Filling)</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#7c2d12; border-color:#000000"></span>M - Missing due to Caries</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#6b7280; border-color:#000000"></span>MO - Missing due to Other Causes</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#f59e0b; border-color:#000000"></span>Im - Impacted Tooth</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#8b5cf6; border-color:#000000"></span>Sp - Supernumerary Tooth</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#78350f; border-color:#000000"></span>Rf - Root Fragment</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#cbd5e1; border-color:#000000"></span>Un - Unerupted</li>
            </ul>
        </div>

        <!-- Restorations & Prosthetics -->
        <div class="mb-4">
            <h4 class="text-xs font-semibold mb-1">Restorations &amp; Prosthetics</h4>
            <ul class="text-xs space-y-1">
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#737373; border-color:#000000"></span>Am - Amalgam Filling</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#3b82f6; border-color:#000000"></span>Co - Composite Filling</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#facc15; border-color:#000000"></span>JC - Jacket Crown</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#a855f7; border-color:#000000"></span>Ab - Abutment</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#ec4899; border-color:#000000"></span>Att - Attachment</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#f97316; border-color:#000000"></span>P - Pontic</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#06b6d4; border-color:#000000"></span>In - Inlay</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#14b8a6; border-color:#000000"></span>Imp - Implant</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#84cc16; border-color:#000000"></span>S - Sealants</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#f472b6; border-color:#000000"></span>Rm - Removable Denture</li>
            </ul>
        </div>

        <!-- Surgery -->
        <div>
            <h4 class="text-xs font-semibold mb-1">Surgery</h4>
            <ul class="text-xs space-y-1">
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#dc2626; border-color:#000000"></span>X - Extraction due to Caries</li>
                <li><span class="inline-block w-3 h-3 mr-2 rounded border" style="background-color:#991b1b; border-color:#000000"></span>XO - Extraction due to Other Causes</li>
            </ul>
        </div>
    </div>
</div>




@php
$upperTemp = ['55','54','53','52','51','61','62','63','64','65'];
$lowerTemp = ['85','84','83','82','81','71','72','73','74','75'];
$upperPerm = ['18','17','16','15','14','13','12','11','21','22','23','24','25','26','27','28'];
$lowerPerm = ['48','47','46','45','44','43','42','41','31','32','33','34','35','36','37','38'];

function toothSVG($tooth){
return <<<HTML
<svg viewBox="0 0 200 200"
     class="tooth-svg w-14 h-14 rotate-[-45deg]"
     data-tooth="$tooth">
     
  <path class="slice" data-part="top"
        d="M100 100 L100 0 A100 100 0 0 1 200 100 Z"/>
        
  <path class="slice" data-part="right"
        d="M100 100 L200 100 A100 100 0 0 1 100 200 Z"/>
        
  <path class="slice" data-part="bottom"
        d="M100 100 L100 200 A100 100 0 0 1 0 100 Z"/>
        
  <path class="slice" data-part="left"
        d="M100 100 L0 100 A100 100 0 0 1 100 0 Z"/>
        
  <circle class="inner-slice"
          data-part="center"
          cx="100" cy="100" r="55"/>
</svg>


HTML;
}

@endphp

{{-- TEMPORARY UPPER --}}
<h3 class="text-sm font-bold text-center">Temporary Upper Teeth</h3>
<div class="grid grid-cols-10 gap-2 border p-2">
@foreach($upperTemp as $t)
<div class="flex flex-col items-center">
    <span class="text-xs font-semibold mb-1">{{ $t }}</span>
    {!! toothSVG($t) !!}
</div>
@endforeach
</div>

{{-- PERMANENT UPPER --}}
<h3 class="text-sm font-bold text-center mt-4">Permanent Upper Teeth</h3>
<div class="flex justify-between border p-2">
@foreach($upperPerm as $t)
<div class="flex flex-col items-center">
    <span class="text-xs font-semibold mb-1">{{ $t }}</span>
    {!! toothSVG($t) !!}
</div>
@endforeach
</div>

{{-- PERMANENT LOWER --}}
<h3 class="text-sm font-bold text-center mt-4">Permanent Lower Teeth</h3>
<div class="flex justify-between border p-2">
@foreach($lowerPerm as $t)
<div class="flex flex-col items-center">
    <span class="text-xs font-semibold mb-1">{{ $t }}</span>
    {!! toothSVG($t) !!}
</div>
@endforeach
</div>

{{-- TEMPORARY LOWER --}}
<h3 class="text-sm font-bold text-center mt-4">Temporary Lower Teeth</h3>
<div class="grid grid-cols-10 gap-2 border p-2">
@foreach($lowerTemp as $t)
<div class="flex flex-col items-center">
    <span class="text-xs font-semibold mb-1">{{ $t }}</span>
    {!! toothSVG($t) !!}
</div>
@endforeach
</div>

{{-- LEGEND --}}

    
    <div class="mt-6 space-y-4">

        <!-- Periodontal Screening -->
        <h3 class="text-sm font-bold">Periodontal Screening</h3>
        <div class="grid grid-cols-2 gap-2">
            <label>
                <input type="checkbox" wire:model.change="chart.gingivitis" @if(auth()->user()->account_type == 'patient') disabled @endif> Gingivitis
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.early_periodontitis" @if(auth()->user()->account_type == 'patient') disabled @endif> Early Periodontitis
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.moderate_periodontitis" @if(auth()->user()->account_type == 'patient') disabled @endif> Moderate Periodontitis
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.advanced_periodontitis" @if(auth()->user()->account_type == 'patient') disabled @endif> Advanced Periodontitis
            </label>
        </div>
    
        <!-- Occlusion -->
        <h3 class="text-sm font-bold mt-4">Occlusion</h3>
        <div class="grid grid-cols-2 gap-2">
            <label>
                <input type="checkbox" wire:model.change="chart.occlusion_class_molar" @if(auth()->user()->account_type == 'patient') disabled @endif> Class Molar
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.overjet" @if(auth()->user()->account_type == 'patient') disabled @endif> Overjet
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.overbite" @if(auth()->user()->account_type == 'patient') disabled @endif> Overbite
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.midline_deviation" @if(auth()->user()->account_type == 'patient') disabled @endif> Midline Deviation
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.crossbite" @if(auth()->user()->account_type == 'patient') disabled @endif> Crossbite
            </label>
        </div>
    
        <!-- Appliances -->
        <h3 class="text-sm font-bold mt-4">Appliances</h3>
        <div class="grid grid-cols-2 gap-2">
            <label>
                <input type="checkbox" wire:model.change="chart.appliance_orthodontic" @if(auth()->user()->account_type == 'patient') disabled @endif> Orthodontic
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.appliance_stayplate" @if(auth()->user()->account_type == 'patient') disabled @endif> Stayplate
            </label>
            {{-- <label>
                <input type="checkbox" wire:model.change="chart.appliance_others"> Others
            </label> --}}
        </div>
    
        <!-- TMD -->
        <h3 class="text-sm font-bold mt-4">TMD</h3>
        <div class="grid grid-cols-2 gap-2">
            <label>
                <input type="checkbox" wire:model.change="chart.tmd_clenching" @if(auth()->user()->account_type == 'patient') disabled @endif> Clenching
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.tmd_clicking" @if(auth()->user()->account_type == 'patient') disabled @endif> Clicking
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.tmd_trismus" @if(auth()->user()->account_type == 'patient') disabled @endif> Trismus
            </label>
            <label>
                <input type="checkbox" wire:model.change="chart.tmd_muscle_spasm" @if(auth()->user()->account_type == 'patient') disabled @endif> Muscle Spasm
            </label>
        </div>

<script>
const DATA = {
  condition: [
    ["✓", "Present Teeth", "#ffffff"],
    ["D", "Decayed", "#ef4444"],
    ["M", "Missing (Caries)", "#7c2d12"],
    ["MO", "Missing (Other)", "#6b7280"],
    ["Im", "Impacted", "#f59e0b"],
    ["Sp", "Supernumerary", "#8b5cf6"],
    ["Rf", "Root Fragment", "#78350f"],
    ["Un", "Unerupted", "#cbd5e1"]
  ],
  restoration: [
    ["Am", "Amalgam Filling", "#737373"],
    ["Co", "Composite Filling", "#3b82f6"],
    ["JC", "Jacket Crown", "#facc15"],
    ["Ab", "Abutment", "#a855f7"],
    ["Att", "Attachment", "#ec4899"],
    ["P", "Pontic", "#f97316"],
    ["In", "Inlay", "#06b6d4"],
    ["Imp", "Implant", "#14b8a6"],
    ["S", "Sealants", "#84cc16"],
    ["Rm", "Removable Denture", "#f472b6"]
  ],
  surgery: [
    ["X", "Extraction (Caries)", "#dc2626"],
    ["XO", "Extraction (Other)", "#991b1b"]
  ]
};
</script>



{{-- MODAL --}}
<div id="toothModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
  <div class="bg-white w-[720px] max-h-[85vh] rounded p-6 overflow-y-auto">

    <h3 class="font-bold mb-4">Select Tooth Record</h3>

    <div class="mb-4">
      <h4 class="font-semibold mb-2">Condition</h4>
      <div id="conditionGroup" class="grid grid-cols-3 gap-3"></div>
    </div>

    <div class="mb-4">
      <h4 class="font-semibold mb-2">Restoration</h4>
      <div id="restorationGroup" class="grid grid-cols-3 gap-3"></div>
    </div>

    <div class="mb-4">
      <h4 class="font-semibold mb-2">Surgery</h4>
      <div id="surgeryGroup" class="grid grid-cols-3 gap-3"></div>
    </div>

    <div class="text-right mt-4">
      <button onclick="closeModal()"
              class="px-4 py-2 bg-gray-200 rounded">
        Close
      </button>
    </div>

  </div>
</div>
<script>
/* =====================================================
   GLOBAL STATE
===================================================== */
let activePart  = null;
let activeTooth = null;
let fetchedRecords = [];

/* =====================================================
   CLICK HANDLER (ADMIN ONLY)
===================================================== */
document.addEventListener('click', function (e) {
@if(auth()->user()->account_type === 'patient')
  return;
@endif

  if (!e.target.matches('.slice, .inner-slice')) return;

  const svg = e.target.closest('svg[data-tooth]');
  if (!svg) return;

  activePart  = e.target;
  activeTooth = svg.dataset.tooth;

  openModal();
});

/* =====================================================
   MODAL
===================================================== */
function openModal() {
  $('#toothModal').removeClass('hidden').addClass('flex');
}

function closeModal() {
  $('#toothModal').addClass('hidden').removeClass('flex');
  activePart  = null;
  activeTooth = null;
}

/* =====================================================
   APPLY COLOR + SAVE
===================================================== */
function applyColor(color, code, group) {
  if (!activePart || !activeTooth) return;

  activePart.style.fill = color;

  saveTooth({
    tooth: activeTooth,
    part: activePart.dataset.part,
    group,
    code,
    color
  });

  closeModal();
}

/* =====================================================
   SAVE (AJAX POST)
===================================================== */
function saveTooth(payload) {
  $.ajax({
    url: "{{ route('dental.tooth.save') }}",
    method: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      patient_id: {{ $patient->id }},
      ...payload
    },
    success(res) {
      fetchTeeth(); // re-sync after save
    },
    error(err) {
      console.error(err.responseText);
      alert('Save failed');
    }
  });
}

/* =====================================================
   FETCH (AJAX GET)
===================================================== */
function fetchTeeth() {
  $.ajax({
    url: "{{ route('dental.tooth.fetch', $patient->id) }}",
    method: "GET",
    success(res) {
      if (!res.success) return;
      fetchedRecords = res.data;
      applyFetchedTeeth();
    },
    error(err) {
      console.error('Fetch failed', err.responseText);
    }
  });
}

/* =====================================================
   APPLY FETCHED DATA (NEW STRUCTURE)
===================================================== */
function applyFetchedTeeth() {
  const allTeeth = document.querySelectorAll('svg[data-tooth]');
  allTeeth.forEach(svg => {
    // Default: present teeth color
    svg.querySelectorAll('.slice, .inner-slice').forEach(el => {
      el.style.fill = '#ffffff'; // green
      el.dataset.code  = '✓';
      el.dataset.group = 'condition';
    });

    // Kung may fetched record, i-override ang color
    const record = fetchedRecords.find(r => r.tooth == svg.dataset.tooth);
    if (!record || !record.data) return;

    Object.entries(record.data).forEach(([part, info]) => {
      const el = svg.querySelector(`[data-part="${part}"]`);
      if (!el) return;
      el.style.fill = info.color;
      el.dataset.code  = info.code;
      el.dataset.group = info.group;
    });
  });
}


/* =====================================================
   MUTATION OBSERVER (LIVEWIRE / ALPINE SAFE)
===================================================== */
const observer = new MutationObserver(() => {
  applyFetchedTeeth();
});

/* =====================================================
   MODAL BUTTON BUILDER
===================================================== */
function buildGroup(key, containerId) {
  const container = document.getElementById(containerId);
  container.innerHTML = '';

  DATA[key].forEach(([code, label, color]) => {
    const btn = document.createElement('button');
    btn.className = 'border p-2 rounded text-sm hover:bg-gray-100 text-left';
    btn.innerHTML = `<b>${code}</b> - ${label}`;
    btn.onclick = () => applyColor(color, code, key);
    container.appendChild(btn);
  });
}

/* =====================================================
   INIT
===================================================== */
document.addEventListener('DOMContentLoaded', () => {
  buildGroup('condition', 'conditionGroup');
  buildGroup('restoration', 'restorationGroup');
  buildGroup('surgery', 'surgeryGroup');

  fetchTeeth();

  observer.observe(document.body, {
    childList: true,
    subtree: true
  });
});
</script>




</div>
