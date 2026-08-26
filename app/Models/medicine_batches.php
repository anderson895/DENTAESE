<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class medicine_batches extends Model
{
    //
      protected $fillable = [
        'medicine_id',
        'store_id',
        'quantity',
        'expiration_date',
        'status',
    ];

    /**
     * withTrashed: puwedeng ma-soft-delete ang gamot habang may natitira pang
     * expired/suspended na batch (tingnan ang InventoryController::destroy).
     * Kung walang ito, null ang relation at nagiging "—" ang pangalan sa
     * archived list — o nagka-fatal error ang mga pahinang umaasa dito.
     */
    public function medicine()
    {
        return $this->belongsTo(medicines::class, 'medicine_id')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id'); 
    }

    public function movements()
    {
        return $this->hasMany(MedicineMovement::class, 'medicine_batch_id');
    }
}
