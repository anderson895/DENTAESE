<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class QrController extends Controller
{
    //

public function generateUserQr(User $user)
{
    if (empty($user->qr_token)) {
        $user->qr_token = Str::uuid()->toString();
    }

    $filename = 'qr_' . $user->id . '.png';

    if (!Storage::disk('public')->exists('qr_codes')) {
        Storage::disk('public')->makeDirectory('qr_codes');
    }

    $qrImage = $this->generatePngViaGd($user->qr_token, 300);
    Storage::disk('public')->put("qr_codes/{$filename}", $qrImage);

    $user->qr_code = $filename;
    $user->save();

    return response()->json([
        'message'   => 'QR code generated successfully.',
        'qr_token'  => $user->qr_token,
        'qr_path'   => asset("storage/qr_codes/{$filename}")
    ]);
}

private function generatePngViaGd(string $token, int $size): string
{
    $encoded    = \BaconQrCode\Encoder\Encoder::encode($token, \BaconQrCode\Common\ErrorCorrectionLevel::M());
    $matrix     = $encoded->getMatrix();
    $matrixSize = $matrix->getWidth();

    $scale  = (int) floor($size / ($matrixSize + 2));
    $margin = (int) floor(($size - ($matrixSize * $scale)) / 2);

    $img   = imagecreatetruecolor($size, $size);
    $white = imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);
    imagefill($img, 0, 0, $white);

    for ($y = 0; $y < $matrixSize; $y++) {
        for ($x = 0; $x < $matrixSize; $x++) {
            if ($matrix->get($x, $y) === 1) {
                $x1 = $margin + $x * $scale;
                $y1 = $margin + $y * $scale;
                imagefilledrectangle($img, $x1, $y1, $x1 + $scale - 1, $y1 + $scale - 1, $black);
            }
        }
    }

    ob_start();
    imagepng($img);
    $png = ob_get_clean();
    imagedestroy($img);

    return $png;
}

    public function LoginQr(Request $request)
    {
         $request->validate([
        'token' => 'required|string',
    ]);

    $user = User::where('qr_token', $request->token)->first();

    if (!$user) {
        return response()->json(['status' => 'error', 'message' => 'Invalid QR code.'], 401);
    }

    Auth::login($user);
    $request->session()->regenerate(); // regenerate session ID

    // Get authenticated user
    $user = Auth::user();

    // Default redirect based on position or account type
    if ($user->position === 'admin') {
        session(['active_branch_id' => 'admin']);
        $redirectUrl = route('dashboard');
    } else {
        $redirectUrl = match ($user->account_type) {
            'admin'   => route('GetBranchLogin'),
            'patient' => route('CBookingo'),
            default   => route('login'),
        };
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Logged in successfully.',
        'redirect' => $redirectUrl,
    ]);
    }
}