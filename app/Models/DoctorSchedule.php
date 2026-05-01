<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $fillable = [
        'dentist_id',
        'store_id',
        'schedule_date',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'start_time'    => 'datetime:H:i',
        'end_time'      => 'datetime:H:i',
    ];

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
