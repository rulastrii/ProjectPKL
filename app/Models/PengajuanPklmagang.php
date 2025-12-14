<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
        'deleted_date' => 'datetime',
    ];

    /** Relasi ke tabel sekolah */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class,'sekolah_id');
    }


public function siswaProfile()
{
    return $this->hasOne(SiswaProfile::class, 'pengajuan_id', 'id');
}



    public function pembimbing()
{
    return $this->hasMany(Pembimbing::class, 'pengajuan_id');
}

}
