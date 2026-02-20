<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sertifikat', function (Blueprint $table) {

            // NOMOR SURAT RESMI
            $table->string('nomor_surat')->after('nomor_sertifikat')->unique();

            // TANGGAL TERBIT
            $table->date('tanggal_terbit')->after('periode_selesai');

            // TOKEN QR VERIFIKASI
            $table->string('qr_token')->after('file_path')->unique();
        });
    }

    public function down(): void
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->dropColumn(['nomor_surat', 'tanggal_terbit', 'qr_token']);
        });
    }
};
