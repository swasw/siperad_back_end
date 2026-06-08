-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for siperad
DROP DATABASE IF EXISTS `siperad`;
CREATE DATABASE IF NOT EXISTS `siperad` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `siperad`;

-- Dumping structure for table siperad.angkatans
DROP TABLE IF EXISTS `angkatans`;
CREATE TABLE IF NOT EXISTS `angkatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `angkatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.angkatans: ~4 rows (approximately)
DELETE FROM `angkatans`;
INSERT INTO `angkatans` (`id`, `angkatan`, `created_at`, `updated_at`) VALUES
	(1, '2021', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(2, '2022', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(3, '2023', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(4, '2024', '2025-06-24 22:04:38', '2025-06-24 22:04:38');

-- Dumping structure for table siperad.barangs
DROP TABLE IF EXISTS `barangs`;
CREATE TABLE IF NOT EXISTS `barangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_barang` text COLLATE utf8mb4_unicode_ci,
  `status_barang` tinyint(1) NOT NULL DEFAULT '0',
  `stok` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.barangs: ~4 rows (approximately)
DELETE FROM `barangs`;
INSERT INTO `barangs` (`id`, `nama_barang`, `deskripsi_barang`, `status_barang`, `stok`, `created_at`, `updated_at`) VALUES
	(1, 'LCD', NULL, 1, 3, '2025-06-24 22:04:37', '2025-06-24 22:04:37'),
	(2, 'Alat Tulis', NULL, 1, 4, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(3, 'Kabel HDMI', 'Kabel Penghubung HDMI', 1, 4, '2025-06-24 22:04:38', '2025-06-25 02:08:30'),
	(4, 'Stop Kontak', NULL, 1, 4, '2025-06-24 22:04:38', '2025-06-24 22:04:38');

-- Dumping structure for table siperad.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table siperad.jadwal_ruangans
DROP TABLE IF EXISTS `jadwal_ruangans`;
CREATE TABLE IF NOT EXISTS `jadwal_ruangans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ruang_id` bigint unsigned NOT NULL,
  `matkul_id` bigint unsigned NOT NULL,
  `dosen_id` bigint unsigned NOT NULL,
  `hari` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai_id` bigint unsigned NOT NULL,
  `jam_selesai_id` bigint unsigned NOT NULL,
  `prodi_id` bigint unsigned NOT NULL,
  `angkatan_id` bigint unsigned NOT NULL,
  `status_ruang` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.jadwal_ruangans: ~29 rows (approximately)
DELETE FROM `jadwal_ruangans`;
INSERT INTO `jadwal_ruangans` (`id`, `ruang_id`, `matkul_id`, `dosen_id`, `hari`, `jam_mulai_id`, `jam_selesai_id`, `prodi_id`, `angkatan_id`, `status_ruang`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, 9, 'senin', 1, 4, 1, 1, 0, '2025-06-24 22:28:22', '2025-06-24 22:34:33'),
	(2, 2, 2, 33, 'senin', 4, 7, 2, 1, 0, '2025-06-24 22:30:24', '2025-06-24 22:35:44'),
	(3, 3, 3, 24, 'senin', 4, 7, 1, 2, 0, '2025-06-24 22:31:17', '2025-06-24 22:39:38'),
	(4, 3, 4, 32, 'senin', 7, 9, 2, 1, 0, '2025-06-24 22:33:42', '2025-06-24 22:37:49'),
	(5, 4, 5, 13, 'senin', 4, 7, 1, 1, 0, '2025-06-24 22:34:18', '2025-06-24 22:39:47'),
	(6, 5, 6, 24, 'senin', 7, 10, 1, 3, 0, '2025-06-24 22:35:24', '2025-06-24 22:39:54'),
	(7, 1, 7, 31, 'senin', 4, 6, 4, 3, 1, '2025-06-24 22:37:40', '2025-06-24 22:37:40'),
	(8, 1, 8, 6, 'senin', 7, 10, 2, 3, 1, '2025-06-24 22:41:08', '2025-06-24 22:41:08'),
	(9, 6, 9, 8, 'senin', 4, 6, 4, 2, 1, '2025-06-24 22:42:05', '2025-06-24 22:42:05'),
	(10, 6, 10, 10, 'senin', 7, 9, 3, 1, 1, '2025-06-24 22:43:22', '2025-06-24 22:43:22'),
	(11, 7, 7, 25, 'senin', 2, 4, 4, 3, 1, '2025-06-24 22:44:32', '2025-06-24 22:44:32'),
	(12, 7, 11, 12, 'senin', 4, 7, 1, 3, 1, '2025-06-24 22:45:20', '2025-06-24 22:45:20'),
	(13, 7, 12, 36, 'senin', 7, 9, 2, 3, 1, '2025-06-24 22:46:36', '2025-06-24 22:46:36'),
	(14, 7, 13, 9, 'senin', 9, 12, 4, 2, 0, '2025-06-24 22:47:24', '2025-06-24 23:52:26'),
	(15, 8, 14, 23, 'senin', 2, 4, 4, 2, 1, '2025-06-24 22:48:51', '2025-06-24 22:48:51'),
	(16, 8, 7, 38, 'senin', 4, 7, 2, 3, 1, '2025-06-24 22:49:27', '2025-06-24 22:49:27'),
	(17, 8, 12, 25, 'senin', 7, 9, 4, 3, 1, '2025-06-24 22:50:26', '2025-06-24 22:50:26'),
	(18, 9, 15, 2, 'senin', 4, 6, 3, 1, 1, '2025-06-24 22:51:10', '2025-06-24 22:51:10'),
	(19, 9, 16, 35, 'senin', 7, 10, 4, 1, 1, '2025-06-24 22:52:18', '2025-06-24 22:52:18'),
	(20, 10, 17, 14, 'senin', 1, 7, 2, 2, 0, '2025-06-24 22:53:50', '2025-06-24 22:55:02'),
	(21, 10, 18, 16, 'senin', 7, 9, 4, 1, 1, '2025-06-24 22:54:50', '2025-06-24 22:54:50'),
	(22, 11, 4, 2, 'senin', 2, 4, 3, 2, 1, '2025-06-24 22:55:39', '2025-06-24 22:55:39'),
	(23, 11, 20, 11, 'senin', 4, 7, 2, 2, 1, '2025-06-24 22:56:45', '2025-06-24 22:56:45'),
	(24, 11, 11, 30, 'senin', 7, 10, 2, 1, 1, '2025-06-24 22:58:06', '2025-06-24 22:58:06'),
	(25, 12, 21, 32, 'senin', 4, 7, 4, 1, 1, '2025-06-24 22:59:50', '2025-06-24 22:59:50'),
	(26, 12, 22, 25, 'senin', 7, 9, 3, 3, 1, '2025-06-24 23:00:30', '2025-06-24 23:00:30'),
	(27, 13, 9, 8, 'senin', 2, 4, 2, 2, 1, '2025-06-24 23:00:59', '2025-06-24 23:00:59'),
	(28, 13, 12, 36, 'senin', 4, 6, 2, 3, 1, '2025-06-24 23:01:30', '2025-06-24 23:01:30'),
	(29, 13, 23, 14, 'senin', 7, 10, 3, 3, 1, '2025-06-24 23:02:07', '2025-06-24 23:02:07'),
	(30, 8, 14, 8, 'selasa', 2, 4, 4, 2, 1, '2025-06-24 23:44:04', '2025-06-24 23:44:04');

-- Dumping structure for table siperad.jams
DROP TABLE IF EXISTS `jams`;
CREATE TABLE IF NOT EXISTS `jams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jam` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.jams: ~13 rows (approximately)
DELETE FROM `jams`;
INSERT INTO `jams` (`id`, `jam`, `created_at`, `updated_at`) VALUES
	(1, '07:30:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(2, '08:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(3, '09:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(4, '10:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(5, '11:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(6, '12:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(7, '13:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(8, '14:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(9, '15:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(10, '16:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(11, '17:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(12, '18:00:00', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(13, '19:00:00', '2025-06-24 22:47:52', '2025-06-24 22:47:52');

-- Dumping structure for table siperad.mata_kuliahs
DROP TABLE IF EXISTS `mata_kuliahs`;
CREATE TABLE IF NOT EXISTS `mata_kuliahs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mata_kuliah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.mata_kuliahs: ~23 rows (approximately)
DELETE FROM `mata_kuliahs`;
INSERT INTO `mata_kuliahs` (`id`, `mata_kuliah`, `created_at`, `updated_at`) VALUES
	(1, 'SIM', '2025-06-24 22:05:25', '2025-06-24 22:05:25'),
	(2, 'TRO', '2025-06-24 22:05:33', '2025-06-24 22:05:33'),
	(3, 'Int. Man', '2025-06-24 22:06:10', '2025-06-24 22:06:10'),
	(4, 'StatNonPar', '2025-06-24 22:06:27', '2025-06-24 22:06:27'),
	(5, 'Komp. Graf', '2025-06-24 22:06:41', '2025-06-24 22:06:41'),
	(6, 'DDP', '2025-06-24 22:07:05', '2025-06-24 22:07:05'),
	(7, 'KalDif', '2025-06-24 22:07:18', '2025-06-24 22:07:18'),
	(8, 'AnRiil', '2025-06-24 22:07:32', '2025-06-24 22:07:32'),
	(9, 'FilMIP', '2025-06-24 22:07:40', '2025-06-24 22:07:48'),
	(10, 'KapSel', '2025-06-24 22:08:03', '2025-06-24 22:08:03'),
	(11, 'MatDis', '2025-06-24 22:08:13', '2025-06-24 22:08:13'),
	(12, 'PDM', '2025-06-24 22:08:22', '2025-06-24 22:08:22'),
	(13, 'Struk Dat', '2025-06-24 22:08:32', '2025-06-24 22:08:32'),
	(14, 'BIM', '2025-06-24 22:08:48', '2025-06-24 22:08:48'),
	(15, 'SPS', '2025-06-24 22:09:10', '2025-06-24 22:09:10'),
	(16, 'KalVar', '2025-06-24 22:09:20', '2025-06-24 22:09:20'),
	(17, 'VarKom', '2025-06-24 22:09:33', '2025-06-24 22:09:33'),
	(18, 'Sist Din', '2025-06-24 22:09:51', '2025-06-24 22:09:51'),
	(19, 'Data Mining', '2025-06-24 22:10:01', '2025-06-24 22:10:01'),
	(20, 'KPB', '2025-06-24 22:10:14', '2025-06-24 22:10:14'),
	(21, 'StatMat 2', '2025-06-24 22:10:26', '2025-06-24 22:10:42'),
	(22, 'Wirus', '2025-06-24 22:10:50', '2025-06-24 22:10:50'),
	(23, 'Alj Mat', '2025-06-24 22:11:10', '2025-06-24 22:11:10');

-- Dumping structure for table siperad.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.migrations: ~0 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(129, '2014_10_12_000000_create_users_table', 1),
	(130, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(131, '2014_10_12_100000_create_password_resets_table', 1),
	(132, '2019_08_19_000000_create_failed_jobs_table', 1),
	(133, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(134, '2024_06_20_094048_create_prodis_table', 1),
	(135, '2024_06_21_140335_create_angkatans_table', 1),
	(136, '2025_06_20_024401_create_barangs_table', 1),
	(137, '2025_06_20_024546_create_peminjaman_barangs_table', 1),
	(138, '2025_06_20_060537_create_ruangs_table', 1),
	(139, '2025_06_20_060545_create_peminjaman_ruangs_table', 1),
	(140, '2025_06_22_035236_create_mahasiswas_table', 1),
	(141, '2025_06_23_025901_create_jadwal_ruangans_table', 1),
	(142, '2025_06_23_044640_create_jams_table', 1),
	(143, '2025_06_23_063755_create_mata_kuliahs_table', 1),
	(144, '2025_06_23_063803_create_nama_dosens_table', 1);

-- Dumping structure for table siperad.nama_dosens
DROP TABLE IF EXISTS `nama_dosens`;
CREATE TABLE IF NOT EXISTS `nama_dosens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_dosen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.nama_dosens: ~38 rows (approximately)
DELETE FROM `nama_dosens`;
INSERT INTO `nama_dosens` (`id`, `nama_dosen`, `created_at`, `updated_at`) VALUES
	(1, 'Ir. Fariani Hermin Indiyah, MT.', '2025-06-24 22:11:54', '2025-06-24 22:12:55'),
	(2, 'Dr. Ir. Bagus Sumargo, M.Si.', '2025-06-24 22:15:47', '2025-06-24 22:15:47'),
	(3, 'Dr. Makmuri, M.Si', '2025-06-24 22:16:02', '2025-06-24 22:16:02'),
	(4, 'Prof. Dr. Wardani Rahayu, M.Si.', '2025-06-24 22:16:15', '2025-06-24 22:16:15'),
	(5, 'Dr. Pinta Deniyanti S, M.Si.', '2025-06-24 22:16:27', '2025-06-24 22:16:27'),
	(6, 'Dr. Ellis Salsabila, M.Si.', '2025-06-24 22:16:51', '2025-06-24 22:16:51'),
	(7, 'Prof. Dr. Suyono, M.Si.', '2025-06-24 22:17:15', '2025-06-24 22:17:15'),
	(8, 'Drs. Sudarwanto, M.Si, DEA.', '2025-06-24 22:17:38', '2025-06-24 22:17:38'),
	(9, 'Drs. Mulyono, M.Kom.', '2025-06-24 22:17:48', '2025-06-24 22:17:48'),
	(10, 'Dr. Dian Handayani, M.SI.', '2025-06-24 22:18:00', '2025-06-24 22:18:00'),
	(11, 'Dra. Widyanti Rahayu, M.Si.', '2025-06-24 22:18:10', '2025-06-24 22:18:10'),
	(12, 'Ratna Widyati, S.Si., M.Kom.', '2025-06-24 22:18:21', '2025-06-24 22:18:21'),
	(13, 'Med Irzal, M.Kom.', '2025-06-24 22:18:29', '2025-06-24 22:18:29'),
	(14, 'Vera Maya Santi, M.Si.', '2025-06-24 22:18:38', '2025-06-24 22:18:38'),
	(15, 'Dr. Ria Arafiyah, M.Si.', '2025-06-24 22:18:47', '2025-06-24 22:18:47'),
	(16, 'Dr. Eti Dwi W, S.Pd., M.Si.', '2025-06-24 22:18:57', '2025-06-24 22:18:57'),
	(17, 'Dr. Lukman El Hakim, M.Pd.', '2025-06-24 22:19:36', '2025-06-24 22:19:36'),
	(18, 'Aris Hadiyan Wijaksana, M.Pd.', '2025-06-24 22:19:43', '2025-06-24 22:19:43'),
	(19, 'Ibnu Hadi, M.Si.', '2025-06-24 22:19:51', '2025-06-24 22:19:51'),
	(20, 'Dwi Antari Wijayanti, M.Pd.', '2025-06-24 22:20:00', '2025-06-24 22:20:00'),
	(21, 'Dr. Yudi Mahatma, M.Si.', '2025-06-24 22:20:07', '2025-06-24 22:20:07'),
	(22, 'Dr. Meiliasari, S.Pd., M.Sc.', '2025-06-24 22:20:22', '2025-06-24 22:20:22'),
	(23, 'Dr. Puspita Sari, S.Pd., M.Sc.', '2025-06-24 22:20:31', '2025-06-24 22:20:31'),
	(24, 'Muhammad Eka S, M.Kom.', '2025-06-24 22:20:38', '2025-06-24 22:20:38'),
	(25, 'Debby Agustine, M.Si.', '2025-06-24 22:20:44', '2025-06-24 22:20:44'),
	(26, 'Siti Rohmah R, S.Pd., M.Si.', '2025-06-24 22:20:51', '2025-06-24 22:20:51'),
	(27, 'Dania Siregar, S.Stat., M.Si.', '2025-06-24 22:20:59', '2025-06-24 22:20:59'),
	(28, 'Ari Hendarno, S.Pd., M.Kom.', '2025-06-24 22:21:15', '2025-06-24 22:21:15'),
	(29, 'Dr. Mimi Nur Hajizah, M.Pd.', '2025-06-24 22:21:28', '2025-06-24 22:21:28'),
	(30, 'Tian Abdul Aziz, Ph.D.', '2025-06-24 22:21:41', '2025-06-24 22:21:41'),
	(31, 'Devi Eka W M, S.Pd., M.Si.', '2025-06-24 22:21:48', '2025-06-24 22:21:48'),
	(32, 'Qorry Meidianingsih, M.Si.', '2025-06-24 22:21:58', '2025-06-24 22:21:58'),
	(33, 'Leny Dhianti Haeruman, M.Pd.', '2025-06-24 22:22:06', '2025-06-24 22:22:06'),
	(34, 'Dr. Flavia AH, S.Pd., M.Pd.', '2025-06-24 22:22:13', '2025-06-24 22:22:13'),
	(35, 'Faroh Ladayya, M.Si.', '2025-06-24 22:22:22', '2025-06-24 22:22:22'),
	(36, 'Dr. Anny Sovia, S.Si., M.Pd.', '2025-06-24 22:22:29', '2025-06-24 22:22:29'),
	(37, 'Agus Agung P, S.Si., M.Pd.', '2025-06-24 22:22:39', '2025-06-24 22:22:39'),
	(38, 'Nurashri Partasiwi, S.Si., M.Pd.', '2025-06-24 22:22:48', '2025-06-24 22:22:48');

-- Dumping structure for table siperad.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.password_resets: ~0 rows (approximately)
DELETE FROM `password_resets`;

-- Dumping structure for table siperad.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table siperad.peminjaman_barangs
DROP TABLE IF EXISTS `peminjaman_barangs`;
CREATE TABLE IF NOT EXISTS `peminjaman_barangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tgl_peminjaman` date NOT NULL,
  `nama_peminjam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodi_id` bigint unsigned NOT NULL,
  `angkatan_id` bigint unsigned NOT NULL,
  `matkul_id` bigint unsigned NOT NULL,
  `dosen_id` bigint unsigned NOT NULL,
  `barang_id` bigint unsigned NOT NULL,
  `status_peminjaman` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.peminjaman_barangs: ~0 rows (approximately)
DELETE FROM `peminjaman_barangs`;
INSERT INTO `peminjaman_barangs` (`id`, `tgl_peminjaman`, `nama_peminjam`, `nim`, `no_hp`, `prodi_id`, `angkatan_id`, `matkul_id`, `dosen_id`, `barang_id`, `status_peminjaman`, `created_at`, `updated_at`) VALUES
	(1, '2025-06-25', 'Ridwan', '1313618016', '081322515328', 1, 1, 6, 9, 1, 0, '2025-06-25 02:16:04', '2025-06-25 02:16:04'),
	(2, '2025-06-26', 'Yola', '1313618017', '081322515320', 2, 3, 13, 14, 2, 0, '2025-06-25 02:47:24', '2025-06-25 02:47:24');

-- Dumping structure for table siperad.peminjaman_ruangs
DROP TABLE IF EXISTS `peminjaman_ruangs`;
CREATE TABLE IF NOT EXISTS `peminjaman_ruangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_peminjam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `matkul_id` bigint unsigned NOT NULL,
  `jam_mulai_id` bigint unsigned NOT NULL,
  `jam_selesai_id` bigint unsigned NOT NULL,
  `dosen_id` bigint unsigned NOT NULL,
  `ruang_id` bigint unsigned NOT NULL,
  `prodi_id` bigint unsigned NOT NULL,
  `angkatan_id` bigint unsigned NOT NULL,
  `status_peminjaman` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.peminjaman_ruangs: ~0 rows (approximately)
DELETE FROM `peminjaman_ruangs`;

-- Dumping structure for table siperad.personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;

-- Dumping structure for table siperad.prodis
DROP TABLE IF EXISTS `prodis`;
CREATE TABLE IF NOT EXISTS `prodis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_prodi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.prodis: ~4 rows (approximately)
DELETE FROM `prodis`;
INSERT INTO `prodis` (`id`, `nama_prodi`, `created_at`, `updated_at`) VALUES
	(1, 'Ilmu Komputer', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(2, 'Pendidikan Matematika', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(3, 'Statistika', '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(4, 'Matematika', '2025-06-24 22:04:38', '2025-06-24 22:04:38');

-- Dumping structure for table siperad.ruangs
DROP TABLE IF EXISTS `ruangs`;
CREATE TABLE IF NOT EXISTS `ruangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_ruang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_ruang` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.ruangs: ~13 rows (approximately)
DELETE FROM `ruangs`;
INSERT INTO `ruangs` (`id`, `nama_ruang`, `keterangan`, `status_ruang`, `created_at`, `updated_at`) VALUES
	(1, 'GDS 507', 'Ruang Belajar', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(2, 'GDS 508', 'Lab Komputer', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(3, 'GDS 512', 'Lab Komputer', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(4, 'GDS 514', 'Lab Komputer', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(5, 'GDS 515', 'Lab Komputer', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(6, 'GDS 517', 'Ruang Belajar', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(7, 'GDS 607', 'Ruang Belajar', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(8, 'GDS 608', 'Ruang Belajar', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(9, 'GDS 613', 'Ruang Belajar', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(10, 'GDS 614', 'Ruang Belajar', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(11, 'GHA 206', 'Ruang Belajar', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(12, 'GHA 213', 'Ruang Belajar', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(13, 'GHA 411', 'Ruang Belajar', 1, '2025-06-24 22:04:38', '2025-06-24 22:04:38');

-- Dumping structure for table siperad.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodi_id` bigint unsigned NOT NULL,
  `angkatan_id` bigint unsigned NOT NULL,
  `type` tinyint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siperad.users: ~2 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `prodi_id`, `angkatan_id`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin', 'admin@gmail.com', NULL, '$2y$12$KTo7ctJqYotdnhCEOq2rk.iziNpg6Ry2QRIwhUSCotNw4pmdCS5Q6', 1, 1, 1, NULL, '2025-06-24 22:04:38', '2025-06-24 22:04:38'),
	(2, 'Ridwan', '1313618016', 'user@gmail.com', NULL, '$2y$12$ViJGRwHwnYSuJqDj0fzoKujmk9eWlSHRFyH6FWpRxMLL/VVdhynVO', 1, 1, 0, NULL, '2025-06-24 22:04:38', '2025-06-24 22:04:38');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
