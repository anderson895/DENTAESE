<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class daily_logs extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'appointment_id',
        'store_id',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    /**
     * Automatically set scanned_at timestamp when creating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($log) {
            if (!$log->scanned_at) {
                $log->scanned_at = now();
            }
        });
    }

    /**
     * Get the user that owns the log
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appointment associated with the log
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the store/branch where the visit was logged
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}