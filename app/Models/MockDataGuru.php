<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockDataGuru extends Model
{
    use HasFactory;

    protected $table = 'data_referensi_guru';

    public $timestamps = false;

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'tanggal_lahir',
        'unit_kerja',
        'email_resmi',
        'jabatan',
        'status_kepegawaian',
        'is_active',
        'created_date',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date:Y-m-d',
        'is_active'     => 'boolean',
    ];
}
