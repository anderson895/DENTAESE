<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineMovement extends Model
{
    protected $fillable = [
        'medicine_id',
        'store_id',
        'medicine_batch_id',
        'type',
        'quantity',
        'remarks',
    ];

    /**
     * withTrashed: kasaysayan ito ng stock, kaya dapat makita pa rin ang
     * pangalan ng gamot kahit na-soft-delete na ito — kung hindi, null ang
     * relation at nagba-blangko (o nagka-error) ang mga ulat.
     */
    public function medicine()
    {
        return $this->belongsTo(medicines::class, 'medicine_id')->withTrashed();
    }

    public function batch()
    {
        return $this->belongsTo(medicine_batches::class, 'medicine_batch_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}

