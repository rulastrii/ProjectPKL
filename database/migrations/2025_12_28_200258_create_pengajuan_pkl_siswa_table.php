<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_pkl_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_id');
            $table->unsignedBigInteger('siswa_id')->nullable(); // optional reference ke tabel siswa
            $table->string('email_siswa');
            $table->enum('status', ['draft','diproses','diterima','ditolak','selesai'])->default('draft');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->foreign('pengajuan_id')->references('id')->on('pengajuan_pklmagang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pkl_siswa');
    }
};
