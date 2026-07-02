@extends('layout.cnav')

@section('title', 'Parental Control')
@section('main-content')

<div class="container mx-auto p-4 space-y-6">

    @php
        $activeCount = $links->where('status', 'active')->count();
        $atLimit = $activeCount >= $maxChildren;
    @endphp
    <div class="bg-white p-5 rounded shadow">
        <h1 class="text-2xl font-bold mb-1">Parental Control</h1>
        <p class="text-sm text-gray-600">
            Link existing patient accounts so you can manage their bookings, view their records,
            and switch between accounts safely.
        </p>
        <p class="text-xs text-gray-500 mt-2">
            Linked Linked Accounts: <strong>{{ $activeCount }} / {{ $maxChildren }}</strong>
            @if($atLimit) <span class="text-red-600">— limit reached</span> @endif
        </p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- LINKED CHILDREN --}}
    <div class="bg-white p-5 rounded shadow">
        <h2 class="text-lg font-semibold mb-3">Linked Accounts</h2>

        @if($links->isEmpty())
            <p class="text-sm text-gray-500">No Linked Accounts yet. Use the form below to send a link request.</p>
        @else
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-left">Name</th>
                        <th class="border p-2 text-left">Email</th>
                        <th class="border p-2 text-left">Relationship</th>
                        <th class="border p-2 text-left">Status</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($links as $link)
                        @php $child = $link->child; @endphp
                        <tr>
                            <td class="border p-2">{{ $child?->name }} {{ $child?->lastname }}</td>
                            <td class="border p-2">{{ $child?->email ?? '—' }}</td>
                            <td class="border p-2">{{ $link->relationship ?? '—' }}</td>
                            <td class="border p-2">
                                @if($link->status === 'active')
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">Pending verification</span>
                                    @if($link->token_expires_at)
                                        <div class="text-[10px] text-gray-500 mt-1">expires {{ $link->token_expires_at->format('M d, H:i') }}</div>
                                    @endif
                                @endif
                            </td>
                            <td class="border p-2 text-center whitespace-nowrap">
                                @if($link->status === 'active')
                                    <form method="POST" action="{{ route('parental.switchTo') }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="child_user_id" value="{{ $link->child_user_id }}">
                                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-xs">View as child</button>
                                    </form>
                                    <form method="POST" action="{{ route('parental.unlink', $link->id) }}" class="inline" onsubmit="return confirm('Unlink this child account?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs">Unlink</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('parental.unlink', $link->id) }}" class="inline" onsubmit="return confirm('Cancel this request?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs">Cancel request</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- LINK EXISTING --}}
    <div class="bg-white p-5 rounded shadow">
        <h2 class="text-lg font-semibold mb-3">Link an existing patient account</h2>
        <p class="text-xs text-gray-500 mb-3">We'll send a confirmation link to the child's email. The link will activate only after they approve it from their inbox.</p>
        <form method="POST" action="{{ route('parental.linkExisting') }}" class="space-y-3">
            @csrf
            <div>
                <label class="text-xs text-gray-600">Family Email</label>
                <input type="email" name="email" class="border rounded p-2 w-full" required>
            </div>
            <div>
                <label class="text-xs text-gray-600">Relationship (optional)</label>
                <input type="text" name="relationship" class="border rounded p-2 w-full" placeholder="e.g. Mother, Father, Guardian">
            </div>
            <button @disabled($atLimit) class="w-full px-4 py-2 bg-blue-600 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed">Send confirmation email</button>
        </form>
    </div>
</div>
@endsection
