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
    Schema::create('sertifikat', function (Blueprint $table) {
        $table->id();

        $table->foreignId('siswa_id')
              ->constrained('siswa_profile')
              ->cascadeOnDelete();

        $table->string('nomor_sertifikat')->unique();
        $table->string('judul')->default('Sertifikat Magang / PKL');

        $table->date('periode_mulai');
        $table->date('periode_selesai');

        $table->string('file_path')->nullable(); // path PDF

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
