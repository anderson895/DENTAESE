<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'store_id',
        'to_store_id', // branch na tatanggap (branch-to-branch lang)
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
        'file_path',   // ✅ ADD
        'type'         // ✅ ADD (text | file)
    ];

    /**
     * Buong usapan ng dalawang branch, magkabilang direksyon.
     */
    public function scopeBetweenBranches($query, $storeId, $otherStoreId)
    {
        return $query->where(function ($q) use ($storeId, $otherStoreId) {
            $q->where(function ($sent) use ($storeId, $otherStoreId) {
                $sent->where('store_id', $storeId)->where('to_store_id', $otherStoreId);
            })->orWhere(function ($received) use ($storeId, $otherStoreId) {
                $received->where('store_id', $otherStoreId)->where('to_store_id', $storeId);
            });
        });
    }

    /**
     * Usapan ng pasyente at branch — walang to_store_id ang mga ito.
     */
    public function scopePatientThread($query)
    {
        return $query->whereNull('to_store_id');
    }

    public function toStore()
    {
        return $this->belongsTo(Store::class, 'to_store_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->withTrashed();
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}

