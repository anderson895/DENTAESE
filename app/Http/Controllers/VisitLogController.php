<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use App\Models\daily_logs;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class VisitLogController extends Controller
{
    // Lower = stricter match (0.5 is the standard for face-api.js)
    private const FACE_MATCH_THRESHOLD = 0.5;

    // ─────────────────────────────────────────────
    // HELPER: Euclidean Distance
    // ─────────────────────────────────────────────
    private function euclideanDistance(array $a, array $b): float
    {
        $sum = 0;
        foreach ($a as $i => $val) {
            $sum += pow($val - ($b[$i] ?? 0), 2);
        }
        return sqrt($sum);
    }

    // ─────────────────────────────────────────────
    // HELPER: Find today's active appointment
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
    // HELPER: Find matching user via face descriptor
    // ─────────────────────────────────────────────
    private function findMatchingUser(array $scannedDescriptor): ?array
    {
        $users = User::whereNotNull('face_descriptor')->get();

        $bestMatch      = null;
        $lowestDistance = PHP_FLOAT_MAX;

        foreach ($users as $user) {
            $storedDescriptor = json_decode($user->face_descriptor, true);

            if (!$storedDescriptor || count($storedDescriptor) !== 128) continue;

            $distance = $this->euclideanDistance($scannedDescriptor, $storedDescriptor);

            if ($distance < $lowestDistance) {
                $lowestDistance = $distance;
                $bestMatch      = $user;
            }
        }

        // Must be below threshold to be a valid match
        if ($bestMatch && $lowestDistance < self::FACE_MATCH_THRESHOLD) {
            return [
                'user'     => $bestMatch,
                'distance' => $lowestDistance,
            ];
        }

        return null;
    }

    // ─────────────────────────────────────────────
    // HELPER: Log visit (shared logic)
    // ─────────────────────────────────────────────
    private function logVisit(User $user, string $method): array
    {
        // Check if already logged today
        $alreadyLogged = daily_logs::where('user_id', $user->id)
            ->whereDate('scanned_at', Carbon::today())
            ->exists();

        // Find and update today's appointment to arrived
        $appointment = $this->findTodayAppointment($user->id);

        if ($appointment) {
            $appointment->update([
                'status' => 'arrived',
                'arrived_at' => $appointment->arrived_at ?? Carbon::now(),
            ]);
        }

        if ($alreadyLogged) {
            return [
                'status'      => 'warning',
                'message'     => 'You have already logged a visit today.',
                'user_name'   => $user->full_name ?? $user->name,
                'appointment' => null,
            ];
        }

        // Create visit log
        daily_logs::create([
            'user_id'        => $user->id,
            'appointment_id' => $appointment?->id,
            'store_id'       => $appointment?->store_id ?? session('active_branch_id'),
        ]);

        Log::info("Visit logged for user {$user->id} via {$method}");

        return [
            'status'      => 'success',
            'message'     => 'Visit logged successfully!',
            'user_name'   => $user->full_name ?? $user->name,
            'redirect'    => route('logs'),
            'appointment' => $appointment ? [
                'name'   => $user->name,
                'branch' => $appointment->store->name ?? 'N/A',
                'time'   => $appointment->appointment_time,
                'status' => 'arrived',
            ] : null,
        ];
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
                    'message' => 'QR Code not recognized.',
                ], 404);
            }

            $result = $this->logVisit($user, 'QR scan');

            return response()->json($result, $result['status'] === 'warning' ? 200 : 200);

        } catch (\Throwable $e) {
            Log::error('QR Scan Error:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'debug'  => [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ],
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // Face Scan (no Face++ API — uses face_descriptor)
    // ─────────────────────────────────────────────
    public function handleFaceScan(Request $request)
    {
        try {
            $request->validate([
                'face_descriptor' => 'required|string',
            ]);

            $scannedDescriptor = json_decode($request->input('face_descriptor'), true);

            if (!$scannedDescriptor || count($scannedDescriptor) !== 128) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Invalid face descriptor. Please try again.',
                ], 400);
            }

            $matchedUser = $this->findMatchingUser($scannedDescriptor);

            if (!$matchedUser) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Face not recognized. Please make sure you have registered your face.',
                ], 404);
            }

            $user = $matchedUser['user'];

            Log::info("Face recognized: User ID {$user->id}, Distance: {$matchedUser['distance']}");

            $result = $this->logVisit($user, 'face recognition');

            return response()->json($result);

        } catch (Exception $e) {
            Log::error('Face Scan Error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred during face recognition. Please try again.',
            ], 500);
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
}