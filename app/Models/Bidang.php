<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidang';

    // Nonaktifkan timestamps default karena kita pakai custom
    public $timestamps = false;

    // Fields yang bisa diisi massal
    protected $fillable = [
        'nama',
        'kode',
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
        'is_active'    => 'boolean',
    ];

    /**
     * Scope untuk data aktif
     */
    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_id');
    }

    public function updater() {
        return $this->belongsTo(User::class, 'updated_id');
    }

}
