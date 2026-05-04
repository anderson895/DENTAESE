<?php

namespace App\Http\Controllers;

use App\Mail\ChildLinkRequest;
use App\Models\ParentChildLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ParentalControlController extends Controller
{
    public const MAX_CHILDREN = 10;

    /**
     * Show the parent's children dashboard.
     */
    public function index()
    {
        $parent = Auth::user();
        $links = ParentChildLink::with('child')
            ->where('parent_user_id', $parent->id)
            ->orderByRaw("CASE status WHEN 'active' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        return view('client.parental.index', [
            'parent'      => $parent,
            'links'       => $links,
            'maxChildren' => self::MAX_CHILDREN,
        ]);
    }

    /**
     * Send a confirmation email to the child so they can approve the link.
     */
    public function linkExisting(Request $request)
    {
        $parent = Auth::user();

        if ($parent->children()->count() >= self::MAX_CHILDREN) {
            return back()->withErrors(['email' => 'Child account limit reached (max ' . self::MAX_CHILDREN . ').']);
        }

        $data = $request->validate([
            'email'        => 'required|email',
            'relationship' => 'nullable|string|max:50',
        ]);

        $child = User::where('email', $data['email'])
            ->where('account_type', 'patient')
            ->first();

        if (!$child) {
            return back()->withErrors(['email' => 'No patient account found with that email.'])->withInput();
        }

        if ($child->id === $parent->id) {
            return back()->withErrors(['email' => 'You cannot link your own account.']);
        }

        $existing = ParentChildLink::where('parent_user_id', $parent->id)
            ->where('child_user_id', $child->id)
            ->first();

        if ($existing && $existing->status === 'active') {
            return back()->withErrors(['email' => 'This account is already linked.']);
        }

        $token = Str::random(48);
        $expiresAt = now()->addHours(48);

        if ($existing) {
            $existing->update([
                'relationship'        => $data['relationship'] ?? $existing->relationship,
                'status'              => 'pending',
                'verification_token'  => $token,
                'token_expires_at'    => $expiresAt,
            ]);
        } else {
            ParentChildLink::create([
                'parent_user_id'      => $parent->id,
                'child_user_id'       => $child->id,
                'relationship'        => $data['relationship'] ?? null,
                'status'              => 'pending',
                'verification_token'  => $token,
                'token_expires_at'    => $expiresAt,
            ]);
        }

        $confirmUrl = route('parental.confirm', ['token' => $token]);
        Mail::to($child->email)->send(new ChildLinkRequest(
            $parent->full_name ?: ($parent->name ?? 'A Dentaease user'),
            $data['relationship'] ?? null,
            $confirmUrl
        ));

        return redirect()->route('parental.index')
            ->with('success', 'A confirmation email has been sent to ' . $child->email . '. The link will activate once they approve it.');
    }

    /**
     * Child clicks the confirmation link from their email.
     */
    public function confirmLink(string $token)
    {
        $link = ParentChildLink::where('verification_token', $token)->first();

        if (!$link || $link->status === 'active') {
            return redirect()->route('login')->withErrors(['email' => 'This confirmation link is invalid or already used.']);
        }

        if ($link->token_expires_at && $link->token_expires_at->isPast()) {
            return redirect()->route('login')->withErrors(['email' => 'This confirmation link has expired.']);
        }

        $confirmUrl = route('parental.confirm', ['token' => $token]);

        if (!Auth::check()) {
            return redirect()->route('login', ['next' => $confirmUrl])
                ->with('info', 'Please log in to your patient account to confirm the parental control link request.');
        }

        if (Auth::id() !== (int) $link->child_user_id) {
            Auth::logout();
            return redirect()->route('login', ['next' => $confirmUrl])
                ->with('info', 'Please log in as the child account (' . ($link->child->email ?? 'the invited account') . ') to confirm this link.');
        }

        $link->update([
            'status'              => 'active',
            'verification_token'  => null,
            'token_expires_at'    => null,
        ]);

        return redirect()->route('CDashboard')->with('success', 'Parental control link approved.');
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
