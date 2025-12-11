<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'nip', 'nama', 'jabatan', 'bidang_id',
        'created_date', 'created_id', 'updated_date', 'updated_id',
        'deleted_id', 'deleted_date', 'is_active'
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
        'deleted_date' => 'datetime',
        'is_active'    => 'boolean',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function pembimbing()
{
    return $this->hasMany(Pembimbing::class, 'pegawai_id');
}

/** relasi langsung ke pengajuan melalui pivot pembimbing */
public function pengajuan()
{
    return $this->belongsToMany(PengajuanPklmagang::class, 'pembimbing', 'pegawai_id', 'pengajuan_id')
                ->withPivot('tahun')
                ->withTimestamps();
}


}
