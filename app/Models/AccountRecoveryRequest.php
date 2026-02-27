<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountRecoveryRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'reason',
        'status',
        'admin_note',
        'handled_by',
        'handled_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}


