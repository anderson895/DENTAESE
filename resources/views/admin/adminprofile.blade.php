@extends('layout.navigation')

@section('title','Profile')
@section('main-content')
<h1 class="text-2xl font-bold mb-4 text-accent">My Profile</h1>

<div class="flex flex-col lg:flex-row gap-5 items-stretch">

    <!-- LEFT: Profile Card -->
    <div class="w-full lg:w-1/3 bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
        <div class="h-36 bg-gradient-to-r from-sky-400 to-primary"></div>
        <div class="px-6 -mt-10 flex flex-col items-center">
            <img src="{{ Auth::user()->profile_image ? asset('storage/profile_pictures/' . Auth::user()->profile_image) : asset('images/defaultp.jpg') }}"
                alt="Profile picture"
                class="w-24 h-24 rounded-full object-cover border-4 border-white shadow bg-white">
            <h2 class="mt-3 text-lg font-bold text-gray-800 text-center">{{ Auth::user()->name }} {{ Auth::user()->lastname }}</h2>
            <span class="text-xs px-2 py-0.5 mt-1 rounded-full bg-sky-50 text-primary font-medium capitalize">{{ Auth::user()->position ?: Auth::user()->account_type }}</span>
        </div>

        <div class="flex flex-col gap-4 mt-4 px-6 pb-6">
            <form class="flex flex-col gap-4" method="POST" action="{{ route('profile.upload') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="fname" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="fname" id="fname"
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600"
                        value="{{ Auth::user()->lastname }}, {{ Auth::user()->name }} {{ Auth::user()->middlename }} {{ Auth::user()->suffix }}" readonly>
                </div>
                <div>
                    <label for="bday" class="block text-sm font-medium text-gray-700 mb-1">Birth Day</label>
                    <input type="date" name="bday" id="bday"
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600"
                        value="{{ Auth::user()->birth_date }}" readonly>
                </div>
                <div>
                    <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-1">Upload Profile Picture</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*"
                        class="w-full text-sm text-gray-600 border border-gray-200 rounded-lg cursor-pointer file:mr-3 file:py-2 file:px-3 file:border-0 file:bg-sky-50 file:text-sky-700 file:text-sm file:font-medium hover:file:bg-sky-100">
                </div>
                <button type="submit" class="bg-primary hover:bg-sky-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition self-start">
                    <i class="fa-solid fa-upload mr-1"></i> Upload
                </button>
            </form>
        </div>
    </div>

    <!-- RIGHT: QR + Face Recognition + Account Settings -->
    <div class="w-full lg:w-2/3 flex flex-col gap-5">
        <div class="flex flex-col md:flex-row gap-5">

            <!-- QR Code Card -->
            <div class="flex-1 bg-white rounded-xl shadow-sm p-5">
                <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">
                    <i class="fa-solid fa-qrcode text-primary"></i> My QR Code
                </h3>
                <div class="flex flex-col items-center justify-center gap-3">
                    @php
                        $myQrPath = Auth::user()->qr_code ? 'qr_codes/' . Auth::user()->qr_code : null;
                        $myQrExists = $myQrPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($myQrPath);
                    @endphp
                    @if($myQrExists)
                        <a id="myQrDownload" href="{{ asset('storage/qr_codes/' . Auth::user()->qr_code) }}" download="qr_code.png" class="flex flex-col items-center">
                            <img id="myQrImage" src="{{ asset('storage/qr_codes/' . Auth::user()->qr_code) }}" alt="QR Code"
                                class="w-32 h-32 object-contain border border-gray-200 p-2 rounded-lg hover:opacity-80" />
                            <p class="text-primary text-sm mt-2 text-center hover:underline">Download QR Code</p>
                        </a>
                    @else
                        <a id="myQrDownload" href="#" download="qr_code.png" class="flex-col items-center hidden">
                            <img id="myQrImage" src="" alt="QR Code" class="w-32 h-32 object-contain border border-gray-200 p-2 rounded-lg" />
                            <p class="text-primary text-sm mt-2 text-center hover:underline">Download QR Code</p>
                        </a>
                        <div id="myQrMissing" class="w-32 h-32 flex items-center justify-center border border-dashed border-red-400 text-red-600 text-xs text-center px-2 rounded-lg">
                            QR file is missing.<br>Click "Regenerate QR" below.
                        </div>
                    @endif
                    <button id="regenerateMyQrBtn" type="button"
                        class="inline-flex items-center justify-center border border-orange-300 text-orange-600 hover:bg-orange-50 px-4 py-2 rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-arrows-rotate mr-1"></i> Regenerate QR
                    </button>
                </div>
            </div>

            <!-- Face Recognition Card -->
            <div class="flex-1 bg-white rounded-xl shadow-sm p-5 flex flex-col">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800">
                        <i class="fa-solid fa-face-smile text-primary"></i> Face Recognition
                    </h3>
                    <button id="removeFaceToken" class="text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                        <i class="fa-solid fa-trash-can mr-1"></i>Remove
                    </button>
                </div>

                <div id="loadingSpinner" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999]">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-sky-500"></div>
                </div>

                <div class="flex flex-col items-center justify-center flex-1 text-center gap-3 py-4">
                    @if(Auth::user()->face_token !== null && Auth::user()->face_token !== "")
                        <span class="w-14 h-14 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                            <i class="fa-solid fa-check text-xl"></i>
                        </span>
                        <p class="text-sm text-gray-600">Your face is registered for login.</p>
                        <button id="capturemodal" class="px-4 py-2 bg-sky-200 text-white rounded-lg text-sm cursor-not-allowed" disabled>Capture & Register</button>
                    @else
                        <span class="w-14 h-14 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center">
                            <i class="fa-solid fa-camera text-xl"></i>
                        </span>
                        <p class="text-sm text-gray-600">Register your face to log in using face recognition.</p>
                        <button id="capturemodal" class="px-4 py-2 bg-primary hover:bg-sky-700 text-white rounded-lg text-sm font-medium transition">
                            <i class="fa-solid fa-camera mr-1"></i> Capture & Register
                        </button>
                    @endif
                </div>

                <!-- Modal -->
                <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
                        <h2 class="text-lg font-bold mb-4 text-gray-800">Capture & Register</h2>
                        <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                        <video id="video" width="320" height="240" autoplay class="rounded-lg"></video>
                        <div class="flex items-center justify-end gap-2 mt-4">
                            <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition" id="capture">Capture</button>
                            <button id="closemodal" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg text-sm font-medium transition">Close</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Account Settings Card -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">
                <i class="fa-solid fa-user-gear text-primary"></i> Account Settings
            </h3>
            <form id="updateProfile" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="text" name="email" id="email"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        value="{{ Auth::user()->email }}">
                </div>
                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                    <input type="number" name="contact" id="contact"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        value="{{ Auth::user()->contact_number }}">
                </div>
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="user" id="user"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        value="{{ Auth::user()->user }}">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        placeholder="Leave blank to keep current password">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const openBtn = document.getElementById('capturemodal');
    const modal = document.getElementById('modal');
    const closeBtn = document.getElementById('closemodal');
  
    openBtn.addEventListener('click', () => {
      modal.classList.remove('hidden');
      if (window.isSecureContext) {
    navigator.mediaDevices.getUserMedia({ video: true })
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
    ///update profile
    $('#updateProfile').submit(function (event) {
        event.preventDefault();
        var formData = {
                       
                        email : $('input[name="email"]').val(),
                       
                        contact : $('input[name="contact"]').val(),
                        user : $('input[name="user"]').val(),
                        password : $('input[name="password"]').val(),
                      

                    }
       $.ajax({
            type: "patch",
            url: "{{route('updateProfile')}}",
            data:formData,
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            success: function (response) {
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
            }, error: function (xhr) {
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


    ///regenerate QR
    document.getElementById('regenerateMyQrBtn').addEventListener('click', () => {
        Swal.fire({
            title: 'Regenerate your QR code?',
            text: 'A new QR will be generated. Your old QR code will no longer work.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, regenerate',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (!result.isConfirmed) return;

            const btn = document.getElementById('regenerateMyQrBtn');
            btn.disabled = true;
            btn.innerHTML = 'Generating...';

            fetch('{{ route("qr.regenerate.mine") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const img = document.getElementById('myQrImage');
                    const dl = document.getElementById('myQrDownload');
                    const missing = document.getElementById('myQrMissing');
                    if (img) img.src = data.qr_path;
                    if (dl) {
                        dl.href = data.qr_path;
                        dl.classList.remove('hidden');
                        dl.classList.add('flex');
                    }
                    if (missing) missing.remove();
                    Swal.fire('Done!', data.message, 'success');
                } else {
                    Swal.fire('Error', data.message || 'Failed to regenerate QR.', 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Failed to regenerate QR.', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-arrows-rotate mr-1"></i> Regenerate QR';
            });
        });
    });

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

@endsection