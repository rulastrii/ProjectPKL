<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasAssignee extends Model
{
    protected $table = 'tugas_assignee';
    public $timestamps = false; // karena memakai custom field created_date, updated_date

    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_date',
        'deleted_id',
        'is_active',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    public function siswa()
    {
        return $this->belongsTo(SiswaProfile::class, 'siswa_id');
    }
}
