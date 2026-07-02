<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentChildLink extends Model
{
    protected $fillable = [
        'parent_user_id',
        'child_user_id',
        'relationship',
        'status',
        'verification_token',
        'token_expires_at',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    public function child()
    {
        return $this->belongsTo(User::class, 'child_user_id');
    }
}
