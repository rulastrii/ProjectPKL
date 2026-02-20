<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPklSiswa extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pkl_siswa';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'pengajuan_id',
        'siswa_id',
        'nama_siswa',     // tambahkan nama siswa manual
        'email_siswa',
        'status',         // draft, diproses, diterima, ditolak, selesai
        'catatan_admin',
    ];

    protected $casts = [
        'periode_mulai' => 'datetime',
        'periode_selesai' => 'datetime',
    ];

    /** Relasi ke pengajuan utama */
    public function pengajuan() {
        return $this->belongsTo(PengajuanPklmagang::class, 'pengajuan_id', 'id');
    }

    /** Relasi ke siswa profile (opsional) */
    public function siswaProfile() {
        return $this->belongsTo(SiswaProfile::class, 'siswa_id', 'id');
    }
}
