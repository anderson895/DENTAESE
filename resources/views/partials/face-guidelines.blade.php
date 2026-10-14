{{--
    Mga kondisyon bago mag-face capture (final defense revision 10/12/26),
    hango sa "Take Live Selfie" na screen ng mga KYC app. Unang step ito ng
    lahat ng face modal; ang [data-face-start] na button ang nagbubukas ng camera.

    Ang bilog, isang mukha lang, at ang liwanag ay sinusuri rin habang naka-camera
    (public/js/face-guard.js). Ang cap at filter ay paalala lang — hindi ito kayang
    tukuyin ng face-api.

    Optional na variable:
        $button — label ng button (default: "Open Camera").

    Emoji ang icon dahil walang FontAwesome sa auth layout (signup, face login).
--}}
@php
    $faceGuidelines = [
        ['icon' => '🧢', 'label' => 'Avoid wearing a cap',            'allowed' => false],
        ['icon' => '👥', 'label' => 'Avoid multiple faces',           'allowed' => false],
        ['icon' => '✨', 'label' => 'Avoid using filters',            'allowed' => false],
        ['icon' => '🙂', 'label' => 'Face must be within the circle', 'allowed' => true],
        ['icon' => '💡', 'label' => 'Use enough lighting',            'allowed' => true],
        ['icon' => '🧕', 'label' => 'Hijab-friendly verification',    'allowed' => true],
    ];
@endphp

<div data-face-step="guidelines" class="w-[320px] max-w-full mx-auto text-center">
    <h3 class="text-base font-bold text-gray-800">Before you start</h3>
    <p class="text-xs text-gray-500 mt-1">Make sure you are the person being verified.</p>

    <div class="grid grid-cols-3 gap-x-2 gap-y-5 mt-5">
        @foreach ($faceGuidelines as $item)
            <div class="flex flex-col items-center gap-1.5">
                <span class="relative w-12 h-12 rounded-full bg-sky-50 flex items-center justify-center text-2xl {{ $loop->index === 3 ? 'border-2 border-dashed border-sky-400' : '' }}">
                    <span aria-hidden="true">{{ $item['icon'] }}</span>
                    <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold text-white {{ $item['allowed'] ? 'bg-green-500' : 'bg-red-500' }}"
                          aria-hidden="true">{{ $item['allowed'] ? '✓' : '✕' }}</span>
                </span>
                <span class="text-[11px] leading-tight text-gray-700">{{ $item['label'] }}</span>
            </div>
        @endforeach
    </div>

    <p class="text-[11px] text-gray-500 mt-5">
        By proceeding, you allow the clinic to collect and use your face data for identity verification.
    </p>

    <button type="button" data-face-start
            class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg py-2.5 transition">
        {{ $button ?? 'Open Camera' }}
    </button>
</div>
