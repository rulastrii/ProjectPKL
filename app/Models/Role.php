<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    public $timestamps = false; // karena kamu pakai timestamp custom

    protected $fillable = [
        'name',
        'description',
        'created_date',
        'created_id',
        'updated_date',
        'updated_id',
        'deleted_date',
        'deleted_id',
        'is_active',
    ];

    // Relasi ke users
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
