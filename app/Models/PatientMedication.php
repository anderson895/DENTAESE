<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PatientMedication extends Model
{
    protected $fillable = [
        'user_id',
        'appointment_id',
        'medicine_name',
        'dosage',
        'frequency',
        'start_date',
        'end_date',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // Active while today is on/before the end date (or no end date set)
    public function getStatusAttribute()
    {
        if ($this->end_date && Carbon::today()->gt($this->end_date)) {
            return 'Completed';
        }
        return 'Active';
    }
}
