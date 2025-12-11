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

    /** Pembimbing belongs to satu pengajuan PKL */
    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPklmagang::class, 'pengajuan_id');
    }

    /** Pembimbing belongs to satu pegawai */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
