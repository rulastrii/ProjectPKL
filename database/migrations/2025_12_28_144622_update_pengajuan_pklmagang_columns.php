<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengajuan_pklmagang', function (Blueprint $table) {
            // Email siswa (optional, bisa diambil dari SiswaProfile->user->email)
            $table->string('email_siswa')->nullable()->after('sekolah_id');

            // Email guru/pengaju (optional, bisa diambil dari users->email via created_id)
            $table->string('email_guru')->nullable()->after('email_siswa');

            // NISN siswa untuk identifikasi unik
            $table->string('nisn')->nullable()->after('email_guru');

            // Optional: bikin kombinasi unik untuk satu siswa di satu pengajuan
            $table->unique(['nisn', 'periode_mulai', 'periode_selesai'], 'unique_siswa_periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_pklmagang', function (Blueprint $table) {
            $table->dropUnique('unique_siswa_periode');
            $table->dropColumn(['email_siswa', 'email_guru', 'nisn']);
        });
    }
};

