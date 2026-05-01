<?php

namespace App\Http\Controllers;

use App\Models\ParentChildLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParentalControlController extends Controller
{
    public const MAX_CHILDREN = 10;

    /**
     * Show the parent's children dashboard.
     */
    public function index()
    {
        $parent = Auth::user();
        $children = $parent->children()->get();

        return view('client.parental.index', [
            'parent'       => $parent,
            'children'     => $children,
            'maxChildren'  => self::MAX_CHILDREN,
        ]);
    }

    /**
     * Link an existing patient account as a child by verifying credentials.
     */
    public function linkExisting(Request $request)
    {
        if (Auth::user()->children()->count() >= self::MAX_CHILDREN) {
            return back()->withErrors(['email' => 'Child account limit reached (max ' . self::MAX_CHILDREN . ').']);
        }

        $data = $request->validate([
            'email'        => 'required|email',
            'password'     => 'required|string',
            'relationship' => 'nullable|string|max:50',
        ]);

        $child = User::where('email', $data['email'])
            ->where('account_type', 'patient')
            ->first();

        if (!$child || !Hash::check($data['password'], $child->password)) {
            return back()->withErrors(['email' => 'Invalid child account credentials.'])->withInput();
        }

        if ($child->id === Auth::id()) {
            return back()->withErrors(['email' => 'You cannot link your own account.']);
        }

        ParentChildLink::firstOrCreate(
            [
                'parent_user_id' => Auth::id(),
                'child_user_id'  => $child->id,
            ],
            [
                'relationship' => $data['relationship'] ?? null,
            ]
        );

        return redirect()->route('parental.index')->with('success', 'Child account linked successfully.');
    }

    /**
     * Create a brand-new child account owned by this parent.
     */
    public function createChild(Request $request)
    {
        if (Auth::user()->children()->count() >= self::MAX_CHILDREN) {
            return back()->withErrors(['email' => 'Child account limit reached (max ' . self::MAX_CHILDREN . ').']);
        }

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'lastname'       => 'required|string|max:255',
            'middlename'     => 'nullable|string|max:255',
            'birth_date'     => 'required|date|before:today',
            'email'          => 'required|email|unique:users,email',
            'contact_number' => 'nullable|string|max:30',
            'relationship'   => 'nullable|string|max:50',
            'password'       => 'required|string|min:8|confirmed',
        ]);

        $child = User::create([
            'name'            => $data['name'],
            'lastname'        => $data['lastname'],
            'middlename'      => $data['middlename'] ?? null,
            'birth_date'      => $data['birth_date'],
            'email'           => $data['email'],
            'contact_number'  => $data['contact_number'] ?? null,
            'password'        => Hash::make($data['password']),
            'account_type'    => 'patient',
            'status'          => 'active',
        ]);

        ParentChildLink::create([
            'parent_user_id' => Auth::id(),
            'child_user_id'  => $child->id,
            'relationship'   => $data['relationship'] ?? null,
        ]);

        return redirect()->route('parental.index')->with('success', 'Child account created and linked.');
    }

    public function unlink(ParentChildLink $link)
    {
        if ($link->parent_user_id !== Auth::id()) {
            abort(403);
        }
        $link->delete();
        return back()->with('success', 'Child account unlinked.');
    }

    /**
     * Switch the active session to act on behalf of a child account.
     */
    public function switchTo(Request $request)
    {
        $data = $request->validate([
            'child_user_id' => 'required|exists:users,id',
        ]);

        $parent = Auth::user();
        if (!$parent->isParentOf((int) $data['child_user_id'])) {
            abort(403, 'Not authorized to switch to this account.');
        }

        // Remember the parent so we can switch back
        session(['parent_user_id' => $parent->id]);

        Auth::loginUsingId((int) $data['child_user_id']);
        return redirect()->route('CDashboard')->with('success', 'Now viewing child account.');
    }

    /**
     * Switch back from child to parent.
     */
    public function switchBack()
    {
        $parentId = session('parent_user_id');
        if (!$parentId) {
            return redirect()->route('CDashboard');
        }
        Auth::loginUsingId((int) $parentId);
        session()->forget('parent_user_id');
        return redirect()->route('parental.index')->with('success', 'Switched back to parent account.');
    }
}
