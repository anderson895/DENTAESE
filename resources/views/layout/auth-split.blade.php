<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Santiago-Amancio Dental Clinic')</title>

    <!-- Speed up CDN connections -->
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Anti-flicker: critical styles applied before Tailwind CDN generates CSS -->
    <style>
        .hidden { display: none; }
        [x-cloak] { display: none !important; }
        body { visibility: hidden; }
        body.tw-ready { visibility: visible; }
    </style>

    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Ginagawang asul ang itim na logo mark para tumugma sa brand */
        .logo-blue {
            filter: invert(43%) sepia(99%) saturate(5121%) hue-rotate(200deg) brightness(95%) contrast(90%);
        }
        /* Puting bersyon ng logo para sa ibabaw ng banner */
        .logo-white { filter: brightness(0) invert(1); }

        /* Itinatago ang sariling "reveal password" na mata ng Edge/IE — ito ang
           dahilan kung bakit dalawa ang mata sa mga password field. Sa amin
           lang na eye icon nakadepende ang show/hide. */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        @keyframes auth-rise {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .auth-rise { animation: auth-rise .5s ease-out both; }

        @media (prefers-reduced-motion: reduce) {
            .auth-rise { animation: none; }
        }

        /* Mas malapad ang panel ng banner (47vw) kaysa sa mismong litrato
           (~71vh dahil portrait ito) — kupas na puti ang sobra. Kung sa gitna
           lang ng natitirang hati isesentro ang form, mukha itong nakahilig sa
           kanan dahil kabilang na sa "puti" ang sobrang iyon. Ibinabawas natin
           ang sobra sa kanang padding para tumapat sa nakikitang gitna. */
        /* Tandaan: ang Tailwind CDN ay nag-iinject ng CSS na SUMUSUNOD sa style
           block na ito, kaya kailangang mas mataas ang specificity (main.… at
           div.…) para hindi matabunan ng lg:px-12 at ng width utilities. */
        @media (min-width: 1024px) {
            /* Nasa gitna ng kupas ang nakikitang hangganan ng dalawang panel,
               hindi sa mismong gilid — kalahati ng lapad ng kupas (1/3 ng 50vw,
               kaya ~8vw) ang idinaragdag sa kanang padding para tumapat ang
               login card sa nakikitang gitna. */
            main.auth-form-pane { padding-right: calc(3rem + 8vw); }
        }
    </style>
</head>
<body class="flex min-h-screen flex-col bg-white">

    <div class="flex flex-1 flex-col lg:flex-row">

        {{-- ================= Kaliwa: banner ng klinika ================= --}}
        {{-- Portrait (960x1280 = 0.75) ang banner.jpg. Kapag porsyento ng LAPAD ang
             basehan ng panel, nagiging halos parisukat ito sa 16:9 na monitor at
             pinuputol ng object-cover ang itaas/ibaba ng gusali. Kaya taas ng
             viewport ang sukatan: 72vh ang lapad ≈ 0.75 ang aspect ng panel, kaya
             halos buong gusali ang kita sa kahit anong laki ng window. --}}
        {{-- Hating-hati ang panel (50/50) para pantay ang banner at ang login card.
             Portrait ang litrato (0.75) samantalang halos parisukat ang panel, kaya
             may ~29% na putol pataas-pababa. Ang object-position na 45% ang nagtutulak
             ng tanaw paitaas: nananatili ang karatula at ang dalawang palapag,
             semento lang sa ibaba ang naaalis. --}}
        {{-- Ang bg ay #1e4fa8 (hindi blue-900): kapag may subpixel rounding sa
             pag-zoom, ang nakikitang manipis na guhit sa ilalim ay kapareho ng
             kulay ng alon at ng footer, kaya walang lumalabas na putol. --}}
        <aside class="relative isolate h-56 shrink-0 overflow-hidden bg-[#1e4fa8] sm:h-64 lg:h-auto lg:w-1/2">
            <img
                src="{{ asset('images/banner.jpg') }}"
                alt="Santiago-Amancio Dental Clinic building"
                class="absolute inset-y-0 left-0 h-full w-full object-cover object-[center_45%]">

            {{-- Walang lamlam sa larawan: likas na kulay ang gusali, asul lang
                 ang alon sa ibaba — dito nakapatong ang tagline. --}}
            <svg class="absolute inset-x-0 -bottom-px z-[6] h-1/4 w-full sm:h-1/3 lg:h-[58%]"
                 viewBox="0 0 600 320" preserveAspectRatio="none" aria-hidden="true">
                <defs>
                    {{-- Patayong gradient: pareho ang kulay ng buong ibabang gilid
                         (#1e4fa8) sa footer, kaya walang putol kahit saang bahagi. --}}
                    <linearGradient id="authSwoosh" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#8ab6ec"/>
                        <stop offset="100%" stop-color="#1e4fa8"/>
                    </linearGradient>

                </defs>
                {{-- Iisang alon lang — walang pangalawang patong na parang anino.
                     Nakapatong ito sa kupas (z-6) kaya hindi napuputla, at umaabot
                     sa kanang gilid kaya dikit sa footer ang asul sa buong lapad
                     ng banner — walang putol. Manipis na sliver na lang ito sa
                     dulo, kaya halos di halata ang dulo sa gilid ng panel. --}}
                {{-- Eksaktong sa kanto (600,320) nagtatapos ang kurba — kung saan
                     nagtatagpo ang gilid ng panel at ang footer. Kaya walang
                     manipis na buntot na maaaring magmukhang putol, at walang
                     patayong baitang laban sa puting panel. --}}
                <path d="M0,60 C130,196 330,266 600,320 L0,320 Z" fill="url(#authSwoosh)"/>
            </svg>

            {{-- Malambot na pagkupas papasok sa puting panel ng form: sa gilid kapag
                 magkatabi ang dalawang panel, sa ibaba kapag nakapatong-patong. --}}
            <div class="pointer-events-none absolute inset-y-0 right-0 z-[5] hidden w-1/3 bg-gradient-to-r from-transparent via-white/75 to-white lg:block"></div>
            <div class="pointer-events-none absolute inset-x-0 bottom-0 z-[5] h-10 bg-gradient-to-b from-transparent to-white lg:hidden"></div>


            {{-- Marka sa itaas + daan pabalik sa landing page --}}
            {{-- Marka ng klinika sa itaas — ito na rin ang daan pabalik sa
                 landing page kapalit ng dating "Back to Home" na buton. --}}
            <a href="{{ url('/') }}" aria-label="Back to home" title="Back to home"
               class="absolute left-5 top-5 z-10 block transition hover:opacity-100 sm:left-6 sm:top-6">
                <img src="{{ asset('images/logo.png') }}" alt="" class="h-9 w-9 opacity-90 drop-shadow logo-white sm:h-11 sm:w-11">
            </a>

            {{-- Tagline sa ibabaw ng alon. Nakatago sa maliliit na screen dahil
                 dumadaan ito sa karatula ng klinika sa larawan. --}}
            <div class="absolute inset-x-0 bottom-0 z-10 hidden p-5 sm:p-8 lg:block lg:p-10">
                <p class="text-base font-normal leading-snug text-white drop-shadow sm:text-xl lg:text-2xl">
                    Caring for your smile.<br>
                    Building your confidence.
                </p>
                <div class="mt-4 h-px w-56 bg-white/30"></div>

                <div class="mt-3 flex items-center gap-2.5">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="h-8 w-8 shrink-0 opacity-90 logo-white">
                    <p class="text-[10px] font-semibold uppercase leading-snug tracking-wide text-sky-50 sm:text-[11px]">
                        Expert care, healthy smiles,<br>better lives.
                    </p>
                </div>
            </div>
        </aside>

        {{-- ================= Kanan: nilalaman ng form ================= --}}
        <main class="auth-form-pane flex flex-1 items-center justify-center px-5 py-10 sm:px-8 lg:px-12">
            <div class="auth-rise w-full max-w-md lg:max-w-lg">
                @yield('auth-content')
            </div>
        </main>
    </div>

    {{-- ================= Footer bar ================= --}}
    {{-- Katulad na katulad ng dulong-ibabang kulay ng alon (#1e4fa8) para
         tuluy-tuloy ang asul mula banner papunta sa footer — walang putol. --}}
    <footer class="bg-[#1e4fa8] text-white">
        <div class="flex flex-col items-center justify-between gap-1 px-5 py-2.5 text-[11px] text-blue-50 sm:flex-row sm:px-8 sm:text-xs">
            <p class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4.5 6v5.25c0 4.28 3.2 8.28 7.5 9.25 4.3-.97 7.5-4.97 7.5-9.25V6L12 3Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.5 12 1.9 1.9 3.4-3.6"/>
                </svg>
                Your data is secure with us.
            </p>
            <p>&copy; {{ date('Y') }} Santiago-Amancio Dental Clinic. All rights reserved.</p>
        </div>
    </footer>

    {{-- Bantay sa mga numeric na input (.js-digits-only, .js-mobile-number) --}}
    <script src="{{ asset('js/input-guards.js') }}"></script>
</body>
</html>
