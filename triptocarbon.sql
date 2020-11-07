-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2020 at 03:33 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `triptocarbon`
--

-- --------------------------------------------------------

--
-- Table structure for table `footprints`
--

CREATE TABLE `footprints` (
  `id` int(10) UNSIGNED NOT NULL,
  `activity` double(8,2) NOT NULL,
  `activityType` enum('miles','fuel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` enum('usa','gbr','def') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fuelType` enum('motorGasoline','diesel','aviationGasoline','jetFuel') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` enum('dieselCar','petrolCar','anyCar','taxi','economyFlight','businessFlight','firstclassFlight','anyFlight','motorbike','bus','transitRail') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footprints`
--

INSERT INTO `footprints` (`id`, `activity`, `activityType`, `country`, `fuelType`, `mode`, `response`, `created_at`, `updated_at`) VALUES
(1, 100.00, 'miles', 'usa', NULL, 'taxi', '23.00', '2020-11-06 20:53:23', '2020-11-06 20:53:23'),
(2, 100.00, 'miles', 'usa', NULL, 'taxi', '23.00', '2020-11-06 20:55:04', '2020-11-06 20:55:04'),
(3, 100.00, 'miles', 'usa', NULL, 'taxi', '23.00', '2020-11-06 20:56:05', '2020-11-06 20:56:05'),
(4, 100.00, 'miles', 'usa', NULL, 'taxi', '23.00', '2020-11-06 21:02:26', '2020-11-06 21:02:26');

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
(14, '2014_10_12_000000_create_users_table', 1),
(15, '2014_10_12_100000_create_password_resets_table', 1),
(16, '2020_10_31_185215_adds_api_token_to_users_table', 1),
(17, '2020_11_06_125301_create_footprints_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `api_token`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$zSeu0cSSR/xe05KB0SvZOuX8U57pTXpShYxGXAJKFPErwVoM9L8Ui', NULL, '2020-11-06 18:02:13', '2020-11-06 19:55:03', 'LtjFjA9cG7WTWlIGBl4XzGa1k6MXHmFtxYuZKOiPUR5bljpTHmber5O2pfQh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `footprints`
--
ALTER TABLE `footprints`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `footprints`
--
ALTER TABLE `footprints`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
