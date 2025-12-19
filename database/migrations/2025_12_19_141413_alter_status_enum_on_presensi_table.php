<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE presensi 
            MODIFY status ENUM('hadir','izin','sakit','absen') NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE presensi 
            MODIFY status ENUM('hadir','absen','sakit') NOT NULL
        ");
    }
};
