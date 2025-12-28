<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        /**
         * ==============================
         * AUTO GENERATE ABSEN HARIAN
         * ==============================
         * - Jalan setiap hari
         * - Jam 17:05 WIB
         * - Logic skip weekend, izin, sakit
         *   ada di Command
         */
        $schedule->command('app:generate-absen-presensi')
                 ->dailyAt('17:05')
                 ->timezone('Asia/Jakarta')
                 ->withoutOverlapping()
                 ->onOneServer();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}
