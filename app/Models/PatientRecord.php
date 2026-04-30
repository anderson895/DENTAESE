<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    protected $fillable = [
        'user_id',
        'last_name', 'first_name', 'middle_name', 'nickname',
        'birthdate', 'sex',
        'nationality', 'religion', 'occupation',
        'home_address', 'home_no',
        'office_address', 'office_no', 'fax_no',
        'dental_insurance', 'effective_date',
        'contact_number', 'email',
        'parent_guardian_name', 'parent_guardian_occupation',
        'referred_by', 'reason_for_consultation',
        'previous_dentist', 'last_dental_visit',
        'physician_name', 'physician_specialty', 'physician_contact',
        'in_good_health', 'under_treatment', 'had_illness_operation',
        'hospitalized', 'taking_medication', 'allergic', 'bleeding_time',
        'allergic_lidocaine', 'allergic_penicillin', 'allergic_sulfa',
        'allergic_aspirin', 'allergic_latex', 'allergic_others',
        'pregnant', 'nursing', 'birth_control_pills',
        'blood_type', 'blood_pressure',
        'health_conditions', 'medical_conditions',
        'profile_completed',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'effective_date' => 'date',
        'health_conditions' => 'array',
        'medical_conditions' => 'array',
        'in_good_health' => 'boolean',
        'under_treatment' => 'boolean',
        'had_illness_operation' => 'boolean',
        'hospitalized' => 'boolean',
        'taking_medication' => 'boolean',
        'allergic' => 'boolean',
        'bleeding_time' => 'boolean',
        'allergic_lidocaine' => 'boolean',
        'allergic_penicillin' => 'boolean',
        'allergic_sulfa' => 'boolean',
        'allergic_aspirin' => 'boolean',
        'allergic_latex' => 'boolean',
        'pregnant' => 'boolean',
        'nursing' => 'boolean',
        'birth_control_pills' => 'boolean',
        'profile_completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
