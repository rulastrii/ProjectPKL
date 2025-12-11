<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penempatan extends Model
{
    use HasFactory;

    protected $table = 'penempatan';
    public $timestamps = false;

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    protected $fillable = [
        'pengajuan_id','bidang_id',
        'created_date','created_id','updated_date','updated_id',
        'deleted_date','deleted_id','is_active'
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPklmagang::class,'pengajuan_id');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class,'bidang_id');
    }
}
