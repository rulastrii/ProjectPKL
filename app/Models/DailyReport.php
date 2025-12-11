<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $table = 'daily_report';
    public $timestamps = false;

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'ringkasan',
        'kendala',
        'screenshot',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_date',
        'deleted_id',
        'is_active'
    ];

    /**
     * Relasi ke siswa profile (many to one)
     */
    public function siswa()
    {
        return $this->belongsTo(SiswaProfile::class, 'siswa_id');
    }

    // Optional accessor agar tanggal lebih enak ditampilkan
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal ? \Carbon\Carbon::parse($this->tanggal)->format('d M Y') : '-';
    }
}
