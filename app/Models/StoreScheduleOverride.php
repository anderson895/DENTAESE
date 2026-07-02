<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreScheduleOverride extends Model
{
    protected $fillable = [
        'store_id',
        'schedule_date',
        'is_open',
        'opening_time',
        'closing_time',
        'reason',
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'is_open'       => 'boolean',
        'opening_time'  => 'datetime:H:i',
        'closing_time'  => 'datetime:H:i',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
