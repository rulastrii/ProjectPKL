<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugas_submit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tugas_id');
            $table->unsignedBigInteger('siswa_id');

            $table->text('catatan')->nullable();
            $table->string('link_lampiran')->nullable();
            $table->string('file')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->enum('status', ['pending', 'sudah dinilai'])->default('pending');
            $table->decimal('skor', 5, 2)->nullable();
            $table->text('feedback')->nullable();

            $table->timestamp('created_date')->nullable();
            $table->integer('created_id')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->integer('updated_id')->nullable();
            $table->timestamp('deleted_date')->nullable();
            $table->integer('deleted_id')->nullable();
            $table->boolean('is_active')->default(true);

            $table->foreign('tugas_id')->references('id')->on('tugas')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('siswa_profile')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas_submit');
    }
};
