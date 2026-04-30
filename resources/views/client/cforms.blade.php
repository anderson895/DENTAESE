@php
    $firstLogin = !($patientinfo->profile_completed ?? false);
    $layout = $firstLogin ? 'layout.auth' : 'layout.cnav';
    $section = $firstLogin ? 'auth-content' : 'main-content';
@endphp

@extends($layout)

@section('title', 'Patient Information Record')

@section($section)
    <div class="w-full max-w-6xl mx-auto py-6 px-2">
        @if($firstLogin)
            <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded text-sm text-yellow-800">
                <strong>Welcome!</strong> Please complete your Patient Information Record before booking your first appointment.
            </div>
        @endif

        @include('client.patient_record', ['patientinfo' => $patientinfo])
    </div>
@endsection
