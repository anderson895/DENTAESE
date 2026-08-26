<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Navigation')</title>

    <!-- Speed up CDN connections -->
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- Anti-flicker: critical styles applied before Tailwind CDN generates CSS -->
    <style>
        .hidden { display: none; }
        body { visibility: hidden; }
        body.tw-ready { visibility: visible; }

        /* Nananatili ang top bar kapag nag-scroll. */
        #topbar { position: sticky; top: 0; z-index: 50; }

        /* Sa desktop, dumidikit ang sidebar sa ILALIM ng top bar, hindi sa
           itaas ng viewport — kung hindi, magkakapatong sila. Sinusukat ng JS
           ang totoong taas ng header papuntang --header-h; ang 4.5rem ay
           panakip lang bago pa tumakbo ang JS at kung sakaling mabigo ito. */
        @media (min-width: 640px) {
            #sidebar {
                top: var(--header-h, 4.5rem);
                height: calc(100vh - var(--header-h, 4.5rem));
            }
        }
    </style>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Isinusukat ang totoong taas ng top bar para eksaktong sa ilalim nito
         dumikit ang sidebar. Sinusundan ang resize dahil nagbabago ang taas
         kapag pumipilipit ang header sa makikitid na screen. -->
    <script>
        (function () {
            function syncHeaderHeight() {
                var bar = document.getElementById('topbar');
                if (!bar) return;
                document.documentElement.style.setProperty('--header-h', bar.offsetHeight + 'px');
            }
            document.addEventListener('DOMContentLoaded', syncHeaderHeight);
            window.addEventListener('resize', syncHeaderHeight);
            window.addEventListener('load', syncHeaderHeight);
        })();
    </script>

    <!-- Reveal the page once Tailwind has generated its styles (prevents FOUC flicker) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    document.body.classList.add('tw-ready');
                });
            });
        });
        // Fallback: never leave the page hidden kahit ma-delay ang CDN
        setTimeout(function () {
            if (document.body) document.body.classList.add('tw-ready');
        }, 1500);
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0284c7',
                        secondary: '#e0f2fe',
                        accent: '#0f172a',
                        navItem: '#38bdf8',
                        background: '#f8fafc',
                    },
                    fontFamily: {
                        sans: ['"Segoe UI"', 'Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background font-sans">
    <div class="flex flex-col min-h-screen">

        <!-- Header -->
        <header id="topbar" class="bg-primary px-6 py-4 shadow-lg flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <button id="toggleSidebar" class="text-white text-2xl sm:hidden">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <img class="h-10" src="{{ asset('images/logo.png') }}" alt="Logo">
                <h1 class="text-white font-bold text-xl">Santiago-Amancio Dental Clinic</h1>

                @php
                    $branch = \App\Models\Store::find(session('active_branch_id'));
                @endphp

                <div class="ml-6 text-white hidden sm:block">
                    @if ($branch)
                        <div class="font-medium text-base">{{ $branch->name }}</div>
                        <div class="text-sm">{{ $branch->address }}</div>
                    @else
                        <div class="text-red-100">Admin View</div>
                    @endif
                </div>
            </div>

            <div class="flex items-center space-x-5">
                <!-- Notifications -->
                <div class="relative">
                    <button id="notificationToggle" class="relative focus:outline-none">
                        <i class="fa-solid fa-bell text-xl text-white"></i>
                        @if(Auth::user()->unreadNotifications->count())
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        @endif
                    </button>

                    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white border rounded-lg shadow-lg z-50">
                        <div class="p-4 border-b">
                            <h3 class="text-sm font-bold text-gray-700">Notifications</h3>
                        </div>
                        <ul class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                            @forelse(Auth::user()->notifications->take(10) as $notification)
                                <li class="px-4 py-3 hover:bg-gray-100 transition">
                                    <p class="text-sm text-gray-800 font-medium">
                                        {{ $notification->data['message'] ?? 'You have a new notification.' }}
                                    </p>
                                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </li>
                            @empty
                                <li class="px-4 py-3 text-center text-sm text-gray-500">No notifications</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            <!-- User Dropdown -->
            <div class="relative">
                <div id="dropdownToggle" class="cursor-pointer flex items-center space-x-2 text-white rounded-lg px-2 py-1 hover:bg-sky-600 transition duration-150">
                    <div class="w-10 h-10 rounded-full bg-white overflow-hidden border">
                        @if(Auth::user()->profile_image)
                            <img src="{{ asset('storage/profile_pictures/' . Auth::user()->profile_image) }}" class="object-cover w-full h-full">
                        @else
                            <i class="fa-solid fa-user text-gray-600 text-xl flex justify-center items-center h-full"></i>
                        @endif
                    </div>
                    <div class="text-sm">
                        <div class="font-bold">{{ Auth::user()->name }}</div>
                        <div class="text-xs">{{ Auth::user()->position }}</div>
                    </div>
                    <i class="fa-solid fa-caret-down text-sm ml-1"></i>
                </div>

                <!-- Dropdown Menu -->
                <ul id="dropdownMenu" class="absolute right-0 mt-2 w-44 bg-white border rounded-md shadow-md hidden z-50 transition-all duration-200">
                    <li><a href="/profile" class="block px-4 py-2 hover:bg-gray-100 text-sm"><i class="fa-regular fa-user mr-2"></i>Profile</a></li>
                    <li><a href="/logouts" class="block px-4 py-2 text-red-500 hover:bg-red-100 text-sm"><i class="fa-solid fa-right-from-bracket mr-2"></i>Logout</a></li>
                </ul>
            </div>
            </div>
        </header>

        <div class="flex flex-1">
            <!-- Sidebar -->
            {{-- sm:sticky + sm:self-start = hindi sumasama sa scroll ang sidebar.
                 Kailangan ang self-start: sa flex row, ini-unat ng default na
                 align-items:stretch ang aside sa buong taas ng row, kaya walang
                 puwang na madudulasan ng sticky at hindi ito gumagana.
                 Ang `top` at `height` ay nasa <style> sa head — nakadepende
                 sila sa --header-h. Sa mobile ay `fixed` pa rin ito: drawer na
                 binubuksan ng #toggleSidebar, kaya sm: lang ang bagong klase. --}}
            <aside id="sidebar" class="bg-secondary sm:w-64 w-56 fixed sm:sticky sm:self-start sm:overflow-y-auto z-40 min-h-full px-4 py-6 shadow-md transform transition-transform duration-300 -translate-x-full sm:translate-x-0">
                <nav class="flex flex-col space-y-1 text-sm text-accent font-medium">
                    @if (auth()->user()->position == 'admin')
                        <select id="branchSelector" class="mb-4 border border-gray-300 rounded px-2 py-1 w-full text-sm">
                            <option value="">-- Select Branch --</option>
                        </select>
                    @else
                        <select id="assignedBranchSelector" class="mb-4 border border-gray-300 rounded px-2 py-1 w-full text-sm">
                            <option value="">-- Select Branch --</option>
                        </select>
                    @endif

                    <!-- Nav links -->
                    <x-nav-link href="/dashboard" icon="fa-solid fa-gauge" label="Dashboard" />

                    @if (session('active_branch_id') == "admin")
                        <x-nav-link href="/useraccount" icon="fa-solid fa-user-gear" label="Staff Accounts" />
                        <x-nav-link href="/sms-logs" icon="fa-solid fa-comment-sms" label="SMS Notifications" />
                    @endif

                    <x-nav-link href="/patientaccount" icon="fa-solid fa-hospital-user" label="Patient Accounts" />
                   

                    @if (auth()->user()->position != 'Receptionist')
                        <x-nav-link href="/services" icon="fa-solid fa-tooth" label="Services" />
                        <x-nav-link href="/branch" icon="fa-solid fa-code-branch" label="Branch" />
                        <x-nav-link href="/schedule/calendar" icon="fa-solid fa-calendar-days" label="Schedule Calendar" />
                    @endif

                    @if (session('active_branch_id') != "admin")
                     <x-nav-link href="/inventory" icon="fa-solid fa-boxes-stacked" label="Inventory Management" />
                        <x-nav-link href="/appointments" icon="fa-solid fa-calendar-check" label="Appointments" />
                        <x-nav-link href="/logs" icon="fa-solid fa-list-check" label="Logs" />
                        <x-nav-link href="/pos/{{ session('active_branch_id') }}" icon="fa-solid fa-cash-register" label="POS" />
                        <x-nav-link href="/reports/sales" icon="fa-solid fa-chart-line" label="POS Reports" />
                        <x-nav-link href="/reports/appointments" icon="fa-solid fa-chart-line" label="Appointment Reports" />
                        @php
                            // Mensahe ng pasyente sa branch na ito...
                            $unreadStaffMessages = \App\Models\Message::patientThread()
                                ->where('store_id', session('active_branch_id'))
                                ->where('is_read', false)
                                ->whereHas('sender', fn ($q) => $q->where('account_type', 'patient'))
                                ->count();

                            // ...kasama ang mensahe mula sa ibang branch.
                            $unreadStaffMessages += \App\Models\Message::where('to_store_id', session('active_branch_id'))
                                ->where('is_read', false)
                                ->count();
                        @endphp
                        <x-nav-link href="/chat" icon="fa-solid fa-comments" label="Message" :badge="$unreadStaffMessages" />
                    @endif
                </nav>
            </aside>

            <!-- Overlay (for mobile) -->
            <div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 hidden sm:hidden"></div>

            <!-- Main Content -->
            <main class="flex-1 p-6 bg-background overflow-y-auto sm:ml-0">
                @yield('main-content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Shared na print helper (window.printSection) para sa lahat ng printout --}}
    @include('partials.print-scripts')

    <script>
    $(function() {
        const sidebar = $('#sidebar');
        const overlay = $('#overlay');

        // Sidebar toggle for mobile
        $('#toggleSidebar').on('click', function() {
            sidebar.toggleClass('-translate-x-full');
            overlay.toggleClass('hidden');
        });

        overlay.on('click', function() {
            sidebar.addClass('-translate-x-full');
            overlay.addClass('hidden');
        });

        // ✅ User dropdown fixed
        const toggleBtn = $('#dropdownToggle');
        const dropdown = $('#dropdownMenu');

        toggleBtn.on('click', (e) => {
            e.stopPropagation();
            dropdown.toggleClass('hidden');
        });

        $(window).on('click', function (e) {
            if (!toggleBtn[0].contains(e.target) && !dropdown[0].contains(e.target)) {
                dropdown.addClass('hidden');
            }
        });

        // Notification bell
        const notifToggle = $('#notificationToggle');
        const notifDropdown = $('#notificationDropdown');
        let notifMarked = false;

        notifToggle.on('click', (e) => {
            e.stopPropagation();
            notifDropdown.toggleClass('hidden');
            if (!notifMarked && !notifDropdown.hasClass('hidden')) {
                fetch("{{ route('notifications.markAsRead') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": '{{ csrf_token() }}',
                        "Content-Type": "application/json"
                    }
                }).then(() => {
                    notifMarked = true;
                    notifToggle.find('span').remove();
                });
            }
        });

        $(window).on('click', function (e) {
            if (notifToggle.length && !notifToggle[0].contains(e.target) && !notifDropdown[0].contains(e.target)) {
                notifDropdown.addClass('hidden');
            }
        });

        // For Admin
        $.get('/get-branches', function (data) {
            let selector = $('#branchSelector');
            if (selector.length) {
                selector.empty().append('<option value="">-- Select Branch --</option>');

                data.forEach(branch => {
                    let selected = branch.id == '{{ session('active_branch_id') }}' ? 'selected' : '';
                    selector.append(`<option value="${branch.id}" ${selected}>${branch.name}</option>`);
                });

                selector.on('change', function () {
                    const branchId = $(this).val();
                    if (branchId) {
                        $.post('/set-active-branch', {
                            id: branchId,
                            _token: '{{ csrf_token() }}'
                        }, function (response) {
                            if (response.status === 'success') {
                                window.location.href = '/dashboard';
                            }
                        });
                    }
                });
            }
        });

        // For Dentist / Receptionist
        $.get('/get-assigned-branches', function (data) {
            let selector = $('#assignedBranchSelector');
            if (selector.length) {
                selector.empty().append('<option value="">-- Select Branch --</option>');

                data.forEach(branch => {
                    let selected = branch.id == '{{ session('active_branch_id') }}' ? 'selected' : '';
                    selector.append(`<option value="${branch.id}" ${selected}>${branch.name}</option>`);
                });

                selector.on('change', function () {
                    const branchId = $(this).val();
                    if (branchId) {
                        $.post('/set-active-branch', {
                            id: branchId,
                            _token: '{{ csrf_token() }}'
                        }, function (response) {
                            if (response.status === 'success') {
                                window.location.href = '/dashboard';
                            }
                        });
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
