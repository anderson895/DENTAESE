
<div class="flex flex-col md:flex-row md:gap-10">
    <!-- 70% Booking Form -->
    <div class="md:w-[70%]">
        <form id="bookingForm" class="space-y-4">
            @csrf

              {{-- Services --}}
            <div>
                <label for="user_id" class="block font-semibold">Select Patient</label>
                <select id="user_id" name="user_id" class="w-full p-2 border rounded" required>
                    <option value="">-- Choose Patient --</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->lastname }}, {{ $client->name }}</option>
                    @endforeach
                </select>
              
            </div>
            <!-- Store Selection -->
            <div>
                <label for="store_id" class="block font-semibold">Select Branch</label>
                <select id="store_id" name="store_id" class="w-full p-2 border rounded" required>
                    <option value="">-- Choose Branch --</option>
                    @foreach ($stores as $store)
                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </select>
                <div id="storedetail" hidden></div>
            </div>

            {{-- Services --}}
            <div>
                <label for="service_id" class="block font-semibold">Select Service</label>
                <select id="service_id" name="service_id" class="w-full p-2 border rounded" required>
                    <option value="">-- Choose Service --</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                <div id="servicedetail" hidden></div>
            </div>
            <!-- Dentist Selection -->
            <div>
                <label for="dentist_id" class="block font-semibold">Select Dentist</label>
                <div id="dentistWrapper">
                <select id="dentist_id" name="dentist_id" class="w-full p-2 border rounded"  disabled>
                  
                    <option value="">-- Choose Dentist --</option>
                    
                </select>
            </div>
            </div>
            <input type="hidden" id="selected_dentist" name="selected_dentist" value="">
            <!-- Date -->
                        <!-- Date and Time Wrapper -->
            <div id="datetimeWrapper" style="display: none;">
                <!-- Date -->
                <div>
                    <label for="appointment_date" class="block font-semibold">Select Date</label>
                    <input type="date" id="appointment_date" name="appointment_date"
                        class="w-full p-2 border rounded" required disabled>
                </div>

                <!-- Time -->
                <div>
                    <label for="appointment_time" class="block font-semibold">Select Time</label>
                    <select id="appointment_time" name="appointment_time" class="w-full p-2 border rounded" required disabled>
                        <option value="">-- Select Date First --</option>
                    </select>
                </div>
            </div>



            <!-- Description -->
            <div>
                <label for="desc" class="block font-semibold">Appointment Description</label>
                <textarea class="w-full p-2 border rounded" rows="10" cols="30" id="desc" name="desc" required></textarea>
            </div>

                        <!-- Submit -->
            <button type="submit" name="appointment_type" value="normal"
                class="bg-blue-600 text-white px-4 py-2 rounded">
                Book Appointment
            </button>

            <button type="submit" name="appointment_type" value="walkin"
                class="bg-green-600 text-white px-4 py-2 rounded">
                Walk-in
            </button>

            <button type="submit" name="appointment_type" value="emergency"
                class="bg-red-600 text-white px-4 py-2 rounded">
                Emergency
            </button>

    
        </form>
    </div>

  



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let openDays = []; 
const dayMap = { sun: 0, mon: 1, tue: 2, wed: 3, thu: 4, fri: 5, sat: 6 };

let flatpickrInstance;

$('#store_id').on('change', function () {
    const storeId = $(this).val();
    if (!storeId) return;

   $.get(`/store/${storeId}/schedule`, function (data) {
    if (data.status === 'success') {
        const dayNameToNumber = {
            sun: 0,
            mon: 1,
            tue: 2,
            wed: 3,
            thu: 4,
            fri: 5,
            sat: 6
        };

        const dayNameToLabel = {
            sun: 'Sunday',
            mon: 'Monday',
            tue: 'Tuesday',
            wed: 'Wednesday',
            thu: 'Thursday',
            fri: 'Friday',
            sat: 'Saturday'
        };
        openDays = (data.open_days || []).map(day => dayNameToNumber[day.toLowerCase()]);
        const readableDays = (data.open_days || []).map(day => dayNameToLabel[day.toLowerCase()]).join(', ');

        if (flatpickrInstance) {
            flatpickrInstance.destroy();
        }

        flatpickrInstance = flatpickr("#appointment_date", {
            dateFormat: "Y-m-d",
            minDate: new Date().fp_incr(2), 
            disable: [
                function (date) {
                    return !openDays.includes(date.getDay());
                }
            ]
        });

        $('#storedetail').html(`
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-bold mb-2">${data.name}</h2>
                <p><strong>Address:</strong> ${data.address}</p>
                <p><strong>Opening Time:</strong> ${data.opening_time}</p>
                <p><strong>Closing Time:</strong> ${data.closing_time}</p>
                <p><strong>Open Days:</strong> ${readableDays}</p>
            </div>
        `);

        $('#appointment_date').prop('disabled', false);
    }
});


$('#service_id').on('change', function () {
    const serviceId = $(this).val();
    $.get(`/service/${serviceId}`, function (servdata) {

        if (servdata.status == 'success') {



            $('#servicedetail').html(`
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-bold mb-2">${servdata.name}</h2>
                <p><strong>Description:</strong> ${servdata.desc}</p>
                <p><strong>Type:</strong> ${servdata.type}</p>
                <p><strong>Approx. Time:</strong> ${servdata.time}</p>
                <p><strong>Approx. Price:</strong> ${servdata.price}</p>
            </div>
        `);
        }
   
        });
});

$.get(`/branch/${storeId}/dentists`, function (response) {
    console.log('dentists response:', response);
        const $w = $('#dentistWrapper');
        if (!$w.length) {
            console.error('dentistWrapper not found in DOM');
            return;
        }

        let selectHtml = `<select id="dentist_id" name="dentist_id" class="w-full p-2 border rounded" required>`;
        if (response.dentists && response.dentists.length > 0) {
            selectHtml += `<option value="">-- Choose Dentist --</option>`;
            response.dentists.forEach(d => {
                selectHtml += `<option value="${d.id}">${d.name}</option>`;
            });
            selectHtml += `</select>`;
            $w.html(selectHtml);
            $('#dentist_id').prop('disabled', false);
        } else {
            selectHtml += `<option value="">No dentists available</option></select>`;
            $w.html(selectHtml);
            $('#dentist_id').prop('disabled', true);
        }
        console.log('dentist select after replace:', $('#dentist_id').length, $('#dentist_id option').length);
});
});

flatpickr("#appointment_date", {
    disable: [
        function(date) {
            return !openDays.includes(date.getDay()); 
        }
    ]
});

$(document).on('change', '#dentist_id', function () {
    const dentistId =  $(this).val();
    $('#selected_dentist').val(dentistId); 
    console.log(dentistId + "asd")
    document.getElementById('appointment_date').value = "";
});

$(document).on('change', '#appointment_date', function () {
    const selectedDate = $(this).val();
    const storeId = $('#store_id').val();
    const dentistId = $('#selected_dentist').val();

    if (!storeId || !dentistId) {
        $('#appointment_time').html('<option>Please select a branch and dentist</option>');
        return;
    }

    $('#appointment_time').html('<option>Loading...</option>').prop('disabled', false);

    // Updated endpoint to include dentist
    $.get(`/branch/${storeId}/dentist/${dentistId}/slots`, { date: selectedDate }, function (response) {
        if (response.slots && response.slots.length > 0) {
            let options = `<option value="">-- Select Time --</option>`;
            response.slots.forEach(time => {
                options += `<option value="${time}">${time}</option>`;
            });
            $('#appointment_time').html(options);
        } else {
            $('#appointment_time').html('<option value="">No slots available</option>');
        }
    });
});

let clickedButton = null;

$('button[type="submit"]').on('click', function () {
    clickedButton = $(this).val(); // "normal" or "walkin"

    if (clickedButton === 'walkin') {
        $('#datetimeWrapper').hide();  // hide date/time for walk-in
        $('#appointment_date, #appointment_time').prop('required', false);
    } else if (clickedButton === 'normal') {
        $('#datetimeWrapper').show();  // show date/time for normal booking
        $('#appointment_date, #appointment_time').prop('required', true);

        // Do NOT pre-fill date or time — leave empty
        $('#appointment_date').val('');
        $('#appointment_time').val('');
    }
});

$('#bookingForm').on('submit', function(e) {
    // For normal booking, prevent submit if date/time are empty
    if (clickedButton === 'normal') {
        const date = $('#appointment_date').val();
        const time = $('#appointment_time').val();
        if (!date || !time) {
            Swal.fire('Error!', 'Please select date and time for the appointment.', 'error');
            return false; // stop submission
        }
    }

    e.preventDefault();

    const formData = {
        _token: '{{ csrf_token() }}',
        user_id: $('#user_id').val(),
        store_id: $('#store_id').val(),
        service_id: $('#service_id').val(),
        dentist_id: $('#selected_dentist').val(),
        appointment_date: $('#appointment_date').val(),
        appointment_time: $('#appointment_time').val(),
        desc: $('#desc').val(),
        appt_type: clickedButton
    };

    $.ajax({
        url: '{{ route('appointments.storeadmin') }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status === 'redirect') {
                window.location.href = response.url;
                return;
            }
            if (response.status === 'success') {
                Swal.fire('Success!', response.message, 'success');
                $('#bookingForm')[0].reset();
                $('#appointment_date').prop('disabled', true); 
                $('#appointment_time').html('<option value="">-- Select Date First --</option>').prop('disabled', true);
                $('#storedetail').html('');
                $('#appointment_date').prop('disabled', false);
            } else if (response.status === 'error') {
                Swal.fire('Error!', response.message, 'error');
            }
        },
        error: function(xhr) {
            const errors = xhr.responseJSON.errors;
            let message = 'Error booking appointment.';
            if (errors) {
                message = Object.values(errors).map(e => e.join(', ')).join(' ');
            }
            alert(message);
        }
    });
});

</script>
