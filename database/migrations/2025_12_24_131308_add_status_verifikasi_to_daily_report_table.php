<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_report', function (Blueprint $table) {
            $table->enum('status_verifikasi', ['terverifikasi', 'ditolak'])
                  ->nullable()
                  ->after('screenshot');
        });
    }

    public function down(): void
    {
        Schema::table('daily_report', function (Blueprint $table) {
            $table->dropColumn('status_verifikasi');
        });
    }
};
