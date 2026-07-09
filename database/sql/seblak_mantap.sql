-- =====================================================================
-- Seblak Mantap - Database Schema + Seed Data (MySQL / HeidiSQL)
-- =====================================================================
-- Cara pakai di HeidiSQL:
-- 1. Buat database baru bernama seblak_db (atau nama lain, sesuaikan
--    juga dengan DB_DATABASE di file .env project Laravel-nya).
-- 2. Klik database tsb, buka tab "Query", tempel seluruh isi file ini,
--    lalu jalankan (F9 / tombol Execute).
-- 3. Sesuaikan DB_DATABASE di .env kalau kamu memberi nama lain.
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `seblak_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `seblak_db`;

SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- Tabel bawaan Laravel
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabel aplikasi Seblak Mantap
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pakets`;
CREATE TABLE `pakets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_paket` varchar(255) NOT NULL,
  `deskripsi` text,
  `harga` decimal(10,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kategori` enum('kuah','goreng','seafood','mie','lainnya') NOT NULL DEFAULT 'kuah',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kondimens`;
CREATE TABLE `kondimens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kondimen` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pengaturans`;
CREATE TABLE `pengaturans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_toko` varchar(255) NOT NULL DEFAULT 'Seblak Mantap',
  `logo` varchar(255) DEFAULT NULL,
  `alamat_toko` text,
  `deskripsi_toko` text,
  `no_wa` varchar(255) DEFAULT NULL,
  `nama_rekening` varchar(255) DEFAULT NULL,
  `qris_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pemesanans`;
CREATE TABLE `pemesanans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_pemesanan` varchar(255) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `tipe_pesanan` enum('makan_di_tempat','bawa_pulang','delivery') NOT NULL DEFAULT 'bawa_pulang',
  `meja` varchar(255) DEFAULT NULL,
  `alamat_pengiriman` text,
  `catatan` text,
  `total_harga` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status_pesanan` enum('menunggu_pembayaran','diproses','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu_pembayaran',
  `status_pembayaran` enum('belum_bayar','menunggu_konfirmasi','lunas') NOT NULL DEFAULT 'belum_bayar',
  `metode_pembayaran` enum('qris','cash') NOT NULL DEFAULT 'qris',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pemesanans_kode_pemesanan_unique` (`kode_pemesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `detail_pemesanans`;
CREATE TABLE `detail_pemesanans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pemesanan_id` bigint unsigned NOT NULL,
  `paket_id` bigint unsigned NOT NULL,
  `jumlah` int unsigned NOT NULL DEFAULT 1,
  `tingkat_pedas` tinyint unsigned NOT NULL DEFAULT 1,
  `harga_satuan` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_pemesanans_pemesanan_id_foreign` (`pemesanan_id`),
  KEY `detail_pemesanans_paket_id_foreign` (`paket_id`),
  CONSTRAINT `detail_pemesanans_pemesanan_id_foreign` FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detail_pemesanans_paket_id_foreign` FOREIGN KEY (`paket_id`) REFERENCES `pakets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `detail_pemesanan_kondimen`;
CREATE TABLE `detail_pemesanan_kondimen` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `detail_pemesanan_id` bigint unsigned NOT NULL,
  `kondimen_id` bigint unsigned NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_pemesanan_kondimen_detail_pemesanan_id_foreign` (`detail_pemesanan_id`),
  KEY `detail_pemesanan_kondimen_kondimen_id_foreign` (`kondimen_id`),
  CONSTRAINT `detail_pemesanan_kondimen_detail_pemesanan_id_foreign` FOREIGN KEY (`detail_pemesanan_id`) REFERENCES `detail_pemesanans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detail_pemesanan_kondimen_kondimen_id_foreign` FOREIGN KEY (`kondimen_id`) REFERENCES `kondimens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pembayarans`;
CREATE TABLE `pembayarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pemesanan_id` bigint unsigned NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `tanggal_bayar` timestamp NULL DEFAULT NULL,
  `dikonfirmasi_oleh` bigint unsigned DEFAULT NULL,
  `tanggal_konfirmasi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayarans_pemesanan_id_foreign` (`pemesanan_id`),
  KEY `pembayarans_dikonfirmasi_oleh_foreign` (`dikonfirmasi_oleh`),
  CONSTRAINT `pembayarans_pemesanan_id_foreign` FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pembayarans_dikonfirmasi_oleh_foreign` FOREIGN KEY (`dikonfirmasi_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2026_07_07_100001_create_pakets_table', 2),
('2026_07_07_100002_create_kondimens_table', 2),
('2026_07_07_100003_create_pengaturans_table', 2),
('2026_07_07_100004_create_pemesanans_table', 2),
('2026_07_07_100005_create_detail_pemesanans_table', 2),
('2026_07_07_100006_create_detail_pemesanan_kondimen_table', 2),
('2026_07_07_100007_create_pembayarans_table', 2),
('2026_07_08_100001_add_is_admin_to_users_table', 3),
('2026_07_08_100002_add_logo_and_deskripsi_to_pengaturans_table', 3);

-- ---------------------------------------------------------------------
-- Data awal (seed)
-- ---------------------------------------------------------------------

-- Akun admin: email admin@seblak.test / password admin123
-- (hash bcrypt di bawah ini sudah setara dengan Hash::make('admin123') di Laravel)
INSERT INTO `users` (`name`, `email`, `password`, `is_admin`, `created_at`, `updated_at`) VALUES
('Admin Seblak', 'admin@seblak.test', '$2y$12$.OAEwOE/J89VRvFydWNqV.IQRWdXfIHez9c.HYCGzGGo.L9wkFWmy', 1, NOW(), NOW());

-- Pengaturan toko. Kolom `logo` mengasumsikan file logo.png sudah kamu
-- taruh di storage/app/public/pengaturan/logo.png (sudah disiapkan di
-- paket file-nya). Kolom `qris_image` sengaja dikosongkan - taruh
-- qris.png di public/assets/qris.png dan otomatis akan terpakai.
INSERT INTO `pengaturans` (`nama_toko`, `logo`, `alamat_toko`, `deskripsi_toko`, `no_wa`, `nama_rekening`, `qris_image`, `created_at`, `updated_at`) VALUES
('Seblak Mantap', 'pengaturan/logo.png', 'Jl. Contoh Raya No. 123, Kota Anda', 'Seblak dengan bumbu autentik, topping melimpah, dan rasa pedas yang pas untuk semua lidah.', '628123456789', NULL, NULL, NOW(), NOW());

INSERT INTO `pakets` (`nama_paket`, `deskripsi`, `harga`, `kategori`, `status`, `created_at`, `updated_at`) VALUES
('Seblak Original Kuah', 'Kerupuk seblak kuah gurih pedas dengan bumbu rempah khas, kencur, dan bawang goreng.', 10000.00, 'kuah', 'aktif', NOW(), NOW()),
('Seblak Ceker', 'Seblak kuah dengan ceker ayam empuk yang meresap bumbu pedas gurih.', 16000.00, 'kuah', 'aktif', NOW(), NOW()),
('Seblak Mie', 'Seblak kuah dipadukan mie kuning kenyal, cocok buat yang suka porsi mengenyangkan.', 15000.00, 'mie', 'aktif', NOW(), NOW()),
('Seblak Seafood', 'Seblak kuah dengan campuran seafood pilihan: udang, cumi, dan bakso ikan.', 21000.00, 'seafood', 'aktif', NOW(), NOW()),
('Seblak Makaroni', 'Seblak kuah dengan makaroni lembut yang menyerap kuah pedas gurih.', 13000.00, 'kuah', 'aktif', NOW(), NOW()),
('Seblak Goreng', 'Seblak digoreng kering berbumbu pedas manis, tanpa kuah, renyah dan nagih.', 14000.00, 'goreng', 'aktif', NOW(), NOW());

INSERT INTO `kondimens` (`nama_kondimen`, `harga`, `status`, `created_at`, `updated_at`) VALUES
('Ceker Ayam', 5000.00, 'aktif', NOW(), NOW()),
('Bakso', 3000.00, 'aktif', NOW(), NOW()),
('Sosis', 3000.00, 'aktif', NOW(), NOW()),
('Makaroni', 2000.00, 'aktif', NOW(), NOW()),
('Kwetiau', 3000.00, 'aktif', NOW(), NOW()),
('Telur', 3000.00, 'aktif', NOW(), NOW()),
('Kerupuk', 1000.00, 'aktif', NOW(), NOW()),
('Cimol', 3000.00, 'aktif', NOW(), NOW()),
('Mie', 3000.00, 'aktif', NOW(), NOW()),
('Sayap Ayam', 6000.00, 'aktif', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
