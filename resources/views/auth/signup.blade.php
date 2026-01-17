@extends('layout.auth')

@section('title', 'Signup')

@section('auth-content')
<div class="p-[50px] bg-sky-100">
<form id="signupForm" method="POST" enctype="multipart/form-data" class="space-y-8">
@csrf

<h2 class="text-2xl font-bold text-sky-600 text-center">Patient Registration</h2>

<!-- STEP LABELS -->
<div class="flex justify-between items-center text-sm font-semibold text-gray-600 mb-2">
    <div class="text-center flex-1"><span id="label-step-1">1. Personal Info</span></div>
    <div class="text-center flex-1"><span id="label-step-2">2. Account Setup</span></div>
    <div class="text-center flex-1"><span id="label-step-3">3. Face Registration</span></div>
    <div class="text-center flex-1"><span id="label-step-4">4. OTP Verification</span></div>
</div>

<!-- PROGRESS BAR -->
<div class="w-full h-2 bg-gray-200 rounded">
    <div id="progressBar" class="h-full bg-blue-600 rounded transition-all duration-300" style="width:25%"></div>
</div>

<!-- ================= STEP 1 ================= -->
<div class="step" id="step-1">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <input type="hidden" name="account_type" value="patient">

        <div>
            <label>First Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Middle Name</label>
            <input type="text" name="middlename" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Last Name</label>
            <input type="text" name="lastname" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Suffix</label>
            <select name="suffix" class="w-full border p-2 rounded">
                <option value="">-- Select --</option>
                <option>Jr.</option><option>Sr.</option><option>II</option>
            </select>
        </div>

        <div>
            <label>Birthdate</label>
            <input type="date" name="birth_date" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Birthplace</label>
            <input type="text" name="birthplace" class="w-full border p-2 rounded" required>
        </div>
    </div>

    <div class="mt-4">
        <label>Current Address</label>
        <input type="text" name="current_address" class="w-full border p-2 rounded" required>
    </div>
</div>

<!-- ================= STEP 2 ================= -->
<div class="step hidden" id="step-2">
    <div class="space-y-4">
        <div>
            <label>Valid ID</label>
            <input type="file" name="verification_id" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Contact Number</label>
            <input type="number" name="contact_number" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Username</label>
            <input type="text" name="user" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Password</label>
            <input type="password" id="password" name="password" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="w-full border p-2 rounded" required>
        </div>
    </div>
</div>

<!-- ================= STEP 3 ================= -->
<div class="step hidden text-center" id="step-3">
    <p class="mb-4 font-semibold text-gray-700">
        Please register your face to continue
    </p>

    <button type="button"
        id="capturemodal"
        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Capture & Register Face
    </button>
</div>

<!-- ================= STEP 4 ================= -->
<div class="step hidden" id="step-4">
    <label>Enter OTP</label>
    <input type="text" id="otp" name="otp"
        class="w-full border p-2 rounded"
        placeholder="6-digit OTP" required>
</div>

<!-- NAV BUTTONS -->
<div class="flex justify-between pt-4 border-t">
    <button type="button" class="prev hidden bg-gray-500 text-white px-6 py-2 rounded">Back</button>
    <button type="button" class="next bg-blue-600 text-white px-6 py-2 rounded">Next</button>
    <button type="submit" class="submit hidden bg-green-600 text-white px-6 py-2 rounded">Submit</button>
</div>

</form>
</div>

<!-- ================= FACE MODAL ================= -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
<div class="bg-white p-6 rounded shadow-lg w-96 text-center">
    <h2 class="font-bold mb-4">Face Registration</h2>
    <canvas id="canvas" width="320" height="240" class="hidden"></canvas>
    <video id="video" width="320" height="240" autoplay></video>

    <div class="mt-4 space-x-2">
        <button id="capture" class="px-4 py-2 bg-green-600 text-white rounded">Capture</button>
        <button id="closemodal" class="px-4 py-2 bg-red-600 text-white rounded">Close</button>
    </div>
</div>
</div>






<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let currentStep = 1;
const totalSteps = 4;

function showStep(step) {
    $('.step').addClass('hidden');
    $('#step-' + step).removeClass('hidden');

    $('.prev').toggleClass('hidden', step === 1);
    $('.next').toggleClass('hidden', step >= totalSteps);
    $('.submit').toggleClass('hidden', step !== totalSteps);

    $('#progressBar').css('width', `${(step / totalSteps) * 100}%`);
}

$(document).ready(function () {
    showStep(currentStep);

    /* NEXT BUTTON */
    $('.next').click(function () {

        /* STEP 2 → SEND OTP */
        if (currentStep === 2) {
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();

            if (password !== confirmPassword) {
                Swal.fire('Password Mismatch', 'Passwords do not match.', 'error');
                return;
            }

            const formData = new FormData($('#signupForm')[0]);
            formData.append('_token', '{{ csrf_token() }}');

            Swal.fire({
                title: 'Sending OTP...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: '{{ route("send.otp") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    Swal.close();
                    currentStep++;
                    showStep(currentStep);
                },
                error: function (xhr) {
                    Swal.close();
                    Swal.fire('Error', xhr.responseJSON.message, 'error');
                }
            });
            return;
        }

        /* STEP 3 → REQUIRE FACE REGISTRATION */
        if (currentStep === 3 && !faceRegistered) {
            Swal.fire('Face Required', 'Please register your face first.', 'warning');
            return;
        }

        currentStep++;
        showStep(currentStep);
    });

    /* PREV BUTTON */
    $('.prev').click(function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    /* PASSWORD TOGGLE */
    $('#showPassword').on('change', function () {
        $('#password').attr('type', this.checked ? 'text' : 'password');
    });

    $('#showConfirmPassword').on('change', function () {
        $('#confirm_password').attr('type', this.checked ? 'text' : 'password');
    });

    /* SUBMIT → OTP VERIFY */
    $('#signupForm').on('submit', function (e) {
        e.preventDefault();
        const otp = $('#otp').val();

        if (otp.length !== 6) {
            Swal.fire('Invalid OTP', 'Enter 6-digit OTP', 'warning');
            return;
        }

        Swal.fire({
            title: 'Verifying OTP...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '{{ route("verify.otp") }}',
            method: 'GET',
            data: { otp, _token: '{{ csrf_token() }}' },
            success: function (res) {
                Swal.fire('Success', res.message, 'success').then(() => {
                    localStorage.clear();
                    window.location.href = "{{ route('login') }}";
                });
            },
            error: function (xhr) {
                Swal.fire('Error', xhr.responseJSON.message, 'error');
            }
        });
    });
});
</script>
<!-- ================= FACE CAPTURE ================= -->
<script>
const openBtn = document.getElementById('capturemodal');
const modal = document.getElementById('modal');
const closeBtn = document.getElementById('closemodal');
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const captureButton = document.getElementById('capture');
const context = canvas.getContext('2d');

let faceRegistered = false;
let stream = null; // store camera stream

// --- Open modal & start camera ---
openBtn.addEventListener('click', async () => {
    modal.classList.remove('hidden');
    try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
    } catch (err) {
        console.error('Camera error:', err);
        Swal.fire('Error', 'Cannot access camera.', 'error');
    }
});

// --- Close modal & stop camera ---
closeBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
    stopCamera();
});

// --- Capture & register face ---
captureButton.addEventListener('click', async () => {
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    canvas.toBlob(async (blob) => {
        if (!blob) {
            return Swal.fire('Error', 'Failed to capture image.', 'error');
        }

        // Collect all required signup fields
        const formData = new FormData();
        formData.append('face_image', blob, 'face.jpg');
        formData.append('name', $('input[name="name"]').val());
        formData.append('middlename', $('input[name="middlename"]').val() || '');
        formData.append('lastname', $('input[name="lastname"]').val());
        formData.append('suffix', $('select[name="suffix"]').val() || '');
        formData.append('birth_date', $('input[name="birth_date"]').val());
        formData.append('birthplace', $('input[name="birthplace"]').val());
        formData.append('current_address', $('input[name="current_address"]').val());
        formData.append('email', $('input[name="email"]').val());
        formData.append('contact_number', $('input[name="contact_number"]').val() || '');
        formData.append('user', $('input[name="user"]').val());
        formData.append('password', $('#password').val());
        formData.append('account_type', 'patient');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        Swal.fire({
            title: 'Registering face...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const res = await fetch('/cregister-face-registration', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const text = await res.text();
            let data;

            // Parse JSON safely
            try {
                data = JSON.parse(text);
            } catch {
                console.error('Server returned non-JSON:', text);
                throw new Error('Invalid response from server. Check console.');
            }

            if (!res.ok) {
                throw new Error(data.message || 'Face registration failed.');
            }

            // Success → mark face as registered
            faceRegistered = true;
            Swal.fire('Success', data.message, 'success');
            modal.classList.add('hidden');
            stopCamera();

            // Move to next step in the signup wizard
            if (typeof currentStep !== 'undefined' && typeof showStep === 'function') {
                currentStep++;
                showStep(currentStep);
            }

        } catch (err) {
            console.error(err);
            Swal.fire('Error', err.message || 'Face registration failed.', 'error');
        }

    }, 'image/jpeg');
});

// --- Stop camera helper ---
function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}
</script>



@endsection
