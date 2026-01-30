<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class Facerecognition extends Controller
{
    //
    private $apiKey = '-2y7KYjX1JuFECsjI_ANCAM5pugEm5R0';
    private $apiSecret = 'QHRO96q2sagJUJ-4DAgVgmBDa2-H3n8v';


    // OLD FUNCTION
    // public function registerFace(Request $request)
    // {
    //     $request->validate([
    //         'face_image' => 'required|image',
    //     ]);

    //     $image = $request->file('face_image');

    //     // Call Face++ detect API
    //     $response = Http::attach(
    //         'image_file',
    //         file_get_contents($image),
    //         $image->getClientOriginalName()
    //     )->post('https://api-us.faceplusplus.com/facepp/v3/detect', [
    //         'api_key' => $this->apiKey,
    //         'api_secret' => $this->apiSecret,
    //     ]);

    //     $data = $response->json();

    //     // Check if face was detected
    //     if (empty($data['faces'][0]['face_token'])) {
    //         return response()->json([
    //             'message' => 'No face detected.',
    //             'api_response' => $data
    //         ], 400);
    //     }

    //     $faceToken = $data['faces'][0]['face_token'];
    //   /** @var \App\Models\User $user */
     
    //     $user = Auth::user(); 
    //     $user->face_token = $faceToken;
    //     $user->save();

    //     return response()->json([
    //         'message' => 'Face registered successfully!',
    //         'face_token' => $faceToken,
    //     ]);
    // }

    public function registerFace(Request $request)
    {
        $request->validate([
            'face_image' => 'required|image',
        ]);

        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        $image = $request->file('face_image');

        try {

            /**
             * STEP 1: DETECT FACE
             */
            $detectResponse = Http::attach(
                'image_file',
                file_get_contents($image),
                $image->getClientOriginalName()
            )->post('https://api-us.faceplusplus.com/facepp/v3/detect', [
                'api_key'    => $this->apiKey,
                'api_secret' => $this->apiSecret,
            ]);

            $detectData = $detectResponse->json();
            $faces = $detectData['faces'] ?? [];

            if (count($faces) === 0) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'No face detected.'
                ], 400);
            }

            if (count($faces) > 1) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Multiple faces detected. Only one face is allowed.'
                ], 422);
            }

            $newFaceToken = $faces[0]['face_token'];

            /**
             * STEP 2: CHECK IF FACE ALREADY EXISTS (OTHER USERS)
             */
            $existingUsers = User::whereNotNull('face_token')
                ->where('id', '!=', $currentUser->id)
                ->get();

            foreach ($existingUsers as $user) {
                $compareResponse = Http::asForm()->post(
                    'https://api-us.faceplusplus.com/facepp/v3/compare',
                    [
                        'api_key'     => $this->apiKey,
                        'api_secret'  => $this->apiSecret,
                        'face_token1' => $user->face_token,
                        'face_token2' => $newFaceToken,
                    ]
                );

                $compareData = $compareResponse->json();

                if (
                    isset($compareData['confidence']) &&
                    $compareData['confidence'] >= 70
                ) {
                    return response()->json([
                        'status'     => 'error',
                        'message'    => 'This face is already registered to another account.',
                        'confidence' => $compareData['confidence']
                    ], 409);
                }
            }

            /**
             * STEP 3: SAVE FACE (UNIQUE)
             */
            $currentUser->face_token = $newFaceToken;
            $currentUser->save();

            return response()->json([
                'status'     => 'success',
                'message'    => 'Face registered successfully!',
                'face_token' => $newFaceToken,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Face recognition service error.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


}
