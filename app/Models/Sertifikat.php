<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    protected $fillable = [
        'siswa_id',
        'nomor_sertifikat',
        'nomor_surat',
        'judul',
        'periode_mulai',
        'periode_selesai',
        'tanggal_terbit',
        'file_path',
        'qr_token',
    ];


    public function siswa() {
        return $this->belongsTo(SiswaProfile::class, 'siswa_id');
    }
    
}
