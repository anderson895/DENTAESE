<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
     protected $fillable = [
        'store_id',
        'user_id',
        'total_amount',
        'amount_given',
        'change_amount',
        'payment_method',
        'status',
        'remarks',
        'patient_id',
        'appointment_id',
    ];

    /**
     * Lahat ng POS sale na kabilang sa isang appointment.
     *
     * Direktang ugnayan ang gamit kapag galing ang bentahan sa "Open POS for
     * this Patient". Kasama pa rin ang lumang paraan ng pagtutugma (pasyente +
     * branch + petsa ng appointment) para hindi mawala ang mga naunang record
     * na wala pang appointment_id.
     *
     * Hindi kasama ang VOID — inalis na 'yon ng kahera at naibalik na ang
     * stock, kaya hindi na dapat lumitaw sa singil, sa Treatment Record, o sa
     * resibo. Dito ito isinasala para sabay maayos ang lahat ng gumagamit.
     * Tandaan: 'void' ang halaga sa enum ng `sales.status`, hindi 'voided'.
     */
    public function scopeForAppointment($query, $appointment)
    {
        return $query->where('status', '!=', 'void')->where(function ($q) use ($appointment) {
            $q->where('appointment_id', $appointment->id)
              ->orWhere(function ($legacy) use ($appointment) {
                  $legacy->whereNull('appointment_id')
                         ->where('patient_id', $appointment->user_id)
                         ->where('store_id', $appointment->store_id)
                         ->whereDate('created_at', $appointment->appointment_date);
              });
        });
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
public function patient()
{
    return $this->belongsTo(User::class, 'patient_id')->where('account_type', 'patient')->withTrashed();
}

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
