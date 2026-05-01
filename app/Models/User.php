<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;
  
    protected $dates = ['deleted_at'];

    protected static function booted()
    {
        static::created(function ($user) {
            app(\App\Http\Controllers\QrController::class)->generateUserQr($user);
        });
    }

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        $lastname   = $this->lastname ?? '';
        $firstname  = $this->name ?? '';
        $middlename = $this->middlename ?? '';
        $suffix     = $this->suffix ?? '';

        return trim("{$lastname}, {$firstname} {$middlename} {$suffix}");
    }

    protected $fillable = [
        'name',
        'middlename',
        'lastname',
        'suffix',
        'birth_date',
        'birthplace',
        'birthplace_municipality',
        'birthplace_province',
        'current_address',
        'address_other_details',
        'address_house_number',
        'address_street',
        'address_barangay',
        'address_municipality',
        'address_province',
        'email',
        'contact_number',
        'user',
        'password',
        'account_type',
        'position',
        'status',
        'verification_id',
        'profile_image',
        'qr_code',
        'qr_token',
        'is_consent',
        'face_descriptor',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_staff')
                    ->using(StoreStaff::class)
                    ->withPivot('position')
                    ->withTimestamps();
    }

    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalForm()
    {
        return $this->hasOne(MedicalForm::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function latestMessage()
    {
        $storeId = session('active_branch_id');

        return $this->hasOne(\App\Models\Message::class, 'sender_id', 'id')
            ->where('store_id', $storeId)
            ->latestOfMany();
    }

    public function children()
    {
        return $this->belongsToMany(User::class, 'parent_child_links', 'parent_user_id', 'child_user_id')
                    ->withPivot('relationship')
                    ->withTimestamps();
    }

    public function parents()
    {
        return $this->belongsToMany(User::class, 'parent_child_links', 'child_user_id', 'parent_user_id')
                    ->withPivot('relationship')
                    ->withTimestamps();
    }

    public function isParentOf(int $childUserId): bool
    {
        return $this->children()->where('child_user_id', $childUserId)->exists();
    }
}