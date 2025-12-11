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
        Schema::create('pengajuan_pklmagang', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat', 50)->nullable();
            $table->date('tgl_surat')->nullable();

            // FK ke sekolah
            $table->unsignedBigInteger('sekolah_id')->nullable();
            $table->foreign('sekolah_id')
                ->references('id')->on('sekolah')
                ->onDelete('set null');

            $table->integer('jumlah_siswa')->nullable();
            $table->date('periode_mulai')->nullable();
            $table->date('periode_selesai')->nullable();

            $table->enum('status', ['draft','diproses','diterima','ditolak','selesai'])->default('draft');

            $table->string('file_surat_path',255)->nullable();
            $table->text('catatan')->nullable();

            // Custom timestamp sama format tabel lain
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
        Schema::dropIfExists('pengajuan_pklmagang');
    }
};
