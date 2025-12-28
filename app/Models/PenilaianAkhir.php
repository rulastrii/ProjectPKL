<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianAkhir extends Model
{
    use HasFactory;

    protected $table = 'penilaian_akhir';

    protected $fillable = [
        'siswa_id',
        'pembimbing_id',
        'periode_mulai',
        'periode_selesai',
        'nilai_tugas',
        'nilai_laporan',
        'nilai_keaktifan',
        'nilai_sikap',
        'nilai_akhir',
    ];

    // Relasi ke siswa
    public function siswa() {
        return $this->belongsTo(SiswaProfile::class, 'siswa_id');
    }

    // Fungsi hitung nilai akhir
    public function hitungNilaiAkhir() {
        $this->nilai_akhir = ($this->nilai_tugas * 0.5) +
                             ($this->nilai_laporan * 0.3) +
                             ($this->nilai_keaktifan * 0.1) +
                             ($this->nilai_sikap * 0.1);
        $this->save();
    }
    
}
