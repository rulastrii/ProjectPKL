<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penempatan', function (Blueprint $table) {
            $table->id();

            // polymorphic
            $table->unsignedBigInteger('pengajuan_id')->nullable();
            $table->string('pengajuan_type')->nullable();

            // relasi bidang
            $table->unsignedBigInteger('bidang_id')->nullable();
            $table->foreign('bidang_id')->references('id')->on('bidang')->nullOnDelete();

            $table->boolean('is_active')->default(true);

            $table->timestamp('created_date')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->timestamp('deleted_date')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();

            $table->index(['pengajuan_id', 'pengajuan_type']);
            $table->index(['is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penempatan');
    }
};
