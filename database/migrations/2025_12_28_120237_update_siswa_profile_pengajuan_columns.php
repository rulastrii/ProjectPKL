<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa_profile', function (Blueprint $table) {

            //  HAPUS FK LAMA (PKL)
            $table->dropForeign(['pengajuan_id']);

            //  UBAH pengajuan_id → MAGANG MAHASISWA
            $table->foreign('pengajuan_id')
                  ->references('id')
                  ->on('pengajuan_magang_mahasiswa')
                  ->onDelete('set null');

            //  TAMBAH kolom pengajuan PKL
            $table->unsignedBigInteger('pengajuanpkl_id')->nullable()
                  ->after('pengajuan_id');

            $table->foreign('pengajuanpkl_id')
                  ->references('id')
                  ->on('pengajuan_pklmagang')
                  ->onDelete('set null');

            // Index tambahan
            $table->index(['pengajuan_id', 'pengajuanpkl_id']);
        });
    }

    public function down(): void
    {
        Schema::table('siswa_profile', function (Blueprint $table) {

            $table->dropForeign(['pengajuanpkl_id']);
            $table->dropColumn('pengajuanpkl_id');

            $table->dropForeign(['pengajuan_id']);

            // Balikkan ke kondisi lama (PKL)
            $table->foreign('pengajuan_id')
                  ->references('id')
                  ->on('pengajuan_pklmagang')
                  ->onDelete('set null');
        });
    }
};
