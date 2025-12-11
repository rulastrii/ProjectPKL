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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY

            // FK ke siswa_profile
            $table->unsignedBigInteger('siswa_id')->nullable();
            $table->foreign('siswa_id')
                  ->references('id')
                  ->on('siswa_profile')
                  ->onDelete('set null');

            $table->date('tanggal')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();

            $table->enum('status', ['hadir','absen','sakit'])->default('hadir');
            $table->string('foto', 255)->nullable();

            // Timestamp custom
            $table->timestamp('created_date')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->timestamp('deleted_date')->nullable();

            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
