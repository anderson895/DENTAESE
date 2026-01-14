@extends('layout.cnav')

@section('title', 'Booking')
@section('main-content')

<style>
    /* ============================= */
/* Calendar Container */
/* ============================= */
#calendar {
    width: 100%;
    margin: 0 auto;
    background-color: #ffffff;
    border-radius: 1rem;
    padding: 0.75rem;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    cursor: pointer;
}


/* ============================= */
/* Remove Default Grid Borders */
/* ============================= */
.fc-theme-standard td,
.fc-theme-standard th {
    border: none !important;
}

/* ============================= */
/* Header / Toolbar */
/* ============================= */
.fc .fc-toolbar {
    margin-bottom: 1rem;
}

.fc .fc-toolbar-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #065f46; /* emerald-800 */
}

/* Navigation buttons */
.fc .fc-button {
    background: #ecfdf5 !important;
    color: #065f46 !important;
    border: none !important;
    border-radius: 0.75rem !important;
    padding: 0.25rem 0.75rem !important;
    font-weight: 500;
}

.fc .fc-button:hover {
    background: #d1fae5 !important;
}

.fc .fc-button:disabled {
    opacity: 0.4;
}

/* ============================= */
/* Weekday Labels */
/* ============================= */
.fc .fc-col-header-cell-cushion {
    color: #6b7280;
    font-weight: 500;
    padding: 0.5rem 0;
}

/* ============================= */
/* Day Cells */
/* ============================= */
.fc-daygrid-day {
    padding: 0.25rem;
}

/* Day cell wrapper */
.fc-daygrid-day-frame {
    height: 64px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease;
}

/* Day number */
.fc-daygrid-day-number {
    font-size: 0.95rem;
    font-weight: 500;
    color: #064e3b;
}

/* Hover effect */
.fc-daygrid-day:hover .fc-daygrid-day-frame {
    background-color: #ecfdf5;
}

/* Today (neutral, same as normal day) */
.fc-day-today .fc-daygrid-day-frame {
    background-color: transparent;
}

/* If today is ALSO selected */
.fc-day-today.fc-day-selected .fc-daygrid-day-frame {
    background-color: #059669 !important;
}

.fc-day-today.fc-day-selected .fc-daygrid-day-number {
    color: #ffffff !important;
}


/* ============================= */
/* Selected Day (custom class added via JS) */
/* ============================= */
.fc-day-selected .fc-daygrid-day-frame {
    background-color: #059669 !important; /* emerald-600 */
}

.fc-day-selected .fc-daygrid-day-number {
    color: #ffffff !important;
    font-weight: 600;
}

/* ============================= */
/* Disabled / Closed Days */
/* ============================= */
.fc .fc-daygrid-day.fc-day-disabled {
    opacity: 0.35;
    pointer-events: none;
}

.fc-day-disabled .fc-daygrid-day-frame {
    background: transparent !important;
}

.fc-day-disabled .fc-daygrid-day-number {
    color: #9ca3af !important;
}

/* ============================= */
/* Event Dots (Green Dots Below Date) */
/* ============================= */
.fc-daygrid-event-dot {
    border-color: #10b981 !important;
}

/* ============================= */
/* Remove "more" link underline */
/* ============================= */
.fc-daygrid-more-link {
    color: #10b981;
    font-weight: 500;
}

/* ============================= */
/* Selectable Cards (Branches, Dentists, Services) */
/* ============================= */
.card-selectable {
    cursor: pointer;
    border-width: 2px;
    border-color: #e5e7eb;
    border-radius: 0.75rem;
    transition: all 0.25s ease;
    background-color: #ffffff;
}

.card-selectable:hover {
    border-color: #10b981;
    box-shadow: 0 8px 20px rgba(16,185,129,0.15);
}

/* Selected card */
.card-selected {
    border-color: #10b981;
    background-color: #ecfdf5;
}

</style>

<form id="bookingForm" class="space-y-4">
    @csrf
    <!-- Step 1: Branch Selection -->
    <div id="step1" class="space-y-4">
        <h2 class="text-xl font-bold mb-2">Select a Branch</h2>
        <input type="hidden" name="store_id" id="store_id" required>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($stores as $store)
                <div class="card-selectable border rounded p-4 shadow hover:shadow-lg bg-white" data-id="{{ $store->id }}">
                    <h3 class="text-lg font-bold">{{ $store->name }}</h3>
                    <p>{{ $store->address }}</p>
                </div>
            @endforeach
        </div>
        <button type="button" id="step1btn" class="bg-gray-400 text-white px-4 py-2 rounded" onclick="goToStep(2)" disabled>Next</button>
        <div id="storedetail"></div>
    </div>

    <!-- Step 2: Dentist Selection + Calendar -->
    <div id="step2" class="space-y-4 hidden">
        <h2 class="text-xl font-bold mb-2">Select a Dentist</h2>
        <input type="hidden" name="dentist_id" id="dentist_id">
        <div id="dentistCards" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>

        <h2 class="text-xl font-bold mb-2">Choose Date & Time</h2>
        <div class="w-full max-w-full sm:max-w-lg md:max-w-xl lg:max-w-2xl">

            <div class="bg-white rounded-2xl shadow-md p-4 sm:p-6">
                <div id="calendar"></div>
            </div>
        </div>


        <input hidden type="text" id="appointment_date" class="w-full p-2 border rounded mt-4" placeholder="Selected date will appear here" readonly>
        <select id="appointment_time" name="appointment_time" class="w-full p-2 border rounded" disabled>
            <option value="">-- Select Date First --</option>
        </select>

        <div class="flex justify-between mt-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="goToStep(1)">Back</button>
            <button type="button" id="step2btn" class="bg-gray-500 text-white px-4 py-2 rounded" disabled onclick="goToStep(3)">Next</button>
        </div>
    </div>

    <!-- Step 3: Service Selection -->
    <div id="step3" class="space-y-4 hidden">
        <h2 class="text-xl font-bold mb-2">Select a Service</h2>
        <input type="hidden" name="service_ids" id="service_ids">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($services as $service)
                <div class="card-selectable border rounded p-4 shadow hover:shadow-lg bg-white" data-id="{{ $service->id }}" data-approx="{{ $service->approx_time }}">
                    <div class="flex justify-center mb-2">
                        <img class="w-[200px] h-[100px]" src="{{ $service->image ? asset('storage/service_images/' . $service->image) : asset('images/logo.png') }}" alt="Service Image" />
                    </div>
                    <h3 class="text-lg font-bold">{{ $service->name }}</h3>
                    <p>{{ $service->description }}</p>
                    <p>Approx. Time: {{ $service->approx_time }} mins</p>
                </div>
            @endforeach
        </div>

        <textarea class="w-full p-2 border rounded" rows="5" id="desc" name="desc" placeholder="Describe your concern..."></textarea>
        <div class="flex justify-between">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="goToStep(2)">Back</button>
            <button type="submit" id="step3btn" class="bg-gray-400 text-white px-4 py-2 rounded" disabled>Book Appointment</button>
        </div>
        <div id="servicedetail"></div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
let calendar;
let openDays = [];

// Helper: enable Step 2 Next button only if dentist and time selected
function checkStep2NextButton() {
    const dentistSelected = $('#dentist_id').val();
    const timeSelected = $('#appointment_time').val();
    const btn = $('#step2btn');

    if(dentistSelected && timeSelected) {
        btn.prop('disabled', false)
           .removeClass('bg-gray-500')
           .addClass('bg-blue-600 cursor-pointer hover:bg-blue-700');
    } else {
        btn.prop('disabled', true)
           .removeClass('bg-blue-600 cursor-pointer hover:bg-blue-700')
           .addClass('bg-gray-500');
    }
}

// Helper: enable Step 3 Book button if at least one service selected
function checkStep3BookButton() {
    const selected = $('#step3 .card-selected').length;
    const btn = $('#step3btn');

    if(selected > 0) {
        btn.prop('disabled', false)
           .removeClass('bg-gray-400')
           .addClass('bg-green-600 cursor-pointer hover:bg-blue-700');
    } else {
        btn.prop('disabled', true)
           .removeClass('bg-green-600 hover:bg-blue-700 cursor-pointer')
           .addClass('bg-gray-400');
    }
}

// Multi-step navigation
function goToStep(step) {
    for (let i = 1; i <= 3; i++) { $('#step' + i).addClass('hidden'); }
    $('#step' + step).removeClass('hidden');
}

// Step 1: Branch selection
$(document).on('click', '#step1 .card-selectable', function() {
    $(this).siblings().removeClass('card-selected');
    $(this).addClass('card-selected');
    $('#store_id').val($(this).data('id')).trigger('change');

    // Enable Step 1 Next button
    $('#step1btn').prop('disabled', false)
                  .removeClass('bg-gray-400')
                  .addClass('bg-blue-600 cursor-pointer hover:bg-blue-700');
});

// Step 2: Dentist selection
$(document).on('click', '#step2 .card-selectable', function() {
    $(this).siblings().removeClass('card-selected');
    $(this).addClass('card-selected');
    $('#dentist_id').val($(this).data('id')).trigger('change');
    checkStep2NextButton();
});

// Step 3: Service selection (multi)
$(document).on('click', '#step3 .card-selectable', function() {
    $(this).toggleClass('card-selected');
    const selectedIds = $('#step3 .card-selected').map(function(){ return $(this).data('id'); }).get();
    $('#service_ids').val(JSON.stringify(selectedIds));
    checkStep3BookButton();
});

// Load dentists & calendar after branch selected
$('#store_id').on('change', function() {
    const storeId = $(this).val();
    if (!storeId) return;

    // Load branch schedule (open days)
    $.get(`/store/${storeId}/schedule`, function(data) {
        if (data.status === 'success') {
            const dayMap = { sun:0, mon:1, tue:2, wed:3, thu:4, fri:5, sat:6 };
            openDays = (data.open_days || []).map(d => dayMap[d.toLowerCase()]);

            // Initialize FullCalendar
            if(calendar) calendar.destroy();
            calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                selectable: true,
                validRange: { start: new Date() },
                dateClick: function(info) {
                    const day = info.date.getDay();
                    if (!openDays.includes(day)) return;

                    // Remove previous selection
                    document
                        .querySelectorAll('.fc-day-selected')
                        .forEach(el => el.classList.remove('fc-day-selected'));

                    // Add selected class (even if today)
                    info.dayEl.classList.add('fc-day-selected');

                    $('#appointment_date').val(info.dateStr).trigger('change');
                },

                dayCellClassNames: function(arg) {
                    if(!openDays.includes(arg.date.getDay())) return ['fc-day-disabled'];
                    return [];
                }
            });
            calendar.render();

            $('#appointment_date').prop('readonly', true);
            $('#appointment_time').html('<option>-- Select Date First --</option>').prop('disabled', true);

            // Load dentists for the branch
            $.get(`/branch/${storeId}/dentists`, function(response) {
                let cards = '';
                let defaultImg = "{{ asset('images/logo.png') }}";
                let profileBase = "{{ asset('storage/profile_pictures') }}";
                if(response.dentists.length > 0){
                    response.dentists.forEach(d => {
                        let img = d.profile_image ? `${profileBase}/${d.profile_image}` : defaultImg;
                        cards += `
                        <div class="card-selectable border rounded p-4 shadow hover:shadow-lg bg-white" data-id="${d.id}">
                            <div class="flex justify-center mb-2"><img class="w-[200px] h-[100px]" src="${img}"/></div>
                            <h3 class="text-lg font-bold">${d.lastname}, ${d.name}</h3>
                            <p>${d.contact_number}</p>
                        </div>`;
                    });
                } else {
                    cards = '<p>No dentists available.</p>';
                }
                $('#dentistCards').html(cards);
            });
        }
    });
});

// Load available slots after date selected
// Helper: convert 24-hour time to AM/PM
function formatTimeToAMPM(time24) {
    let [hour, minute] = time24.split(':').map(Number);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    hour = hour % 12 || 12;
    return `${hour}:${minute.toString().padStart(2, '0')} ${ampm}`;
}

// Load available slots after date selected
$('#appointment_date').on('change', function () {
    const date = $(this).val();
    const storeId = $('#store_id').val();
    const dentistId = $('#dentist_id').val();

    if (!date || !storeId || !dentistId) return;

    $('#appointment_time')
        .prop('disabled', false)
        .html('<option value="">Loading...</option>');

    $.get(`/branch/${storeId}/dentist/${dentistId}/slots`, { date }, function (resp) {

        if (resp.status === 'success') {

            let options = '<option value="">-- Select Time --</option>';

            const booked = resp.booked_slots || [];
            const allTimes = [...new Set([...resp.slots, ...booked])].sort();

            allTimes.forEach(time => {
                const formattedTime = formatTimeToAMPM(time);

                if (booked.includes(time)) {
                    options += `
                        <option value="${time}" disabled>
                            ${formattedTime} (Booked)
                        </option>
                    `;
                } else {
                    options += `
                        <option value="${time}">
                            ${formattedTime}
                        </option>
                    `;
                }
            });

            $('#appointment_time').html(options);
            checkStep2NextButton();

        } else {
            $('#appointment_time')
                .html('<option value="">No slots available</option>')
                .prop('disabled', true);
        }
    });
});

// Enable Step2 Next button when time selected
$('#appointment_time').on('change', function() {
    checkStep2NextButton();
});

// Submit booking form
$('#bookingForm').on('submit', function(e){
    e.preventDefault();
    const formData = {
        _token: '{{ csrf_token() }}',
        store_id: $('#store_id').val(),
        service_ids: JSON.parse($('#service_ids').val()),
        dentist_id: $('#dentist_id').val(),
        appointment_date: $('#appointment_date').val(),
        appointment_time: $('#appointment_time').val(),
        desc: $('#desc').val()
    };

    $.post('{{ route('appointments.store') }}', formData, function(resp){
        if(resp.status === 'success'){
            Swal.fire('Success!', resp.message, 'success');
            $('#bookingForm')[0].reset();
            goToStep(1);
        } else {
            Swal.fire('Error!', resp.message, 'error');
        }
    }).fail(xhr => {
        Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
    });
});
</script>

@endsection
