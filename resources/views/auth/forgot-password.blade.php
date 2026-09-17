@extends('layout.auth')

@section('title', 'Forgot Password')

@section('auth-content')
<div class="p-[50px] bg-sky-100">

    <div class="text-center mb-5">
        <h2 class="text-2xl font-bold text-sky-600">Forgot Password</h2>
    </div>

    <!-- STEP 1: Email -->
    <form id="emailForm" class="flex flex-col gap-5">
        @csrf
        <div>
            <label class="text-gray-700 text-sm font-medium">Email</label>
            <input type="email" name="email" id="emailInput" required
                class="mt-1 w-full border border-sky-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-sky-400 bg-white">
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-md px-4 py-2 transition duration-150">
                Send OTP
            </button>
        </div>
    </form>

    <!-- STEP 2: OTP -->
    <form id="otpForm" class="flex-col gap-5 hidden" style="display:none;">
        <div>
            <label class="text-gray-700 text-sm font-medium">Enter the 6-digit code sent to your email</label>
            <input type="text" name="otp" id="otpInput" maxlength="6" minlength="6" inputmode="numeric"
                required pattern="[0-9]{6}" placeholder="######"
                title="Enter all 6 digits of the code."
                class="js-digits-only mt-1 w-full border border-sky-300 rounded-md p-2 tracking-widest text-center focus:outline-none focus:ring-2 focus:ring-sky-400 bg-white">
            <p id="otpError" class="hidden text-red-600 text-sm mt-1"></p>
        </div>
        <div class="flex justify-between items-center mt-4">
            <button type="button" id="resendOtp" class="text-sm text-blue-500 hover:text-blue-700 underline">Resend OTP</button>
            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-md px-4 py-2 transition duration-150">
                Verify OTP
            </button>
        </div>
    </form>

    <!-- STEP 3: New Password -->
    <form id="resetForm" class="flex-col gap-5 hidden" style="display:none;">
        <div>
            <label class="text-gray-700 text-sm font-medium">New Password</label>
            <div class="relative">
                <input type="password" name="password" id="newPasswordInput"
                    class="mt-1 w-full border border-sky-300 rounded-md p-2 pr-10 focus:outline-none focus:ring-2 focus:ring-sky-400 bg-white">
                @include('partials.password-toggle', ['for' => 'newPasswordInput'])
            </div>
        </div>
        <div class="mt-3">
            <label class="text-gray-700 text-sm font-medium">Retype Password</label>
            <div class="relative">
                <input type="password" name="confirm_password" id="confirmPasswordInput"
                    class="mt-1 w-full border border-sky-300 rounded-md p-2 pr-10 focus:outline-none focus:ring-2 focus:ring-sky-400 bg-white">
                @include('partials.password-toggle', ['for' => 'confirmPasswordInput'])
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-md px-4 py-2 transition duration-150">
                Reset Password
            </button>
        </div>
    </form>

    <div class="text-center mt-6 text-sm text-gray-700">
        <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 underline transition">Back to Login</a>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
{{-- Nasa partials/password-toggle ang togglePasswordField() --}}
$(document).ready(function () {
    const token = '{{ csrf_token() }}';

    function loader(title) {
        Swal.fire({
            title: title,
            text: 'Please wait',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => Swal.showLoading()
        });
    }

    function sendOtp(isResend) {
        loader('Sending OTP...');
        $.post('{{ route('password.sendOtp') }}', { email: $('#emailInput').val(), _token: token })
            .done(function (res) {
                Swal.close();
                Swal.fire('Success', res.message, 'success');
                $('#emailForm').hide();
                $('#otpForm').css('display', 'flex');
            })
            .fail(function (xhr) {
                Swal.close();
                const msg = (xhr.responseJSON && (xhr.responseJSON.message || Object.values(xhr.responseJSON.errors || {})[0])) || 'Something went wrong.';
                Swal.fire('Error', Array.isArray(msg) ? msg[0] : msg, 'error');
            });
    }

    $('#emailForm').submit(function (e) {
        e.preventDefault();
        sendOtp(false);
    });

    $('#resendOtp').click(function () {
        sendOtp(true);
    });

    $('#otpForm').submit(function (e) {
        e.preventDefault();

        // Walang laktawan: kailangang kumpleto ang anim na digit bago pa man
        // umabot sa server.
        const otp = $('#otpInput').val().trim();
        const otpError = $('#otpError');
        if (!/^\d{6}$/.test(otp)) {
            otpError
                .text(otp.length ? `Please enter all 6 digits — ${6 - otp.length} missing.` : 'Please enter the 6-digit code sent to you.')
                .removeClass('hidden');
            $('#otpInput').addClass('border-red-500').focus();
            return;
        }
        otpError.addClass('hidden');
        $('#otpInput').removeClass('border-red-500');

        loader('Verifying...');
        $.post('{{ route('password.verifyOtp') }}', { otp: otp, _token: token })
            .done(function (res) {
                Swal.close();
                $('#otpForm').hide();
                $('#resetForm').css('display', 'flex');
            })
            .fail(function (xhr) {
                Swal.close();
                const msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Invalid OTP.';
                Swal.fire('Error', msg, 'error');
            });
    });

    $('#resetForm').submit(function (e) {
        e.preventDefault();
        loader('Resetting password...');
        $.post('{{ route('password.reset') }}', {
            password: $('#newPasswordInput').val(),
            confirm_password: $('#confirmPasswordInput').val(),
            _token: token
        })
            .done(function (res) {
                Swal.close();
                Swal.fire({
                    title: 'Success!',
                    text: res.message,
                    icon: 'success',
                    confirmButtonText: 'Go to Login'
                }).then(() => window.location.href = '{{ route('login') }}');
            })
            .fail(function (xhr) {
                Swal.close();
                const msg = (xhr.responseJSON && (xhr.responseJSON.message || Object.values(xhr.responseJSON.errors || {})[0])) || 'Something went wrong.';
                Swal.fire('Error', Array.isArray(msg) ? msg[0] : msg, 'error');
            });
    });
});
</script>
@endsection
