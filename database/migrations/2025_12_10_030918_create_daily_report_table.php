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
        Schema::create('daily_report', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY

            // Foreign key ke siswa_profile
            $table->unsignedBigInteger('siswa_id')->nullable();
            $table->foreign('siswa_id')
                  ->references('id')
                  ->on('siswa_profile')
                  ->onDelete('set null');

            $table->date('tanggal')->nullable();
            $table->text('ringkasan')->nullable();
            $table->text('kendala')->nullable();
            $table->string('screenshot', 255)->nullable();

            // Custom timestamp seperti pola sebelumnya
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
        Schema::dropIfExists('daily_report');
    }
};
