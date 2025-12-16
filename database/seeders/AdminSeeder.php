<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'admin123', // otomatis di-hash karena setPasswordAttribute
            'role_id' => 1, // Admin
            'created_date' => $now,
            'updated_date' => $now,
            'email_verified_at' => $now, // langsung terverifikasi
            'is_active' => 1,
        ]);
    }
}
