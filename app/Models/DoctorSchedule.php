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

    /**
     * Hanapin ang schedule ng dentista sa isang petsa para sa isang branch.
     *
     * Naka-save ang bawat entry kasama ang store_id, kaya dapat branch-specific
     * din ang paghahanap — kung hindi, ang day-off niya sa ibang branch ay
     * nakakabura ng timeslots sa branch na binu-book. Ang entry na walang
     * store_id ay pang-lahat ng branch, pero mas nangingibabaw ang tugmang
     * branch kapag pareho silang may laman sa parehong araw.
     */
    public static function forDentistOn($dentistId, $date, $storeId = null)
    {
        return static::where('dentist_id', $dentistId)
            ->where('schedule_date', \Carbon\Carbon::parse($date)->toDateString())
            ->where(function ($q) use ($storeId) {
                $q->whereNull('store_id');
                if ($storeId) {
                    $q->orWhere('store_id', $storeId);
                }
            })
            ->orderByRaw('store_id IS NULL')
            ->first();
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
