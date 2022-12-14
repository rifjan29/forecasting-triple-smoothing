-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 10, 2022 at 07:38 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_forecast`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_satuan` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama`, `id_satuan`, `created_at`, `updated_at`) VALUES
(17, 'plastik', 55, '2022-10-11 00:29:52', '2022-10-13 20:07:06'),
(20, 'Plateser Hitam 5', 44, '2022-10-11 02:29:12', '2022-11-08 23:23:55');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_10_09_133621_create_satuan_table', 1),
(6, '2022_10_09_135342_create_barang_table', 1),
(7, '2022_10_09_135447_create_transaksi_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('salmanbahamisah@yahoo.com', '$2y$10$ODstrlb7FsCDIRSXnHmFTO.5Zo.EkDPhwnkWQ1iXRPOs7lH2z5fiu', '2022-10-11 19:35:40');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `satuan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `satuan`, `created_at`, `updated_at`) VALUES
(44, 'Lembar', '2022-10-10 23:42:39', '2022-10-12 02:23:32'),
(45, 'Lonjor', '2022-10-10 23:42:47', '2022-10-10 23:42:47'),
(46, 'Pack', '2022-10-10 23:42:56', '2022-10-10 23:42:56'),
(47, 'Pil', '2022-10-10 23:43:01', '2022-10-10 23:43:01'),
(48, 'Set', '2022-10-10 23:43:04', '2022-10-10 23:43:04'),
(49, 'Roll', '2022-10-10 23:43:17', '2022-10-10 23:43:17'),
(50, 'Sak', '2022-10-10 23:43:23', '2022-10-10 23:43:23'),
(51, 'Unit', '2022-10-10 23:43:28', '2022-10-10 23:43:28'),
(52, 'Pcs', '2022-10-10 23:43:37', '2022-10-10 23:43:37'),
(53, 'Meter', '2022-10-10 23:43:40', '2022-10-10 23:43:40'),
(54, 'Kg', '2022-10-10 23:43:48', '2022-10-10 23:43:48'),
(55, 'Biji', '2022-10-11 09:38:10', '2022-10-11 09:38:10'),
(56, 'Buah', '2022-10-11 09:38:25', '2022-10-11 09:38:25'),
(57, 'sdsda', '2022-10-12 23:57:51', '2022-10-12 23:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `qty` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bulan` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('Penjualan','Purchase Order','Profit','Peramalan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_barang`, `qty`, `harga`, `total_harga`, `bulan`, `tahun`, `kategori`, `created_at`, `updated_at`) VALUES
(162, 20, '1', '1168000', '1168000', '02', '2020', 'Purchase Order', '2022-11-07 19:23:23', '2022-11-07 20:44:30'),
(163, 20, '1', '282000', '282000', '02', '2020', 'Profit', '2022-11-07 19:23:23', '2022-11-09 21:02:11'),
(164, 20, '0', '0', '0', '03', '2020', 'Purchase Order', '2022-11-07 19:28:11', '2022-11-09 23:20:52'),
(165, 20, '0', '0', '0', '03', '2020', 'Profit', '2022-11-07 19:28:11', '2022-11-09 23:20:52'),
(166, 20, '2', '1168000', '2336000', '04', '2020', 'Purchase Order', '2022-11-07 19:28:27', '2022-11-09 23:21:10'),
(167, 20, '2', '282000', '564000', '04', '2020', 'Profit', '2022-11-07 19:28:27', '2022-11-09 23:24:34'),
(170, 20, '0', '0', '0', '06', '2020', 'Purchase Order', '2022-11-07 19:29:27', '2022-11-09 23:21:48'),
(171, 20, '0', '0', '0', '06', '2020', 'Profit', '2022-11-07 19:29:27', '2022-11-09 23:21:48'),
(172, 20, '2', '931000', '1862000', '07', '2020', 'Purchase Order', '2022-11-07 20:51:36', '2022-11-09 23:22:01'),
(173, 20, '2', '519000', '1038000', '07', '2020', 'Profit', '2022-11-07 20:51:36', '2022-11-09 23:25:45'),
(174, 20, '0', '0', '0', '08', '2020', 'Purchase Order', '2022-11-07 20:51:59', '2022-11-09 23:22:21'),
(175, 20, '0', '0', '0', '08', '2020', 'Profit', '2022-11-07 20:51:59', '2022-11-09 23:22:21'),
(176, 20, '2', '931000', '1862000', '09', '2020', 'Purchase Order', '2022-11-07 20:52:13', '2022-11-09 23:22:35'),
(177, 20, '2', '519000', '1038000', '09', '2020', 'Profit', '2022-11-07 20:52:13', '2022-11-09 23:26:17'),
(178, 20, '0', '0', '0', '10', '2020', 'Purchase Order', '2022-11-07 20:52:28', '2022-11-09 23:22:54'),
(179, 20, '0', '0', '0', '10', '2020', 'Profit', '2022-11-07 20:52:28', '2022-11-09 23:22:54'),
(180, 20, '2', '931000', '1862000', '11', '2020', 'Purchase Order', '2022-11-07 20:52:49', '2022-11-07 20:52:49'),
(181, 20, '2', '519000', '1038000', '11', '2020', 'Profit', '2022-11-07 20:52:49', '2022-11-09 23:26:47'),
(182, 20, '1', '931000', '931000', '12', '2020', 'Purchase Order', '2022-11-07 20:53:08', '2022-11-09 23:23:09'),
(183, 20, '1', '519000', '519000', '12', '2020', 'Profit', '2022-11-07 20:53:08', '2022-11-09 23:27:00'),
(184, 20, '1', '1450000', '1450000', '02', '2020', 'Penjualan', '2022-11-09 21:02:11', '2022-11-09 21:02:11'),
(185, 20, '0', '0', '0', '03', '2020', 'Penjualan', '2022-11-09 23:24:02', '2022-11-09 23:24:02'),
(186, 20, '2', '1450000', '2900000', '04', '2020', 'Penjualan', '2022-11-09 23:24:34', '2022-11-09 23:24:34'),
(189, 20, '0', '0', '0', '06', '2020', 'Penjualan', '2022-11-09 23:25:06', '2022-11-09 23:25:06'),
(190, 20, '2', '1450000', '2900000', '07', '2020', 'Penjualan', '2022-11-09 23:25:45', '2022-11-09 23:25:45'),
(191, 20, '0', '0', '0', '08', '2020', 'Penjualan', '2022-11-09 23:26:02', '2022-11-09 23:26:02'),
(192, 20, '2', '1450000', '2900000', '09', '2020', 'Penjualan', '2022-11-09 23:26:17', '2022-11-09 23:26:17'),
(193, 20, '0', '0', '0', '10', '2020', 'Penjualan', '2022-11-09 23:26:31', '2022-11-09 23:26:31'),
(194, 20, '2', '1450000', '2900000', '11', '2020', 'Penjualan', '2022-11-09 23:26:47', '2022-11-09 23:26:47'),
(195, 20, '1', '1450000', '1450000', '12', '2020', 'Penjualan', '2022-11-09 23:27:00', '2022-11-09 23:27:00'),
(196, 20, '1', '519000', '519000', '05', '2020', 'Profit', '2022-11-09 23:33:34', '2022-11-09 23:33:54'),
(197, 20, '1', '1450000', '1450000', '05', '2020', 'Penjualan', '2022-11-09 23:33:34', '2022-11-09 23:33:34'),
(198, 20, '1', '931000', '931000', '05', '2020', 'Purchase Order', '2022-11-09 23:33:54', '2022-11-09 23:33:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'Mohammad Salman', 'salmanbahamisah@gmail.com', NULL, '$2y$10$dKhcKLFD7vzzbswNqmYEJuCtYeYCBwMeboX4IOlXBdywGVyTAY6b2', NULL, '2022-10-12 00:36:47', '2022-10-12 00:36:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id_satuan_foreign` (`id_satuan`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id_barang_foreign` (`id_barang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_id_satuan_foreign` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
