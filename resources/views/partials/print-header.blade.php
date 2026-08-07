@php
    $clinicName     = config('clinic.name', 'SANTIAGO – AMANCIO DENTAL CLINIC');
    $clinicTagline  = config('clinic.tagline', '');
    $clinicAddress  = $address ?? config('clinic.address', '');
    $clinicPhone    = config('clinic.phone', '');
    $clinicEmail    = config('clinic.email', '');
    $clinicDentists = config('clinic.dentists', '');
    $reportTitle    = $title ?? '';
    $reportMeta     = $meta ?? null;

    $logoCandidates = ['images/clinic-logo.png', 'images/logo.png'];
    $logoSrc = null;
    foreach ($logoCandidates as $rel) {
        if (file_exists(public_path($rel))) {
            $logoSrc = asset($rel);
            break;
        }
    }
@endphp

<div class="clinic-print-header"
     style="border-bottom:2px solid #0b3b8c; padding:6px 0 10px; margin-bottom:14px; display:flex; align-items:center; gap:14px; font-family: 'Times New Roman', Georgia, serif;">
    @if($logoSrc)
        <img src="{{ $logoSrc }}" alt="Clinic Logo"
             style="width:72px; height:72px; object-fit:contain; flex:0 0 auto;">
    @endif

    <div style="flex:1; text-align:center;">
        <div style="font-size:18pt; font-weight:bold; letter-spacing:1px; color:#0b3b8c; line-height:1.1;">
            {{ $clinicName }}
        </div>
        @if($clinicTagline)
            <div style="font-size:9pt; color:#555; font-style:italic;">{{ $clinicTagline }}</div>
        @endif
        @if($clinicAddress)
            <div style="font-size:10pt; color:#222; margin-top:2px;">{{ $clinicAddress }}</div>
        @endif
        @if($clinicPhone || $clinicEmail)
            <div style="font-size:10pt; color:#222;">
                @if($clinicPhone){{ $clinicPhone }}@endif
                @if($clinicPhone && $clinicEmail) &middot; @endif
                @if($clinicEmail){{ $clinicEmail }}@endif
            </div>
        @endif
        @if($clinicDentists)
            <div style="font-size:10pt; font-weight:bold; color:#0b3b8c; margin-top:2px;">
                {{ $clinicDentists }}
            </div>
        @endif
    </div>
</div>

@if($reportTitle)
    <h2 style="text-align:center; font-size:13pt; font-weight:bold; margin:4px 0 10px; text-transform:uppercase; letter-spacing:1.5px;">
        {{ $reportTitle }}
    </h2>
    @if($reportMeta)
        <div style="text-align:center; font-size:9pt; color:#444; margin-bottom:10px;">{{ $reportMeta }}</div>
    @endif
@endif

{{-- Naka-fixed ang footer kaya inuulit ito ng browser sa bawat pahina kapag nagprint.
     Dito lang nakalagay ang petsa/oras at kung sino ang nagprint — wala na sa header. --}}
<div class="clinic-print-footer"
     style="position:fixed; left:10mm; right:10mm; bottom:6mm; padding:4px 0 0; border-top:1px solid #999;
            display:flex; justify-content:space-between; align-items:center;
            font-family: 'Times New Roman', Georgia, serif; font-size:8pt; color:#444;">
    <div>Printed: {{ now()->format('M d, Y h:i A') }}</div>
    @auth
        <div>By: {{ trim((auth()->user()->name ?? '').' '.(auth()->user()->lastname ?? '')) }}</div>
    @endauth
</div>
