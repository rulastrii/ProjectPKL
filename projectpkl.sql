-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jan 2026 pada 05.48
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
(1, 9, 16, 'Rara', 'mengisi laporan harian', 'laporan', 10, '2025-12-27 03:56:49'),
(2, 9, 16, 'Rara', 'mengisi laporan harian', 'laporan', 11, '2025-12-27 03:58:15'),
(3, 9, 16, 'Rara', 'memperbarui laporan harian', 'laporan', 11, '2025-12-27 04:03:22'),
(4, 9, 16, 'Rara', 'melakukan presensi pulang', 'presensi', 35, '2025-12-27 04:07:25'),
(5, 9, 16, 'Rara', 'submit tugas Jaringan Komputer', 'tugas', 9, '2025-12-27 04:14:35'),
(6, 9, 16, 'Rara', 'submit tugas Aplikasi CRUD Laravel', 'tugas', 10, '2025-12-27 04:22:13'),
(7, 9, 16, 'Rara', 'submit tugas Aplikasi CRUD Laravel', 'tugas', 10, '2025-12-27 04:22:46'),
(8, 9, 16, 'Rara', 'memperbarui tugas Aplikasi CRUD Laravel', 'tugas', 10, '2025-12-27 04:30:39'),
(9, 9, 16, 'Rara', 'memperbarui tugas Aplikasi CRUD Laravel', 'tugas', 10, '2025-12-27 04:30:50'),
(10, 9, 16, 'Rara', 'memperbarui tugas Aplikasi CRUD Laravel', 'tugas', 10, '2025-12-27 04:32:50'),
(11, 9, 16, 'Rara', 'memperbarui tugas Jaringan Komputer', 'tugas', 9, '2025-12-27 04:33:06'),
(12, 9, 16, 'Rara', 'memperbarui tugas Jaringan Komputer', 'tugas', 9, '2025-12-27 04:33:27'),
(13, NULL, NULL, 'Tidak diketahui', 'melihat daftar sertifikat', 'sertifikat', NULL, '2025-12-27 04:35:32'),
(14, NULL, NULL, 'Tidak diketahui', 'melihat daftar sertifikat', 'sertifikat', NULL, '2025-12-27 04:36:59'),
(15, NULL, 61, 'Jono', 'melakukan presensi pulang', 'presensi', 40, '2025-12-29 07:44:02'),
(16, NULL, 61, 'Jono', 'mengisi laporan harian', 'laporan', 12, '2025-12-29 08:29:20'),
(17, NULL, 61, 'Jono', 'memperbarui laporan harian', 'laporan', 12, '2025-12-29 08:31:02'),
(18, NULL, 61, 'Jono', 'mengumpulkan tugas Jaringan Komputer', 'tugas', 11, '2025-12-29 08:45:51'),
(19, NULL, 63, 'Amanda', 'melakukan presensi masuk', 'presensi', 41, '2025-12-31 01:04:40'),
(20, 9, 16, 'Rara', 'melakukan presensi masuk', 'presensi', 42, '2025-12-31 01:57:27'),
(21, 9, 16, 'Rara', 'melakukan presensi pulang', 'presensi', 42, '2025-12-31 01:59:10'),
(22, 9, 16, 'Rara', 'mengisi laporan harian', 'laporan', 13, '2025-12-31 02:00:58'),
(23, 9, 16, 'Rara', 'mengumpulkan tugas Analisis Data', 'tugas', 12, '2025-12-31 02:10:52');

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
(1, 'TIK', 'TIK001', '2025-12-17 02:56:14', 1, NULL, NULL, NULL, NULL, 1),
(2, 'E-Government', 'EGOV', '2025-12-18 13:12:11', 1, NULL, NULL, NULL, NULL, 1),
(3, 'Persandian dan Keamanan Data', 'PSND', '2025-12-31 01:30:07', 1, NULL, NULL, NULL, NULL, 1);

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
(2, NULL, '2025-12-24', 'melanjutkan project sebelumnya..', 'agak bingung dilogikanya', '1766559333_download (1).jpg', 'terverifikasi', '2025-12-24 06:55:33', 41, '2025-12-24 07:07:07', 48, NULL, NULL, 1),
(3, 16, '2025-12-24', 'melakukan pembuatan project sbeeumnay', 'ngga ada', NULL, 'terverifikasi', '2025-12-24 07:17:57', 41, '2025-12-24 07:24:55', 48, NULL, NULL, 1),
(4, 16, '2025-12-24', 'aaaa', NULL, NULL, 'ditolak', '2025-12-24 07:30:06', 41, '2025-12-25 00:35:41', 48, NULL, NULL, 1),
(5, 16, '2025-12-25', 'ngga ada', 'lumayan sulit', '1766622980_download (1).jpg', 'terverifikasi', '2025-12-25 00:36:20', 41, '2025-12-25 00:36:35', 48, NULL, NULL, 1),
(6, 16, '2025-12-27', 'xxx', 'xxx', '1766806406_download.jpg', NULL, '2025-12-27 03:33:26', 41, NULL, NULL, NULL, NULL, 1),
(7, 16, '2025-12-27', 'aa', 'xx', '1766807505_download.jpg', NULL, '2025-12-27 03:51:45', 41, NULL, NULL, NULL, NULL, 1),
(8, 16, '2025-12-27', 'aa', 'xx', '1766807542_download.jpg', NULL, '2025-12-27 03:52:22', 41, NULL, NULL, NULL, NULL, 1),
(9, 16, '2025-12-27', 'aa', 'xx', '1766807660_download.jpg', NULL, '2025-12-27 03:54:20', 41, NULL, NULL, NULL, NULL, 1),
(10, 16, '2025-12-27', 'aa', 'xx', '1766807809_download.jpg', NULL, '2025-12-27 03:56:49', 41, NULL, NULL, NULL, NULL, 1),
(11, 16, '2025-12-27', 'CCXXX', 'CCXXX', '1766807895_download (1).jpg', NULL, '2025-12-27 03:58:15', 41, '2025-12-27 04:03:22', 41, NULL, NULL, 1),
(12, NULL, '2025-12-29', 'cccv', 'nggf', '1766996960_download (1).jpg', 'terverifikasi', '2025-12-29 08:29:20', 51, '2025-12-29 08:31:31', 48, NULL, NULL, 1),
(13, 16, '2025-12-31', 'Melakukan kegiatan pembuatan desain', 'Ada kendala pada bagian A', '1767146458_download (1).jpg', NULL, '2025-12-31 02:00:58', 41, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_referensi_guru`
--

CREATE TABLE `data_referensi_guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `unit_kerja` varchar(150) NOT NULL,
  `email_resmi` varchar(100) NOT NULL,
  `jabatan` varchar(50) NOT NULL DEFAULT 'guru',
  `status_kepegawaian` varchar(30) NOT NULL DEFAULT 'aktif',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_referensi_guru`
--

INSERT INTO `data_referensi_guru` (`id`, `nip`, `nama_lengkap`, `tanggal_lahir`, `unit_kerja`, `email_resmi`, `jabatan`, `status_kepegawaian`, `is_active`, `created_date`) VALUES
(1, '197812312005011001', 'Ahmad Fauzi, S.Pd', '1978-12-31', 'SMP Negeri 1 Cirebon', 'ahmad.fauzi@smpn1.sch.id', 'guru', 'aktif', 1, '2025-12-16 10:16:51'),
(2, '198503152010012002', 'Siti Nurhaliza, M.Pd', '1985-03-15', 'SMA Negeri 2 Cirebon', 'siti.nurhaliza@sman2.sch.id', 'guru', 'aktif', 1, '2025-12-16 10:16:51');

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
(2, 41, 'Rara', 'Magang', 'Bagus', 'foto_16_1766112218.png', 3, 'aktif', '2025-12-19 02:56:44', '2025-12-19 02:56:44'),
(3, 41, 'Rara', 'Magang', 'Pengalaman selama magang sangat menyenangkan sekali..', 'foto_16_1766112218.png', 5, 'aktif', '2025-12-19 02:59:41', '2025-12-19 02:59:41'),
(4, 41, 'Rara', 'Magang', 'Pembimbingnya galak', 'foto_16_1766112218.png', 4, 'aktif', '2025-12-31 02:56:24', '2025-12-31 02:56:24');

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
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2025_12_05_034700_create_roles_table', 1),
(3, '2025_12_05_065024_create_users_table', 1),
(4, '2025_12_06_193110_create_password_resets_table', 1),
(5, '2025_12_08_082239_create_sekolah_table', 1),
(6, '2025_12_08_085628_create_bidang_table', 1),
(7, '2025_12_08_135136_create_pegawai_table', 1),
(8, '2025_12_09_013411_create_pengajuan_pklmagang_table', 1),
(9, '2025_12_09_033145_create_pembimbing_table', 1),
(10, '2025_12_10_021357_create_penempatan_table', 1),
(11, '2025_12_10_030044_create_siswa_profile_table', 1),
(12, '2025_12_10_030558_create_presensi_table', 1),
(13, '2025_12_10_030918_create_daily_report_table', 1),
(14, '2025_12_10_031047_create_tugas_table', 1),
(15, '2025_12_10_031344_create_tugas_assignee_table', 1),
(16, '2025_12_10_031801_create_tugas_submit_table', 1),
(17, '2025_12_11_141529_add_email_verified_at_to_users_table', 1),
(18, '2025_12_16_121740_create_profile_guru_table', 1),
(19, '2025_12_16_131214_create_data_referensi_guru_table', 1),
(20, '2025_12_17_101433_create_pengajuan_magang_mahasiswa_table', 2),
(21, '2025_12_17_111758_update_status_enum_pengajuan_magang_mahasiswa_table', 3),
(22, '2025_12_17_193956_add_user_id_to_pengajuan_magang_mahasiswa_table', 4),
(23, '2025_12_17_223044_add_force_change_password_to_users_table', 5),
(24, '2025_12_18_001853_add_magang_fields_to_siswa_profile_table', 6),
(25, '2025_12_18_145039_add_pengajuan_type_to_pembimbing_table', 7),
(26, '2025_12_18_215210_update_user_id_pembimbing', 8),
(27, '2025_12_19_075616_create_feedback_table', 9),
(28, '2025_12_19_141413_alter_status_enum_on_presensi_table', 10),
(29, '2025_12_21_141546_add_kelengkapan_to_presensi_table', 11),
(30, '2025_12_24_131308_add_status_verifikasi_to_daily_report_table', 12),
(31, '2025_12_24_151410_create_penilaian_akhir_table', 13),
(32, '2025_12_24_151439_create_sertifikat_table', 13),
(33, '2025_12_25_083426_make_pembimbing_id_nullable_on_penilaian_akhir_table', 14),
(34, '2025_12_26_075716_add_fields_to_sertifikat_table', 15),
(35, '2025_12_27_104454_create_aktivitas_table', 16),
(36, '2025_12_28_120237_update_siswa_profile_pengajuan_columns', 17),
(37, '2025_12_28_144622_update_pengajuan_pklmagang_columns', 18),
(38, '2025_12_28_144910_update_siswa_profile_pengajuan_columns', 19),
(39, '2025_12_28_200210_drop_email_siswa_from_pengajuan_pklmagang_table', 20),
(40, '2025_12_28_200258_create_pengajuan_pkl_siswa_table', 21),
(41, '2025_12_28_203348_add_nama_siswa_to_pengajuan_pkl_siswa_table', 22),
(42, '2025_12_29_143351_add_user_id_to_pengajuan_pklmagang_table', 23),
(43, '2025_12_29_230145_create_pages_table', 24);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`content`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `created_at`, `updated_at`) VALUES
(5, 'syarat-magang', 'Syarat Magang', '[\r\n    {\r\n        \"icon\": \"fas fa-envelope-open-text\",\r\n        \"title\": \"Surat Pengantar Kampus\",\r\n        \"desc\": \"Surat pengantar dari kampus yang ditujukan kepada Kepala Kesbangpol sebagai persetujuan magang.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-file-signature\",\r\n        \"title\": \"Surat Perizinan Kesbangpol\",\r\n        \"desc\": \"Surat resmi dari Kesbangpol yang memberikan izin untuk melaksanakan magang di DKIS.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-file-alt\",\r\n        \"title\": \"Proposal Magang\",\r\n        \"desc\": \"Proposal magang yang menjelaskan tujuan, program, dan kegiatan yang akan dilakukan selama magang.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-user\",\r\n        \"title\": \"CV Terbaru\",\r\n        \"desc\": \"Curriculum Vitae terbaru yang memuat data pribadi, pendidikan, pengalaman, dan keahlian peserta.\",\r\n        \"link\": \"#\"\r\n    }\r\n]\r\n', '2025-12-29 17:02:32', '2025-12-29 17:02:32'),
(6, 'about', 'About', '[\r\n    {\r\n        \"icon\": \"fas fa-info-circle\",\r\n        \"title\": \"About Sistem Informasi PKL & Magang\",\r\n        \"desc\": \"Sistem Informasi ini memudahkan siswa/mahasiswa untuk mengajukan permohonan PKL dan magang di Dinas Komunikasi dan Informatika (DKIS) Kota Cirebon secara online, cepat, dan transparan.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-bullseye\",\r\n        \"title\": \"Tujuan Sistem\",\r\n        \"desc\": \"Memberikan kemudahan dan efisiensi dalam pengajuan PKL dan magang, serta mempermudah pihak DKIS dalam memonitor dan menindaklanjuti pengajuan.\",\r\n        \"link\": \"#\"\r\n    },\r\n    {\r\n        \"icon\": \"fas fa-cogs\",\r\n        \"title\": \"Fitur Utama\",\r\n        \"desc\": \"Sistem menyediakan fitur pendaftaran online, persetujuan otomatis, manajemen dokumen, serta notifikasi bagi peserta dan admin.\",\r\n        \"link\": \"#\"\r\n    }\r\n]\r\n', '2025-12-29 17:20:52', '2025-12-30 02:31:21'),
(8, 'faqs', 'FAQs', '[\n    {\n        \"icon\": \"fas fa-circle\",\n        \"title\": \"Siapa yang bisa mengikuti PKL dan Magang di DKIS?\",\n        \"desc\": \"Semua siswa\\/mahasiswa yang memenuhi syarat dapat mendaftar melalui sistem online DKIS.\",\n        \"link\": \"#\"\n    },\n    {\n        \"icon\": \"fas fa-circle\",\n        \"title\": \"Bagaimana cara mengajukan permohonan PKL\\/Magang?\",\n        \"desc\": \"Isi formulir pendaftaran online, unggah dokumen yang diperlukan, dan tunggu persetujuan dari pihak DKIS.\",\n        \"link\": \"#\"\n    },\n    {\n        \"icon\": \"fas fa-circle\",\n        \"title\": \"Dokumen apa saja yang dibutuhkan untuk pendaftaran?\",\n        \"desc\": \"Surat pengantar kampus, proposal magang, dan CV terbaru.\",\n        \"link\": \"#\"\n    },\n    {\n        \"icon\": \"fas fa-circle\",\n        \"title\": \"Berapa lama durasi PKL atau Magang di DKIS?\",\n        \"desc\": \"Durasi biasanya 1\\u20133 bulan sesuai kesepakatan dengan pihak DKIS.\",\n        \"link\": \"#\"\n    },\n    {\n        \"icon\": \"fas fa-circle\",\n        \"title\": \"Apakah peserta mendapatkan sertifikat atau surat keterangan?\",\n        \"desc\": \"Ya, setelah selesai peserta akan menerima surat keterangan resmi dari DKIS.\",\n        \"link\": \"#\"\n    },\n    {\n        \"icon\": \"fas fa-circle\",\n        \"title\": \"Bagaimana jika ada pertanyaan atau kendala selama proses PKL\\/Magang?\",\n        \"desc\": \"Hubungi admin DKIS melalui email, WhatsApp, atau media sosial resmi.\",\n        \"link\": \"#\"\n    }\n]', '2025-12-30 01:06:02', '2025-12-30 01:07:12');

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
(9, 48, '30920058', 'Budi', 'Staf Admin', 1, '2025-12-22 07:42:08', 1, '2025-12-25 00:51:43', 1, NULL, NULL, 1),
(10, NULL, '22061517', 'Santo', 'Staf Pengelola', 2, '2025-12-22 10:20:23', 1, '2025-12-31 00:58:55', 1, NULL, NULL, 1),
(11, NULL, '4150871', 'Andri', 'Staf Pengelola', 2, '2025-12-31 01:12:53', 1, NULL, NULL, NULL, NULL, 1),
(12, 55, '2015411', 'Ranti', 'Staf bidang', 1, '2025-12-31 01:31:18', 1, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembimbing`
--

CREATE TABLE `pembimbing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pengajuan_id` bigint(20) UNSIGNED NOT NULL,
  `pengajuan_type` varchar(255) NOT NULL COMMENT 'App\\Models\\PengajuanPklmagang | App\\Models\\PengajuanMagangMahasiswa',
  `pegawai_id` bigint(20) UNSIGNED NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembimbing`
--

INSERT INTO `pembimbing` (`id`, `user_id`, `pengajuan_id`, `pengajuan_type`, `pegawai_id`, `tahun`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(14, 48, 26, 'App\\Models\\PengajuanMagangMahasiswa', 9, 2026, '2025-12-22 10:08:36', 1, NULL, NULL, NULL, NULL, 1),
(15, 48, 1, 'App\\Models\\PengajuanPklmagang', 9, 2026, '2025-12-22 10:19:30', 1, NULL, NULL, NULL, NULL, 1),
(16, 49, 26, 'App\\Models\\PengajuanMagangMahasiswa', 10, 2026, '2025-12-22 10:21:17', 1, NULL, NULL, NULL, NULL, 1),
(17, 48, 30, 'App\\Models\\PengajuanPklmagang', 9, 2026, '2025-12-29 04:24:54', 1, NULL, NULL, NULL, NULL, 1),
(18, 48, 32, 'App\\Models\\PengajuanPklmagang', 9, 2026, '2025-12-31 01:37:21', 1, '2025-12-31 01:38:02', 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penempatan`
--

CREATE TABLE `penempatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengajuan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pengajuan_type` varchar(255) DEFAULT NULL,
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
-- Dumping data untuk tabel `penempatan`
--

INSERT INTO `penempatan` (`id`, `pengajuan_id`, `pengajuan_type`, `bidang_id`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(2, 26, 'App\\Models\\PengajuanMagangMahasiswa', 1, '2025-12-19 05:37:48', 1, NULL, NULL, 1, '2025-12-22 04:17:38', 1),
(3, 1, 'App\\Models\\PengajuanPklSiswa', 1, '2025-12-19 06:36:22', 1, NULL, NULL, 1, '2025-12-29 03:03:53', 1),
(4, 26, 'App\\Models\\PengajuanMagangMahasiswa', 1, '2025-12-22 04:17:25', 1, NULL, NULL, NULL, NULL, 1),
(7, 9, 'App\\Models\\PengajuanPklSiswa', 2, '2025-12-31 00:58:28', 1, NULL, NULL, 1, '2025-12-31 01:09:23', 1),
(8, 10, 'App\\Models\\PengajuanPklSiswa', 1, '2025-12-31 00:59:21', 1, NULL, NULL, NULL, NULL, 1),
(9, 9, 'App\\Models\\PengajuanPklSiswa', 1, '2025-12-31 01:09:46', 1, NULL, NULL, NULL, NULL, 1),
(10, 12, 'App\\Models\\PengajuanPklSiswa', 1, '2025-12-31 01:52:17', 1, NULL, NULL, NULL, NULL, 1);

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
(26, 41, 'Rara', 'lastricrb3@gmail.com', 'Universitas Muhammadiyah Cirebon', 'Teknik Informatika', '2025-12-18', '2026-01-09', '005/SKet/HRD/VIII/2025', '2025-12-15', 'uploads/surat/1766024599_400-Article Text-1036-1-10-20210331.pdf', 'Selamat anda diterima.', 'diterima', NULL, '2025-12-18 02:23:19', 1, '2025-12-19 04:04:32', NULL, NULL, 1);

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

INSERT INTO `pengajuan_pklmagang` (`id`, `user_id`, `no_surat`, `tgl_surat`, `sekolah_id`, `email_guru`, `jumlah_siswa`, `periode_mulai`, `periode_selesai`, `status`, `file_surat_path`, `catatan`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(32, NULL, '001/PKL/SMKN1/12/2025', '2025-12-31', 1, 'rulastri458@gmail.com', 2, '2026-01-01', '2026-01-10', 'diproses', 'surat/p3jCbJpLDNNwnUwo3WoUOBS0zd0EWTlTZwTvNIC7.pdf', NULL, '2025-12-31 00:55:53', 53, NULL, NULL, NULL, NULL, 1),
(33, NULL, '004/MAG/UNIVERSITASXYZ/03/2025', '2025-12-31', 3, 'rulastri4@gmail.com', 2, '2026-01-01', '2026-01-30', 'diproses', 'surat/w8XG0sL3qrOemxNRDMSBcC8CE83K7wXm93BjTw2M.pdf', NULL, '2025-12-31 01:42:37', 53, NULL, NULL, NULL, NULL, 1);

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
(9, 32, NULL, 'amanda@gmail.com', 'Amanda', 'diterima', 'Selamat anda diterima', '2025-12-31 00:56:12', '2025-12-31 00:57:32'),
(10, 32, NULL, 'jayanti@gmail.com', 'Jayanti', 'diterima', 'Selamat anda diterima', '2025-12-31 00:56:30', '2025-12-31 00:57:49'),
(11, 33, NULL, 'lastricrb3@gmial.com', 'Nana', 'ditolak', 'Hanya 1 Siswa yang diterima', '2025-12-31 01:43:07', '2025-12-31 01:47:30'),
(12, 33, NULL, 'lastricrb3@gmail.com', 'Lastri A', 'diterima', 'Selamat anda diterima', '2025-12-31 01:43:36', '2025-12-31 01:47:36');

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
(2, 16, 14, 76.00, 20.00, 0.00, 0.00, 44.00, '2025-12-18', '2026-01-09', '2025-12-25 01:36:59', '2025-12-31 02:17:09'),
(4, 63, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2025-12-31 02:12:23', '2025-12-31 02:12:23');

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
(27, NULL, '2025-12-22', NULL, NULL, 'absen', 'tidak_lengkap', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(28, 16, '2025-12-22', NULL, NULL, 'absen', 'tidak_lengkap', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(29, 16, '2025-12-23', NULL, '13:18:30', 'hadir', 'tidak_lengkap', NULL, '1766470710_pulang_download.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(30, 16, '2025-12-24', '07:42:16', '15:01:08', 'hadir', 'lengkap', '1766536936_masuk_download.jpg', '1766563269_pulang_download.jpg', NULL, NULL, '2025-12-24 01:43:22', 48, NULL, NULL, 1),
(31, 16, '2025-12-25', NULL, '13:50:19', 'hadir', 'tidak_lengkap', NULL, '1766645421_pulang_download.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(32, 16, '2025-12-26', '07:28:57', NULL, 'hadir', 'tidak_lengkap', '1766708938_masuk_download.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(35, 16, '2025-12-27', NULL, '11:07:25', 'hadir', 'tidak_lengkap', NULL, '1766808445_pulang_download.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(36, NULL, '2025-12-28', NULL, NULL, 'absen', 'tidak_lengkap', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(37, 16, '2025-12-28', NULL, NULL, 'absen', 'tidak_lengkap', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(41, 63, '2025-12-31', '08:04:40', NULL, 'hadir', 'tidak_lengkap', '1767143080_masuk_user-profile_9368284.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(42, 16, '2025-12-31', '08:57:27', '08:59:10', 'hadir', 'lengkap', '1767146247_masuk_user-profile_9368284.png', '1767146350_pulang_download.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile_guru`
--

CREATE TABLE `profile_guru` (
  `id_guru` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Relasi ke users.id setelah akun dibuat',
  `nip` varchar(20) NOT NULL COMMENT 'NIP guru, bukan identitas login',
  `nama_lengkap` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `unit_kerja` varchar(100) NOT NULL COMMENT 'Sekolah / unit kerja',
  `email_resmi` varchar(100) NOT NULL COMMENT 'Email resmi untuk OTP & login',
  `no_hp` varchar(20) DEFAULT NULL,
  `jabatan` varchar(50) NOT NULL DEFAULT 'guru',
  `status_kepegawaian` varchar(30) NOT NULL DEFAULT 'aktif',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `profile_guru`
--

INSERT INTO `profile_guru` (`id_guru`, `user_id`, `nip`, `nama_lengkap`, `tanggal_lahir`, `unit_kerja`, `email_resmi`, `no_hp`, `jabatan`, `status_kepegawaian`, `is_active`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_date`, `deleted_id`) VALUES
(9, 53, '198503152010012002', 'Siti Nurhaliza, M.Pd', '1985-03-15', 'SMA Negeri 2 Cirebon', 'siti.nurhaliza@sman2.sch.id', NULL, 'guru', 'aktif', 1, '2025-12-31 00:38:11', NULL, NULL, NULL, NULL, NULL);

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
(1, 'Admin', 'Administrator sistem', '2025-12-16 10:16:36', NULL, '2025-12-16 10:16:36', NULL, NULL, NULL, 1),
(2, 'Pembimbing', 'Pembimbing PKL/Magang', '2025-12-16 10:16:36', NULL, '2025-12-16 10:16:36', NULL, NULL, NULL, 1),
(3, 'Guru', 'Guru sekolah', '2025-12-16 10:16:36', NULL, '2025-12-16 10:16:36', NULL, NULL, NULL, 1),
(4, 'Siswa', 'Siswa PKL', '2025-12-16 10:16:36', NULL, '2025-12-16 10:16:36', NULL, NULL, NULL, 1),
(5, 'Magang', 'Mahasiswa Magang', '2025-12-16 10:16:36', NULL, '2025-12-16 10:16:36', NULL, NULL, NULL, 1);

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
(1, 'SMPN 1 CIREBON', '22200987', 'JL.', '021-98765432', '2025-12-17 02:58:08', 1, NULL, NULL, NULL, NULL, 1),
(2, 'SMKN 1 Cirebon', '220511', 'Jl. Perjuangan', '0871627899', '2025-12-31 01:21:52', 1, NULL, NULL, 1, '2025-12-31 01:28:31', 1),
(3, 'SMK 4 Kuningan', '2205111', 'Jl. Kuningan No. 5', '0872525660', '2025-12-31 01:27:30', 1, 1, '2025-12-31 01:27:50', NULL, NULL, 1);

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
(69, 16, '001/MAGANG/DKIS-KC/2025', '800/1/DKIS/2025', 'Penyelesaian Keigatan Magang', '2025-12-18', '2026-01-09', '2025-12-31', 'uploads/sertifikat/sertifikat_69.pdf', 'a53e3736-9ad4-4a0d-97d8-bbf752c2cee0', '2025-12-31 02:18:35', '2025-12-31 02:18:40');

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
(16, 41, 26, NULL, 'Rara', NULL, '2100511087', NULL, 'Teknik Informatika', 'Universitas Muhammadiyah Cirebon', 'foto_16_1766112218.png', '2025-12-18 05:19:17', 41, '2025-12-19 02:43:38', 41, NULL, NULL, 1),
(63, 54, NULL, NULL, 'Amanda', '22061161', NULL, '12', 'TKJ', NULL, '', '2025-12-31 01:03:51', 54, '2025-12-31 01:04:26', 54, NULL, NULL, 1);

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
(12, 14, 'Algoritma dan Struktur Data', '<p class=\"ql-align-justify\"><img src=\"data:image/jpeg;base64,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\"></p><p class=\"ql-align-justify\">Mahasiswa diminta membuat laporan mengenai algoritma sorting (bubble, quicksort, merge sort) beserta analisis kompleksitasnya.</p>', '2025-12-26 04:30:00', 'sudah dinilai', '2025-12-23 04:29:26', 48, '2025-12-24 03:47:12', 48, NULL, NULL, 1),
(13, 14, 'Basis Data', '<p class=\"ql-align-justify\">Mendesain ERD dan membuat query SQL untuk sebuah sistem inventaris.</p>', '2025-12-27 04:30:00', 'sudah dinilai', '2025-12-23 04:32:28', 48, '2025-12-23 07:59:28', 48, NULL, NULL, 1),
(14, 14, 'Pembuatan Website Sederhana', '<p>Membuat website portofolio menggunakan HTML, CSS, dan JavaScript.</p>', '2025-12-27 04:30:00', 'sudah dinilai', '2025-12-23 04:33:04', 48, NULL, NULL, NULL, NULL, 1),
(15, 14, 'Aplikasi CRUD Laravel', '<p class=\"ql-align-justify\">Mahasiswa diminta membuat aplikasi manajemen tugas menggunakan Laravel, dengan autentikasi user dan relasi tabel.</p>', '2025-12-30 04:30:00', 'pending', '2025-12-23 04:33:40', 48, NULL, NULL, NULL, NULL, 1),
(16, 14, 'Analisis Keamanan Sistem Informasi', '<p class=\"ql-align-justify\">Menganalisis sistem informasi perusahaan, menemukan potensi vulnerability, dan membuat rekomendasi perbaikan.</p>', '2025-12-29 05:00:00', 'pending', '2025-12-23 04:34:45', 48, '2025-12-23 04:35:06', 48, NULL, NULL, 1),
(17, 14, 'Jaringan Komputer', '<p class=\"ql-align-justify\">Membuat laporan topologi jaringan, protokol TCP/IP, dan konfigurasi simulasi jaringan di Cisco Packet Tracer.</p>', '2025-12-28 05:00:00', 'sudah dinilai', '2025-12-23 04:35:58', 48, NULL, NULL, NULL, NULL, 1),
(18, 14, 'SQL dan MySQL', '<p>Peserta mampu menjelaskan serta meberikan contoh terkait materi ini.</p>', '2025-12-30 01:34:00', 'sudah dinilai', '2025-12-24 01:34:29', 48, NULL, NULL, NULL, NULL, 1),
(19, 14, 'Analisis Data', '<p>Peserta diharapkan mampu memahami apa itu analisis data</p>', '2026-01-02 02:05:00', 'pending', '2025-12-31 02:05:32', 48, NULL, NULL, NULL, NULL, 1);

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
(4, 13, 16, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(5, 12, 16, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(6, 14, 16, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(7, 18, 16, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(8, 17, 16, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(9, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(11, 19, 16, NULL, NULL, NULL, NULL, NULL, NULL, 1);

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

INSERT INTO `tugas_submit` (`id`, `tugas_id`, `siswa_id`, `catatan`, `link_lampiran`, `file`, `submitted_at`, `status`, `skor`, `feedback`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_date`, `deleted_id`, `is_active`) VALUES
(5, 12, 16, NULL, NULL, 'uploads/tugas/1766548174_Algoritma_dan_Struktur_Data_Tugas.pdf', '2025-12-24 03:49:34', 'sudah dinilai', 90.00, 'bagus', '2025-12-24 03:49:34', 41, '2025-12-24 03:50:29', 48, NULL, NULL, 1),
(6, 13, 16, 'Tugas ini membahas konsep dasar basis data, sistem manajemen basis data (DBMS), serta peran basis data dalam pengelolaan informasi.', 'https://github.com/username/basis-data-project', 'tugas_files/FIU3gWJL7MALxz5gWE1EU5OKaSWIML1K72RYFl0f.pdf', '2025-12-23 07:09:52', 'sudah dinilai', 50.00, 'ditingkatkan lagi belajarnya..', '2025-12-23 07:09:52', 41, '2025-12-24 05:19:56', 48, NULL, NULL, 1),
(7, 18, 16, NULL, NULL, 'tugas_files/AUAMH00E5pEgCyey3hlN1hXKIYz0K9QARSOX0DZ0.pdf', '2025-12-24 01:50:26', 'sudah dinilai', 95.00, NULL, '2025-12-24 01:50:26', 41, '2025-12-25 00:34:32', 48, NULL, NULL, 1),
(8, 14, 16, NULL, NULL, 'uploads/tugas/1766622716_Algoritma_dan_Struktur_Data_Tugas.pdf', '2025-12-25 00:31:57', 'sudah dinilai', 60.00, NULL, '2025-12-25 00:31:57', 41, '2025-12-25 00:32:33', 48, NULL, NULL, 1),
(9, 17, 16, 'xxas', 'https://github.com/username/algoritma-struktur-data', 'uploads/tugas/1766809986_Algoritma_dan_Struktur_Data_Tugas.pdf', '2025-12-27 04:33:27', 'sudah dinilai', 85.00, 'lebih semangat lagi.', '2025-12-27 04:14:35', 41, '2025-12-31 02:07:23', 48, NULL, NULL, 1),
(10, 15, 16, 'adaa', 'https://github.com/username/basis-data-project', 'uploads/tugas/1766809839_sertifikat_26.pdf', '2025-12-27 04:32:50', 'pending', NULL, NULL, '2025-12-27 04:22:46', 41, '2025-12-27 04:32:50', 41, NULL, NULL, 1),
(12, 19, 16, 'Saya sudah memahami apa itu analisis data', NULL, 'uploads/tugas/1767147052_Template-Surat-Permohonan-Magang-di-Bank-Indonesia-Mekari-Sign.docx.pdf', '2025-12-31 02:10:52', 'pending', NULL, NULL, NULL, NULL, '2025-12-31 02:10:52', 41, NULL, NULL, 1);

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

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `force_change_password`, `role_id`, `created_date`, `created_id`, `updated_date`, `updated_id`, `deleted_id`, `deleted_date`, `is_active`) VALUES
(1, 'Administrator', 'admin@example.com', '2025-12-16 10:16:42', '$2y$10$24H2mgFziP1IAVxTx7RG4O77aQuomrN8uKk0IVi0ecugjEevf18t.', 1, 1, '2025-12-16 10:16:42', NULL, '2025-12-16 10:16:42', NULL, NULL, NULL, 1),
(26, 'Rania', 'rifkifadilah.1@gmail.com', '2025-12-17 16:50:11', '$2y$10$GtgMPB96KTk8XFn0JbP5JeLF/G.Vc1fA2QO//zklZdHoBopSHSHg2', 0, 5, '2025-12-17 16:49:44', 1, '2025-12-18 02:28:45', 1, NULL, NULL, 1),
(41, 'Rara', 'lastri@gmail.com', '2025-12-18 04:28:46', '$2y$10$nfo5j03QXYO/qSxOEaBoge0omwTzPu/zaJ6Rk712q2lKs.6MQa482', 0, 5, '2025-12-18 04:27:49', 1, '2025-12-31 01:02:35', 1, NULL, NULL, 1),
(48, 'Budi', 'rulastri8@gmail.com', '2025-12-22 07:42:53', '$2y$10$Z2vaYT1rn2S/Y2mMpybpx.3iVylgES.HJgzEfpVqQjbGd5afD5x4.', 0, 2, '2025-12-22 07:42:22', 1, '2025-12-22 07:43:59', 1, NULL, NULL, 1),
(53, 'Siti Nurhaliza, M.Pd', 'rulastri4@gmail.com', '2025-12-31 00:41:58', '$2y$10$s2kNdc2T1KhCIOSseY9nFuurV3JrJi.rNME3658TD.x/9Ganb3mim', 1, 3, '2025-12-31 00:38:10', NULL, '2025-12-31 01:02:46', 1, NULL, NULL, 1),
(54, 'amanda', 'amanda@gmail.com', '2025-12-31 01:02:04', '$2y$10$jVmK6Gc4ii/c75iWoZ0EIuI4Xwon/j2S6WmY.LPGiDG9/Fpx7Aqdi', 0, 4, '2025-12-31 01:00:42', 1, NULL, NULL, NULL, NULL, 1),
(55, 'Ranti', 'rulastri458@gmail.com', '2025-12-31 01:33:29', '$2y$10$TlxMDW9CEm7wTS9mumSwf.WbODAksZEF3/xBrxviBt4NO/hujocda', 0, 2, '2025-12-31 01:32:16', 1, '2025-12-31 01:34:49', 1, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

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
-- Indeks untuk tabel `data_referensi_guru`
--
ALTER TABLE `data_referensi_guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_referensi_guru_nip_unique` (`nip`),
  ADD UNIQUE KEY `data_referensi_guru_email_resmi_unique` (`email_resmi`);

--
-- Indeks untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_user_id_foreign` (`user_id`);

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
  ADD KEY `pembimbing_pegawai_id_foreign` (`pegawai_id`),
  ADD KEY `pembimbing_pengajuan_id_pegawai_id_index` (`pengajuan_id`,`pegawai_id`);

--
-- Indeks untuk tabel `penempatan`
--
ALTER TABLE `penempatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penempatan_bidang_id_foreign` (`bidang_id`),
  ADD KEY `penempatan_pengajuan_id_bidang_id_index` (`pengajuan_id`,`bidang_id`),
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
-- Indeks untuk tabel `profile_guru`
--
ALTER TABLE `profile_guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `profile_guru_nip_unique` (`nip`),
  ADD UNIQUE KEY `profile_guru_email_resmi_unique` (`email_resmi`),
  ADD UNIQUE KEY `profile_guru_user_id_unique` (`user_id`),
  ADD KEY `profile_guru_nip_tanggal_lahir_index` (`nip`,`tanggal_lahir`),
  ADD KEY `profile_guru_jabatan_status_kepegawaian_index` (`jabatan`,`status_kepegawaian`),
  ADD KEY `profile_guru_is_active_index` (`is_active`),
  ADD KEY `profile_guru_created_id_foreign` (`created_id`),
  ADD KEY `profile_guru_updated_id_foreign` (`updated_id`),
  ADD KEY `profile_guru_deleted_id_foreign` (`deleted_id`);

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
-- AUTO_INCREMENT untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `daily_report`
--
ALTER TABLE `daily_report`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `data_referensi_guru`
--
ALTER TABLE `data_referensi_guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pembimbing`
--
ALTER TABLE `pembimbing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `penempatan`
--
ALTER TABLE `penempatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_magang_mahasiswa`
--
ALTER TABLE `pengajuan_magang_mahasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_pklmagang`
--
ALTER TABLE `pengajuan_pklmagang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_pkl_siswa`
--
ALTER TABLE `pengajuan_pkl_siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `penilaian_akhir`
--
ALTER TABLE `penilaian_akhir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `profile_guru`
--
ALTER TABLE `profile_guru`
  MODIFY `id_guru` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `siswa_profile`
--
ALTER TABLE `siswa_profile`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tugas_assignee`
--
ALTER TABLE `tugas_assignee`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tugas_submit`
--
ALTER TABLE `tugas_submit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

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
-- Ketidakleluasaan untuk tabel `profile_guru`
--
ALTER TABLE `profile_guru`
  ADD CONSTRAINT `profile_guru_created_id_foreign` FOREIGN KEY (`created_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `profile_guru_deleted_id_foreign` FOREIGN KEY (`deleted_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `profile_guru_updated_id_foreign` FOREIGN KEY (`updated_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `profile_guru_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
