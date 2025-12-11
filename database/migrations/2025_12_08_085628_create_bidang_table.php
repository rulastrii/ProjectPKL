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
        Schema::create('bidang', function (Blueprint $table) {
            $table->id(); // id SERIAL PRIMARY KEY
            $table->string('nama', 100);
            $table->string('kode', 20)->nullable();
            $table->timestamp('created_date')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->timestamp('deleted_date')->nullable();
            $table->boolean('is_active')->default(true);

            $table->index(['is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang');
    }
};
