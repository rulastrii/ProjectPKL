<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_guru', function (Blueprint $table) {

            /* =========================
             * PRIMARY KEY
             * ========================= */
            $table->bigIncrements('id_guru');

            /* =========================
             * RELASI KE USERS (SETELAH REGISTER)
             * ========================= */
            $table->unsignedBigInteger('user_id')
                  ->nullable()
                  ->unique()
                  ->comment('Relasi ke users.id setelah akun dibuat');

            /* =========================
             * IDENTITAS GURU (DATA PUSAT)
             * ========================= */
            $table->string('nip', 20)
                  ->unique()
                  ->comment('NIP guru, bukan identitas login');

            $table->string('nama_lengkap', 100);
            $table->date('tanggal_lahir');

            $table->string('unit_kerja', 100)
                  ->comment('Sekolah / unit kerja');

            /* =========================
             * KONTAK RESMI (VERIFIKASI)
             * ========================= */
            $table->string('email_resmi', 100)
                  ->unique()
                  ->comment('Email resmi untuk OTP & login');

            $table->string('no_hp', 20)
                  ->nullable();

            /* =========================
             * VALIDASI STATUS GURU
             * ========================= */
            $table->string('jabatan', 50)->default('guru');
            $table->string('status_kepegawaian', 30)->default('aktif');

            /* =========================
             * FLAG AKTIF (SOFT DELETE)
             * ========================= */
            $table->boolean('is_active')->default(true);

            /* =========================
             * AUDIT FIELDS
             * ========================= */
            $table->timestamp('created_date')->useCurrent();
            $table->unsignedBigInteger('created_id')->nullable();

            $table->timestamp('updated_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();

            $table->timestamp('deleted_date')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();

            /* =========================
             * INDEXING
             * ========================= */
            $table->index(['nip', 'tanggal_lahir']);
            $table->index(['jabatan', 'status_kepegawaian']);
            $table->index('is_active');

            /* =========================
             * FOREIGN KEYS
             * ========================= */
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            $table->foreign('created_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            $table->foreign('updated_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            $table->foreign('deleted_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_guru');
    }
};
