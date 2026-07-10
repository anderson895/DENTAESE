
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
                        data-tab="medical-tab">Patient Information</button>
                </li>
                {{-- <li>
                    <button
                        class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-primary hover:border-primary"
                        data-tab="chart-tab">Dental Chart</button>
                </li> --}}
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
            <div class="flex flex-col lg:flex-row gap-5 items-stretch">

                {{-- LEFT: Profile Card --}}
                <div class="w-full lg:w-1/3 bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
                    <div class="h-36 bg-gradient-to-r from-sky-400 to-primary"></div>
                    <div class="px-6 pb-6 -mt-10 flex flex-col items-center flex-1">
                        <img src="{{ $user->profile_image ? asset('storage/profile_pictures/' . $user->profile_image) : asset('images/defaultp.jpg') }}"
                            alt="Profile picture"
                            class="w-24 h-24 rounded-full object-cover border-4 border-white shadow bg-white">
                        <h2 class="mt-3 text-lg font-bold text-gray-800 text-center">{{ $user->name }} {{ $user->lastname }}</h2>
                        <span class="text-xs text-gray-500 capitalize">{{ $user->account_type }}</span>

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
                                <label for="suffix" class="block text-sm font-medium text-gray-700 mb-1">Suffix</label>
                                <select name="suffix" id="suffix"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 bg-white">
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
                        <button id="deletebtn" data-id="{{ $user->id }}"
                            class="w-full mt-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                            <i class="fa-solid fa-trash-can mr-1"></i> Delete
                        </button>
                    </div>
                </div>

                {{-- RIGHT: QR + Account Settings --}}
                <div class="w-full lg:w-2/3 flex flex-col gap-5">

                    {{-- QR Code --}}
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">
                            <i class="fa-solid fa-qrcode text-primary"></i> QR Code
                        </h3>
                        <div class="flex flex-col items-center">
                            @php
                                $userQrPath = $user->qr_code ? 'qr_codes/' . $user->qr_code : null;
                                $userQrExists = $userQrPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($userQrPath);
                            @endphp
                            @if($userQrExists)
                                <img src="{{ asset('storage/qr_codes/' . $user->qr_code) }}" alt="User QR Code"
                                    class="w-40 h-40 object-contain border border-gray-200 p-2 rounded-lg" />
                            @else
                                <div class="w-40 h-40 flex items-center justify-center border border-dashed border-gray-300 text-gray-400 text-xs text-center px-2 rounded-lg">
                                    No QR code available.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Account Settings --}}
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
                                <button class="bg-primary hover:bg-sky-700 text-white text-sm font-medium px-6 py-2 rounded-lg transition" type="submit">
                                    <i class="fa-solid fa-floppy-disk mr-1"></i> Update
                                </button>
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

    <div id="medical-tab" class="tab-content hidden">
      
       @include('client.patient_record', ['patient'=> $patient])
        
    </div>

    <div id="record-tab" class="tab-content hidden">
        @include('admin.dental-chart.treatment-record', ['record' => $record])
    </div>

    <div id="chart-tab" class="tab-content hidden">
        @include('admin.dental-chart.index', ['patient'=> $patient])
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.querySelectorAll(".tab-button").forEach(button => {
            button.addEventListener("click", () => {
                const tab = button.dataset.tab;

                // Remove active class from all buttons
                document.querySelectorAll(".tab-button").forEach(btn => {
                    btn.classList.remove("active", "border-primary", "text-primary");
                    btn.classList.add("border-transparent");
                });
                button.classList.remove("border-transparent");
                button.classList.add("active", "border-primary", "text-primary");

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

