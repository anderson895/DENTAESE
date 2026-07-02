<?php

namespace App\Http\Controllers;

use App\Models\ParentChildLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ParentalControlController extends Controller
{
    public const MAX_CHILDREN = 10;

    /**
     * Show the guardian's dependents dashboard.
     */
    public function index()
    {
        $parent = Auth::user();
        $links = ParentChildLink::with('child')
            ->where('parent_user_id', $parent->id)
            ->latest()
            ->get();

        return view('client.parental.index', [
            'parent'      => $parent,
            'links'       => $links,
            'maxChildren' => self::MAX_CHILDREN,
        ]);
    }

    /**
     * Add a dependent (child / senior citizen) who cannot use the system.
     * The guardian enters their details; no email verification needed.
     * The dependent gets a patient record but no login credentials.
     */
    public function addDependent(Request $request)
    {
        $parent = Auth::user();

        if ($parent->children()->count() >= self::MAX_CHILDREN) {
            return back()->withErrors(['name' => 'Dependent limit reached (max ' . self::MAX_CHILDREN . ').'])->withInput();
        }

        $data = $request->validate([
            'name'           => 'required|string|max:100',
            'middlename'     => 'nullable|string|max:100',
            'lastname'       => 'required|string|max:100',
            'suffix'         => 'nullable|string|max:20',
            'birth_date'     => 'required|date|before_or_equal:today',
            'relationship'   => 'required|string|max:50',
            'contact_number' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($parent, $data) {
            $dependent = User::create([
                'name'           => $data['name'],
                'middlename'     => $data['middlename'] ?? null,
                'lastname'       => $data['lastname'],
                'suffix'         => $data['suffix'] ?? null,
                'birth_date'     => $data['birth_date'],
                'contact_number' => $data['contact_number'] ?? $parent->contact_number,
                'current_address'=> $parent->current_address,
                'email'          => null,
                'user'           => 'dep_' . Str::lower(Str::random(12)),
                'password'       => bcrypt(Str::random(40)), // unusable — dependents cannot log in
                'account_type'   => 'patient',
                'is_managed'     => true,
            ]);

            ParentChildLink::create([
                'parent_user_id' => $parent->id,
                'child_user_id'  => $dependent->id,
                'relationship'   => $data['relationship'],
                'status'         => 'active',
            ]);
        });

        return redirect()->route('parental.index')
            ->with('success', $data['name'] . ' ' . $data['lastname'] . ' has been added as your dependent. You can now book appointments on their behalf.');
    }

    /**
     * Remove a dependent link. Managed dependents (no login of their own)
     * are soft-deleted together with the link.
     */
    public function unlink(ParentChildLink $link)
    {
        if ($link->parent_user_id !== Auth::id()) {
            abort(403);
        }

        $child = $link->child;
        $link->delete();

        if ($child && $child->is_managed) {
            $child->delete(); // soft delete — records are preserved
        }

        return back()->with('success', 'Dependent removed.');
    }

    /**
     * Switch the active session to act on behalf of a dependent account.
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

        // Remember the guardian so we can switch back
        session(['parent_user_id' => $parent->id]);

        $dependent = Auth::loginUsingId((int) $data['child_user_id']);

        // Follow the same onboarding gate as a normal patient login:
        // consent first, then the patient details form, then booking.
        if (empty($dependent->is_consent)) {
            $redirect = route('CConsent');
        } elseif (!\App\Models\PatientRecord::where('user_id', $dependent->id)->where('profile_completed', true)->exists()) {
            $redirect = route('CForms');
        } else {
            $redirect = route('CDashboard');
        }

        return redirect($redirect)->with('success', 'You are now assisting your dependent. Anything you book or fill out will be under their name.');
    }

    /**
     * Switch back from dependent to guardian.
     */
    public function switchBack()
    {
        $parentId = session('parent_user_id');
        if (!$parentId) {
            return redirect()->route('CDashboard');
        }
        Auth::loginUsingId((int) $parentId);
        session()->forget('parent_user_id');
        return redirect()->route('parental.index')->with('success', 'Switched back to your account.');
    }
}
