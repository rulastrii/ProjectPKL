<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_referensi_guru', function (Blueprint $table) {

            $table->id();

            // IDENTITAS Data guru
            $table->string('nip', 20)->unique();
            $table->string('nama_lengkap', 100);
            $table->date('tanggal_lahir');

            // INFORMASI SEKOLAH
            $table->string('unit_kerja', 150);
            $table->string('email_resmi', 100)->unique();

            // STATUS
            $table->string('jabatan', 50)->default('guru');
            $table->string('status_kepegawaian', 30)->default('aktif');

            // FLAG
            $table->boolean('is_active')->default(true);

            // AUDIT
            $table->timestamp('created_date')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_referensi_guru');
    }
};
