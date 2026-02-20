<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\DB;
use App\Models\Pegawai;

class ActivateUserAfterEmailVerified
{
    public function handle(Verified $event)
    {
        $user = $event->user;

        DB::transaction(function () use ($user) {

            // Aktifkan user
            $user->update([
                'is_active' => true,
            ]);

            // Jika user ini pegawai → aktifkan pegawai juga
            $pegawai = Pegawai::where('user_id', $user->id)->first();
            if ($pegawai) {
                $pegawai->update([
                    'is_active' => true
                ]);
            }
        });
    }
}
