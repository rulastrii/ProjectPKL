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
        Schema::create('penempatan', function (Blueprint $table) {
            $table->id();

            // Foreign Key relasi ke pengajuan_pklmagang
            $table->unsignedBigInteger('pengajuan_id')->nullable();
            $table->foreign('pengajuan_id')->references('id')->on('pengajuan_pklmagang')
                  ->onDelete('cascade');

            // Foreign key ke tabel bidang
            $table->unsignedBigInteger('bidang_id')->nullable();
            $table->foreign('bidang_id')->references('id')->on('bidang')
                  ->onDelete('set null'); 

            // custom timestamps
            $table->timestamp('created_date')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->timestamp('deleted_date')->nullable();

            $table->boolean('is_active')->default(true);

            // Index opsional untuk mempercepat query
            $table->index(['pengajuan_id','bidang_id']);
            $table->index(['is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penempatan');
    }
};
