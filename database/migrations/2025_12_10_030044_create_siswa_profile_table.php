<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_profile', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY

            // Relasi ke users
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            // Relasi ke pengajuan_pklmagang
            $table->unsignedBigInteger('pengajuan_id')->nullable();
            $table->foreign('pengajuan_id')
                  ->references('id')
                  ->on('pengajuan_pklmagang')
                  ->onDelete('set null');

            $table->string('nama', 100);
            $table->string('nisn', 30)->nullable();
            $table->string('kelas', 50)->nullable();
            $table->string('jurusan', 100)->nullable();
            $table->string('foto', 255)->nullable();

            // Custom timestamps
            $table->timestamp('created_date')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();

            $table->timestamp('updated_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();

            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->timestamp('deleted_date')->nullable();

            $table->boolean('is_active')->default(true);

            // Index untuk mempercepat query
            $table->index(['user_id', 'pengajuan_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_profile');
    }
};
