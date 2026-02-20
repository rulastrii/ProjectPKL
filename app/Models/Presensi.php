<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';
    protected $primaryKey = 'id';
    public $timestamps = false; // karena tanpa created_at & updated_at default

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'kelengkapan',
        'foto_masuk',
        'foto_pulang',
        'created_id',
        'created_date',
        'updated_id',
        'updated_date',
        'deleted_id',
        'deleted_date',
        'is_active'
    ];

    /**
     * Relasi ke tabel siswa_profile (many to one)
     */
    public function siswa() {
    return $this->belongsTo(SiswaProfile::class, 'siswa_id');
}

public function getNamaAttribute() {
    return optional($this->siswa)->nama ?? 'Tidak diketahui';
}


    
}
