<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\newuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendOtp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AuthUi extends Controller
{
    // ===============================
    // HELPER: Euclidean Distance
    // ===============================
    private function euclideanDistance(array $a, array $b): float
    {
        $sum = 0;
        foreach ($a as $i => $val) {
            $sum += pow($val - ($b[$i] ?? 0), 2);
        }
        return sqrt($sum);
    }

    // ===============================
    // VIEWS
    // ===============================
    public function GetBranchLogin(Request $request)
    {
        $branches = Auth::user()->stores;
        return view('auth.SelectBranch', compact('branches'));
    }

    public function SelectBranchLogin(Request $request)
    {
        $request->validate(['branch_id' => 'required|exists:stores,id']);
        session(['active_branch_id' => $request->branch_id]);
        return redirect()->intended('/dashboard');
    }

    public function SignUpUi(Request $request)
    {
        return view('auth.signup');
    }

    public function Qr(Request $request)
    {
        return view('auth.qrlogin');
    }

    public function LoginUi(Request $request)
    {
        return view('auth.login');
    }

    public function FaceUi(Request $request)
    {
        return view('auth.face');
    }

    // ===============================
    // NORMAL LOGIN
    // ===============================
    public function LoginForm(Request $request)
    {
        $credentials = $request->only('user', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->position == 'admin') {
                session(['active_branch_id' => 'admin']);
                $redirectUrl = route('dashboard');
            } elseif ($user->account_type == 'patient') {
                $redirectUrl = $user->is_consent == 0
                    ? route('CConsent')
                    : route('CBookingo');
            } else {
                $redirectUrl = match ($user->account_type) {
                    'admin'   => route('GetBranchLogin'),
                    'patient' => route('CBookingo'),
                    default   => route('login'),
                };
            }

            return response()->json(['status' => 'success', 'redirect' => $redirectUrl]);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid credentials']);
    }

    // ===============================
    // FACE LOGIN
    // ===============================
    public function loginFace(Request $request)
    {
        $request->validate([
            'face_descriptor' => 'required|string',
        ]);

        $scannedDescriptor = json_decode($request->input('face_descriptor'), true);

        if (!$scannedDescriptor || count($scannedDescriptor) !== 128) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid face descriptor.',
            ]);
        }

        $users          = User::whereNotNull('face_descriptor')->get();
        $matchedUser    = null;
        $lowestDistance = PHP_FLOAT_MAX;

        foreach ($users as $user) {
            $storedDescriptor = json_decode($user->face_descriptor, true);
            if (!$storedDescriptor || count($storedDescriptor) !== 128) continue;

            $distance = $this->euclideanDistance($scannedDescriptor, $storedDescriptor);

            if ($distance < $lowestDistance) {
                $lowestDistance = $distance;
                $matchedUser    = $user;
            }
        }

        if (!$matchedUser || $lowestDistance > 0.5) {
            return response()->json([
                'status'          => 'error',
                'message'         => 'Face not recognized.',
                'lowest_distance' => $lowestDistance,
            ]);
        }

        Auth::login($matchedUser);

        if ($matchedUser->position === 'admin') {
            session(['active_branch_id' => 'admin']);
            $redirectUrl = route('dashboard');
        } elseif ($matchedUser->account_type === 'patient') {
            $redirectUrl = $matchedUser->is_consent == 0
                ? route('CConsent')
                : route('CBookingo');
        } else {
            $redirectUrl = match ($matchedUser->account_type) {
                'admin'   => route('GetBranchLogin'),
                'patient' => route('CBookingo'),
                default   => route('login'),
            };
        }

        return response()->json([
            'status'   => 'success',
            'message'  => 'Login successful!',
            'distance' => $lowestDistance,
            'redirect' => $redirectUrl,
        ]);
    }

    // ===============================
    // SIGNUP - Send OTP
    // FIX: Added face_descriptor validation rule so it
    //      passes through validation without being stripped.
    //      Also stored in session so finalSignup() can
    //      use it as fallback if request body is missing it.
    // ===============================
    public function sendOtp(Request $request)
    {
        $request->validate([
            'name'            => 'required',
            'middlename'      => 'nullable|string',
            'lastname'        => 'required|string',
            'suffix'          => 'nullable|string|max:10',
            'birth_date'      => 'required|date',
            'birthplace_municipality' => 'required|string',
            'birthplace_province'     => 'required|string',
            'address_street'          => 'required|string',
            'address_barangay'        => 'required|string',
            'address_municipality'    => 'required|string',
            'address_province'        => 'required|string',
            'address_house_number'    => 'nullable|string',
            'address_other_details'   => 'nullable|string',
            'email'           => 'required|email|unique:users,email|unique:newusers,email',
            'password'        => 'required',
            'contact_number'  => 'required',
            'account_type'    => 'required',
            'user'            => 'required|unique:users,user|unique:newusers,user',
            'verification_id' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'face_descriptor' => 'required|string',
        ]);

        $otp      = rand(100000, 999999);
        $filename = null;

        if ($request->hasFile('verification_id')) {
            $uploadedFile = $request->file('verification_id');
            $filename     = uniqid('verify_') . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('temp_verifications', $filename, 'public');
        }

        // FIX: explicitly include face_descriptor in the session
        //      so it's available as a fallback in finalSignup()
        Session::put('pending_user', array_merge(
            $request->except(['verification_id', '_token']),
            ['verification_id' => $filename]
        ));
        Session::put('signup_otp', $otp);

        Mail::to($request->email)->send(new SendOtp($otp));

        return response()->json(['message' => 'OTP sent to your email.']);
    }

    // ===============================
    // SIGNUP - Verify OTP
    // ===============================
    public function verifyOtp(Request $request)
    {
        if ($request->otp != Session::get('signup_otp')) {
            return response()->json(['message' => 'Invalid OTP.'], 400);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'OTP verified successfully.',
        ]);
    }

    // ===============================
    // SIGNUP - Final (save user)
    // FIX: face_descriptor is read from $request first.
    //      If missing (edge case), falls back to session.
    //      Either way it must be a valid 128-value descriptor.
    // ===============================
    public function finalSignup(Request $request)
    {
        $request->validate([
            'name'            => 'required|string',
            'middlename'      => 'nullable|string',
            'lastname'        => 'required|string',
            'suffix'          => 'nullable|string|max:10',
            'birth_date'      => 'required|date',
            'birthplace_municipality' => 'required|string',
            'birthplace_province'     => 'required|string',
            'address_house_number'    => 'nullable|string',
            'address_street'          => 'required|string',
            'address_barangay'        => 'required|string',
            'address_municipality'    => 'required|string',
            'address_province'        => 'required|string',
            'address_other_details'   => 'nullable|string',
            'email'           => 'required|email|unique:users,email',
            'contact_number'  => 'nullable|string',
            'user'            => 'required|string|unique:users,user',
            'password'        => 'required|string|min:6',
            'account_type'    => 'required|string',
            'face_descriptor' => 'required|string',
        ]);

        // Build combined fields for backward compatibility
        $birthplace = $request->birthplace_municipality . ', ' . $request->birthplace_province;
        $currentAddress = implode(', ', array_filter([
            $request->address_other_details,
            $request->address_house_number,
            $request->address_street,
            $request->address_barangay,
            $request->address_municipality,
            $request->address_province,
        ]));

        // FIX: prefer $request value; fall back to session if somehow missing
        $faceDescriptorRaw = $request->face_descriptor
            ?? Session::get('pending_user.face_descriptor');

        if (!$faceDescriptorRaw) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Face descriptor is missing. Please go back and capture your face again.',
            ], 422);
        }

        $descriptorArray = json_decode($faceDescriptorRaw, true);

        if (!$descriptorArray || count($descriptorArray) !== 128) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid face descriptor. Please go back and capture your face again.',
            ], 400);
        }

        // Check if face already registered to another user
        $existingUsers = User::whereNotNull('face_descriptor')->get();

        foreach ($existingUsers as $existingUser) {
            $storedDescriptor = json_decode($existingUser->face_descriptor, true);
            if (!$storedDescriptor || count($storedDescriptor) !== 128) continue;

            $distance = $this->euclideanDistance($descriptorArray, $storedDescriptor);

            if ($distance < 0.5) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'This face is already registered to another account.',
                ], 409);
            }
        }

        // Create user — face_descriptor saved here
        $user = User::create([
            'name'            => $request->name,
            'middlename'      => $request->middlename ?? null,
            'lastname'        => $request->lastname,
            'suffix'          => $request->suffix ?? null,
            'birth_date'      => $request->birth_date,
            'birthplace'      => $birthplace,
            'birthplace_municipality' => $request->birthplace_municipality,
            'birthplace_province'     => $request->birthplace_province,
            'current_address' => $currentAddress,
            'address_other_details'   => $request->address_other_details,
            'address_house_number'    => $request->address_house_number,
            'address_street'          => $request->address_street,
            'address_barangay'        => $request->address_barangay,
            'address_municipality'    => $request->address_municipality,
            'address_province'        => $request->address_province,
            'email'           => $request->email,
            'contact_number'  => $request->contact_number ?? null,
            'user'            => $request->user,
            'password'        => bcrypt($request->password),
            'account_type'    => $request->account_type,
            // FIX: save the raw JSON string (not the decoded array)
            'face_descriptor' => $faceDescriptorRaw,
        ]);

        // Clear signup session data
        Session::forget(['pending_user', 'signup_otp']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Account created successfully!',
            'user'    => $user,
        ], 201);
    }

    // ===============================
    // OLD SIGNUP (kept for reference)
    // ===============================
    public function SignUpForm(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required',
            'email'          => 'required|email',
            'password'       => 'required',
            'contact_number' => 'required',
            'account_type'   => 'required',
            'user'           => 'required|unique:users,user',
        ]);

        $otp = rand(100000, 999999);

        $validated['password']       = bcrypt($validated['password']);
        $validated['otp_code']       = $otp;
        $validated['otp_expires_at'] = Carbon::now()->addMinutes(10);
        $validated['is_verified']    = false;

        $user = newuser::create($validated);

        if ($user) {
            Mail::to($user->email)->send(new \App\Mail\SendOtp($otp));

            return response()->json([
                'status'  => 'success',
                'message' => 'Account created successfully. An OTP has been sent to your email for verification.',
                'user_id' => $user->id,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Failed to create account.',
        ], 500);
    }
}