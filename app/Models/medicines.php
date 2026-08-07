<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class medicines extends Model
{
    use SoftDeletes;

    //
     protected $fillable = [
        'name',
        'unit',
        'price',         // ← global price
        'description',
    ];

    // One medicine has many batches
    public function batches()
    {
        return $this->hasMany(medicine_batches::class, 'medicine_id');
    }
    public function movements()
    {
        return $this->hasMany(MedicineMovement::class, 'medicine_id');
    }
}
