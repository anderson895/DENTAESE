@extends('layout.cnav')

@section('title', 'Parental Control')
@section('main-content')

<div class="container mx-auto p-4 space-y-6">

    @php($atLimit = $children->count() >= $maxChildren)
    <div class="bg-white p-5 rounded shadow">
        <h1 class="text-2xl font-bold mb-1">Parental Control</h1>
        <p class="text-sm text-gray-600">
            Link or create child patient accounts so you can manage their bookings, view their records,
            and switch between accounts safely.
        </p>
        <p class="text-xs text-gray-500 mt-2">
            Linked child accounts: <strong>{{ $children->count() }} / {{ $maxChildren }}</strong>
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
        <h2 class="text-lg font-semibold mb-3">Linked Children</h2>

        @if($children->isEmpty())
            <p class="text-sm text-gray-500">No children linked yet. Use the forms below to link an existing account or create a new one.</p>
        @else
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-left">Name</th>
                        <th class="border p-2 text-left">Email</th>
                        <th class="border p-2 text-left">Relationship</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($children as $child)
                        <tr>
                            <td class="border p-2">{{ $child->name }} {{ $child->lastname }}</td>
                            <td class="border p-2">{{ $child->email }}</td>
                            <td class="border p-2">{{ $child->pivot->relationship ?? '—' }}</td>
                            <td class="border p-2 text-center">
                                <form method="POST" action="{{ route('parental.switchTo') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="child_user_id" value="{{ $child->id }}">
                                    <button class="px-3 py-1 bg-blue-600 text-white rounded text-xs">View as child</button>
                                </form>

                                @php
                                    $linkRow = \App\Models\ParentChildLink::where('parent_user_id', auth()->id())
                                        ->where('child_user_id', $child->id)->first();
                                @endphp
                                @if($linkRow)
                                    <form method="POST" action="{{ route('parental.unlink', $linkRow->id) }}" class="inline" onsubmit="return confirm('Unlink this child account?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs">Unlink</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- LINK EXISTING --}}
        <div class="bg-white p-5 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">Link an existing patient account</h2>
            <p class="text-xs text-gray-500 mb-3">Verify the child's existing patient credentials to link it to your parent account.</p>
            <form method="POST" action="{{ route('parental.linkExisting') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="text-xs text-gray-600">Child's email</label>
                    <input type="email" name="email" class="border rounded p-2 w-full" required>
                </div>
                <div>
                    <label class="text-xs text-gray-600">Child's password</label>
                    <input type="password" name="password" class="border rounded p-2 w-full" required>
                </div>
                <div>
                    <label class="text-xs text-gray-600">Relationship (optional)</label>
                    <input type="text" name="relationship" class="border rounded p-2 w-full" placeholder="e.g. Mother, Father, Guardian">
                </div>
                <button @disabled($atLimit) class="w-full px-4 py-2 bg-blue-600 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed">Link account</button>
            </form>
        </div>

        {{-- CREATE NEW CHILD --}}
        <div class="bg-white p-5 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">Create a new child account</h2>
            <p class="text-xs text-gray-500 mb-3">Creates a new patient account that is automatically linked to your parent account.</p>
            <form method="POST" action="{{ route('parental.createChild') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-gray-600">First name</label>
                        <input type="text" name="name" class="border rounded p-2 w-full" required>
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Last name</label>
                        <input type="text" name="lastname" class="border rounded p-2 w-full" required>
                    </div>
                </div>
                <div>
                    <label class="text-xs text-gray-600">Middle name (optional)</label>
                    <input type="text" name="middlename" class="border rounded p-2 w-full">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-gray-600">Birthdate</label>
                        <input type="date" name="birth_date" class="border rounded p-2 w-full" required>
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Contact number</label>
                        <input type="text" name="contact_number" class="border rounded p-2 w-full">
                    </div>
                </div>
                <div>
                    <label class="text-xs text-gray-600">Email</label>
                    <input type="email" name="email" class="border rounded p-2 w-full" required>
                </div>
                <div>
                    <label class="text-xs text-gray-600">Relationship</label>
                    <input type="text" name="relationship" class="border rounded p-2 w-full" placeholder="e.g. Son, Daughter">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-gray-600">Password</label>
                        <input type="password" name="password" class="border rounded p-2 w-full" required>
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Confirm</label>
                        <input type="password" name="password_confirmation" class="border rounded p-2 w-full" required>
                    </div>
                </div>
                <button @disabled($atLimit) class="w-full px-4 py-2 bg-green-600 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed">Create child account</button>
            </form>
        </div>
    </div>
</div>
@endsection
