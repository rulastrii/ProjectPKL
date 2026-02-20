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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();       // admin, pembimbing, siswa
            $table->string('description')->nullable();  // deskripsi role

            $table->timestamp('created_date')->nullable();
            $table->integer('created_id')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->integer('updated_id')->nullable();
            $table->timestamp('deleted_date')->nullable();
            $table->integer('deleted_id')->nullable();

            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
