<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pengajuan_pkl_siswa', function (Blueprint $table) {
        $table->string('nama_siswa')->nullable()->after('email_siswa');
    });
}

public function down()
{
    Schema::table('pengajuan_pkl_siswa', function (Blueprint $table) {
        $table->dropColumn('nama_siswa');
    });
}

};
