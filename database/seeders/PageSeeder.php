<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::create([
            'slug' => 'syarat-magang',
            'title' => 'Syarat Magang',
            'content' => json_encode([
                [
                    "icon" => "fas fa-envelope-open-text",
                    "title" => "Surat Pengantar Kampus",
                    "desc" => "Surat pengantar dari kampus yang ditujukan kepada Kepala Kesbangpol sebagai persetujuan magang.",
                    "link" => "/uploads/surat_pengantar_kampus.pdf"
                ],
                [
                    "icon" => "fas fa-file-signature",
                    "title" => "Surat Perizinan Kesbangpol",
                    "desc" => "Surat resmi dari Kesbangpol yang memberikan izin untuk melaksanakan magang di DKIS.",
                    "link" => "/uploads/surat_perizinan_kesbangpol.pdf"
                ],
                [
                    "icon" => "fas fa-file-alt",
                    "title" => "Proposal Magang",
                    "desc" => "Proposal magang yang menjelaskan tujuan, program, dan kegiatan yang akan dilakukan selama magang.",
                    "link" => "/uploads/proposal_magang.pdf"
                ],
                [
                    "icon" => "fas fa-user",
                    "title" => "CV Terbaru",
                    "desc" => "Curriculum Vitae terbaru yang memuat data pribadi, pendidikan, pengalaman, dan keahlian peserta.",
                    "link" => "/uploads/cv_terbaru.pdf"
                ]
            ], JSON_PRETTY_PRINT)
        ]);

        Page::create([
            'slug' => 'about',
            'title' => 'About',
            'content' => json_encode([
                [
                    "icon" => "fas fa-info-circle",
                    "title" => "About Sistem Informasi PKL & Magang",
                    "desc" => "Sistem Informasi ini memudahkan siswa/mahasiswa untuk mengajukan permohonan PKL dan magang di DKIS Kota Cirebon secara online, cepat, dan transparan.",
                    "link" => "#"
                ],
                [
                    "icon" => "fas fa-bullseye",
                    "title" => "Tujuan Sistem",
                    "desc" => "Memberikan kemudahan dan efisiensi dalam pengajuan PKL dan magang.",
                    "link" => "#"
                ]
            ], JSON_PRETTY_PRINT)
        ]);

        Page::create([
            'slug' => 'faqs',
            'title' => 'FAQS',
            'content' => json_encode([
                [
                    "icon" => "fas fa-user-graduate",
                    "title" => "Siapa yang bisa mengikuti PKL dan Magang di DKIS?",
                    "desc" => "Semua siswa/mahasiswa yang memenuhi syarat dapat mendaftar melalui sistem online DKIS.",
                    "link" => "#"
                ],
                [
                    "icon" => "fas fa-file-signature",
                    "title" => "Bagaimana cara mengajukan permohonan PKL/Magang?",
                    "desc" => "Isi formulir pendaftaran online, unggah dokumen yang diperlukan, dan tunggu persetujuan.",
                    "link" => "#"
                ]
            ], JSON_PRETTY_PRINT)
        ]);
    }
}