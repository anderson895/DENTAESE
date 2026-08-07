<?php 

// app/Http/Controllers/DentalToothController.php
namespace App\Http\Controllers;

use App\Models\DentalTooth;
use Illuminate\Http\Request;

class DentalToothController extends Controller
{
    public function store(Request $request)
    {
        // Only dentists/doctors may modify the dental chart.
        // Admins, receptionists and patients are view-only.
        $user = auth()->user();
        if (!$user
            || $user->account_type === 'patient'
            || in_array($user->position, ['admin', 'Receptionist'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not allowed to modify the dental chart.',
            ], 403);
        }

        $request->validate([
            'patient_id' => 'required|integer',
            'tooth'      => 'required|string',
            'part'       => 'required|string', // outer-1, inner, etc
            'group'      => 'required|string', // condition, restoration, surgery
            'code'       => 'required|string',
            'color'      => 'required|string',
        ]);

        $tooth = DentalTooth::firstOrCreate(
            [
                'patient_id' => $request->patient_id,
                'tooth'      => $request->tooth,
            ],
            [
                'data' => []
            ]
        );

        $data = $tooth->data ?? [];

        // Save/update specific tooth part
        $data[$request->part] = [
            'group' => $request->group,
            'code'  => $request->code,
            'color' => $request->color,
        ];

        $tooth->update([
            'data' => $data
        ]);

        return response()->json([
            'success' => true,
            'data'    => $tooth
        ]);
    }



        public function fetch($patientId)
    {
        $teeth = DentalTooth::where('patient_id', $patientId)->get();

        return response()->json([
            'success' => true,
            'data' => $teeth
        ]);
    }
}
