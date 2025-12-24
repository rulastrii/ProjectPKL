<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    protected $fillable = [
        'siswa_id',
        'nomor_sertifikat',
        'judul',
        'periode_mulai',
        'periode_selesai',
        'file_path',
    ];

    public function siswa()
    {
        return $this->belongsTo(SiswaProfile::class, 'siswa_id');
    }
}
