<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaProfile extends Model
{
    protected $table = 'siswa_profile';  
    protected $primaryKey = 'id';
    public $timestamps = false; // karena tidak menggunakan created_at & updated_at default

    protected $fillable = [
        'user_id',
        'pengajuan_id',
        'nama',
        'nisn',
        'kelas',
        'jurusan',
        'foto',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_id',
        'deleted_date',
        'is_active'
    ];

    /**
     * Relasi ke Users
     * One to One (1 siswa_profile dimiliki 1 user)
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Relasi ke tabel pengajuan_pklmagang
     */
    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPklMagang::class, 'pengajuan_id');
    }

    public function isLengkap(): bool
{
    return !empty($this->nama)
        && !empty($this->nisn)
        && !empty($this->kelas)
        && !empty($this->jurusan)
        && !empty($this->foto);
}
    
}
