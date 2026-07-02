@extends('layout.cnav')

@section('title', 'Dashboard')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('main-content')

@if(session('success'))
    <div class="m-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="m-4 p-4 rounded bg-red-100 text-red-800 border border-red-300">
        <ul class="list-disc pl-5 text-sm">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div id="response"></div>
<script>
    document.getElementById('faceLoginForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        const responseBox = document.getElementById('response');
        responseBox.textContent = 'Processing...';

        try {
            const response = await fetch('/get-face-landmarks', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                responseBox.textContent = data.message;
            } else {
                responseBox.textContent = data.message || 'Login failed.';
            }
        } catch (error) {
            responseBox.textContent = 'An error occurred. Check console.';
            console.error(error);
        }
    });
</script>
@endsection