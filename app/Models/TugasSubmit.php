<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasSubmit extends Model
{
    protected $table = 'tugas_submit';
    public $timestamps = false; 

    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'catatan',
        'link_lampiran',
        'file',
        'submitted_at',
        'is_late',
        'late_days',
        'late_penalty',
        'status',
        'skor',
        'feedback',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_date',
        'deleted_id',
        'is_active',
    ];

    protected $casts = [
    'submitted_at' => 'datetime',
];


    public function tugas() {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    public function siswa() {
        return $this->belongsTo(SiswaProfile::class, 'siswa_id');
    }
    
}

