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
            Add dependents — such as your child or a senior citizen — who cannot use the system by themselves.
            You act as their guardian: book appointments and fill out forms on their behalf using your own account.
        </p>
        <p class="text-xs text-gray-500 mt-2">
            Dependents: <strong>{{ $activeCount }} / {{ $maxChildren }}</strong>
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

    {{-- DEPENDENTS --}}
    <div class="bg-white p-5 rounded shadow">
        <h2 class="text-lg font-semibold mb-3">My Dependents</h2>

        @if($links->isEmpty())
            <p class="text-sm text-gray-500">No dependents yet. Use the form below to add one.</p>
        @else
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-left">Name</th>
                        <th class="border p-2 text-left">Birth Date</th>
                        <th class="border p-2 text-left">Relationship</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($links as $link)
                        @php $child = $link->child; @endphp
                        @continue(!$child)
                        <tr>
                            <td class="border p-2">{{ $child->name }} {{ $child->lastname }} {{ $child->suffix }}</td>
                            <td class="border p-2">
                                {{ $child->birth_date ? \Carbon\Carbon::parse($child->birth_date)->format('M d, Y') : '—' }}
                                @if($child->birth_date)
                                    <span class="text-xs text-gray-500">({{ \Carbon\Carbon::parse($child->birth_date)->age }} yrs old)</span>
                                @endif
                            </td>
                            <td class="border p-2">{{ $link->relationship ?? '—' }}</td>
                            <td class="border p-2 text-center whitespace-nowrap">
                                <form method="POST" action="{{ route('parental.switchTo') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="child_user_id" value="{{ $link->child_user_id }}">
                                    <button class="px-3 py-1 bg-blue-600 text-white rounded text-xs">Assist / Book for them</button>
                                </form>
                                <form method="POST" action="{{ route('parental.unlink', $link->id) }}" class="inline" onsubmit="return confirm('Remove this dependent?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- ADD DEPENDENT --}}
    <div class="bg-white p-5 rounded shadow">
        <h2 class="text-lg font-semibold mb-3">Add a dependent</h2>
        <p class="text-xs text-gray-500 mb-3">
            Enter the details of your child or senior dependent. No email or account is needed —
            they will be linked to your account right away and you can book appointments for them.
        </p>
        <form method="POST" action="{{ route('parental.addDependent') }}" class="space-y-3">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs text-gray-600">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="border rounded p-2 w-full" required>
                </div>
                <div>
                    <label class="text-xs text-gray-600">Middle Name</label>
                    <input type="text" name="middlename" value="{{ old('middlename') }}" class="border rounded p-2 w-full">
                </div>
                <div>
                    <label class="text-xs text-gray-600">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="lastname" value="{{ old('lastname') }}" class="border rounded p-2 w-full" required>
                </div>
                <div>
                    <label class="text-xs text-gray-600">Suffix</label>
                    <input type="text" name="suffix" value="{{ old('suffix') }}" class="border rounded p-2 w-full" placeholder="e.g. Jr., III">
                </div>
                <div>
                    <label class="text-xs text-gray-600">Birth Date <span class="text-red-500">*</span></label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" max="{{ now()->toDateString() }}" class="border rounded p-2 w-full" required>
                </div>
                <div>
                    <label class="text-xs text-gray-600">Relationship <span class="text-red-500">*</span></label>
                    <select name="relationship" class="border rounded p-2 w-full" required>
                        <option value="" disabled {{ old('relationship') ? '' : 'selected' }}>Select relationship</option>
                        @foreach(['Child', 'Parent', 'Grandparent', 'Senior Citizen', 'Spouse', 'Sibling', 'Other'] as $rel)
                            <option value="{{ $rel }}" {{ old('relationship') === $rel ? 'selected' : '' }}>{{ $rel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-600">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number') }}" class="border rounded p-2 w-full" placeholder="Leave blank to use your own contact number">
                </div>
            </div>
            <button @disabled($atLimit) class="w-full px-4 py-2 bg-blue-600 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed">Add Dependent</button>
        </form>
    </div>
</div>
@endsection
