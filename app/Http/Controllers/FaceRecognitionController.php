<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\User;
use CURLFile;


class FaceRecognitionController extends Controller
{
    //
 
        // private $apiKey = 'd6oKAAzVLTtgRyeecdED4eHFi9wfmq3I';
        // private $apiSecret = 'qe_nYezzGtNwf4WN_drOcrxfeg0ryJ7S';
        
        private $apiKey = '-2y7KYjX1JuFECsjI_ANCAM5pugEm5R0';
        private $apiSecret = 'QHRO96q2sagJUJ-4DAgVgmBDa2-H3n8v';
        private $storedFaceToken = 'eb70acc4760484bcac5e091c58671b00'; 

    public function getLandmarks(Request $request)
    {
        $request->validate([
            'login_face_image' => 'required|image',
        ]);
    
        // Get the uploaded image
        $image = $request->file('login_face_image');
    
      
        $detectResponse = Http::attach(
            'image_file', file_get_contents($image), $image->getClientOriginalName()
        )->post('https://api-us.faceplusplus.com/facepp/v3/detect', [
            'api_key' => $this->apiKey,
            'api_secret' => $this->apiSecret,
        ]);
    
       
    
        // Parse the response
        $detectData = $detectResponse->json();
    
        // If no faces are detected, return an error response
        if (empty($detectData['faces'][0]['face_token'])) {
            return response()->json(['error' => 'No face detected in login image.', 'api_response' => $detectData], 400);
        }
    
        // Extract the face token from the response
        $faceToken2 = $detectData['faces'][0]['face_token'];
    
       
        $verifyResponse = Http::asForm()->post('https://api-us.faceplusplus.com/facepp/v3/compare', [
            'api_key' => $this->apiKey,
            'api_secret' => $this->apiSecret,
            'face_token1' => $this->storedFaceToken,  // Stored face token from DB
            'face_token2' => $faceToken2,
        ]);
    
  
      
    
       
        $verifyData = $verifyResponse->json();
    
       
        if (isset($verifyData['confidence']) && $verifyData['confidence'] > 70) {
            return response()->json(['message' => 'Login successful!', 'verify_data' => $verifyData]);
        } else {
            return response()->json(['message' => 'Login failed. Face does not match.', 'verify_data' => $verifyData], 401);
        }
    }

   public function registerFaceForSignup(Request $request)
{
    $request->validate([
        'face_image' => 'required|image',
    ]);

    $image = $request->file('face_image');

    try {
        /** STEP 1: DETECT FACE **/
        $detectResponse = Http::attach(
            'image_file',
            file_get_contents($image),
            $image->getClientOriginalName()
        )->post('https://api-us.faceplusplus.com/facepp/v3/detect', [
            'api_key' => $this->apiKey,
            'api_secret' => $this->apiSecret,
        ]);

        $detectData = $detectResponse->json();
        $faces = $detectData['faces'] ?? [];

        if (count($faces) === 0) {
            return response()->json(['message' => 'No face detected.'], 400);
        }

        if (count($faces) > 1) {
            return response()->json([
                'message' => 'Multiple faces detected. Only 1 face is allowed.'
            ], 422);
        }

        $newFaceToken = $faces[0]['face_token'];

        /** STEP 2: CHECK IF FACE ALREADY EXISTS **/
        $existingUsers = User::whereNotNull('face_token')->get();

        foreach ($existingUsers as $user) {
            $compareResponse = Http::asForm()->post(
                'https://api-us.faceplusplus.com/facepp/v3/compare',
                [
                    'api_key' => $this->apiKey,
                    'api_secret' => $this->apiSecret,
                    'face_token1' => $user->face_token,
                    'face_token2' => $newFaceToken,
                ]
            );

            $compareData = $compareResponse->json();

            if (isset($compareData['confidence']) && $compareData['confidence'] >= 70) {
                return response()->json([
                    'message' => 'Face already exists. Registration denied.'
                ], 409);
            }
        }

        /** STEP 3: ALLOW REGISTRATION **/
        return response()->json([
            'message' => 'Face is valid and unique.',
            'face_token' => $newFaceToken
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Face++ API error.',
            'error' => $e->getMessage()
        ], 500);
    }
}




}
