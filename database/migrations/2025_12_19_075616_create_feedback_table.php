<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID user yang memberi feedback
            $table->string('nama_user'); // nama user
            $table->string('role_name'); // jabatan / peran pengguna
            $table->text('feedback'); // isi feedback
            $table->string('foto')->nullable(); // foto profil user
            $table->tinyInteger('bintang')->default(0); // rating bintang 0–5
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif'); // status feedback
            $table->timestamps(); // created_at & updated_at otomatis

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
