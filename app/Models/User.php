<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    // Timestamps dinonaktifkan karena kita pakai custom timestamps
    public $timestamps = false;

    // Fields yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_id',
        'deleted_date',
        'is_active',
    ];

    // Fields yang disembunyikan saat serialisasi
    protected $hidden = [
        'password',
    ];

    protected $casts = [
    'created_date' => 'datetime', // otomatis jadi Carbon
];

    /**
     * Relasi ke role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function siswaProfile()
{
    return $this->hasOne(SiswaProfile::class,'user_id');
}


    /**
     * Mutator untuk hash password otomatis saat diset
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Scope untuk data aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
