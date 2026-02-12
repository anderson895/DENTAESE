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

    public function handleQrScan(Request $request)
{
    try {
        $request->validate([
            'qr_token' => 'required|string',
        ]);

        $user = User::where('qr_token', $request->qr_token)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code not recognized.'
            ], 404);
        }

        $alreadyLogged = daily_logs::where('user_id', $user->id)
            ->whereDate('scanned_at', Carbon::today())
            ->exists();

        if ($alreadyLogged) {
            return response()->json([
                'status' => 'warning',
                'message' => 'You have already logged a visit today.'
            ], 200);
        }

        // Find appointment (optional)
        $appointment = Appointment::where('user_id', $user->id)
            ->whereDate('appointment_date', Carbon::today())
            ->whereIn('status', ['approved', 'pending'])
            ->first();

        // Create visit log (with or without appointment)
        $log = daily_logs::create([
            'user_id' => $user->id,
            'appointment_id' => $appointment ? $appointment->id : null, // Null if no appointment
            'store_id' => session('active_branch_id'), // Capture active branch from session
        ]);

        Log::info("Visit logged successfully for user {$user->id} via QR scan");

        return response()->json([
            'status' => 'success',
            'message' => $appointment 
                ? 'Visit logged successfully!' 
                : 'Visit logged successfully! (No appointment found)',
            'appointment' => $appointment ? [
                'name' => $user->name,
                'branch' => $appointment->store->name ?? 'N/A',
                'time' => $appointment->appointment_time,
                'status' => $appointment->status,
            ] : null
        ]);

    } catch (Exception $e) {
        Log::error('QR Scan Error: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while processing your request.'
        ], 500);
    }
}

public function handleFaceScan(Request $request)
{
    $tempImagePath = null;

    try {
        $request->validate([
            'image_base64' => 'required|string',
        ]);

        // Process base64 image
        $imageData = $this->decodeBase64Image($request->input('image_base64'));
        
        if (!$imageData) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid image data.'
            ], 400);
        }

        // Save temporary image
        $tempImagePath = storage_path('app/temp/scan_face_' . time() . '.jpg');
        $this->ensureDirectoryExists(dirname($tempImagePath));
        file_put_contents($tempImagePath, $imageData);

        // Detect face in the uploaded image
        $scannedFaceToken = $this->detectFace($tempImagePath);

        if (!$scannedFaceToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'No face detected in the image. Please try again.'
            ], 400);
        }

        // Find matching user by comparing with all registered faces
        $matchedUser = $this->findMatchingUser($scannedFaceToken);

        if (!$matchedUser) {
            return response()->json([
                'status' => 'error',
                'message' => 'Face not recognized. Please make sure you have registered your face.'
            ], 404);
        }

        Log::info("Face recognized: User ID {$matchedUser['user']->id}, Confidence: {$matchedUser['confidence']}");

        // Check if already logged today
        $alreadyLogged = daily_logs::where('user_id', $matchedUser['user']->id)
            ->whereDate('scanned_at', Carbon::today())
            ->exists();

        if ($alreadyLogged) {
            return response()->json([
                'status' => 'warning',
                'message' => 'You have already logged a visit today.',
                'user_name' => $matchedUser['user']->full_name
            ], 200);
        }

        // OPTION A: Find appointment OR create without appointment
        $appointment = Appointment::where('user_id', $matchedUser['user']->id)
            ->whereDate('appointment_date', Carbon::today())
            ->whereIn('status', ['approved', 'pending'])
            ->first();

        // Create visit log (with or without appointment)
        $log = daily_logs::create([
            'user_id' => $matchedUser['user']->id,
            'appointment_id' => $appointment ? $appointment->id : null, // Null if no appointment
            'store_id' => session('active_branch_id'), // Capture active branch from session
        ]);

        Log::info("Visit logged successfully for user {$matchedUser['user']->id} via face recognition");

        return response()->json([
            'status' => 'success',
            'message' => $appointment 
                ? 'Visit logged successfully!' 
                : 'Visit logged successfully! (No appointment found)',
            'user_name' => $matchedUser['user']->full_name,
            'redirect' => route('logs'),
            'appointment' => $appointment ? [
                'name' => $matchedUser['user']->name,
                'branch' => $appointment->store->name ?? 'N/A',
                'time' => $appointment->appointment_time,
                'status' => $appointment->status,
            ] : null
        ]);

    } catch (Exception $e) {
        Log::error('Face Scan Error: ' . $e->getMessage());
        
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred during face recognition. Please try again.'
        ], 500);

    } finally {
        if ($tempImagePath && file_exists($tempImagePath)) {
            @unlink($tempImagePath);
        }
    }
}

/**
 * Find matching user by comparing face with all registered users
 */
private function findMatchingUser($scannedFaceToken)
{
    // Get all users with registered faces
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

    // Return match only if confidence is above threshold
    if ($bestMatch && $highestConfidence > self::FACE_MATCH_THRESHOLD) {
        return [
            'user' => $bestMatch,
            'confidence' => $highestConfidence
        ];
    }

    return null;
}

public function logs(Request $request)
{
    $date = $request->input('date', Carbon::today()->toDateString());

    // Get logs for selected date
    $logs = daily_logs::with(['user', 'appointment.store', 'store'])
        ->whereDate('scanned_at', $date)
        ->latest('scanned_at')
        ->get();

    // No need for users variable anymore since we removed the dropdown
    return view('admin.visit-logs', compact('logs', 'date'));
}

    // Helper methods
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
                    'api_key' => $this->apiKey,
                    'api_secret' => $this->apiSecret,
                ]);

            $data = $response->json();

            if (isset($data['error_message'])) {
                Log::error('Face++ Detect Error: ' . $data['error_message']);
                return null;
            }

            if (isset($data['faces'][0]['face_token'])) {
                return $data['faces'][0]['face_token'];
            }

            return null;

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
                    'api_key' => $this->apiKey,
                    'api_secret' => $this->apiSecret,
                    'face_token1' => $faceToken1,
                    'face_token2' => $faceToken2,
                ]);

            $data = $response->json();

            if (isset($data['error_message'])) {
                Log::error('Face++ Compare Error: ' . $data['error_message']);
                return null;
            }

            if (isset($data['confidence'])) {
                return $data['confidence'];
            }

            return null;

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