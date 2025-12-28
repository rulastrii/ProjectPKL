<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaProfile extends Model
{
    protected $table = 'siswa_profile';  
    protected $primaryKey = 'id';
    public $timestamps = false; 

    protected $fillable = [
        'user_id',
        
    'pengajuan_id',        // MAGANG MAHASISWA
    'pengajuanpkl_id',    // PKL (GURU) 
        'nama',
        'nisn',
        'nim',
        'kelas',
        'jurusan',
        'universitas',
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
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function penilaianAkhir() {
        return $this->hasOne(PenilaianAkhir::class, 'siswa_id');
    }

    public function sertifikat() {
        return $this->hasOne(Sertifikat::class, 'siswa_id');
    }

    public function laporan() {
        return $this->hasMany(DailyReport::class, 'siswa_id');
    }

    /**
         * Relasi ke penempatan
         * 1 siswa punya 1 penempatan aktif
         */
    /**public function penempatan() {
        return $this->hasOne(Penempatan::class, 'pengajuan_id')
                    ->where('pengajuan_type', 'siswa')
                    ->where('is_active', 1);
    }*/


    public function penempatan() {
    return $this->hasOne(Penempatan::class, 'siswa_id')
                ->where('is_active', 1);
}

    

    public function tugasSubmit() {
        return $this->hasMany(TugasSubmit::class, 'siswa_id');
    }

    public function pembimbing() {
        return $this->hasMany(\App\Models\Pembimbing::class, 'siswa_id');
    }

    /**
     * Relasi ke tabel pengajuan_pklmagang
     */
    public function pengajuan() {
    return $this->belongsTo(PengajuanMagangMahasiswa::class, 'pengajuan_id');
}

public function pengajuanpkl() { 
    return $this->belongsTo(PengajuanPklmagang::class, 'pengajuanpkl_id'); 
}


    public function isLengkap(): bool {
        if($this->user->role_id == 4){ // PKL
            return !empty($this->nama)
                && !empty($this->nisn)
                && !empty($this->kelas)
                && !empty($this->jurusan)
                && !empty($this->foto);
        } elseif($this->user->role_id == 5){ // Mahasiswa Magang
            return !empty($this->nama)
                && !empty($this->nim)
                && !empty($this->jurusan)
                && !empty($this->universitas)
                && !empty($this->foto);
        }
        return false;
    }

    public function bidang() {
        return $this->belongsTo(Bidang::class, 'bidang_id'); // pastikan nama kolomnya benar
    }

}
