@extends('layout.navigation')

@section('title','Appointment Booking')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<div class="p-4">

@if(auth()->user()->position === 'Receptionist' || auth()->user()->position === 'admin')
<form method="GET" action="{{ route('admin.booking') }}" class="flex flex-wrap md:flex-row gap-4 mb-6 bg-white p-4 rounded shadow">
    <div class="flex flex-col w-full md:w-1/4">
        <label for="dentist_id" class="font-semibold mb-1">Filter by Dentist:</label>
        <select name="dentist_id" id="dentist_id" class="border border-gray-300 rounded p-2">
            <option value="">-- All Dentists --</option>
            @foreach ($dentists as $dentist)
                <option value="{{ $dentist->id }}" {{ request('dentist_id') == $dentist->id ? 'selected' : '' }}>
                    {{ $dentist->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex flex-col w-full md:w-1/4">
        <label for="date" class="font-semibold mb-1">Filter by Date:</label>
        <input type="date" name="date" id="date" value="{{ request('date') }}" class="border border-gray-300 rounded p-2">
    </div>

    <div class="flex flex-col w-full md:w-1/4">
        <label for="status" class="font-semibold mb-1">Filter by Status:</label>
        <select name="status" id="statusFilter" class="border border-gray-300 rounded p-2">
            <option value="">-- All Status --</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="arrived" {{ request('status') == 'arrived' ? 'selected' : '' }}>Arrived</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
        </select>
    </div>

    <div class="flex items-end w-full md:w-auto">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full md:w-auto">Filter</button>
    </div>
</form>
@endif

@if(auth()->user()->position == 'Dentist')
<form method="GET" action="{{ route('admin.booking') }}" class="flex flex-wrap gap-4 mb-6 bg-white p-4 rounded shadow">
    <div class="flex flex-col w-full md:w-1/4">
        <label for="date" class="font-semibold mb-1">Filter by Date:</label>
        <input type="date" id="date" name="date" value="{{ request('date') }}" class="border border-gray-300 rounded p-2">
    </div>
    <div class="flex flex-col w-full md:w-1/4">
        <label for="status" class="font-semibold mb-1">Filter by Status:</label>
        <select name="status" class="border border-gray-300 rounded p-2">
            <option value="">-- All Status --</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="arrived" {{ request('status') == 'arrived' ? 'selected' : '' }}>Arrived</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
        </select>
    </div>
    <div class="flex items-end">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Filter</button>
    </div>
</form>
@endif

<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">Appointment Booking</h2>
    <div class="flex flex-row gap-4">
    <a href="{{ route('admin.booking.history') }}" 
       class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">
        View History Logs
    </a>
    <button onclick="$('#bookingModal').removeClass('hidden')"
    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
    + Add Appointment
</button>
    </div>
   
</div>








<!-- Modal for Time & Date Editing -->
<div id="changeTimeModal"
     class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Change Appointment Date & Time</h2>

        <input type="hidden" id="changeAppointmentId">

        <!-- Change Date -->
        <div class="mb-3">
            <label class="block font-semibold mb-1">Appointment Date</label>
            <input type="date" id="newDate"
                   class="w-full border rounded p-2">
        </div>

        <!-- Start Time -->
        <div class="mb-3">
            <label class="block font-semibold mb-1">Start Time</label>
            <input type="time" id="newStartTime"
                   class="w-full border rounded p-2">
        </div>

        <!-- End Time -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">End Time</label>
            <input type="time" id="newEndTime"
                   class="w-full border rounded p-2">
        </div>

        <div class="flex justify-end gap-2">
            <button class="px-3 py-1 bg-gray-300 rounded"
                    onclick="$('#changeTimeModal').addClass('hidden')">
                Cancel
            </button>
            <button id="saveChangeTime"
                    class="px-3 py-1 bg-blue-600 text-white rounded">
                Save
            </button>
        </div>
    </div>
</div>







<!-- Booking Modal -->

<div class="overflow-x-auto bg-white p-4 rounded shadow">
    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2 border">User</th>
                <th class="px-4 py-2 border">Service</th>
                <th class="px-4 py-2 border">Modify Service</th>
                <th class="px-4 py-2 border">Date</th>
                <th class="px-4 py-2 border">Start</th>
                <th class="px-4 py-2 border">End</th>
                <th class="px-4 py-2 border">Type</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Arrived</th>
                <th class="px-4 py-2 border">Action</th>
            </tr>
        </thead>
        <tbody id="appointments-table-body">
            @include('admin.partials.appointments-table', ['appointments' => $appointments])
        </tbody>
    </table>
</div>
<div id="editServicesModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-lg w-96">

        <h2 class="text-xl font-bold mb-4">Edit Services</h2>

        <input type="hidden" id="editAppointmentId">

        <div id="servicesContainer" class="space-y-2">
            @foreach ($services as $service)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" 
                           id="serviceCheckbox{{ $service->id }}" 
                           value="{{ $service->id }}">
                    <span>{{ $service->name }}</span>
                </label>
            @endforeach
        </div>

        <div class="mt-4 flex justify-end space-x-2">
            <button onclick="closeServiceModal()" class="px-3 py-1 bg-gray-300 rounded">Cancel</button>
            <button id="saveServiceChangesBtn" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
        </div>

    </div>
</div>


@include('admin.partials.usermodal')


<div id="bookingModal" 
     class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6 relative mx-4 my-8">
        
        <!-- Close Button -->
        <button type="button" 
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800"
                onclick="$('#bookingModal').addClass('hidden')">
            ✕
        </button>

        <h2 class="text-2xl font-bold mb-4 text-center">Book an Appointment</h2>

        <div class="flex flex-col md:flex-row md:gap-10">
            <div class="w-full">
                @include('admin.partials.booking_modal')
            </div>
        </div>
    </div>
</div>


</div> <!-- End padding wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$(document).on('click', '.change-time-btn', function () {
    $('#changeAppointmentId').val($(this).data('id'));
    $('#newDate').val($(this).data('date'));
    $('#newStartTime').val($(this).data('start'));
    $('#newEndTime').val($(this).data('end')); 

    $('#changeTimeModal').removeClass('hidden');
});



$('#saveChangeTime').on('click', function () {
    const appointmentId = $('#changeAppointmentId').val();
    const newDate = $('#newDate').val();
    const startTime = $('#newStartTime').val();
    const endTime = $('#newEndTime').val();

    if (!newDate || !startTime || !endTime) {
        Swal.fire('Error', 'Please fill all fields', 'error');
        return;
    }

    Swal.fire({
        title: 'Confirm Change?',
        text: 'Update appointment date & time?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, update'
    }).then((result) => {
        if (!result.isConfirmed) return;

        // 🔄 Show loader
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: `/appointments/${appointmentId}/change-time`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                appointment_date: newDate,
                appointment_time: startTime,
                booking_end_time: endTime
            },
            success: function () {
                $('#changeTimeModal').addClass('hidden');
                location.reload();
            },
            error: function (xhr) {
                Swal.fire(
                    'Error',
                    xhr.responseJSON?.message || 'Something went wrong',
                    'error'
                );
            }
        });
    });
});





function showUserModal(userId) {
    $('#userModalContent').html('<p class="text-center text-gray-500">Loading...</p>');
    document.getElementById('userModal').classList.remove('hidden');

    $.get(`/user/details/${userId}`, function (html) {
        $('#userModalContent').html(html);
    }).fail(function () {
        $('#userModalContent').html('<p class="text-red-500">Failed to load user details.</p>');
    });
}

function closeUserModal() {
    document.getElementById('userModal').classList.add('hidden');
}
</script>

<script>
$(document).on('click', '.approve-btn', function () {
    const button = $(this);
    const row = button.closest('tr');
    const appointmentId = button.data('id');
    const time = row.find('.appointment-time').val();
    const endTime = row.find('.booking-end-time').val();

    // detect type
    const isChangeTime = button.text().trim().toLowerCase() === 'change time';

    // CONFIRMATION
    Swal.fire({
        title: 'Are you sure?',
        text: isChangeTime
            ? 'Do you want to change the appointment time?'
            : 'Do you want to approve this appointment?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, proceed',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (!result.isConfirmed) return;

        // LOADING
        Swal.fire({
            title: 'Processing...',
            text: 'Please wait',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: `/appointments/${appointmentId}/approve`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                appointment_time: time,
                booking_end_time: endTime,
                change_time: isChangeTime ? 1 : 0,
            },
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: isChangeTime ? 'Time Changed!' : 'Approved!',
                    text: isChangeTime
                        ? 'Appointment time has been successfully updated.'
                        : 'Appointment has been approved.'
                });

                $.get('{{ route('appointments.fetch') }}', function (html) {
                    $('#appointments-table-body').html(html);
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Something went wrong.'
                });
            }
        });
    });
});
    

$(document).on('click', '.cancel-btn', function () {
    const button = $(this);
    const appointmentId = button.data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This will cancel the appointment.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/appointments/${appointmentId}/cancel`,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cancelled!',
                        text: 'Appointment has been cancelled.'
                    });

                    $.get('{{ route('appointments.fetch') }}', function (html) {
                        $('#appointments-table-body').html(html);
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Something went wrong.'
                    });
                }
            });
        }
    });
});
</script>

<script>
$(document).on("click", ".edit-services-btn", function () {
    const appointmentId = $(this).data("id");
    let services = $(this).data("services");

    // 🔥 Always convert to array safely
    if (!services) {
        services = []; // null → empty array
    } 
    else if (typeof services === "string") {
        try {
            services = JSON.parse(services);
        } catch (e) {
            services = []; // invalid JSON → empty array
        }
    }

    console.log("Loaded services:", services);

    // Fill hidden input
    $("#editAppointmentId").val(appointmentId);

    // Reset checkboxes
    $("#servicesContainer input[type=checkbox]").prop("checked", false);

    // Check the services already selected
    services.forEach(id => {
        $(`#serviceCheckbox${id}`).prop("checked", true);
    });

    // Show modal
    $("#editServicesModal").removeClass("hidden");
});

function closeServiceModal() {
    $("#editServicesModal").addClass("hidden");
}


$("#saveServiceChangesBtn").on("click", function () {
    const appointmentId = $("#editAppointmentId").val();

    const selectedServices = $("#servicesContainer input[type=checkbox]:checked")
        .map(function () { return this.value; })
        .get();

    $.ajax({
        url: "/appointments/update-services",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: appointmentId,
            services: selectedServices
        },
        success: function (response) {
            // Update visible row without refresh
            // $(`tr[data-id="${appointmentId}"] .service-names`).text(
            //     selectedServices.join(", ")
            // );

            // closeServiceModal();
            // alert("Services updated!");
             Swal.fire({
        icon: 'success',
        title: 'Updated!',
        text: 'Services updated successfully.'
    }).then(() => {
        location.reload(); 
    });
        }
    });
});

</script>
@endsection
