<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';

    // Timestamps dinonaktifkan karena kita pakai custom timestamps
    public $timestamps = false;

    // Fields yang bisa diisi secara massal
    protected $fillable = [
        'nama',
        'npsn',
        'alamat',
        'kontak',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_id',
        'deleted_date',
        'is_active',
    ];

    // Cast fields ke tipe tertentu
    protected $casts = [
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
        'deleted_date' => 'datetime',
        'is_active'    => 'boolean',
    ];

    /**
     * Scope untuk data aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
