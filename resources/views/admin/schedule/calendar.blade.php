@extends('layout.navigation')

@section('title', 'Schedule Calendar')
@section('main-content')

<style>
    .cal-grid { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 4px; }
    .cal-cell {
        background: #fff; border: 1px solid #e5e7eb; min-height: 110px; padding: 6px;
        cursor: pointer; transition: background-color 120ms ease; position: relative;
    }
    .cal-cell:hover { background: #f3f4f6; }
    .cal-cell.is-other-month { background: #f9fafb; color: #9ca3af; }
    .cal-cell.is-today { border-color: #2563eb; box-shadow: inset 0 0 0 1px #2563eb; }
    .cal-cell.is-closed { background: #fee2e2; }
    .cal-cell.is-doctor-off { background: #fef3c7; }
    .cal-cell.is-doctor-available { background: #d1fae5; }
    .cal-day-num { font-weight: 600; font-size: 12px; color: #374151; }
    .cal-pill { display: inline-block; font-size: 10px; padding: 2px 6px; border-radius: 999px; margin-top: 4px; }
    .cal-pill-open { background: #dcfce7; color: #166534; }
    .cal-pill-closed { background: #fee2e2; color: #991b1b; }
    .cal-pill-off { background: #fef3c7; color: #92400e; }
    .cal-pill-doc { background: #dbeafe; color: #1e40af; }
    .cal-header-day { text-align: center; font-size: 11px; font-weight: 700; color: #6b7280; padding: 6px 0; text-transform: uppercase; letter-spacing: 0.5px; }
    .modal-backdrop { background: rgba(0,0,0,0.5); }
</style>

<div class="container mx-auto p-4" x-data="scheduleCalendar()" x-init="init()">

    <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
        <div>
            <h1 class="text-2xl font-bold">Schedule Calendar</h1>
            <p class="text-xs text-gray-500">Manage clinic open days and per-doctor availability per date.</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="changeMonth(-1)" class="px-3 py-1 bg-gray-200 rounded">&laquo; Prev</button>
            <span class="font-semibold text-lg" x-text="monthLabel"></span>
            <button @click="changeMonth(1)" class="px-3 py-1 bg-gray-200 rounded">Next &raquo;</button>
            <button @click="goToday()" class="px-3 py-1 bg-blue-600 text-white rounded">Today</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4 bg-white p-3 rounded shadow-sm">
        <div>
            <label class="text-xs font-semibold text-gray-600">Mode</label>
            <select x-model="mode" @change="loadEvents()" class="w-full border rounded p-2">
                <option value="clinic">Clinic Open Days</option>
                <option value="doctor">Doctor Schedule</option>
            </select>
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-600">Branch</label>
            <select x-model="storeId" @change="loadEvents()" class="w-full border rounded p-2">
                <option value="">-- All Branches --</option>
                @foreach($stores as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div x-show="mode === 'doctor'">
            <label class="text-xs font-semibold text-gray-600">Dentist</label>
            <select x-model="dentistId" @change="loadEvents()" class="w-full border rounded p-2">
                <option value="">-- All Dentists --</option>
                @foreach($dentists as $d)
                    <option value="{{ $d->id }}">{{ $d->name }} {{ $d->lastname }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex items-center gap-3 text-xs mb-2">
        <span class="inline-flex items-center gap-1"><span class="inline-block w-3 h-3 bg-red-200 rounded"></span> Clinic closed</span>
        <span class="inline-flex items-center gap-1"><span class="inline-block w-3 h-3 bg-yellow-200 rounded"></span> Dentist off</span>
        <span class="inline-flex items-center gap-1"><span class="inline-block w-3 h-3 bg-green-200 rounded"></span> Dentist available</span>
    </div>

    <!-- Calendar grid -->
    <div class="cal-grid">
        <template x-for="d in ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']" :key="d">
            <div class="cal-header-day" x-text="d"></div>
        </template>

        <template x-for="cell in cells" :key="cell.key">
            <div class="cal-cell"
                 :class="{
                     'is-other-month': !cell.inMonth,
                     'is-today': cell.isToday,
                     'is-closed': cell.clinicClosed,
                     'is-doctor-off': cell.doctorOff,
                     'is-doctor-available': cell.doctorAvailable,
                 }"
                 @click="openCell(cell)">
                <div class="flex justify-between items-start">
                    <span class="cal-day-num" x-text="cell.day"></span>
                    <span class="text-[10px] text-gray-400" x-text="cell.weeklyOpen ? '' : 'Wkly closed'"></span>
                </div>
                <template x-if="cell.clinicOverride">
                    <div>
                        <span class="cal-pill" :class="cell.clinicOverride.is_open ? 'cal-pill-open' : 'cal-pill-closed'"
                              x-text="cell.clinicOverride.is_open ? 'Open override' : 'Closed'"></span>
                        <template x-if="cell.clinicOverride.reason">
                            <div class="text-[10px] text-gray-500 mt-1" x-text="cell.clinicOverride.reason"></div>
                        </template>
                    </div>
                </template>
                <template x-for="d in cell.doctors" :key="d.id">
                    <div class="mt-1">
                        <span class="cal-pill" :class="d.status === 'off' ? 'cal-pill-off' : 'cal-pill-doc'"
                              x-text="d.dentist_name + (d.status === 'off' ? ' (off)' : (d.start_time ? (' ' + d.start_time + '-' + d.end_time) : ''))"></span>
                    </div>
                </template>
            </div>
        </template>
    </div>

    <!-- Modal -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center modal-backdrop">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6" @click.away="modalOpen = false">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-bold" x-text="modalTitle"></h2>
                <button class="text-gray-500" @click="modalOpen = false">&times;</button>
            </div>

            <p class="text-sm text-gray-600 mb-3">Date: <strong x-text="modalDate"></strong></p>

            <!-- Clinic mode form -->
            <template x-if="mode === 'clinic'">
                <div class="space-y-3">
                    <template x-if="!storeId">
                        <p class="text-sm text-red-600">Please select a branch above first.</p>
                    </template>
                    <template x-if="storeId">
                        <div class="space-y-3">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="form.is_open" class="form-checkbox">
                                <span>Open on this date</span>
                            </label>
                            <div class="grid grid-cols-2 gap-2" x-show="form.is_open">
                                <div>
                                    <label class="text-xs">Opening time (override)</label>
                                    <input type="time" x-model="form.opening_time" class="border rounded p-2 w-full">
                                </div>
                                <div>
                                    <label class="text-xs">Closing time (override)</label>
                                    <input type="time" x-model="form.closing_time" class="border rounded p-2 w-full">
                                </div>
                            </div>
                            <div>
                                <label class="text-xs">Reason / Note</label>
                                <input type="text" x-model="form.reason" placeholder="e.g. Holiday, Special hours" class="border rounded p-2 w-full">
                            </div>
                            <div class="flex justify-between pt-2">
                                <button class="px-3 py-2 bg-red-100 text-red-700 rounded" x-show="form.id" @click="deleteOverride()">Remove override</button>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded ml-auto" @click="saveClinic()">Save</button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Doctor mode form -->
            <template x-if="mode === 'doctor'">
                <div class="space-y-3">
                    <template x-if="!dentistId">
                        <p class="text-sm text-red-600">Please select a dentist above first.</p>
                    </template>
                    <template x-if="dentistId">
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs">Status</label>
                                <select x-model="form.status" class="border rounded p-2 w-full">
                                    <option value="available">Available</option>
                                    <option value="off">Off / Day off</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-2" x-show="form.status === 'available'">
                                <div>
                                    <label class="text-xs">Start</label>
                                    <input type="time" x-model="form.start_time" class="border rounded p-2 w-full">
                                </div>
                                <div>
                                    <label class="text-xs">End</label>
                                    <input type="time" x-model="form.end_time" class="border rounded p-2 w-full">
                                </div>
                            </div>
                            <div>
                                <label class="text-xs">Notes</label>
                                <input type="text" x-model="form.notes" class="border rounded p-2 w-full">
                            </div>
                            <div class="flex justify-between pt-2">
                                <button class="px-3 py-2 bg-red-100 text-red-700 rounded" x-show="form.id" @click="deleteDoctor()">Remove</button>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded ml-auto" @click="saveDoctor()">Save</button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function scheduleCalendar() {
    return {
        mode: 'clinic',
        storeId: '',
        dentistId: '',
        cursor: null,
        cells: [],
        clinicOverrides: [],
        doctorSchedules: [],
        store: null,
        modalOpen: false,
        modalTitle: '',
        modalDate: '',
        form: {},

        init() {
            this.cursor = new Date();
            this.cursor.setDate(1);
            this.loadEvents();
        },

        get monthLabel() {
            if (!this.cursor) return '';
            return this.cursor.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        },

        changeMonth(delta) {
            const d = new Date(this.cursor);
            d.setMonth(d.getMonth() + delta);
            this.cursor = d;
            this.loadEvents();
        },

        goToday() {
            this.cursor = new Date();
            this.cursor.setDate(1);
            this.loadEvents();
        },

        async loadEvents() {
            const params = new URLSearchParams({
                year: this.cursor.getFullYear(),
                month: this.cursor.getMonth() + 1,
            });
            if (this.storeId)   params.append('store_id', this.storeId);
            if (this.dentistId) params.append('dentist_id', this.dentistId);

            const res = await fetch(`{{ route('schedule.events') }}?${params.toString()}`, {
                headers: { 'Accept': 'application/json' },
            });
            const data = await res.json();
            this.store           = data.store;
            this.clinicOverrides = data.clinic_overrides || [];
            this.doctorSchedules = data.doctor_schedules || [];
            this.buildCells();
        },

        buildCells() {
            const dayShort = ['sun','mon','tue','wed','thu','fri','sat'];
            const today = new Date(); today.setHours(0,0,0,0);
            const first = new Date(this.cursor);
            first.setDate(1);
            const startWeekday = first.getDay();

            const start = new Date(first);
            start.setDate(first.getDate() - startWeekday);

            const cells = [];
            for (let i = 0; i < 42; i++) {
                const d = new Date(start);
                d.setDate(start.getDate() + i);
                const iso = d.toISOString().slice(0, 10);
                const inMonth = d.getMonth() === this.cursor.getMonth();
                const weeklyOpen = !this.store || (this.store.open_days || []).includes(dayShort[d.getDay()]);
                const override = this.clinicOverrides.find(o => o.schedule_date === iso);
                const docs = this.doctorSchedules.filter(x => x.schedule_date === iso);

                const clinicClosed = override ? !override.is_open : (this.storeId && !weeklyOpen);
                const doctorOff = docs.some(x => x.status === 'off');
                const doctorAvailable = docs.some(x => x.status === 'available');

                cells.push({
                    key: iso,
                    day: d.getDate(),
                    iso,
                    weeklyOpen,
                    inMonth,
                    isToday: d.getTime() === today.getTime(),
                    clinicOverride: override,
                    clinicClosed: !!clinicClosed,
                    doctors: docs,
                    doctorOff,
                    doctorAvailable,
                });
            }
            this.cells = cells;
        },

        openCell(cell) {
            this.modalDate = cell.iso;
            if (this.mode === 'clinic') {
                this.modalTitle = 'Clinic open / closed override';
                const o = cell.clinicOverride;
                this.form = {
                    id: o?.id || null,
                    is_open: o ? o.is_open : true,
                    opening_time: o?.opening_time || '',
                    closing_time: o?.closing_time || '',
                    reason: o?.reason || '',
                };
            } else {
                this.modalTitle = 'Doctor schedule';
                const existing = cell.doctors.find(x => String(x.dentist_id) === String(this.dentistId));
                this.form = {
                    id: existing?.id || null,
                    status: existing?.status || 'available',
                    start_time: existing?.start_time || '',
                    end_time: existing?.end_time || '',
                    notes: existing?.notes || '',
                };
            }
            this.modalOpen = true;
        },

        async saveClinic() {
            if (!this.storeId) return;
            const body = new FormData();
            body.append('store_id', this.storeId);
            body.append('schedule_date', this.modalDate);
            body.append('is_open', this.form.is_open ? 1 : 0);
            if (this.form.opening_time) body.append('opening_time', this.form.opening_time);
            if (this.form.closing_time) body.append('closing_time', this.form.closing_time);
            if (this.form.reason)       body.append('reason', this.form.reason);
            const res = await fetch(`{{ route('schedule.clinic.save') }}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body
            });
            if (res.ok) { this.modalOpen = false; this.loadEvents(); }
        },

        async deleteOverride() {
            if (!this.form.id) return;
            const res = await fetch(`/schedule/clinic-override/${this.form.id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            });
            if (res.ok) { this.modalOpen = false; this.loadEvents(); }
        },

        async saveDoctor() {
            if (!this.dentistId) return;
            const body = new FormData();
            body.append('dentist_id', this.dentistId);
            if (this.storeId) body.append('store_id', this.storeId);
            body.append('schedule_date', this.modalDate);
            body.append('status', this.form.status);
            if (this.form.status === 'available') {
                if (this.form.start_time) body.append('start_time', this.form.start_time);
                if (this.form.end_time)   body.append('end_time', this.form.end_time);
            }
            if (this.form.notes) body.append('notes', this.form.notes);
            const res = await fetch(`{{ route('schedule.doctor.save') }}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body
            });
            if (res.ok) { this.modalOpen = false; this.loadEvents(); }
        },

        async deleteDoctor() {
            if (!this.form.id) return;
            const res = await fetch(`/schedule/doctor/${this.form.id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            });
            if (res.ok) { this.modalOpen = false; this.loadEvents(); }
        },
    }
}
</script>
@endsection
