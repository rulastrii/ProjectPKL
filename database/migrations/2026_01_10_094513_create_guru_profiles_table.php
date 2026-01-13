<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('guru_profiles', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel users
            $table->unsignedBigInteger('user_id');

            // data khusus guru
            $table->string('nip', 20)->nullable();
            $table->string('sekolah', 150);

            // path dokumen pendukung (SK / surat tugas / dll)
            $table->string('dokumen_verifikasi')->nullable();

            // status verifikasi oleh admin
            $table->enum('status_verifikasi', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

            // admin yang memverifikasi
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            // foreign key
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('verified_by')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru_profiles');
    }
};
