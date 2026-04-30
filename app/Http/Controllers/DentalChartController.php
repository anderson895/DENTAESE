<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\PatientRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DentalChartController extends Controller
{
    //
    public function store(Request $request)
    {
        $user = Auth::user();
        $user->is_consent = true;
        $user->save();

        $hasCompletedProfile = PatientRecord::where('user_id', $user->id)
            ->where('profile_completed', true)
            ->exists();

        $redirectRoute = $hasCompletedProfile ? 'CBookingo' : 'CForms';

        return redirect()->route($redirectRoute)->with('success', 'Thank you. Your informed consent has been recorded.');
    }

    public function storeRecord(Request $request)
    {
        $data = $request->all();

        // Handle checkboxes (if not checked, Laravel doesn’t send them, so default to 0)
        $checkboxes = [
            'in_good_health', 'under_treatment', 'had_illness_operation',
            'hospitalized', 'taking_medication', 'allergic', 'bleeding_time',
            'pregnant', 'nursing', 'birth_control_pills'
        ];

        foreach ($checkboxes as $checkbox) {
            $data[$checkbox] = $request->has($checkbox) ? 1 : 0;
        }

        // Arrays for checkboxes
        $data['health_conditions'] = $request->input('health_conditions', []);
        $data['medical_conditions'] = $request->input('medical_conditions', []);

        PatientRecord::create($data);

        return redirect()->back()->with('success', 'Patient record saved successfully!');
    }

    public function treatmentRecord(User $patient)
    {
   
        $record = $patient->appointment; // This returns a collection (even if empty)
    
        return view('admin.dental-chart.treatment-record', compact('record'));
    }

    public function showForm(User $patient)
    {
        $userId = $patient->id;
        $patientinfo = null;
        $patientinfo = PatientRecord::firstOrCreate(
            ['user_id' => $userId],
            ['user_id' => $userId]
        );

        return view('client.patient_record', compact('patientinfo'));
    }

    // Store or update patient record (PDA format)
    public function storeOrUpdatePatientRecord(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',

            // Demographics
            'last_name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'sex' => 'nullable|in:M,F',
            'religion' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'home_address' => 'nullable|string|max:500',
            'home_no' => 'nullable|string|max:50',
            'office_address' => 'nullable|string|max:500',
            'office_no' => 'nullable|string|max:50',
            'fax_no' => 'nullable|string|max:50',
            'dental_insurance' => 'nullable|string|max:255',
            'effective_date' => 'nullable|date',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'parent_guardian_name' => 'nullable|string|max:255',
            'parent_guardian_occupation' => 'nullable|string|max:255',

            // Dental & Medical history
            'referred_by' => 'nullable|string|max:255',
            'reason_for_consultation' => 'nullable|string|max:500',
            'previous_dentist' => 'nullable|string|max:255',
            'last_dental_visit' => 'nullable|string|max:255',
            'physician_name' => 'nullable|string|max:255',
            'physician_specialty' => 'nullable|string|max:255',
            'physician_contact' => 'nullable|string|max:50',
            'blood_type' => 'nullable|string|max:10',
            'blood_pressure' => 'nullable|string|max:20',
            'allergic_others' => 'nullable|string|max:255',

            // Arrays
            'medical_conditions' => 'nullable|array',
            'medical_conditions.*' => 'string',
            'health_conditions' => 'nullable|array',
            'health_conditions.*' => 'string',
        ]);

        // Yes/No radios — accept 1 or 0 strings
        $radioFields = [
            'in_good_health','under_treatment','had_illness_operation','hospitalized',
            'taking_medication','allergic','bleeding_time','pregnant','nursing','birth_control_pills',
        ];
        foreach ($radioFields as $field) {
            $value = $request->input($field);
            if ($value === null || $value === '') continue;
            $data[$field] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        // Allergy checkboxes
        $allergyCheckboxes = [
            'allergic_lidocaine','allergic_penicillin','allergic_sulfa',
            'allergic_aspirin','allergic_latex',
        ];
        foreach ($allergyCheckboxes as $field) {
            $data[$field] = $request->has($field);
        }

        $userId = $request->user_id;
        $record = PatientRecord::firstOrNew(['user_id' => $userId]);
        $wasFirstSubmission = !$record->profile_completed;
        $record->fill($data);
        $record->profile_completed = true;
        $record->save();

        // Mark user.formstatus = 1 once the PDA form is completed
        if ($record->user_id) {
            User::where('id', $record->user_id)->update(['formstatus' => 1]);
        }

        $payload = [
            'status' => 'success',
            'message' => 'Patient record saved successfully',
        ];

        // First-time submission redirects to the booking dashboard
        if ($wasFirstSubmission && auth()->check() && auth()->id() == $record->user_id) {
            $payload['redirect'] = route('CBookingo');
        }

        return response()->json($payload);
    }
}
