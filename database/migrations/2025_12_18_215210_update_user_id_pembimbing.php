<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pembimbing')
            ->join('pegawai', 'pembimbing.pegawai_id', '=', 'pegawai.id')
            ->join('users', function($join){
                $join->on('pegawai.user_id', '=', 'users.id')
                     ->where('users.role_id', 2); // role pembimbing
            })
            ->whereNull('pembimbing.user_id')
            ->update(['pembimbing.user_id' => DB::raw('users.id')]);
    }

    public function down(): void
    {
        DB::table('pembimbing')
            ->whereNotNull('user_id')
            ->update(['user_id' => null]);
    }
};
