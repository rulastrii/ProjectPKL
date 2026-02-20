<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa_profile', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('nisn');          // khusus Mahasiswa Magang
            $table->string('universitas')->nullable()->after('jurusan'); // khusus Mahasiswa Magang
        });
    }

    public function down(): void
    {
        Schema::table('siswa_profile', function (Blueprint $table) {
            $table->dropColumn(['nim', 'universitas']);
        });
    }
};
