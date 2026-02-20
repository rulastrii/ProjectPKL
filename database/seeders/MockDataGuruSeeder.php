<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MockDataGuru;

class MockDataGuruSeeder extends Seeder
{
    public function run(): void {
        MockDataGuru::insert([
            [
                'nip' => '197812312005011001',
                'nama_lengkap' => 'Ahmad Fauzi, S.Pd',
                'tanggal_lahir' => '1978-12-31',
                'unit_kerja' => 'SMP Negeri 1 Cirebon',
                'email_resmi' => 'ahmad.fauzi@smpn1.sch.id',
                'jabatan' => 'guru',
                'status_kepegawaian' => 'aktif',
                'is_active' => true,
                'created_date' => now(),
            ],
            [
                'nip' => '198503152010012002',
                'nama_lengkap' => 'Siti Nurhaliza, M.Pd',
                'tanggal_lahir' => '1985-03-15',
                'unit_kerja' => 'SMA Negeri 2 Cirebon',
                'email_resmi' => 'siti.nurhaliza@sman2.sch.id',
                'jabatan' => 'guru',
                'status_kepegawaian' => 'aktif',
                'is_active' => true,
                'created_date' => now(),
            ],
        ]);
    }
    
}
