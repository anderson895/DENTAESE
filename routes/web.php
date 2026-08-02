<?php


use App\Http\Controllers\AuthUi;
use App\Http\Controllers\FaceRecognitionController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;
use  App\Models\User;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SmsLogController;

use function Laravel\Prompts\password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\QrController;


use App\Http\Controllers\DentalToothController;

Route::post('/dental/tooth/save', [DentalToothController::class, 'store'])->name('dental.tooth.save');

Route::get('/dental/tooth/{patient}', [DentalToothController::class, 'fetch'])->name('dental.tooth.fetch');
// 9847239847
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/syseng', function () {
    
    $user = 'qwe';
    $password = 'qwe';
    $name= 'qwe';
    $account_type = 'admin';
    $position = 'admin';
    $auth = new User();
    $auth->user = $user;
    $auth->password = $password;
    $auth->name = $name;
    $auth->account_type = $account_type;
    $auth->position = $position;
    $auth->formstatus = 1;
    $auth->save();
    return view('auth.login');
    
});

Route::get('/generateqr', function () {
    $users = User::whereNull('qr_code')->get();

    foreach ($users as $user) {
        // Generate unique token if not set
        if (empty($user->qr_token)) {
            $user->qr_token = Str::uuid()->toString();
        }

        // Set filename
        $filename = 'qr_' . $user->id . '.svg';

        // Ensure directory exists
        if (!Storage::disk('public')->exists('qr_codes')) {
            Storage::disk('public')->makeDirectory('qr_codes');
        }

        // Generate QR and save
        $qrImage = QrCode::format('svg')->size(200)->generate($user->qr_token);
        Storage::disk('public')->put("qr_codes/{$filename}", $qrImage);

        // Save to DB
        $user->qr_code = $filename;
        $user->save();
    }

    return response()->json([
        'message' => 'QR codes generated for users without QR.',
        'count' => $users->count()
    ]);

    
});
Route::get('/', [LandingPageController::class, 'index']);

require __DIR__.'/admin.php';
require __DIR__.'/client.php';





//auth page
Route::get('/signupui',[AuthUi::class,'SignUpUi'])->name('signupui');
Route::get('/loginui',[AuthUi::class, 'LogInUi'])->name('loginui');
Route::get('/faceui',[AuthUi::class, 'FaceUi'])->name('faceui');
Route::post('/get-face-landmarks', [FaceRecognitionController::class, 'getLandmarks']);


// Face registration for new users
Route::post('/cregister-face-registration', [FaceRecognitionController::class, 'registerFaceForSignup']);



Route::get('/qr',[AuthUi::class, 'Qr'])->name('Qr');
Route::post('/qr-login', [QrController::class, 'LoginQr'])->name('qr.login');

Route::middleware('auth')->group(function () {
    Route::post('/qr/regenerate/{user}', [QrController::class, 'regenerateForUser'])->name('qr.regenerate');
    Route::post('/qr/regenerate-mine', [QrController::class, 'regenerateMyQr'])->name('qr.regenerate.mine');
});


//signup form

Route::post('/signupform', [AuthUi::class, 'SignUpForm'])->name('signupform');
Route::post('/loginform', [AuthUi::class, 'LoginForm'])->name('loginform');

// Forgot password (OTP-based)
Route::get('/forgot-password', [AuthUi::class, 'ForgotPasswordUi'])->name('password.forgot');
Route::post('/forgot-password/send-otp', [AuthUi::class, 'forgotPasswordSendOtp'])->name('password.sendOtp');
Route::post('/forgot-password/verify-otp', [AuthUi::class, 'forgotPasswordVerifyOtp'])->name('password.verifyOtp');
Route::post('/forgot-password/reset', [AuthUi::class, 'forgotPasswordReset'])->name('password.reset');
Route::post('/login-face', [AuthUi::class, 'loginFace'])->name('login-face');


// web.php
Route::post('/signup/validate-step', [AuthUi::class, 'validateSignupStep'])->name('signup.validateStep');
Route::post('/signup/send-otp', [AuthUi::class, 'sendOtp'])->name('send.otp');
Route::get('/signup/verify-otp', [AuthUi::class, 'verifyOtp'])->name('verify.otp');

// --- NEW: Final signup route (after OTP is verified) ---
Route::post('/signup/final', [AuthUi::class, 'finalSignup'])->name('final.signup');




Route::get('/logouts', [AdminController::class,'Logout'])->name('Logout')->middleware('auth');


Route::get('/dental-chart/{patient}', function (User $patient) {
    return view('admin.dental-chart.index', compact('patient'));
})->name('dental-chart.index');

// ADMIN
Route::middleware('auth')->group(function () {
    Route::get('/sms-logs', [SmsLogController::class, 'index'])->name('sms-logs.index');

    Route::get('/chat', [MessageController::class, 'index'])->name('chat.index');
    Route::get('/patients', [MessageController::class, 'patients'])->name('patients.list');
    Route::get('/messages/{storeId}/{userId}', [MessageController::class, 'fetch'])->name('messages.fetch');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    // ✅ ADMIN FILE UPLOAD
    Route::post('/messages/upload', [MessageController::class, 'adminUpload'])
        ->name('messages.upload');

    // ✅ BRANCH-TO-BRANCH (Dentist / Receptionist / Admin)
    Route::get('/branch-messages/branches', [MessageController::class, 'staffBranches'])->name('branch.messages.list');
    Route::get('/branch-messages/{storeId}', [MessageController::class, 'branchMessages'])->name('branch.messages');
    Route::post('/branch-messages', [MessageController::class, 'sendBranchMessage'])->name('branch.messages.store');
    Route::post('/branch-messages/upload', [MessageController::class, 'uploadBranchFile'])->name('branch.messages.upload');
});

// PATIENT
Route::middleware('auth')->group(function () {
    Route::get('/patient/chat', [MessageController::class, 'patientIndex'])->name('patient.chat.index');
    Route::get('/patient/branches', [MessageController::class, 'branches'])->name('patient.branches.list');
    Route::get('/patient/messages/{storeId}', [MessageController::class, 'patientMessages'])->name('patient.messages');
    Route::post('/patient/messages', [MessageController::class, 'sendMessage'])->name('patient.messages.store');

    // ✅ FILE UPLOAD
    Route::post('/patient/messages/upload', [MessageController::class, 'uploadFile'])
        ->name('patient.messages.upload');
});

// ─────────────────────────────────────────────
// SELF-HEALING STORAGE FALLBACK
// Serves /storage/* files directly kapag sira o wala yung
// public/storage symlink (e.g. after Hostinger deployment).
// Kapag buo yung symlink, hindi ito tinatamaan — Apache/Nginx
// pa rin ang nagse-serve ng file nang direkta.
// ─────────────────────────────────────────────
Route::get('/storage/{path}', function (string $path) {
    $base = realpath(storage_path('app/public'));
    $file = realpath(storage_path('app/public') . DIRECTORY_SEPARATOR . $path);

    abort_unless(
        $base && $file && str_starts_with($file, $base . DIRECTORY_SEPARATOR) && is_file($file),
        404
    );

    return response()->file($file);
})->where('path', '.*');
