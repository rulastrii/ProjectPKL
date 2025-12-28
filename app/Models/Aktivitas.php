<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    use HasFactory;
    protected $table = 'aktivitas';
    public $timestamps = false;

    protected $fillable = [
        'pegawai_id',
        'siswa_id',
        'nama',
        'aksi',
        'sumber',
        'ref_id',
        'created_at'
    ];
    
}
