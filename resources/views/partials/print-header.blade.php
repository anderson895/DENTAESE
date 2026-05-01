@php
    $clinicName    = config('clinic.name', 'SANTIAGO–AMANCIO DENTAL CLINIC');
    $clinicTagline = config('clinic.tagline', 'Quality Dental Care You Can Trust');
    $clinicAddress = $address ?? config('clinic.address', '');
    $clinicPhone   = config('clinic.phone', '');
    $clinicEmail   = config('clinic.email', '');
    $reportTitle   = $title ?? '';
    $reportMeta    = $meta ?? null;
    $logoPath      = public_path('images/clinic-logo.png');
    $logoSrc       = file_exists($logoPath) ? asset('images/clinic-logo.png') : null;
@endphp

<div class="clinic-print-header" style="border-bottom:2px solid #000; padding:8px 0 10px; margin-bottom:14px; display:flex; align-items:center; gap:14px;">
    @if($logoSrc)
        <img src="{{ $logoSrc }}" alt="Clinic Logo" style="width:64px; height:64px; object-fit:contain;">
    @else
        <div style="width:64px; height:64px; border-radius:50%; background:#dbeafe; color:#1d4ed8; font-weight:700; display:flex; align-items:center; justify-content:center; font-size:11px; text-align:center; line-height:1.1;">
            DENTAEASE
        </div>
    @endif
    <div style="flex:1;">
        <div style="font-size:16pt; font-weight:bold; letter-spacing:0.5px;">{{ $clinicName }}</div>
        @if($clinicTagline)
            <div style="font-size:9pt; color:#555; font-style:italic;">{{ $clinicTagline }}</div>
        @endif
        @if($clinicAddress)
            <div style="font-size:9pt; color:#333;">{{ $clinicAddress }}</div>
        @endif
        @if($clinicPhone || $clinicEmail)
            <div style="font-size:9pt; color:#333;">
                @if($clinicPhone) Tel: {{ $clinicPhone }} @endif
                @if($clinicPhone && $clinicEmail) &middot; @endif
                @if($clinicEmail) {{ $clinicEmail }} @endif
            </div>
        @endif
    </div>
    <div style="text-align:right; font-size:9pt; color:#444;">
        <div>Printed: {{ now()->format('M d, Y h:i A') }}</div>
        <div>By: {{ auth()->user()->name ?? '' }} {{ auth()->user()->lastname ?? '' }}</div>
    </div>
</div>

@if($reportTitle)
    <h2 style="text-align:center; font-size:14pt; font-weight:bold; margin:6px 0 12px; text-transform:uppercase; letter-spacing:1px;">
        {{ $reportTitle }}
    </h2>
    @if($reportMeta)
        <div style="text-align:center; font-size:9pt; color:#444; margin-bottom:10px;">{{ $reportMeta }}</div>
    @endif
@endif
