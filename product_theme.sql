-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 04:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `product_theme`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_04_16_140527_create_products_table', 2),
(6, '2025_04_16_140610_create_product_variations_table', 2),
(7, '2025_04_16_142532_create_product_variations_table', 3),
(8, '2025_04_17_080319_create_orders_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `subtotal`, `tax`, `total`, `post_code`, `created_at`, `updated_at`) VALUES
(8, 2511.00, 251.10, 2762.10, '201', '2025-04-18 12:29:02', '2025-04-18 12:29:02'),
(9, 1962.00, 196.20, 2158.20, '202', '2025-04-18 12:29:52', '2025-04-18 12:29:52'),
(10, 3276.00, 327.60, 3603.60, NULL, '2025-04-18 20:10:06', '2025-04-18 20:10:06'),
(11, 1408.50, 140.85, 1549.35, '204', '2025-04-18 20:33:48', '2025-04-18 20:33:48'),
(12, 1551.00, 155.10, 1706.10, NULL, '2025-04-18 20:44:44', '2025-04-18 20:44:44'),
(13, 3708.00, 370.80, 4078.80, NULL, '2025-04-18 20:51:13', '2025-04-18 20:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `variation_id`, `quantity`, `price`, `discount`, `created_at`, `updated_at`) VALUES
(11, 8, 4, NULL, 2, 108.00, 0.00, '2025-04-18 12:29:02', '2025-04-18 12:29:02'),
(12, 8, 5, NULL, 3, 765.00, 0.00, '2025-04-18 12:29:02', '2025-04-18 12:29:02'),
(13, 9, 4, NULL, 4, 108.00, 0.00, '2025-04-18 12:29:52', '2025-04-18 12:29:52'),
(14, 9, 5, NULL, 2, 765.00, 0.00, '2025-04-18 12:29:52', '2025-04-18 12:29:52'),
(15, 10, 4, NULL, 2, 108.00, 0.00, '2025-04-18 20:10:07', '2025-04-18 20:10:07'),
(16, 10, 5, NULL, 4, 765.00, 0.00, '2025-04-18 20:10:08', '2025-04-18 20:10:08'),
(17, 11, 4, NULL, 2, 108.00, 0.00, '2025-04-18 20:33:48', '2025-04-18 20:33:48'),
(18, 11, 5, NULL, 1, 765.00, 0.00, '2025-04-18 20:33:48', '2025-04-18 20:33:48'),
(19, 11, 6, NULL, 3, 142.50, 0.00, '2025-04-18 20:33:48', '2025-04-18 20:33:48'),
(20, 12, 4, NULL, 2, 108.00, 0.00, '2025-04-18 20:44:44', '2025-04-18 20:44:44'),
(21, 12, 5, NULL, 1, 765.00, 0.00, '2025-04-18 20:44:44', '2025-04-18 20:44:44'),
(22, 12, 6, NULL, 4, 142.50, 0.00, '2025-04-18 20:44:44', '2025-04-18 20:44:44'),
(23, 13, 7, NULL, 2, 1275.00, 0.00, '2025-04-18 20:51:14', '2025-04-18 20:51:14'),
(24, 13, 4, NULL, 1, 108.00, 0.00, '2025-04-18 20:51:14', '2025-04-18 20:51:14'),
(25, 13, 5, NULL, 1, 765.00, 0.00, '2025-04-18 20:51:14', '2025-04-18 20:51:14'),
(26, 13, 6, NULL, 2, 142.50, 0.00, '2025-04-18 20:51:14', '2025-04-18 20:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `unit_value` varchar(255) NOT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(5,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `unit`, `unit_value`, `selling_price`, `purchase_price`, `discount`, `tax`, `image`, `created_at`, `updated_at`) VALUES
(4, 'T-shirt', 'MNG-001', 'piece', '1', 120.00, 100.00, 10.00, 5.00, 'products/eK0XUXSCFrf20UcFe0fu4W3gZQTC6bWH7ITlNfkx.jpg', '2025-04-18 12:23:39', '2025-04-18 12:23:39'),
(5, 'Shoe', 'TSH-SHOE-M', 'piece', '1', 900.00, 1200.00, 15.00, 7.00, 'products/Smy348akU2vd7YoBKsKpMlsa890yw5L2cx1VDaY9.jpg', '2025-04-18 12:26:37', '2025-04-18 12:26:37'),
(6, 'Sugar', 'Su-002', 'Kg', '1 Kg', 150.00, 135.00, 5.00, 2.00, 'products/A2VAeJIGsn6X6plmvCfPlzvokkEHNKHBdbTmQKOo.jpg', '2025-04-18 20:19:35', '2025-04-18 20:19:35'),
(7, 'Trouser pant', 'TSH-L', 'piece', '1', 1500.00, 1200.00, 15.00, 5.00, 'products/GyIuFHdk5wpuQYFJvqcg7c17i5mK9FhZakHxTcBd.jpg', '2025-04-18 20:50:26', '2025-04-18 20:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `product_id`, `attribute`, `value`, `purchase_price`, `selling_price`, `created_at`, `updated_at`) VALUES
(7, 4, 'Red', 'L', 100.00, 120.00, '2025-04-18 12:23:40', '2025-04-18 12:23:40'),
(8, 4, 'Blue', 'XL', 130.00, 150.00, '2025-04-18 12:23:40', '2025-04-18 12:23:40'),
(9, 5, 'SHOE-M', '38', 900.00, 1200.00, '2025-04-18 12:26:38', '2025-04-18 12:26:38'),
(10, 5, 'SHOE-XL', '41', 1800.00, 2000.00, '2025-04-18 12:26:38', '2025-04-18 12:26:38'),
(11, 6, 'White', '1 KG', 135.00, 150.00, '2025-04-18 20:19:35', '2025-04-18 20:19:35'),
(12, 6, 'Red', '2 KG', 150.00, 180.00, '2025-04-18 20:19:35', '2025-04-18 20:19:35'),
(13, 7, 'Black', '38', 1200.00, 1500.00, '2025-04-18 20:50:27', '2025-04-18 20:50:27'),
(14, 7, 'White', '40', 800.00, 1000.00, '2025-04-18 20:50:27', '2025-04-18 20:50:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$xjh.VR0F7Y6Sdy0B5B1yr.R08vw0tEcAhQealIsjsJc1VjFRnmovC', NULL, '2025-04-16 08:04:41', '2025-04-16 08:04:41');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_variation_id_foreign` (`variation_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variations_product_id_foreign` (`product_id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`);

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
