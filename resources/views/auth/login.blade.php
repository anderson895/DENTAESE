@extends('layout.auth-split')

@section('title', 'Login')

@section('auth-content')

    {{-- ===== Pamagat ng klinika ===== --}}
    {{-- Logo lockup ng klinika: malaking wordmark na nakasiksik sa tooth mark,
         tapos ang linya ng mga dentista na may guhit sa magkabilang gilid. --}}
    <div>
        <div class="flex items-center justify-center gap-1">
            <img src="{{ asset('images/logo.png') }}" alt="" class="h-20 w-20 shrink-0 logo-blue sm:h-24 sm:w-24">
            <div class="leading-[0.95]">
                <p class="text-xl font-bold tracking-tight text-[#1e4fa8] sm:text-2xl">SANTIAGO - AMANCIO</p>
                <h1 class="text-3xl font-extrabold tracking-tight text-[#1e4fa8] sm:text-4xl">DENTAL CLINIC</h1>
            </div>
        </div>

        <p class="text-center text-[10px] font-bold tracking-tight text-[#1e4fa8] sm:text-[11px]">
            DR. MARIETA SANTIAGO AMANCIO &middot; DR. ABELARDO SANTIAGO
        </p>

        <div class="mt-1.5 flex items-center justify-center gap-2">
            <span class="h-px w-12 bg-[#9dc0e8]"></span>
            <span class="text-[9px] font-bold tracking-[0.2em] text-[#1e4fa8] sm:text-[10px]">DENTISTS</span>
            <span class="h-px w-12 bg-[#9dc0e8]"></span>
        </div>
    </div>

    {{-- ===== Pagbati ===== --}}
    <div class="mt-8 text-center">
        <h2 class="text-2xl font-bold text-blue-900">Welcome Back!</h2>
        <p class="mt-1 text-sm text-gray-500">Please sign in to your account.</p>
    </div>

    @if(session('info'))
        <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
            {{ session('info') }}
        </div>
    @endif

    <form id="loginForm" method="post" class="mt-6 space-y-4">
        @csrf

        <input type="hidden" name="next" value="{{ request('next') }}">

        <div>
            <label for="usernameInput" class="mb-1.5 block text-sm font-medium text-gray-700">Username</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <svg class="h-[18px] w-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"/>
                    </svg>
                </span>
                <input
                    type="text"
                    name="user"
                    id="usernameInput"
                    placeholder="Enter your username"
                    autocomplete="username"
                    required
                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-11 pr-3.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30">
            </div>
        </div>

        <div>
            <label for="passwordInput" class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <svg class="h-[18px] w-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 10.5h10.5a1.5 1.5 0 0 0 1.5-1.5v-7.5a1.5 1.5 0 0 0-1.5-1.5H6.75a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5Z"/>
                    </svg>
                </span>
                <input
                    type="password"
                    name="password"
                    id="passwordInput"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-11 pr-11 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/30">

                {{-- Toggle button (eye icon lang, wala nang "Show" na teksto) --}}
                <button
                    type="button"
                    onclick="togglePassword(this)"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 transition hover:text-[#3f68a8]"
                    aria-label="Show password"
                >
                    @include('partials.eye-icon')
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex cursor-pointer items-center gap-2 text-gray-600">
                <input type="checkbox" name="remember" id="rememberInput"
                       class="h-4 w-4 rounded border-gray-300 text-[#3f68a8] focus:ring-sky-500">
                Remember me
            </label>
            <a href="{{ route('password.forgot') }}" class="font-medium text-[#3f68a8] transition hover:text-[#2b4f85] hover:underline">
                Forgot Password?
            </a>
        </div>

        <button
            type="submit"
            id="loginSubmit"
            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-700/20 transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
            </svg>
            Sign In
        </button>
    </form>

    <div class="mt-6 space-y-2 text-center text-sm text-gray-600">
        <p>
            Login using
            <a href="{{ route('faceui') }}" class="font-medium text-[#3f68a8] underline transition hover:text-[#2b4f85]">Face Recognition</a>
            or
            <a href="{{ route('Qr') }}" class="font-medium text-[#3f68a8] underline transition hover:text-[#2b4f85]">QR</a>
        </p>
        <p>
            Don&rsquo;t have an account?
            <a href="{{ route('signupui') }}" class="font-medium text-[#3f68a8] underline transition hover:text-[#2b4f85]">Sign up</a>
        </p>
    </div>

    <p class="mt-6 border-t border-gray-200 pt-4 text-center text-xs leading-relaxed text-gray-500">
        By signing in, you acknowledge that you have read and agree to our
        <a href="{{ route('terms') }}" class="text-[#3f68a8] underline transition hover:text-[#2b4f85]">Terms and Conditions</a>.
    </p>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function togglePassword(btn) {
      const input = document.getElementById('passwordInput');
      const isHidden = input.type === 'password';

      input.type = isHidden ? 'text' : 'password';
      btn.querySelector('.eye-open')?.classList.toggle('hidden', isHidden);
      btn.querySelector('.eye-closed')?.classList.toggle('hidden', !isHidden);
      btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
    }
$(document).ready(function () {
    $('#loginForm').submit(function (event) {
        event.preventDefault();

        var formData = {
            user: $('input[name="user"]').val(),
            password: $('input[name="password"]').val(),
            remember: $('#rememberInput').is(':checked') ? 1 : 0,
            next: $('input[name="next"]').val(),
            _token: '{{ csrf_token() }}'
        };

        // 🔒 Iwas sa dobleng submit habang naghihintay ng sagot
        $('#loginSubmit').prop('disabled', true);

        // 🔄 Show loader habang nagpo-process
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
            type: 'POST',
            url: '{{ route('loginform') }}',
            data: formData,
            success: function (response) {
                Swal.close(); // ❌ close loader

                if (response.status === "success") {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                } else {
                    $('#loginSubmit').prop('disabled', false);
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function (xhr) {
                Swal.close(); // ❌ close loader
                $('#loginSubmit').prop('disabled', false);
                console.log(xhr.responseText);

                Swal.fire(
                    'Error',
                    'Something went wrong. Please try again.',
                    'error'
                );
            }
        });
    });
});
</script>

@endsection
