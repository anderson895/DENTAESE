@extends('layout.navigation')

@section('title','Appointment Booking')

@section('main-content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="mb-4">
    <a href="{{ route('admin.booking') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Back to Bookings
    </a>
</div>

<form method="GET" action="{{ route('admin.booking.history') }}" class="mb-4 flex space-x-4">
    <input type="date" name="start_date" value="{{ request('start_date') }}" class="border p-2 rounded">
    <input type="date" name="end_date" value="{{ request('end_date') }}" class="border p-2 rounded">
    <button class="bg-gray-600 text-white px-4 py-2 rounded">Filter</button>
</form>

<table class="w-full border">
    <thead class="bg-gray-200">
        <tr>
            <th>User</th>
            <th>Dentist</th>
            <th>Time</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    @foreach ($appointments as $appointment)
        <tr class="border text-center">
            <td>{{ $appointment->user->name }}</td>
            <td>{{ $appointment->dentist->name ?? 'N/A' }}</td>
            <td>{{ $appointment->appointment_time }} - {{ $appointment->booking_end_time }}</td>
            
            <td>{{ $appointment->total_price }}</td>
            <td>{{ ucfirst($appointment->status) }}</td>
            <td>
                <button
                    class="editBtn bg-green-500 text-white px-3 py-1 rounded"
                    data-id="{{ $appointment->id }}"
                    data-desc="{{ $appointment->desc }}"
                    data-work="{{ $appointment->work_done }}"
                    data-price="{{ $appointment->total_price }}"
                    data-status="{{ $appointment->status }}"
                    data-services='@json($appointment->service_ids)'>
                    View
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- MODAL -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4">Update Appointment</h2>

        <input type="hidden" id="appointment_id">

        <input id="desc" class="w-full border p-2 mb-3 rounded" hidden>

        <textarea id="work_done" class="w-full border p-2 mb-3 rounded" hidden></textarea>

        <label class="block font-semibold">Status</label>
        <select id="status" class="w-full border p-2 mb-3 rounded">
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
            <option value="no_show">No Show</option>
        </select>

        <!-- SERVICES CHECKBOX -->
        <label class="block font-semibold mb-2">Services</label>
        <div class="border p-3 rounded mb-3 max-h-40 overflow-y-auto">
            @foreach ($services as $service)
                <label class="flex items-center space-x-2 mb-1">
                <input
                    type="checkbox"
                    class="service-checkbox"
                    value="{{ $service->id }}"
                >
                <span>{{ $service->name }}</span>
            </label>

            @endforeach
        </div>

        <label class="block font-semibold">Total Price</label>
        <input
            id="total_price"
            type="number"
            step="0.01"
            class="w-full border p-2 mb-4 rounded"
            placeholder="Enter total price"
        >


        <div class="flex justify-end gap-2">
            <button id="closeModal" class="px-4 py-2 bg-gray-400 rounded">Cancel</button>
            <button id="saveBtn" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$('.editBtn').click(function () {
    $('#editModal').removeClass('hidden').addClass('flex');

    $('#appointment_id').val($(this).data('id'));
    $('#desc').val($(this).data('desc'));
    $('#work_done').val($(this).data('work'));
    $('#status').val($(this).data('status'));
    $('#total_price').val($(this).data('price'));

    let services = $(this).data('services') || [];

    $('.service-checkbox').prop('checked', false);

    services.forEach(id => {
        $('.service-checkbox[value="' + id + '"]').prop('checked', true);
    });
});




$('#closeModal').click(function () {
    $('#editModal').addClass('hidden').removeClass('flex');
});

$('#saveBtn').click(function () {
    let id = $('#appointment_id').val();
    let serviceIds = [];

    $('.service-checkbox:checked').each(function () {
        serviceIds.push($(this).val());
    });

    Swal.fire({
        title: 'Saving...',
        text: 'Please wait while we update the appointment',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: `/admin/booking-history/${id}`,
        type: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            desc: $('#desc').val(),
            work_done: $('#work_done').val(),
            status: $('#status').val(),
            total_price: $('#total_price').val(),
            service_ids: serviceIds
        },
        success: function () {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Appointment record has been updated successfully.',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                location.reload();
            });
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: 'Something went wrong. Please try again.'
            });
        }
    });
});
</script>

@endsection
