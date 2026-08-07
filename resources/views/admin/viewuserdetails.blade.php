@extends('layout.navigation')

@section('title', 'Profile')
@section('main-content')
<button onclick="history.back()"
    class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition">
    ⬅ Back
</button>

    <h1 class="text-2xl font-semibold mb-4">View User Details</h1>

    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-300">
        <ul class="flex space-x-6 text-sm font-medium text-center text-gray-600" id="tabs">
            <li>
                <button
                    class="tab-button border-b-2 py-2 px-4 hover:text-primary hover:border-primary active border-primary text-primary"
                    data-tab="profile-tab">Profile</button>
            </li>

            @if ($user->account_type == 'patient')
                <li>

                    <button
                        class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-primary hover:border-primary"
                        data-tab="printable-patient">Patient Information</button>
                </li>
                <li>
                    <button
                        class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-primary hover:border-primary"
                        data-tab="printable-info">Dental Chart</button>
                </li>
                <li>
                    <button
                        class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-primary hover:border-primary"
                        data-tab="record-tab">Treatment Record</button>
                </li>
            @endif

        </ul>
    </div>

    <div id="profile-tab" class="tab-content">
        <div class="flex flex-col h-full">
            <div class="flex flex-col lg:flex-row gap-5 items-start">

                <!-- Profile Card -->
                <div class="w-full lg:w-1/3 bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="h-36 bg-gradient-to-r from-sky-400 to-primary"></div>
                    <div class="px-6 pb-6 -mt-10 flex flex-col items-center">
                        <img src="{{ $user->profile_image ? asset('storage/profile_pictures/' . $user->profile_image) : asset('images/defaultp.jpg') }}"
                            alt="Profile picture"
                            class="w-24 h-24 rounded-full object-cover border-4 border-white shadow bg-white">
                        <h2 class="mt-3 text-lg font-bold text-gray-800 text-center">{{ $user->name }} {{ $user->lastname }}</h2>
                        <span class="text-xs px-2 py-0.5 mt-1 rounded-full bg-sky-50 text-primary font-medium capitalize">{{ $user->position ?: $user->account_type }}</span>
                        @if (!is_null($user->deleted_at))
                            <span class="text-xs px-2 py-0.5 mt-1 rounded-full bg-red-50 text-red-600 font-medium">Archived</span>
                        @endif

                        <form class="w-full mt-5 space-y-4">
                            <div>
                                <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="lastname" id="lastname" value="{{ $user->lastname }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label for="middlename" class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
                                <input type="text" name="middlename" id="middlename" value="{{ $user->middlename }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Suffix</label>
                                <select name="suffix"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                                    <option value="">-- Select Suffix --</option>
                                    <option value="Jr." {{ old('suffix', $user->suffix ?? '') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                    <option value="Sr." {{ old('suffix', $user->suffix ?? '') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                    <option value="II" {{ old('suffix', $user->suffix ?? '') == 'II' ? 'selected' : '' }}>II</option>
                                    <option value="III" {{ old('suffix', $user->suffix ?? '') == 'III' ? 'selected' : '' }}>III</option>
                                    <option value="IV" {{ old('suffix', $user->suffix ?? '') == 'IV' ? 'selected' : '' }}>IV</option>
                                    <option value="V" {{ old('suffix', $user->suffix ?? '') == 'V' ? 'selected' : '' }}>V</option>
                                </select>
                            </div>
                            <div>
                                <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-1">Birth Day</label>
                                <input type="date" name="birthdate" id="birthdate" value="{{ $user->birth_date }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>
                        </form>

                        <div class="w-full mt-4">
                            @if (is_null($user->deleted_at))
                                <!-- Archive Button -->
                                <button id="archiveBtn" data-id="{{ $user->id }}"
                                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                    <i class="fa-solid fa-box-archive mr-1"></i> Archive
                                </button>
                            @else
                                <div class="flex gap-2">
                                    <!-- Restore Button -->
                                    <button id="restoreBtn" data-id="{{ $user->id }}"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                        <i class="fa-solid fa-rotate-left mr-1"></i> Restore
                                    </button>

                                    <!-- Permanent Delete Button -->
                                    <button id="permanentDeleteBtn" data-id="{{ $user->id }}"
                                        class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Delete
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="w-full lg:w-2/3 flex flex-col gap-5">

                    <!-- QR Code Card -->
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">
                            <i class="fa-solid fa-qrcode text-primary"></i> QR Code
                        </h3>
                        <div class="flex flex-col items-center gap-3">
                            @php
                                $qrPath = $user->qr_code ? 'qr_codes/' . $user->qr_code : null;
                                $qrExists = $qrPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($qrPath);
                            @endphp
                            @if($qrExists)
                                <img id="userQrImage" src="{{ asset('storage/qr_codes/' . $user->qr_code) }}" alt="User QR Code"
                                    class="w-40 h-40 object-contain border border-gray-200 p-2 rounded-lg">
                            @else
                                <img id="userQrImage" src="" alt="QR not available" class="w-40 h-40 object-contain border border-gray-200 p-2 rounded-lg hidden">
                                <div id="qrMissingMsg" class="w-40 h-40 flex items-center justify-center border border-dashed border-red-400 text-red-600 text-xs text-center px-2 rounded-lg">
                                    QR file is missing.<br>Click "Regenerate QR" to create a new one.
                                </div>
                            @endif
                            <button type="button" id="regenerateQrBtn" data-id="{{ $user->id }}"
                                class="inline-flex items-center justify-center border border-orange-300 text-orange-600 hover:bg-orange-50 px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fa-solid fa-arrows-rotate mr-1"></i> Regenerate QR
                            </button>
                        </div>
                    </div>

                    <!-- Account Settings Card -->
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">
                            <i class="fa-solid fa-user-gear text-primary"></i> Account Settings
                        </h3>
                        <form id="updateProfile" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="hidden" name="id" id="id" value="{{ $user->id }}">

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="text" name="email" id="email" value="{{ $user->email }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                <input type="number" name="contact" id="contact" value="{{ $user->contact_number }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label for="user" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <input type="text" name="user" id="user" value="{{ $user->user }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password" name="password" id="password" placeholder="Leave blank to keep current password"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>

                            <div class="md:col-span-2 flex justify-end">
                                <button class="bg-primary hover:bg-sky-700 text-white text-sm font-medium px-6 py-2 rounded-lg transition"
                                    type="submit"><i class="fa-solid fa-floppy-disk mr-1"></i> Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- @if ($user->account_type == 'patient')
                <div class="mt-10 bg-white p-6 rounded shadow w-full">
                    <h2 class="text-xl font-bold mb-4">Completed Appointments</h2>
                    @if ($completedAppointments->isEmpty())
                        <p class="text-gray-500">You have no completed appointments.</p>
                    @else
                        <table class="table-auto w-full border-collapse border">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="px-3 py-2">Date</th>
                                    <th class="px-3 py-2">Time</th>
                                    <th class="px-3 py-2">End Time</th>
                                    <th class="px-3 py-2">Dentist</th>
                                    <th class="px-3 py-2">Description</th>
                                    <th class="px-3 py-2">Work Done</th>
                                    <th class="px-3 py-2">Total Price</th>
                                    <th class="px-3 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($completedAppointments as $appointment)
                                    <tr class="border-t">
                                        <td class="px-3 py-2">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ \Carbon\Carbon::parse($appointment->booking_end_time)->format('h:i A') }}
                                        </td>
                                        <td class="px-3 py-2">{{ $appointment->dentist->name ?? 'N/A' }}</td>
                                        <td class="px-3 py-2">{{ $appointment->desc }}</td>
                                        <td class="px-3 py-2">{{ $appointment->work_done }}</td>
                                        <td class="px-3 py-2">₱{{ number_format($appointment->total_price, 2) }}</td>
                                        <td class="px-3 py-2">{{ $appointment->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endif --}}
        </div>
    </div>
  @if ($user->account_type == 'patient')
    <div  id="printable-patient" class="tab-content hidden">
      
       @include('client.patient_record', ['patient'=> $patient])
        
    </div>

    <div id="record-tab" class="tab-content hidden">
        @include('admin.dental-chart.treatment-record', ['record' => $record])
    </div>

    <div id="printable-info" class="tab-content hidden">
        @include('admin.dental-chart.index', ['patient'=> $patient])
    </div>
    
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.querySelectorAll(".tab-button").forEach(button => {
            button.addEventListener("click", () => {
                const tab = button.dataset.tab;

                // Remove active class from all buttons
                document.querySelectorAll(".tab-button").forEach(btn =>
                    btn.classList.remove("active", "border-blue-600", "text-blue-600")
                );
                button.classList.add("active", "border-blue-600", "text-blue-600");

                // Hide all tab content
                document.querySelectorAll(".tab-content").forEach(tc =>
                    tc.classList.add("hidden")
                );

                // Show clicked tab
                document.getElementById(tab).classList.remove("hidden");
            });
        });
    </script>
    <script>
        const openBtn = document.getElementById('capturemodal');
        const modal = document.getElementById('modal');
        const closeBtn = document.getElementById('closemodal');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            if (window.isSecureContext) {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(stream => {
                        video.srcObject = stream;
                    })
                    .catch(error => {
                        console.error("Error accessing media devices.", error);
                    });
            } else {
                console.error("getUserMedia requires a secure context (HTTPS).");
            }
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    </script>

    <script>
        $('#deletebtn').click(function(e) {
            e.preventDefault(); // prevent default if inside a form or link

            const userId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this user!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('deleteuser') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: userId
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    window.location.href = '/useraccount';
                                }
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error', xhr.responseJSON.message ||
                                'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureButton = document.getElementById('capture');
        const context = canvas.getContext('2d');


        captureButton.addEventListener('click', () => {
            // Draw video frame onto canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert canvas to Blob
            canvas.toBlob(function(blob) {
                let formData = new FormData();
                formData.append('face_image', blob, 'face_capture.jpg');

                // Show loading spinner
                document.getElementById('loadingSpinner').classList.remove('hidden');

                fetch('/register-face', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // for Laravel Blade
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Hide loading spinner
                        document.getElementById('loadingSpinner').classList.add('hidden');

                        // Show SweetAlert success
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'Face registered!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Close modal (optional)

                            document.getElementById('modal').classList.add('hidden');
                            location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('loadingSpinner').classList.add('hidden');

                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to register face.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            }, 'image/jpeg');
        });
    </script>
<script>
    // Regenerate QR
    $('#regenerateQrBtn').click(function (e) {
        e.preventDefault();
        const userId = $(this).data('id');
        const btn = $(this);

        Swal.fire({
            title: 'Regenerate QR Code?',
            text: 'A new QR code will be generated. The old QR (if any) will no longer work.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, regenerate',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (!result.isConfirmed) return;

            btn.prop('disabled', true).text('Generating...');

            $.ajax({
                type: 'POST',
                url: '{{ url("/qr/regenerate") }}/' + userId,
                data: { _token: '{{ csrf_token() }}' },
                success: function (response) {
                    if (response.status === 'success') {
                        $('#userQrImage').attr('src', response.qr_path).removeClass('hidden');
                        $('#qrMissingMsg').remove();
                        Swal.fire('Done!', response.message, 'success');
                    } else {
                        Swal.fire('Error', response.message || 'Failed to regenerate QR.', 'error');
                    }
                },
                error: function (xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message || 'Failed to regenerate QR.', 'error');
                },
                complete: function () {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-arrows-rotate mr-1"></i> Regenerate QR');
                }
            });
        });
    });

    // Archive (Soft Delete)
    $('#archiveBtn').click(function(e) {
        e.preventDefault();
        const userId = $(this).data('id');

        Swal.fire({
            title: 'Archive this user?',
            text: 'This will temporarily deactivate the account.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, archive it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.archive') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: userId
                    },
                    success: function(response) {
                        Swal.fire('Archived!', response.message, 'success')
                            .then(() => location.reload());
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Unable to archive user.', 'error');
                    }
                });
            }
        });
    });

    // Restore
    $('#restoreBtn').click(function(e) {
        e.preventDefault();
        const userId = $(this).data('id');

        Swal.fire({
            title: 'Restore this user?',
            text: 'This will reactivate the account.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.restore') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: userId
                    },
                    success: function(response) {
                        Swal.fire('Restored!', response.message, 'success')
                            .then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error', 'Unable to restore user.', 'error');
                    }
                });
            }
        });
    });

    // Permanent Delete
    $('#permanentDeleteBtn').click(function(e) {
        e.preventDefault();
        const userId = $(this).data('id');

        Swal.fire({
            title: 'Permanently delete this user?',
            text: 'This action cannot be undone!',
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete permanently!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('user.forceDelete') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: userId
                    },
                    success: function(response) {
                        Swal.fire('Deleted!', response.message, 'success')
                            .then(() => window.location.href = '/useraccount');
                    },
                    error: function() {
                        Swal.fire('Error', 'Unable to permanently delete user.', 'error');
                    }
                });
            }
        });
    });
</script>

    <script>
        ///update profile
        $('#updateProfile').submit(function(event) {
            event.preventDefault();
            var formData = {
                id: $('input[name="id"]').val(),
                email: $('input[name="email"]').val(),
                name: $('input[name="name"]').val(),
                lastname: $('input[name="lastname"]').val(),
                middlename: $('input[name="middlename"]').val(),
                suffix: $('select[name="suffix"]').val(),
                birthdate: $('input[name="birthdate"]').val(),
                contact: $('input[name="contact"]').val(),
                user: $('input[name="user"]').val(),
                password: $('input[name="password"]').val(),


            }
            $.ajax({
                type: "patch",
                url: "{{ route('updateUser') }}",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',

                        })
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',

                        })
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorList = '';

                        for (let field in errors) {
                            errorList += `${errors[field].join(', ')}\n`;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: errorList.trim(),
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                }
            });
        })


        ///remove face token
        document.getElementById('removeFaceToken').addEventListener('click', () => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will remove your registered face.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/remove-face-token', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire('Removed!', data.message, 'success').then(() => {
                                location.reload(); // Optional: refresh to reflect change
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Failed to remove face token.', 'error');
                        });
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('.medical-form-slide');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const indicator = document.getElementById('slideIndicator');
            let currentSlide = 0;

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('hidden', i !== index);
                });
                indicator.textContent = `${index + 1} of ${slides.length}`;
            }

            nextBtn.addEventListener('click', () => {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            });

            prevBtn.addEventListener('click', () => {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            });

            showSlide(currentSlide);
        });
    </script>
    <script>
    // Back-compat: nasa partials/print-scripts.blade.php na ang totoong printer.
    // Wala nang location.reload() — hindi na sinisira ang pahina kapag nagprint.
    function printDiv(divId) {
        window.printSection(divId, { paper: 'Letter', scale: 80 });
    }
    </script>
@endsection
