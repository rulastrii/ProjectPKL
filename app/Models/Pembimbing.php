<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    use HasFactory;

    protected $table = 'pembimbing';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'pengajuan_id',
        'pengajuan_type',
        'pegawai_id',
        'tahun',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_id',
        'deleted_date',
        'is_active',
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
        'deleted_date' => 'datetime',
        'is_active'    => 'boolean',
    ];

    /** Polymorphic pengajuan (PKL / Mahasiswa) */
    public function pengajuan()
    {
        return $this->morphTo();
    }

    /** Relasi ke pegawai */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    /** Relasi ke user (akun pembimbing) */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
