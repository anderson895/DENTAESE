@extends('layout.navigation')

@section('title','SMS Notifications')
@section('main-content')

<div class="mb-4">
    <h2 class="font-bold text-xl">SMS Notifications</h2>
    <p class="text-sm text-gray-600">
        Bawat SMS na pinadala ng sistema — appointment updates at OTP.
    </p>
</div>

@unless ($enabled)
    <div class="mb-4 rounded border border-yellow-300 bg-yellow-50 px-4 py-3 text-sm text-yellow-900">
        <strong>SMS sending is turned off.</strong>
        Naitatala pa rin ang eksaktong mensahe sa ibaba, pero walang aktwal na
        ipinapadala. I-set ang <code>SMS_ENABLED=true</code> sa
        <code>.env</code> kapag aprubado na ang sender name
        <strong>{{ $senderName ?: '(wala)' }}</strong>.
    </div>
@endunless

<div class="mb-4 flex flex-wrap gap-3 text-sm">
    @foreach (['sent' => 'Sent', 'failed' => 'Failed', 'skipped' => 'Not sent'] as $key => $label)
        <div class="rounded border bg-white px-4 py-2">
            <div class="text-gray-500">{{ $label }}</div>
            <div class="text-lg font-bold">{{ $counts[$key] ?? 0 }}</div>
        </div>
    @endforeach
</div>

<form method="GET" class="mb-4 flex flex-wrap items-end gap-2 text-sm">
    <div>
        <label class="block text-gray-600">Status</label>
        <select name="status" class="rounded border px-2 py-1">
            <option value="">All</option>
            @foreach (['sent','failed','skipped'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-gray-600">Type</label>
        <select name="purpose" class="rounded border px-2 py-1">
            <option value="">All</option>
            @foreach ($purposes as $p)
                <option value="{{ $p }}" @selected(request('purpose') === $p)>{{ $p }}</option>
            @endforeach
        </select>
    </div>
    <button class="rounded bg-gray-800 px-4 py-1.5 text-white">Filter</button>
    <a href="{{ url('/sms-logs') }}" class="px-2 py-1.5 text-gray-600 underline">Reset</a>
</form>

<div class="overflow-x-auto rounded border bg-white">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-3 py-2">Date</th>
                <th class="px-3 py-2">Type</th>
                <th class="px-3 py-2">Number</th>
                <th class="px-3 py-2">Message</th>
                <th class="px-3 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr class="border-t align-top">
                    <td class="whitespace-nowrap px-3 py-2 text-gray-600">
                        {{ $log->created_at->format('M j, Y g:i A') }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-2">{{ $log->purposeLabel() }}</td>
                    <td class="whitespace-nowrap px-3 py-2">
                        {{ $log->recipient ?: $log->raw_number ?: '—' }}
                    </td>
                    <td class="px-3 py-2 text-gray-800">
                        {{ $log->message }}
                        @if ($log->error)
                            <div class="mt-1 text-xs text-red-600">{{ $log->error }}</div>
                        @endif
                    </td>
                    <td class="whitespace-nowrap px-3 py-2">
                        <span class="rounded px-2 py-0.5 text-xs font-semibold {{ $log->statusColor() }}">
                            {{ $log->status === 'skipped' ? 'not sent' : $log->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-3 py-6 text-center text-gray-500">
                        Wala pang SMS na naitatala.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $logs->links() }}
</div>

@endsection
