<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    protected $casts = [
        'open_days' => 'array',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
    ];
    public function staff()
{
   return $this->belongsToMany(User::class, 'store_staff')
                ->using(StoreStaff::class)     
                ->withPivot('position')        
                ->withTimestamps();  
}

public function messages()
{
    return $this->hasMany(Message::class);
}

public function scheduleOverrides()
{
    return $this->hasMany(StoreScheduleOverride::class);
}

public function isOpenOn(string $date): bool
{
    $override = $this->scheduleOverrides()->where('schedule_date', $date)->first();
    if ($override) {
        return (bool) $override->is_open;
    }
    $day = strtolower(\Carbon\Carbon::parse($date)->format('D'));
    return in_array($day, $this->open_days ?? []);
}

public function hoursOn(string $date): array
{
    $override = $this->scheduleOverrides()->where('schedule_date', $date)->first();
    $opening = $override?->opening_time ?: optional($this->opening_time)->format('H:i');
    $closing = $override?->closing_time ?: optional($this->closing_time)->format('H:i');
    return [
        'opening_time' => $opening ? \Carbon\Carbon::parse($opening)->format('H:i') : null,
        'closing_time' => $closing ? \Carbon\Carbon::parse($closing)->format('H:i') : null,
    ];
}

}
