<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_magang_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mahasiswa');
            $table->string('email_mahasiswa')->unique();
            $table->string('universitas');
            $table->string('jurusan')->nullable();
            $table->date('periode_mulai');
            $table->date('periode_selesai');
            $table->string('no_surat')->nullable();
            $table->date('tgl_surat')->nullable();
            $table->string('file_surat_path')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');

            // Audit fields
            $table->unsignedBigInteger('created_id')->nullable();
            $table->timestamp('created_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->timestamp('deleted_date')->nullable();

            $table->boolean('is_active')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_magang_mahasiswa');
    }
};
