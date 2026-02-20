<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('penilaian_akhir', function (Blueprint $table) {
        $table->id();

        $table->foreignId('siswa_id')
              ->constrained('siswa_profile')
              ->cascadeOnDelete();

        $table->foreignId('pembimbing_id')
              ->constrained('pembimbing')
              ->cascadeOnDelete();

        $table->float('nilai_tugas')->nullable();
        $table->float('nilai_laporan')->nullable();
        $table->float('nilai_keaktifan')->nullable();
        $table->float('nilai_sikap')->nullable();

        $table->float('nilai_akhir')->nullable();

        $table->date('periode_mulai')->nullable();
        $table->date('periode_selesai')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_akhir');
    }
};
