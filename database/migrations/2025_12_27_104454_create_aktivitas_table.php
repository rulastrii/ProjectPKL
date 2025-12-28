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
        Schema::create('aktivitas', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('pegawai_id')->nullable();
    $table->unsignedBigInteger('siswa_id')->nullable();

    $table->string('nama');          // Rara
    $table->string('aksi');          // mengisi laporan harian
    $table->string('sumber');        // laporan | presensi | tugas
    $table->unsignedBigInteger('ref_id')->nullable(); // id laporan / presensi / submit

    $table->timestamp('created_at');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitas');
    }
};
