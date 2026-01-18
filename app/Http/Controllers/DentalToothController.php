<?php 

// app/Http/Controllers/DentalToothController.php
namespace App\Http\Controllers;

use App\Models\DentalTooth;
use Illuminate\Http\Request;

class DentalToothController extends Controller
{
    public function store(Request $request)
    {
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
