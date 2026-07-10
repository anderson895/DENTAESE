<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientMedication;

class PatientMedicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);

        $medication = PatientMedication::create($validated);

        return response()->json([
            'message' => 'Medication added successfully.',
            'medication' => $medication,
        ]);
    }

    public function update(Request $request, $id)
    {
        $medication = PatientMedication::findOrFail($id);

        $validated = $request->validate([
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);

        $medication->update($validated);

        return response()->json([
            'message' => 'Medication updated successfully.',
            'medication' => $medication,
        ]);
    }

    public function destroy($id)
    {
        $medication = PatientMedication::findOrFail($id);
        $medication->delete();

        return response()->json([
            'message' => 'Medication removed successfully.',
        ]);
    }
}
