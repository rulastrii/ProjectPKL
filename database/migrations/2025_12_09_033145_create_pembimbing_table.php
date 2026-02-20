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
        Schema::create('pembimbing', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pengajuan_id');
            $table->unsignedBigInteger('pegawai_id');

            $table->integer('tahun')->nullable();

            $table->timestamp('created_date')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();

            $table->timestamp('updated_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();

            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->timestamp('deleted_date')->nullable();

            $table->boolean('is_active')->default(true);

            // Foreign key
            $table->foreign('pengajuan_id')->references('id')->on('pengajuan_pklmagang')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');

            $table->index(['pengajuan_id','pegawai_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbing');
    }
};
