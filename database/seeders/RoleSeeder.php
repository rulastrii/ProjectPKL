<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $roles = [
            ['name' => 'Admin', 'description' => 'Administrator sistem', 'is_active' => 1],
            ['name' => 'Pembimbing', 'description' => 'Pembimbing PKL/Magang', 'is_active' => 1],
            ['name' => 'Guru', 'description' => 'Guru sekolah', 'is_active' => 1],
            ['name' => 'Siswa', 'description' => 'Siswa PKL', 'is_active' => 1],
            ['name' => 'Magang', 'description' => 'Mahasiswa Magang', 'is_active' => 1],
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role['name'],
                'description' => $role['description'],
                'created_date' => $now,
                'updated_date' => $now,
                'is_active' => $role['is_active'],
            ]);
        }
    }
}
