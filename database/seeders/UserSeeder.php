<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        $adminRole = Role::where('name', 'Admin')->first();

        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id
        ]);

        // PEMBIMBING
        $pembimbingRole = Role::where('name', 'Pembimbing')->first();

        User::create([
            'name' => 'Pembimbing 1',
            'email' => 'pembimbing1@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $pembimbingRole->id
        ]);

        User::create([
            'name' => 'Pembimbing 2',
            'email' => 'pembimbing2@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $pembimbingRole->id
        ]);

        // GURU
        $guruRole = Role::where('name', 'Guru')->first();

        User::create([
            'name' => 'Guru 1',
            'email' => 'guru1@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $guruRole->id
        ]);

        // SISWA
        $siswaRole = Role::where('name', 'Siswa')->first();

        User::create([
            'name' => 'Siswa 1',
            'email' => 'siswa1@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $siswaRole->id
        ]);

        // MAGANG
        $magangRole = Role::where('name', 'Magang')->first();

        User::create([
            'name' => 'Magang 1',
            'email' => 'magang1@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $magangRole->id
        ]);
    }
}