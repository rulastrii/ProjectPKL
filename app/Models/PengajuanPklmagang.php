<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
    use App\Models\Penempatan;

class PengajuanPklmagang extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pklmagang';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'no_surat',
        'tgl_surat',
        'sekolah_id',
        'jumlah_siswa',
        'periode_mulai',
        'periode_selesai',
        'status',
        'file_surat_path',
        'catatan',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_id',
        'deleted_date',
        'is_active',
        'email_guru',
        'user_id', // tetap ada
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
        'deleted_date' => 'datetime',
        'periode_mulai' => 'datetime',
        'periode_selesai' => 'datetime',
    ];

    /** Relasi ke tabel sekolah */
    public function sekolah() {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    /** Relasi ke siswa per pengajuan */
    public function siswa() {
        return $this->hasMany(PengajuanPklSiswa::class, 'pengajuan_id', 'id');
    }

    public function penempatan()
{
    return $this->morphOne(
        Penempatan::class,
        'pengajuan',
        'pengajuan_type',
        'pengajuan_id'
    )->where('is_active', 1);
}


    public function pembimbing() {
        return $this->morphMany(Pembimbing::class, 'pengajuan');
    }
    
}
