<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pembimbing', function (Blueprint $table) {
            $table->string('pengajuan_type')
                  ->after('pengajuan_id')
                  ->comment('App\Models\PengajuanPklmagang | App\Models\PengajuanMagangMahasiswa');
        });
    }

    public function down()
    {
        Schema::table('pembimbing', function (Blueprint $table) {
            $table->dropColumn('pengajuan_type');
        });
    }
};
