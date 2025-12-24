<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DailyReport;

class DailyReportPolicy
{
    /**
     * Pembimbing boleh verifikasi
     * HANYA jika laporan BELUM diverifikasi
     */
    public function verify(User $user, DailyReport $report): bool
    {
        // role pembimbing (sesuaikan kalau beda)
        if ($user->role_id != 2) {
            return false;
        }

        // ❗ BELUM diverifikasi → BOLEH
        if (is_null($report->status_verifikasi)) {
            return true;
        }

        // SUDAH diverifikasi → LOCK
        return false;
    }

}
