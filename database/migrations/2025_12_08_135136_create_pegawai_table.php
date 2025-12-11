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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nip', 50)->unique();
            $table->string('nama', 100);
            $table->string('jabatan', 100)->nullable();
            $table->unsignedBigInteger('bidang_id')->nullable();

            $table->timestamp('created_date')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->timestamp('deleted_date')->nullable();
            $table->boolean('is_active')->default(true);

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('bidang_id')->references('id')->on('bidang')->onDelete('set null');

            $table->index(['is_active', 'bidang_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
