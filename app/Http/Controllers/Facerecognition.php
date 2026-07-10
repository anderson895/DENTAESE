<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class Facerecognition extends Controller
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
    // REGISTER FACE
    // ===============================
    public function registerFace(Request $request)
    {
        $request->validate([
            'face_descriptor' => 'required|string',
        ]);

        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        $newDescriptor = json_decode($request->input('face_descriptor'), true);

        // Validate descriptor format (face-api.js always returns 128 values)
        if (!$newDescriptor || count($newDescriptor) !== 128) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid face descriptor. Please try again.',
            ], 400);
        }

        try {
            // ===============================
            // CHECK IF FACE ALREADY EXISTS
            // ===============================
            $existingUsers = User::whereNotNull('face_descriptor')
                ->where('id', '!=', $currentUser->id)
                ->get();

            foreach ($existingUsers as $user) {
                $storedDescriptor = json_decode($user->face_descriptor, true);

                if (!$storedDescriptor || count($storedDescriptor) !== 128) continue;

                $distance = $this->euclideanDistance($newDescriptor, $storedDescriptor);

                if ($distance < 0.5) {
                    return response()->json([
                        'status'   => 'error',
                        'message'  => 'This face is already registered to another account.',
                        'distance' => $distance,
                    ], 409);
                }
            }

            // ===============================
            // SAVE FACE DESCRIPTOR
            // ===============================
            $currentUser->face_descriptor = json_encode($newDescriptor);
            $currentUser->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Face registered successfully!',
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Face registration error.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ===============================
    // REMOVE FACE
    // ===============================
    public function removeFaceToken(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->face_descriptor = null;
        $user->face_token = null; // clear legacy column too
        $user->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Face removed successfully.',
        ]);
    }
}