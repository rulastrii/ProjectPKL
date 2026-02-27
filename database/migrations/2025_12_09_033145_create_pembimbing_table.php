<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembimbing', function (Blueprint $table) {
            $table->id();

            // polymorphic
            $table->unsignedBigInteger('pengajuan_id');
            $table->string('pengajuan_type')->comment('App\Models\PengajuanPklSiswa | App\Models\PengajuanMagangMahasiswa');;

            // relasi internal
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->integer('tahun')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamp('created_date')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->timestamp('deleted_date')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();

            // FK YANG BOLEH
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->cascadeOnDelete();

            $table->index(['pengajuan_id', 'pengajuan_type']);
            $table->index(['pegawai_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembimbing');
    }
};
