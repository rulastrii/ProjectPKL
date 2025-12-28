<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PengajuanMagangMahasiswa extends Model
{
    use Notifiable;
    use HasFactory;

    protected $table = 'pengajuan_magang_mahasiswa';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nama_mahasiswa',
        'email_mahasiswa',
        'universitas',
        'jurusan',
        'periode_mulai',
        'periode_selesai',
        'no_surat',
        'tgl_surat',
        'file_surat_path',
        'catatan',
        'status',
        'is_active',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_date',
        'deleted_id',
    ];

    protected $casts = [
        'periode_mulai'  => 'date',
        'periode_selesai'=> 'date',
        'tgl_surat'=> 'date',
        'created_date'   => 'datetime',
        'updated_date'   => 'datetime',
        'deleted_date'   => 'datetime',
        'is_active'      => 'boolean',
    ];
    
    /**
     * Tentukan email tujuan notifikasi
     */
    public function routeNotificationForMail() {
        return $this->email_mahasiswa;
    }
    
    public function pembimbing() {
        return $this->morphMany(Pembimbing::class, 'pengajuan');
    }
 
    public function siswaProfile() {
        return $this->hasOne(SiswaProfile::class, 'pengajuan_id', 'id');
    }

        public function user() {
        return $this->belongsTo(User::class);
    }

}
