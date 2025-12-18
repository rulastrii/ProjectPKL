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

    /** polymorphic pengajuan (PKL / Mahasiswa) */
    public function pengajuan()
    {
        return $this->morphTo();
    }

    /** Pembimbing belongs to pegawai */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}

