<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';
    public $timestamps = false;

    protected $fillable = [
        'pembimbing_id',
        'judul',
        'deskripsi',
        'tenggat',
        'status',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_date',
        'deleted_id',
        'is_active'
    ];

    /**
     * Relasi ke pembimbing (many to one)
     */
    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'pembimbing_id');
    }


    public function tugasAssignees()
{
    return $this->hasMany(TugasAssignee::class, 'tugas_id');
}
public function submits()
{
    return $this->hasMany(TugasSubmit::class, 'tugas_id');
}

// Tugas.php
public function creator()
{
    return $this->belongsTo(User::class, 'created_id');
}

public function updater()
{
    return $this->belongsTo(User::class, 'updated_id');
}

    /**
     * Accessor format waktu tenggat
     */
    public function getTenggatFormattedAttribute()
    {
        return $this->tenggat ? \Carbon\Carbon::parse($this->tenggat)->format('d M Y H:i') : '-';
    }
}
