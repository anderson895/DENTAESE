<?php 
// app/Models/DentalTooth.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalTooth extends Model
{
    protected $fillable = [
        'patient_id',
        'tooth',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];
}
