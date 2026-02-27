<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tugas_submit', function (Blueprint $table) {
            $table->boolean('is_late')
                ->default(0)
                ->after('submitted_at');

            $table->integer('late_days')
                ->default(0)
                ->after('is_late');

            $table->integer('late_penalty')
                ->default(0)
                ->comment('persen potongan nilai')
                ->after('late_days');
        });
    }

    public function down(): void
    {
        Schema::table('tugas_submit', function (Blueprint $table) {
            $table->dropColumn([
                'is_late',
                'late_days',
                'late_penalty',
            ]);
        });
    }
};
