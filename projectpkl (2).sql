-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Feb 2026 pada 06.16
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectpkl`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `account_recovery_requests`
--

CREATE TABLE `account_recovery_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `handled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `handled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pegawai_id` bigint(20) UNSIGNED DEFAULT NULL,
  `siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `aksi` varchar(255) NOT NULL,
  `sumber` varchar(255) NOT NULL,
  `ref_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `aktivitas`
--

INSERT INTO `aktivitas` (`id`, `pegawai_id`, `siswa_id`, `nama`, `aksi`, `sumber`, `ref_id`, `created_at`) VALUES
(1, 2, 1, 'Rifki', 'melakukan presensi pulang', 'presensi', 1, '2026-01-22 06:27:32'),
(2, NULL, 1, 'Rifki', 'mengumpulkan tugas Dongeng Si Kancil3', 'tugas', 1, '2026-01-22 06:28:57'),
(3, NULL, 1, 'Rifki', 'mengisi laporan harian', 'laporan', 1, '2026-01-22 06:29:14'),
(4, 2, 2, 'Aninda', 'melakukan presensi pulang', 'presensi', 2, '2026-01-24 04:16:46'),
(5, NULL, 2, 'Aninda', 'mengisi laporan harian', 'laporan', 2, '2026-01-24 04:18:44'),
(6, NULL, 2, 'Aninda', 'mengumpulkan tugas Basis Data', 'tugas', 2, '2026-01-24 04:20:50'),
(7, NULL, 2, 'Aninda', 'mengumpulkan tugas Algoritma dan Struktur Data', 'tugas', 3, '2026-01-24 04:27:04'),
(8, NULL, 2, 'Aninda', 'mengumpulkan tugas Algoritma dan Struktur Data 2', 'tugas', 4, '2026-01-25 05:10:40'),
(9, NULL, 2, 'Aninda', 'mengumpulkan tugas Algoritma dan Struktur Data 2', 'tugas', 5, '2026-01-25 05:38:17'),
(10, NULL, 2, 'Aninda', 'mengumpulkan tugas Algoritma dan Struktur Data 2', 'tugas', 6, '2026-01-25 06:12:29'),
(11, 2, 2, 'Aninda', 'melakukan presensi pulang', 'presensi', 3, '2026-01-25 06:28:18'),
(12, NULL, 2, 'Aninda', 'mengisi laporan harian', 'laporan', 3, '2026-01-25 06:34:09'),
(13, NULL, 2, 'Aninda', 'mengumpulkan tugas Basis Data 2', 'tugas', 7, '2026-01-25 06:35:26'),
(14, NULL, 2, 'Aninda', 'mengisi laporan harian', 'laporan', 4, '2026-01-25 06:37:28'),
(15, NULL, 3, 'Zaza', 'melakukan presensi pulang', 'presensi', 4, '2026-01-25 09:14:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bidang`
--

CREATE TABLE `bidang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bidang`
--

INSERT INTO `bidang` (`id`, `nama`, `kode`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(1, 'Bidang Informatika', 'INF', '2026-01-22 05:55:36', 1, NULL, NULL, NULL, NULL, 1),
(2, 'Bidang Statistik', 'STAT', '2026-01-22 05:55:36', 1, NULL, NULL, NULL, NULL, 1),
(3, 'Bidang Persandian dan Keamanan Informasi', 'SANDI', '2026-01-22 05:55:36', 1, NULL, NULL, NULL, NULL, 1),
(4, 'Bidang Informasi dan Komunikasi Publik', 'IKP', '2026-01-22 05:55:36', 1, NULL, NULL, NULL, NULL, 1),
(5, 'Bidang E-Government', 'EGOV', '2026-01-22 05:55:36', 1, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `daily_report`
--

CREATE TABLE `daily_report` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `ringkasan` text DEFAULT NULL,
  `kendala` text DEFAULT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `status_verifikasi` enum('terverifikasi','ditolak') DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `daily_report`
--

INSERT INTO `daily_report` (`id`, `siswa_id`, `tanggal`, `ringkasan`, `kendala`, `screenshot`, `status_verifikasi`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(1, 1, '2026-01-22', 'xx', 'xx', '1769063354_WhatsApp Image 2026-01-22 at 09.05.23.jpeg', 'terverifikasi', '2026-01-22 06:29:14', 6, '2026-01-22 06:29:45', 5, NULL, NULL, 1),
(2, 2, '2026-01-24', 'ccc', 'ccc', '1769228324_WhatsApp Image 2026-01-22 at 09.05.23 (1).jpeg', 'terverifikasi', '2026-01-24 04:18:44', 7, '2026-01-24 04:18:53', 5, NULL, NULL, 1),
(3, 2, '2026-01-25', 'xxx', 'cc', '1769322849_Update Activity 180126-34. Activity Melihat Sertifikat.jpg', 'terverifikasi', '2026-01-25 06:34:09', 7, '2026-01-25 06:34:25', 5, NULL, NULL, 1),
(4, 2, '2026-01-25', 'xx', 'xx', '1769323048_WhatsApp Image 2026-01-22 at 09.05.23.jpeg', 'terverifikasi', '2026-01-25 06:37:28', 7, '2026-01-25 06:37:55', 5, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `feedback` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `bintang` tinyint(4) NOT NULL DEFAULT 0,
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `nama_user`, `role_name`, `feedback`, `foto`, `bintang`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 'Rifki', 'Magang', 'Pengalaman yang sangat menarik bisa berkontribusi', 'foto_1_1769063101.jpeg', 5, 'aktif', '2026-01-22 06:32:00', '2026-01-22 06:32:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru_profiles`
--

CREATE TABLE `guru_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `sekolah` varchar(150) NOT NULL,
  `dokumen_verifikasi` varchar(255) DEFAULT NULL,
  `status_verifikasi` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `guru_profiles`
--

INSERT INTO `guru_profiles` (`id`, `user_id`, `nip`, `sekolah`, `dokumen_verifikasi`, `status_verifikasi`, `verified_by`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 8, '2207811919011', 'SMK Negeri 1 Kota Cirebon', 'uploads/guru/dokumen/1769323950_rekap-peserta-Rifki (3).pdf', 'approved', 1, '2026-01-25 06:52:53', '2026-01-25 06:52:30', '2026-01-25 06:52:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(88, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(89, '2025_12_05_034700_create_roles_table', 1),
(90, '2025_12_05_065024_create_users_table', 1),
(91, '2025_12_06_193110_create_password_resets_table', 1),
(92, '2025_12_08_082239_create_sekolah_table', 1),
(93, '2025_12_08_085628_create_bidang_table', 1),
(94, '2025_12_08_135136_create_pegawai_table', 1),
(95, '2025_12_09_013411_create_pengajuan_pklmagang_table', 1),
(96, '2025_12_09_033145_create_pembimbing_table', 1),
(97, '2025_12_10_021357_create_penempatan_table', 1),
(98, '2025_12_10_030044_create_siswa_profile_table', 1),
(99, '2025_12_10_030558_create_presensi_table', 1),
(100, '2025_12_10_030918_create_daily_report_table', 1),
(101, '2025_12_10_031047_create_tugas_table', 1),
(102, '2025_12_10_031344_create_tugas_assignee_table', 1),
(103, '2025_12_10_031801_create_tugas_submit_table', 1),
(104, '2025_12_11_141529_add_email_verified_at_to_users_table', 1),
(105, '2025_12_17_101433_create_pengajuan_magang_mahasiswa_table', 1),
(106, '2025_12_17_111758_update_status_enum_pengajuan_magang_mahasiswa_table', 1),
(107, '2025_12_17_193956_add_user_id_to_pengajuan_magang_mahasiswa_table', 1),
(108, '2025_12_17_223044_add_force_change_password_to_users_table', 1),
(109, '2025_12_18_001853_add_magang_fields_to_siswa_profile_table', 1),
(110, '2025_12_19_075616_create_feedback_table', 1),
(111, '2025_12_19_141413_alter_status_enum_on_presensi_table', 1),
(112, '2025_12_21_141546_add_kelengkapan_to_presensi_table', 1),
(113, '2025_12_24_131308_add_status_verifikasi_to_daily_report_table', 1),
(114, '2025_12_24_151410_create_penilaian_akhir_table', 1),
(115, '2025_12_24_151439_create_sertifikat_table', 1),
(116, '2025_12_25_083426_make_pembimbing_id_nullable_on_penilaian_akhir_table', 1),
(117, '2025_12_26_075716_add_fields_to_sertifikat_table', 1),
(118, '2025_12_27_104454_create_aktivitas_table', 1),
(119, '2025_12_28_120237_update_siswa_profile_pengajuan_columns', 1),
(120, '2025_12_28_144622_update_pengajuan_pklmagang_columns', 1),
(121, '2025_12_28_144910_update_siswa_profile_pengajuan_columns', 1),
(122, '2025_12_28_200210_drop_email_siswa_from_pengajuan_pklmagang_table', 1),
(123, '2025_12_28_200258_create_pengajuan_pkl_siswa_table', 1),
(124, '2025_12_28_203348_add_nama_siswa_to_pengajuan_pkl_siswa_table', 1),
(125, '2025_12_29_143351_add_user_id_to_pengajuan_pklmagang_table', 1),
(126, '2025_12_29_230145_create_pages_table', 1),
(127, '2026_01_10_094513_create_guru_profiles_table', 1),
(128, '2026_01_21_100640_add_login_lock_columns_to_users_table', 1),
(129, '2026_01_21_105119_drop_locked_until_from_users_table', 1),
(130, '2026_01_21_105828_create_account_recovery_requests_table', 1),
(131, '2026_01_22_125223_update_user_id_on_pembimbing_table', 2),
(132, '2026_01_24_103947_add_late_columns_to_tugas_submit_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'syarat-magang', 'Syarat Magang', '[\r\n    {\r\n        \"icon\": \"fas fa-envelope-open-text\",\r\n        \"title\": \"Surat Pengantar Kampus\",\r\n        \"desc\": \"Surat pengantar dari kampus yang ditujukan kepada Kepala Kesbangpol sebagai persetujuan magang.\",\r\n        \"link\": \"/uploads/surat_pengantar_kampus.pdf\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-file-signature\",\r\n        \"title\": \"Surat Perizinan Kesbangpol\",\r\n        \"desc\": \"Surat resmi dari Kesbangpol yang memberikan izin untuk melaksanakan magang di DKIS.\",\r\n        \"link\": \"/uploads/surat_perizinan_kesbangpol.pdf\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-file-alt\",\r\n        \"title\": \"Proposal Magang\",\r\n        \"desc\": \"Proposal magang yang menjelaskan tujuan, program, dan kegiatan yang akan dilakukan selama magang.\",\r\n        \"link\": \"/uploads/proposal_magang.pdf\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-user\",\r\n        \"title\": \"CV Terbaru\",\r\n        \"desc\": \"Curriculum Vitae terbaru yang memuat data pribadi, pendidikan, pengalaman, dan keahlian peserta.\",\r\n        \"link\": \"/uploads/cv_terbaru.pdf\"\r\n    }\r\n]\r\n', '2026-01-21 21:14:48', NULL),
(2, 'about', 'About', '[\r\n    {\r\n        \"icon\": \"fas fa-info-circle\",\r\n        \"title\": \"About Sistem Informasi PKL & Magang\",\r\n        \"desc\": \"Sistem Informasi ini memudahkan siswa/mahasiswa untuk mengajukan permohonan PKL dan magang di Dinas Komunikasi dan Informatika (DKIS) Kota Cirebon secara online, cepat, dan transparan.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-bullseye\",\r\n        \"title\": \"Tujuan Sistem\",\r\n        \"desc\": \"Memberikan kemudahan dan efisiensi dalam pengajuan PKL dan magang, serta mempermudah pihak DKIS dalam memonitor dan menindaklanjuti pengajuan.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-cogs\",\r\n        \"title\": \"Fitur Utama\",\r\n        \"desc\": \"Sistem menyediakan fitur pendaftaran online, persetujuan otomatis, manajemen dokumen, serta notifikasi bagi peserta dan admin.\",\r\n        \"link\": \"#\"\r\n    }\r\n]\r\n', '2026-01-21 21:13:36', NULL),
(3, 'faqs', 'FAQS', '[\r\n    {\r\n        \"icon\": \"fas fa-user-graduate\",\r\n        \"title\": \"Siapa yang bisa mengikuti PKL dan Magang di DKIS?\",\r\n        \"desc\": \"Semua siswa/mahasiswa yang memenuhi syarat dapat mendaftar melalui sistem online DKIS.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-file-signature\",\r\n        \"title\": \"Bagaimana cara mengajukan permohonan PKL/Magang?\",\r\n        \"desc\": \"Isi formulir pendaftaran online, unggah dokumen yang diperlukan, dan tunggu persetujuan dari pihak DKIS.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-folder-open\",\r\n        \"title\": \"Dokumen apa saja yang dibutuhkan untuk pendaftaran?\",\r\n        \"desc\": \"Surat pengantar kampus, proposal magang, dan CV terbaru.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-clock\",\r\n        \"title\": \"Berapa lama durasi PKL atau Magang di DKIS?\",\r\n        \"desc\": \"Durasi biasanya 1–3 bulan sesuai kesepakatan dengan pihak DKIS.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-certificate\",\r\n        \"title\": \"Apakah peserta mendapatkan sertifikat atau surat keterangan?\",\r\n        \"desc\": \"Ya, setelah selesai peserta akan menerima surat keterangan resmi dari DKIS.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-headset\",\r\n        \"title\": \"Bagaimana jika ada pertanyaan atau kendala selama proses PKL/Magang?\",\r\n        \"desc\": \"Hubungi admin DKIS melalui email, WhatsApp, atau media sosial resmi.\",\r\n        \"link\": \"#\"\r\n    }\r\n]\r\n', '2026-01-21 21:21:30', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nip` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `bidang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `user_id`, `nip`, `nama`, `jabatan`, `bidang_id`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(1, NULL, '198705012010011001', 'Ahmad Fauzi', 'Kepala Dinas', 1, '2026-01-22 05:56:09', 1, NULL, NULL, NULL, NULL, 1),
(2, 5, '199003122011021002', 'Siti Nurhaliza', 'Sekretaris Dinas', 2, '2026-01-22 05:56:09', 1, NULL, NULL, NULL, NULL, 1),
(3, NULL, '199512082015031003', 'Rizky Maulana', 'Analis Sistem', 3, '2026-01-22 05:56:09', 1, NULL, NULL, NULL, NULL, 1),
(4, NULL, '199811142019041004', 'Dewi Lestari', 'Pranata Humas', 4, '2026-01-22 05:56:09', 1, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembimbing`
--

CREATE TABLE `pembimbing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengajuan_id` bigint(20) UNSIGNED NOT NULL,
  `pengajuan_type` varchar(255) NOT NULL COMMENT 'App\\Models\\PengajuanPklSiswa | App\\Models\\PengajuanMagangMahasiswa',
  `pegawai_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembimbing`
--

INSERT INTO `pembimbing` (`id`, `pengajuan_id`, `pengajuan_type`, `pegawai_id`, `user_id`, `tahun`, `is_active`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_date`, `deleted_id`) VALUES
(1, 2, 'App\\Models\\PengajuanMagangMahasiswa', 2, 5, 2027, 1, '2026-01-22 06:13:31', 1, '2026-01-22 06:20:10', 1, NULL, NULL),
(4, 3, 'App\\Models\\PengajuanPklSiswa', 2, 5, 2026, 1, '2026-01-25 10:12:33', 1, NULL, NULL, NULL, NULL),
(5, 4, 'App\\Models\\PengajuanPklSiswa', 2, 5, 2025, 1, '2026-01-28 05:53:18', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penempatan`
--

CREATE TABLE `penempatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengajuan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pengajuan_type` varchar(255) DEFAULT NULL,
  `bidang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penempatan`
--

INSERT INTO `penempatan` (`id`, `pengajuan_id`, `pengajuan_type`, `bidang_id`, `is_active`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_date`, `deleted_id`) VALUES
(1, 2, 'App\\Models\\PengajuanMagangMahasiswa', 2, 1, '2026-01-22 06:13:52', 1, '2026-01-22 06:26:32', 1, NULL, NULL),
(4, 3, 'App\\Models\\PengajuanPklSiswa', 2, 1, '2026-01-25 09:47:20', 1, NULL, NULL, NULL, NULL),
(5, 4, 'App\\Models\\PengajuanPklSiswa', 2, 1, '2026-01-25 09:47:48', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_magang_mahasiswa`
--

CREATE TABLE `pengajuan_magang_mahasiswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_mahasiswa` varchar(255) NOT NULL,
  `email_mahasiswa` varchar(255) NOT NULL,
  `universitas` varchar(255) NOT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `periode_mulai` date NOT NULL,
  `periode_selesai` date NOT NULL,
  `no_surat` varchar(255) DEFAULT NULL,
  `tgl_surat` date DEFAULT NULL,
  `file_surat_path` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('draft','diproses','diterima','ditolak','selesai') NOT NULL DEFAULT 'draft',
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengajuan_magang_mahasiswa`
--

INSERT INTO `pengajuan_magang_mahasiswa` (`id`, `user_id`, `nama_mahasiswa`, `email_mahasiswa`, `universitas`, `jurusan`, `periode_mulai`, `periode_selesai`, `no_surat`, `tgl_surat`, `file_surat_path`, `catatan`, `status`, `created_id`, `created_date`, `updated_id`, `updated_date`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(1, 1, 'Ananda Mahasiswa', 'ananda@student.ac.id', 'Universitas A', 'Informatika', '2026-02-01', '2026-05-31', NULL, NULL, NULL, NULL, 'diproses', NULL, '2026-01-22 06:00:56', NULL, NULL, NULL, NULL, 1),
(2, 7, 'Aninda', 'lastri3@gmail.com', 'Universitas Negeri Yogyakarta', 'Sistem Informasi', '2026-01-22', '2026-02-07', '22/209/901/2027', '2026-01-21', 'uploads/surat/1769227988_Surat-Balasan-B_400.14.5.4_036_SEKRE_2026 (1).pdf', NULL, 'diterima', NULL, '2026-01-24 04:13:08', 1, '2026-01-22 06:21:42', NULL, NULL, 1),
(3, 3, 'Citra Mahasiswa', 'citra@student.ac.id', 'Universitas C', 'Teknik Komputer', '2026-01-15', '2026-04-15', NULL, NULL, NULL, NULL, 'diterima', NULL, '2026-01-22 06:00:56', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_pklmagang`
--

CREATE TABLE `pengajuan_pklmagang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tgl_surat` date DEFAULT NULL,
  `sekolah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email_guru` varchar(255) DEFAULT NULL,
  `nisn` varchar(255) DEFAULT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `jumlah_siswa` int(11) DEFAULT NULL,
  `periode_mulai` date DEFAULT NULL,
  `periode_selesai` date DEFAULT NULL,
  `status` enum('draft','diproses','diterima','ditolak','selesai') NOT NULL DEFAULT 'draft',
  `file_surat_path` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengajuan_pklmagang`
--

INSERT INTO `pengajuan_pklmagang` (`id`, `user_id`, `no_surat`, `tgl_surat`, `sekolah_id`, `email_guru`, `nisn`, `kelas`, `jurusan`, `jumlah_siswa`, `periode_mulai`, `periode_selesai`, `status`, `file_surat_path`, `catatan`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(3, NULL, '2/2/23/2029', '2026-01-25', 4, 'rifkifadilahv.1@gmail.com', NULL, NULL, NULL, 2, '2026-01-26', '2026-01-31', 'diproses', 'uploads/surat/1769332261_rekap-peserta-Rifki_(3).pdf', 'XX', '2026-01-25 09:11:01', 8, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_pkl_siswa`
--

CREATE TABLE `pengajuan_pkl_siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengajuan_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email_siswa` varchar(255) NOT NULL,
  `nama_siswa` varchar(255) DEFAULT NULL,
  `status` enum('draft','diproses','diterima','ditolak','selesai') NOT NULL DEFAULT 'draft',
  `catatan_admin` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengajuan_pkl_siswa`
--

INSERT INTO `pengajuan_pkl_siswa` (`id`, `pengajuan_id`, `siswa_id`, `email_siswa`, `nama_siswa`, `status`, `catatan_admin`, `created_at`, `updated_at`) VALUES
(3, 3, 3, 'lastricrb3@gmail.com', 'Zaza', 'diterima', NULL, '2026-01-25 09:11:11', '2026-01-25 09:14:09'),
(4, 3, NULL, 'ahah@gmail.com', 'yanti', 'diterima', NULL, '2026-01-25 09:11:22', '2026-01-25 09:11:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian_akhir`
--

CREATE TABLE `penilaian_akhir` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `pembimbing_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nilai_tugas` double(8,2) DEFAULT NULL,
  `nilai_laporan` double(8,2) DEFAULT NULL,
  `nilai_keaktifan` double(8,2) DEFAULT NULL,
  `nilai_sikap` double(8,2) DEFAULT NULL,
  `nilai_akhir` double(8,2) DEFAULT NULL,
  `periode_mulai` date DEFAULT NULL,
  `periode_selesai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penilaian_akhir`
--

INSERT INTO `penilaian_akhir` (`id`, `siswa_id`, `pembimbing_id`, `nilai_tugas`, `nilai_laporan`, `nilai_keaktifan`, `nilai_sikap`, `nilai_akhir`, `periode_mulai`, `periode_selesai`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 90.00, 100.00, 80.00, 85.00, 91.50, '2026-03-01', '2026-06-30', '2026-01-22 06:29:50', '2026-01-22 06:30:10'),
(2, 2, 1, 89.62, 100.00, 0.00, 0.00, 74.81, '2026-01-22', '2026-02-07', '2026-01-24 04:34:38', '2026-01-25 06:37:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `status` enum('hadir','izin','sakit','absen') NOT NULL,
  `kelengkapan` enum('lengkap','tidak_lengkap') NOT NULL DEFAULT 'tidak_lengkap',
  `foto_masuk` varchar(255) DEFAULT NULL,
  `foto_pulang` varchar(255) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `siswa_id`, `tanggal`, `jam_masuk`, `jam_keluar`, `status`, `kelengkapan`, `foto_masuk`, `foto_pulang`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(1, 1, '2026-01-22', NULL, '13:27:32', 'hadir', 'tidak_lengkap', NULL, '1769063252_pulang_WhatsApp Image 2026-01-22 at 09.05.27 (1).jpeg', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 2, '2026-01-24', NULL, '11:16:46', 'hadir', 'tidak_lengkap', NULL, '1769228206_pulang_WhatsApp Image 2026-01-22 at 09.05.27 (1).jpeg', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, 2, '2026-01-25', NULL, '13:28:18', 'absen', 'tidak_lengkap', NULL, '1769322498_pulang_WhatsApp Image 2026-01-22 at 09.05.27.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(4, 3, '2026-01-25', NULL, '16:14:26', 'absen', 'tidak_lengkap', NULL, '1769332466_pulang_WhatsApp Image 2026-01-22 at 09.05.23.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(5, 1, '2026-01-25', NULL, NULL, 'absen', 'tidak_lengkap', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(6, 1, '2026-01-27', NULL, NULL, 'absen', 'tidak_lengkap', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(7, 2, '2026-01-27', NULL, NULL, 'absen', 'tidak_lengkap', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(8, 3, '2026-01-27', NULL, NULL, 'absen', 'tidak_lengkap', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_date`, `deleted_id`, `is_active`) VALUES
(1, 'Admin', 'Administrator sistem', '2026-01-22 05:52:52', NULL, '2026-01-22 05:52:52', NULL, NULL, NULL, 1),
(2, 'Pembimbing', 'Pembimbing PKL/Magang', '2026-01-22 05:52:52', NULL, '2026-01-22 05:52:52', NULL, NULL, NULL, 1),
(3, 'Guru', 'Guru sekolah', '2026-01-22 05:52:52', NULL, '2026-01-22 05:52:52', NULL, NULL, NULL, 1),
(4, 'Siswa', 'Siswa PKL', '2026-01-22 05:52:52', NULL, '2026-01-22 05:52:52', NULL, NULL, NULL, 1),
(5, 'Magang', 'Mahasiswa Magang', '2026-01-22 05:52:52', NULL, '2026-01-22 05:52:52', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sekolah`
--

CREATE TABLE `sekolah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(150) NOT NULL,
  `npsn` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kontak` varchar(100) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted_id` int(11) DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sekolah`
--

INSERT INTO `sekolah` (`id`, `nama`, `npsn`, `alamat`, `kontak`, `created_date`, `created_id`, `updated_id`, `updated_date`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(1, 'SMK Negeri 1 Kota Cirebon', '202219510', 'Jl. Perjuangan No. 10, Kota Cirebon', 'smkn1cirebon@sch.id', '2026-01-22 05:55:11', 1, 8, '2026-01-25 08:13:16', NULL, NULL, 1),
(2, 'SMK Negeri 2 Kota Cirebon', '20221952', 'Jl. Kalijaga No. 25, Kota Cirebon', 'smkn2cirebon@sch.id', '2026-01-22 05:55:11', 1, NULL, NULL, NULL, NULL, 1),
(3, 'SMK Negeri 3 Kota Cirebon', '20221953', 'Jl. Evakuasi No. 1, Kota Cirebon', 'smkn3cirebon@sch.id', '2026-01-22 05:55:11', 1, NULL, NULL, NULL, NULL, 1),
(4, 'SMK Informatika Cirebon', '20221954', 'Jl. Tuparev No. 88, Kota Cirebon', 'info@smkinfocirebon.sch.id', '2026-01-22 05:55:11', 1, NULL, NULL, NULL, NULL, 1),
(5, 'SMK Pariwisata Cirebon', '20221955', 'Jl. Cipto Mangunkusumo No. 14, Kota Cirebon', 'admin@smkpariwisatacrb.sch.id', '2026-01-22 05:55:11', 1, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sertifikat`
--

CREATE TABLE `sertifikat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `nomor_sertifikat` varchar(255) NOT NULL,
  `nomor_surat` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL DEFAULT 'Sertifikat Magang / PKL',
  `periode_mulai` date NOT NULL,
  `periode_selesai` date NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `qr_token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sertifikat`
--

INSERT INTO `sertifikat` (`id`, `siswa_id`, `nomor_sertifikat`, `nomor_surat`, `judul`, `periode_mulai`, `periode_selesai`, `tanggal_terbit`, `file_path`, `qr_token`, `created_at`, `updated_at`) VALUES
(1, 1, '001/MAGANG/DKIS-KC/2026', '800/1/DKIS/2026', 'Magang', '2026-03-01', '2026-06-30', '2026-01-22', 'uploads/sertifikat/sertifikat_1.pdf', '37286e3b-b9da-420d-9496-0ac3a70979f8', '2026-01-22 06:30:31', '2026-01-22 06:30:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa_profile`
--

CREATE TABLE `siswa_profile` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pengajuan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pengajuanpkl_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `nisn` varchar(30) DEFAULT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `universitas` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa_profile`
--

INSERT INTO `siswa_profile` (`id`, `user_id`, `pengajuan_id`, `pengajuanpkl_id`, `nama`, `nisn`, `nim`, `kelas`, `jurusan`, `universitas`, `foto`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(1, 6, 2, NULL, 'Rifki', NULL, '22000202', NULL, 'Sistem Informasi', 'Universitas Brawijaya', 'foto_1_1769063101.jpeg', '2026-01-22 06:24:36', 6, '2026-01-22 06:25:01', 6, NULL, NULL, 1),
(2, 7, 2, NULL, 'Aninda', NULL, '22078999', NULL, 'Sistem Informasi', 'Universitas Negeri Yogyakarta', 'foto_2_1769228192.jpeg', '2026-01-24 04:16:10', 7, '2026-01-24 04:16:32', 7, NULL, NULL, 1),
(3, 10, NULL, 3, 'Zaza', '22078111', NULL, '12', 'TKJ', NULL, 'foto_3_1769331296.jpeg', '2026-01-25 08:54:23', 10, '2026-01-25 08:54:56', 10, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pembimbing_id` bigint(20) UNSIGNED DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tenggat` timestamp NULL DEFAULT NULL,
  `status` enum('pending','sudah dinilai') NOT NULL DEFAULT 'pending',
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id`, `pembimbing_id`, `judul`, `deskripsi`, `tenggat`, `status`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(1, 1, 'Dongeng Si Kancil3', '<p>xxx	</p>', '2026-01-24 06:28:00', 'sudah dinilai', '2026-01-22 06:28:25', 5, NULL, NULL, NULL, NULL, 1),
(2, 1, 'Basis Data', '<p>xxx</p>', '2026-01-24 04:21:00', 'sudah dinilai', '2026-01-24 04:19:24', 5, NULL, NULL, NULL, NULL, 1),
(3, 1, 'Algoritma dan Struktur Data', '<p>xxx</p>', '2026-01-24 04:21:00', 'sudah dinilai', '2026-01-24 04:19:56', 5, '2026-01-24 04:20:26', 5, NULL, NULL, 1),
(4, 1, 'Algoritma dan Struktur Data 2', '<p>xxx</p>', '2026-01-24 05:00:00', 'sudah dinilai', '2026-01-24 04:35:30', 5, '2026-01-25 06:12:14', 5, NULL, NULL, 1),
(5, 1, 'Basis Data 2', '<p>xx</p>', '2026-01-25 06:36:00', 'sudah dinilai', '2026-01-25 06:35:02', 5, NULL, NULL, NULL, NULL, 1),
(6, 1, 'Basis Data 3', '<p>xxx</p>', '2026-01-27 09:15:00', 'pending', '2026-01-25 09:15:29', 5, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas_assignee`
--

CREATE TABLE `tugas_assignee` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tugas_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tugas_assignee`
--

INSERT INTO `tugas_assignee` (`id`, `tugas_id`, `siswa_id`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_date`, `deleted_id`, `is_active`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(4, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(5, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas_submit`
--

CREATE TABLE `tugas_submit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tugas_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `catatan` text DEFAULT NULL,
  `link_lampiran` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `is_late` tinyint(1) NOT NULL DEFAULT 0,
  `late_days` int(11) NOT NULL DEFAULT 0,
  `late_penalty` int(11) NOT NULL DEFAULT 0 COMMENT 'persen potongan nilai',
  `status` enum('pending','sudah dinilai') NOT NULL DEFAULT 'pending',
  `skor` decimal(5,2) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tugas_submit`
--

INSERT INTO `tugas_submit` (`id`, `tugas_id`, `siswa_id`, `catatan`, `link_lampiran`, `file`, `submitted_at`, `is_late`, `late_days`, `late_penalty`, `status`, `skor`, `feedback`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_date`, `deleted_id`, `is_active`) VALUES
(1, 1, 1, 'xxx', 'https://google.from', NULL, '2026-01-22 06:28:57', 0, 0, 0, 'sudah dinilai', 90.00, NULL, NULL, NULL, '2026-01-22 06:29:33', 5, NULL, NULL, 1),
(2, 2, 2, 'xx', NULL, 'uploads/tugas/1769228450_Surat-Balasan-B_400.14.5.4_036_SEKRE_2026 (1).pdf', '2026-01-24 04:20:50', 0, 0, 0, 'sudah dinilai', 98.00, NULL, NULL, NULL, '2026-01-24 04:23:55', 5, NULL, NULL, 1),
(3, 3, 2, 'xxx', NULL, 'uploads/tugas/1769228823_Surat-Balasan-B_400.14.5.4_036_SEKRE_2026 (1).pdf', '2026-01-24 04:27:03', 0, 0, 0, 'sudah dinilai', 80.00, NULL, NULL, NULL, '2026-01-24 04:33:55', 5, NULL, NULL, 1),
(6, 4, 2, 'xxx', 'https://github.com/username/tugas-asd', NULL, '2026-01-25 06:12:29', 1, 1, 5, 'sudah dinilai', 85.50, 'xxx', NULL, NULL, '2026-01-25 06:15:29', 5, NULL, NULL, 1),
(7, 5, 2, 'xx', 'http://www.blogspot.com', NULL, '2026-01-25 06:35:26', 0, 0, 0, 'sudah dinilai', 95.00, NULL, NULL, NULL, '2026-01-25 06:35:42', 5, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `failed_login_attempts` int(11) NOT NULL DEFAULT 0,
  `force_change_password` tinyint(1) NOT NULL DEFAULT 1,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `failed_login_attempts`, `force_change_password`, `role_id`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(1, 'Administrator', 'admin@example.com', '2026-01-22 05:52:57', '$2y$10$d6tRTiOJMEx48thWTxkht.eOpI4BxslfzgCP.fVhWnHGNwB2ZA0Ly', 0, 1, 1, '2026-01-22 05:52:57', NULL, '2026-01-22 05:52:57', NULL, NULL, NULL, 1),
(2, 'Ananda Mahasiswa', 'ananda@student.ac.id', NULL, '$2y$10$j6hfV44IhdlHeIEBXM0GKOvfTKyqxTSMlCaNdKcLo0I0t.xfIkkqm', 0, 0, 5, '2026-01-22 06:00:02', NULL, NULL, NULL, NULL, NULL, 1),
(3, 'Rifki Mahasiswa', 'rifki@student.ac.id', NULL, '$2y$10$dummyhash', 0, 1, 5, '2026-01-22 06:00:02', NULL, NULL, NULL, NULL, NULL, 1),
(4, 'Citra Mahasiswa', 'citra@student.ac.id', '2026-01-22 06:01:23', '$2y$10$QH3z5rnRkVfOeaNt1UN1K.xg7LRohdXFlJ/4ya5lJKyf9ctQ/Hume', 0, 0, 5, '2026-01-22 06:00:02', 1, '2026-01-22 06:15:31', 1, NULL, NULL, 1),
(5, 'Siti Nurhaliza', 'rulastri458@gmail.com', '2026-01-22 06:03:09', '$2y$10$m1HyUeGjJusZt9RD3YDcZe6TWaFbSMb9sdlHWQ42DkBTDw2vJBEcO', 0, 0, 2, '2026-01-22 06:02:17', 1, NULL, NULL, NULL, NULL, 1),
(6, 'Rifki', 'lastri@gmail.com', '2026-01-22 06:23:27', '$2y$10$Kiy6eg6b277Dxyy9DmqbDe.9im67sJ/gRzgz5Vt2qepQnfI8u0A6O', 0, 0, 5, '2026-01-22 06:22:36', 1, '2026-01-24 04:12:47', 1, NULL, NULL, 1),
(7, 'Aninda', 'lastri3@gmail.com', '2026-01-24 04:15:26', '$2y$10$dnUzI.fqPIk2ilb.6XURa.RRBJuT3mRm2dCBngOUf7X/rWYPZ2Qci', 0, 0, 5, '2026-01-24 04:15:13', 1, NULL, NULL, NULL, NULL, 1),
(8, 'Sulisa', 'rifkifadilahv.1@gmail.com', '2026-01-25 06:54:08', '$2y$10$Q.Jb8p7PylaFtWxdFybSDeBPuDrnfsW9Ft3hSQBbyKoOAbLdvqxQG', 0, 0, 3, '2026-01-25 06:52:29', NULL, NULL, NULL, NULL, NULL, 1),
(10, 'zaza', 'lastricrb3@gmail.com', '2026-01-25 08:52:56', '$2y$10$Gnu.FBvIImeFd1WUmvIUf.cbFWIzmkqIKcg//OAgDETkZK0C.9M1a', 0, 0, 4, '2026-01-25 08:52:30', 1, NULL, NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `account_recovery_requests`
--
ALTER TABLE `account_recovery_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bidang_is_active_index` (`is_active`);

--
-- Indeks untuk tabel `daily_report`
--
ALTER TABLE `daily_report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_report_siswa_id_foreign` (`siswa_id`);

--
-- Indeks untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `guru_profiles`
--
ALTER TABLE `guru_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_profiles_user_id_foreign` (`user_id`),
  ADD KEY `guru_profiles_verified_by_foreign` (`verified_by`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pegawai_nip_unique` (`nip`),
  ADD KEY `pegawai_user_id_foreign` (`user_id`),
  ADD KEY `pegawai_bidang_id_foreign` (`bidang_id`),
  ADD KEY `pegawai_is_active_bidang_id_index` (`is_active`,`bidang_id`);

--
-- Indeks untuk tabel `pembimbing`
--
ALTER TABLE `pembimbing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembimbing_pengajuan_id_pengajuan_type_index` (`pengajuan_id`,`pengajuan_type`),
  ADD KEY `pembimbing_pegawai_id_user_id_index` (`pegawai_id`,`user_id`);

--
-- Indeks untuk tabel `penempatan`
--
ALTER TABLE `penempatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penempatan_bidang_id_foreign` (`bidang_id`),
  ADD KEY `penempatan_pengajuan_id_pengajuan_type_index` (`pengajuan_id`,`pengajuan_type`),
  ADD KEY `penempatan_is_active_index` (`is_active`);

--
-- Indeks untuk tabel `pengajuan_magang_mahasiswa`
--
ALTER TABLE `pengajuan_magang_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengajuan_magang_mahasiswa_email_mahasiswa_unique` (`email_mahasiswa`),
  ADD KEY `pengajuan_magang_mahasiswa_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pengajuan_pklmagang`
--
ALTER TABLE `pengajuan_pklmagang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_siswa_periode` (`nisn`,`periode_mulai`,`periode_selesai`),
  ADD KEY `pengajuan_pklmagang_sekolah_id_foreign` (`sekolah_id`),
  ADD KEY `pengajuan_pklmagang_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pengajuan_pkl_siswa`
--
ALTER TABLE `pengajuan_pkl_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_pkl_siswa_pengajuan_id_foreign` (`pengajuan_id`);

--
-- Indeks untuk tabel `penilaian_akhir`
--
ALTER TABLE `penilaian_akhir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penilaian_akhir_siswa_id_foreign` (`siswa_id`),
  ADD KEY `penilaian_akhir_pembimbing_id_foreign` (`pembimbing_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presensi_siswa_id_foreign` (`siswa_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indeks untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sertifikat_nomor_sertifikat_unique` (`nomor_sertifikat`),
  ADD UNIQUE KEY `sertifikat_nomor_surat_unique` (`nomor_surat`),
  ADD UNIQUE KEY `sertifikat_qr_token_unique` (`qr_token`),
  ADD KEY `sertifikat_siswa_id_foreign` (`siswa_id`);

--
-- Indeks untuk tabel `siswa_profile`
--
ALTER TABLE `siswa_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_profile_user_id_pengajuan_id_is_active_index` (`user_id`,`pengajuan_id`,`is_active`),
  ADD KEY `siswa_profile_pengajuanpkl_id_foreign` (`pengajuanpkl_id`),
  ADD KEY `siswa_profile_pengajuan_id_pengajuanpkl_id_index` (`pengajuan_id`,`pengajuanpkl_id`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_pembimbing_id_foreign` (`pembimbing_id`);

--
-- Indeks untuk tabel `tugas_assignee`
--
ALTER TABLE `tugas_assignee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_assignee_tugas_id_foreign` (`tugas_id`),
  ADD KEY `tugas_assignee_siswa_id_foreign` (`siswa_id`);

--
-- Indeks untuk tabel `tugas_submit`
--
ALTER TABLE `tugas_submit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_submit_tugas_id_foreign` (`tugas_id`),
  ADD KEY `tugas_submit_siswa_id_foreign` (`siswa_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_is_active_index` (`role_id`,`is_active`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `account_recovery_requests`
--
ALTER TABLE `account_recovery_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `daily_report`
--
ALTER TABLE `daily_report`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `guru_profiles`
--
ALTER TABLE `guru_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT untuk tabel `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pembimbing`
--
ALTER TABLE `pembimbing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `penempatan`
--
ALTER TABLE `penempatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_magang_mahasiswa`
--
ALTER TABLE `pengajuan_magang_mahasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_pklmagang`
--
ALTER TABLE `pengajuan_pklmagang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_pkl_siswa`
--
ALTER TABLE `pengajuan_pkl_siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `penilaian_akhir`
--
ALTER TABLE `penilaian_akhir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `siswa_profile`
--
ALTER TABLE `siswa_profile`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tugas_assignee`
--
ALTER TABLE `tugas_assignee`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tugas_submit`
--
ALTER TABLE `tugas_submit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `daily_report`
--
ALTER TABLE `daily_report`
  ADD CONSTRAINT `daily_report_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa_profile` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `guru_profiles`
--
ALTER TABLE `guru_profiles`
  ADD CONSTRAINT `guru_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guru_profiles_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pegawai_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pembimbing`
--
ALTER TABLE `pembimbing`
  ADD CONSTRAINT `pembimbing_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penempatan`
--
ALTER TABLE `penempatan`
  ADD CONSTRAINT `penempatan_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pengajuan_magang_mahasiswa`
--
ALTER TABLE `pengajuan_magang_mahasiswa`
  ADD CONSTRAINT `pengajuan_magang_mahasiswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pengajuan_pklmagang`
--
ALTER TABLE `pengajuan_pklmagang`
  ADD CONSTRAINT `pengajuan_pklmagang_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengajuan_pklmagang_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pengajuan_pkl_siswa`
--
ALTER TABLE `pengajuan_pkl_siswa`
  ADD CONSTRAINT `pengajuan_pkl_siswa_pengajuan_id_foreign` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan_pklmagang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian_akhir`
--
ALTER TABLE `penilaian_akhir`
  ADD CONSTRAINT `penilaian_akhir_pembimbing_id_foreign` FOREIGN KEY (`pembimbing_id`) REFERENCES `pembimbing` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_akhir_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa_profile` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa_profile` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD CONSTRAINT `sertifikat_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa_profile` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa_profile`
--
ALTER TABLE `siswa_profile`
  ADD CONSTRAINT `siswa_profile_pengajuan_id_foreign` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan_magang_mahasiswa` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `siswa_profile_pengajuanpkl_id_foreign` FOREIGN KEY (`pengajuanpkl_id`) REFERENCES `pengajuan_pklmagang` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `siswa_profile_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_pembimbing_id_foreign` FOREIGN KEY (`pembimbing_id`) REFERENCES `pembimbing` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tugas_assignee`
--
ALTER TABLE `tugas_assignee`
  ADD CONSTRAINT `tugas_assignee_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa_profile` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tugas_assignee_tugas_id_foreign` FOREIGN KEY (`tugas_id`) REFERENCES `tugas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tugas_submit`
--
ALTER TABLE `tugas_submit`
  ADD CONSTRAINT `tugas_submit_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa_profile` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tugas_submit_tugas_id_foreign` FOREIGN KEY (`tugas_id`) REFERENCES `tugas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
