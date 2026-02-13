<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use App\Models\daily_logs;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class VisitLogController extends Controller
{
    private $apiKey = '-2y7KYjX1JuFECsjI_ANCAM5pugEm5R0';
    private $apiSecret = 'QHRO96q2sagJUJ-4DAgVgmBDa2-H3n8v';
    private const FACE_MATCH_THRESHOLD = 80;

    // ─────────────────────────────────────────────
    // Shared: find today's active appointment
    // ─────────────────────────────────────────────
    private function findTodayAppointment(int $userId): ?Appointment
    {
        $today = now()->format('Y-m-d');

        $appointment = Appointment::where('user_id', $userId)
            ->where('appointment_date', $today)
            ->whereIn('status', ['approved', 'pending'])
            ->latest('appointment_date')
            ->first();

        Log::info('Appointment lookup', [
            'user_id'      => $userId,
            'today'        => $today,
            'found_id'     => $appointment?->id,
            'found_date'   => $appointment?->getRawOriginal('appointment_date'),
            'found_status' => $appointment?->status,
        ]);

        return $appointment;
    }

    // ─────────────────────────────────────────────
    // QR Scan
    // ─────────────────────────────────────────────
    public function handleQrScan(Request $request)
    {
        try {
            $request->validate([
                'qr_token' => 'required|string',
            ]);

            $user = User::where('qr_token', $request->qr_token)->first();

            if (!$user) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'QR Code not recognized.'
                ], 404);
            }

            // Check if already logged today
            $alreadyLogged = daily_logs::where('user_id', $user->id)
                ->whereDate('scanned_at', Carbon::today())
                ->exists();

            // Always find and update today's appointment status to arrived
            // regardless of whether they already logged — as long as the appointment is today
            $appointment = $this->findTodayAppointment($user->id);

            if ($appointment) {
                $appointment->update(['status' => 'arrived']);
            }

            // If already logged, return warning (don't create duplicate log)
            if ($alreadyLogged) {
                return response()->json([
                    'status'  => 'warning',
                    'message' => 'You have already logged a visit today.',
                ], 200);
            }

            // Create visit log
            daily_logs::create([
                'user_id'        => $user->id,
                'appointment_id' => $appointment?->id,
                'store_id'       => $appointment?->store_id ?? session('active_branch_id'),
            ]);

            Log::info("Visit logged for user {$user->id} via QR scan");

            return response()->json([
                'status'      => 'success',
                'message'     => 'Visit logged successfully!',
                'appointment' => $appointment ? [
                    'name'   => $user->name,
                    'branch' => $appointment->store->name ?? 'N/A',
                    'time'   => $appointment->appointment_time,
                    'status' => 'arrived',
                ] : null
            ]);

        } catch (\Throwable $e) {
            Log::error('QR Scan Error:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'debug'  => [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ]
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // Face Scan
    // ─────────────────────────────────────────────
    public function handleFaceScan(Request $request)
    {
        $tempImagePath = null;

        try {
            $request->validate([
                'image_base64' => 'required|string',
            ]);

            $imageData = $this->decodeBase64Image($request->input('image_base64'));

            if (!$imageData) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Invalid image data.'
                ], 400);
            }

            $tempImagePath = storage_path('app/temp/scan_face_' . time() . '.jpg');
            $this->ensureDirectoryExists(dirname($tempImagePath));
            file_put_contents($tempImagePath, $imageData);

            $scannedFaceToken = $this->detectFace($tempImagePath);

            if (!$scannedFaceToken) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'No face detected in the image. Please try again.'
                ], 400);
            }

            $matchedUser = $this->findMatchingUser($scannedFaceToken);

            if (!$matchedUser) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Face not recognized. Please make sure you have registered your face.'
                ], 404);
            }

            $user = $matchedUser['user'];

            Log::info("Face recognized: User ID {$user->id}, Confidence: {$matchedUser['confidence']}");

            // Check if already logged today
            $alreadyLogged = daily_logs::where('user_id', $user->id)
                ->whereDate('scanned_at', Carbon::today())
                ->exists();

            // Always find and update today's appointment status to arrived
            // regardless of whether they already logged — as long as the appointment is today
            $appointment = $this->findTodayAppointment($user->id);

            if ($appointment) {
                $appointment->update(['status' => 'arrived']);
            }

            // If already logged, return warning (don't create duplicate log)
            if ($alreadyLogged) {
                return response()->json([
                    'status'    => 'warning',
                    'message'   => 'You have already logged a visit today.',
                    'user_name' => $user->full_name,
                    'redirect'  => route('logs'),
                ], 200);
            }

            // Create visit log
            daily_logs::create([
                'user_id'        => $user->id,
                'appointment_id' => $appointment?->id,
                'store_id'       => $appointment?->store_id ?? session('active_branch_id'),
            ]);

            Log::info("Visit logged for user {$user->id} via face recognition");

            return response()->json([
                'status'      => 'success',
                'message'     => 'Visit logged successfully!',
                'user_name'   => $user->full_name,
                'redirect'    => route('logs'),
                'appointment' => $appointment ? [
                    'name'   => $user->name,
                    'branch' => $appointment->store->name ?? 'N/A',
                    'time'   => $appointment->appointment_time,
                    'status' => 'arrived',
                ] : null
            ]);

        } catch (Exception $e) {
            Log::error('Face Scan Error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred during face recognition. Please try again.'
            ], 500);

        } finally {
            if ($tempImagePath && file_exists($tempImagePath)) {
                @unlink($tempImagePath);
            }
        }
    }

    // ─────────────────────────────────────────────
    // Logs View
    // ─────────────────────────────────────────────
    public function logs(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        $logs = daily_logs::with(['user', 'appointment.store', 'store'])
            ->whereDate('scanned_at', $date)
            ->latest('scanned_at')
            ->get();

        return view('admin.visit-logs', compact('logs', 'date'));
    }

    // ─────────────────────────────────────────────
    // Private Helpers
    // ─────────────────────────────────────────────
    private function findMatchingUser($scannedFaceToken)
    {
        $users = User::whereNotNull('face_token')->get();

        $bestMatch = null;
        $highestConfidence = 0;

        foreach ($users as $user) {
            $confidence = $this->compareFaces($user->face_token, $scannedFaceToken);

            if ($confidence !== null && $confidence > $highestConfidence) {
                $highestConfidence = $confidence;
                $bestMatch = $user;
            }
        }

        if ($bestMatch && $highestConfidence > self::FACE_MATCH_THRESHOLD) {
            return [
                'user'       => $bestMatch,
                'confidence' => $highestConfidence
            ];
        }

        return null;
    }

    private function decodeBase64Image($base64String)
    {
        try {
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $base64String);
            $decoded = base64_decode($imageData, true);

            if ($decoded === false || strlen($decoded) < 100) {
                return null;
            }

            return $decoded;

        } catch (Exception $e) {
            Log::error('Base64 Decode Error: ' . $e->getMessage());
            return null;
        }
    }

    private function detectFace($imagePath)
    {
        try {
            if (!file_exists($imagePath)) {
                throw new Exception("Image file not found: {$imagePath}");
            }

            $response = Http::timeout(30)
                ->attach('image_file', file_get_contents($imagePath), basename($imagePath))
                ->post('https://api-us.faceplusplus.com/facepp/v3/detect', [
                    'api_key'    => $this->apiKey,
                    'api_secret' => $this->apiSecret,
                ]);

            $data = $response->json();

            if (isset($data['error_message'])) {
                Log::error('Face++ Detect Error: ' . $data['error_message']);
                return null;
            }

            return $data['faces'][0]['face_token'] ?? null;

        } catch (Exception $e) {
            Log::error('Face Detection Error: ' . $e->getMessage());
            return null;
        }
    }

    private function compareFaces($faceToken1, $faceToken2)
    {
        try {
            $response = Http::timeout(30)
                ->asForm()
                ->post('https://api-us.faceplusplus.com/facepp/v3/compare', [
                    'api_key'      => $this->apiKey,
                    'api_secret'   => $this->apiSecret,
                    'face_token1'  => $faceToken1,
                    'face_token2'  => $faceToken2,
                ]);

            $data = $response->json();

            if (isset($data['error_message'])) {
                Log::error('Face++ Compare Error: ' . $data['error_message']);
                return null;
            }

            return $data['confidence'] ?? null;

        } catch (Exception $e) {
            Log::error('Face Comparison Error: ' . $e->getMessage());
            return null;
        }
    }

    private function ensureDirectoryExists($directory)
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}