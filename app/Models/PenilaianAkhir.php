<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianAkhir extends Model
{
    protected $table = 'penilaian_akhir';

    protected $fillable = [
        'siswa_id',
        'pembimbing_id',
        'nilai_tugas',
        'nilai_laporan',
        'nilai_keaktifan',
        'nilai_sikap',
        'nilai_akhir',
        'periode_mulai',
        'periode_selesai',
    ];

    public function siswa()
    {
        return $this->belongsTo(SiswaProfile::class, 'siswa_id');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'pembimbing_id');
    }
}
