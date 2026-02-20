<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum status
        Schema::table('pengajuan_magang_mahasiswa', function (Blueprint $table) {
            $table->enum('status', ['draft','diproses','diterima','ditolak','selesai'])
                  ->default('draft')
                  ->change();
        });

        // Jika menggunakan MySQL versi lama dan tidak support change() langsung di enum:
        // DB::statement("ALTER TABLE pengajuan_magang_mahasiswa MODIFY status ENUM('draft','diproses','diterima','ditolak','selesai') DEFAULT 'draft'");
    }

    public function down(): void
    {
        // Kembalikan ke enum lama
        Schema::table('pengajuan_magang_mahasiswa', function (Blueprint $table) {
            $table->enum('status', ['pending','approved','rejected'])->default('pending')->change();
        });
    }
};
