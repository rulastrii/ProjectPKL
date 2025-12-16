<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileGuru extends Model
{
    use HasFactory;

    protected $table = 'profile_guru';
    protected $primaryKey = 'id_guru';

    // Karena tidak pakai timestamps bawaan Laravel
    public $timestamps = false;

    /* =========================
     * MASS ASSIGNMENT
     * ========================= */
    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'tanggal_lahir',
        'unit_kerja',
        'email_resmi',
        'no_hp',
        'jabatan',
        'status_kepegawaian',
        'is_active',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_date',
        'deleted_id',
    ];

    /* =========================
     * CASTING
     * ========================= */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_date'  => 'datetime',
        'updated_date'  => 'datetime',
        'deleted_date'  => 'datetime',
        'is_active'     => 'boolean',
    ];

    /* =========================
     * RELATIONS
     * ========================= */

    // Relasi ke akun user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Audit relations
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_id');
    }

    /* =========================
     * SCOPES
     * ========================= */

    // Data guru aktif
    public function scopeActive($query)
    {
        return $query
            ->where('is_active', true)
            ->whereNull('deleted_date');
    }

    // Guru yang boleh register (belum punya akun)
    public function scopeCanRegister($query)
    {
        return $query
            ->active()
            ->where('jabatan', 'guru')
            ->where('status_kepegawaian', 'aktif')
            ->whereNull('user_id');
    }
}
