-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2023 at 08:56 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `krisandpartners`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
('14f14e61-0f8a-4313-8e9b-c118df0419ac', 'Satu', '2023-05-29 06:12:14', '2023-05-29 06:12:14', NULL),
('6389c750-2ed1-496e-8d72-a5f056e2c208', 'Dua', '2023-05-29 06:12:20', '2023-05-29 06:12:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` varchar(100) NOT NULL,
  `competition_join_category_id` varchar(100) NOT NULL,
  `no_certificate` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `competition_join_category_id`, `no_certificate`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
('21d13a6d-5c68-428e-8e40-eb32028b8f59', '05cb90ec-06ef-4a3f-8d33-ab4fbe3792c6', '1', 'Muhammad Ma\'dum', '2023-05-31 01:45:13', '2023-05-31 03:07:03', NULL),
('5dbc5450-3765-46cb-9354-85a299e5280d', 'f25e321d-dc27-4894-a1c8-51c0fdba3659', '1', 'Muhammad Ma\'dum', '2023-05-31 02:22:25', '2023-05-31 02:22:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE `competitions` (
  `id` int(100) NOT NULL,
  `title` text NOT NULL,
  `from` timestamp NULL DEFAULT NULL,
  `to` timestamp NULL DEFAULT NULL,
  `banner` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`id`, `title`, `from`, `to`, `banner`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 'Kompetisi 1', '2023-04-03 17:00:00', '2023-06-29 17:00:00', 'banners/4HNaB9xuHttLtEYbVvqxpcfjgJXkGWnjLcp0C7Px.jpg', '<p>asdfasdf</p>', '2023-05-29 19:27:46', '2023-05-30 09:58:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `competition_categories`
--

CREATE TABLE `competition_categories` (
  `id` varchar(100) NOT NULL,
  `competition_id` varchar(100) NOT NULL,
  `category_id` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competition_categories`
--

INSERT INTO `competition_categories` (`id`, `competition_id`, `category_id`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
('62e43352-20ae-49af-8855-80c4510368ff', '10', '6389c750-2ed1-496e-8d72-a5f056e2c208', '56000', '2023-05-30 09:58:19', '2023-05-30 09:58:19', NULL),
('cf45af1f-085b-4dd9-bd7d-dc5f9f59dbf9', '10', '14f14e61-0f8a-4313-8e9b-c118df0419ac', '89000', '2023-05-30 09:58:19', '2023-05-30 09:58:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `competition_joins`
--

CREATE TABLE `competition_joins` (
  `id` varchar(100) NOT NULL,
  `competition_id` int(15) NOT NULL,
  `member_id` varchar(100) NOT NULL,
  `join_date` timestamp NULL DEFAULT current_timestamp(),
  `image` text NOT NULL,
  `url` text NOT NULL,
  `description` text NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competition_joins`
--

INSERT INTO `competition_joins` (`id`, `competition_id`, `member_id`, `join_date`, `image`, `url`, `description`, `total`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('8242657c-0531-4d85-9fc0-cabf9779c9b8', 10, '857a377d-b3d1-41c7-9f16-f257a805c825', '2023-05-31 10:13:56', 'images/BOvu9z0WPtCbp9ps9XVcxHQAQfBEx9lZ39HSu0a8.jpg', 'https://www.youtube.com/watch?v=BO0iD17ngiI', '<p>asdfsafd</p>', 56000, 'unpaid', '2023-05-31 10:13:56', '2023-05-31 10:13:56', NULL),
('f91d2af8-af44-4394-9fc4-291e70241feb', 10, '857a377d-b3d1-41c7-9f16-f257a805c825', '2023-05-30 20:51:12', 'images/4m8I1ybn35Br5MkHztTfoKfqv2utRtWbJqEOC1wm.jpg', 'https://www.youtube.com/watch?v=szpPtrpL-sw', '<p>asfdasdf</p>', 145000, 'paid', '2023-05-30 20:51:12', '2023-05-30 20:51:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `competition_join_categories`
--

CREATE TABLE `competition_join_categories` (
  `id` varchar(100) NOT NULL,
  `member_id` varchar(100) NOT NULL,
  `competition_join_id` varchar(100) NOT NULL,
  `category_id` varchar(100) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `win_status` tinyint(1) NOT NULL DEFAULT 0,
  `win_date` timestamp NULL DEFAULT NULL,
  `win_notification` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competition_join_categories`
--

INSERT INTO `competition_join_categories` (`id`, `member_id`, `competition_join_id`, `category_id`, `price`, `win_status`, `win_date`, `win_notification`, `created_at`, `updated_at`, `deleted_at`) VALUES
('05cb90ec-06ef-4a3f-8d33-ab4fbe3792c6', '857a377d-b3d1-41c7-9f16-f257a805c825', 'f91d2af8-af44-4394-9fc4-291e70241feb', '14f14e61-0f8a-4313-8e9b-c118df0419ac', 89000, 1, '2023-05-31 01:45:13', NULL, '2023-05-30 20:51:12', '2023-05-31 01:45:13', NULL),
('d8b4ac26-2323-49ca-a773-736f972620f5', '857a377d-b3d1-41c7-9f16-f257a805c825', '8242657c-0531-4d85-9fc0-cabf9779c9b8', '6389c750-2ed1-496e-8d72-a5f056e2c208', 56000, 0, NULL, NULL, '2023-05-31 10:13:56', '2023-05-31 10:13:56', NULL),
('f25e321d-dc27-4894-a1c8-51c0fdba3659', '857a377d-b3d1-41c7-9f16-f257a805c825', 'f91d2af8-af44-4394-9fc4-291e70241feb', '6389c750-2ed1-496e-8d72-a5f056e2c208', 56000, 1, '2023-05-31 02:22:25', NULL, '2023-05-30 20:51:12', '2023-05-31 02:22:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `competition_join_payments`
--

CREATE TABLE `competition_join_payments` (
  `id` varchar(100) NOT NULL,
  `member_id` varchar(100) NOT NULL,
  `competition_join_id` varchar(100) NOT NULL,
  `midtrans_order_id` varchar(100) DEFAULT NULL,
  `total` int(20) NOT NULL,
  `status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competition_join_payments`
--

INSERT INTO `competition_join_payments` (`id`, `member_id`, `competition_join_id`, `midtrans_order_id`, `total`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('e95d5ddc-3a4a-4b2c-844a-b208e339b6e3', '857a377d-b3d1-41c7-9f16-f257a805c825', '8242657c-0531-4d85-9fc0-cabf9779c9b8', '86588773-cea7-45d8-bbc6-241fe5153f7d', 56000, 'unpaid', '2023-05-31 17:41:20', '2023-05-31 10:41:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `register_date` timestamp NULL DEFAULT current_timestamp(),
  `phone` varchar(20) NOT NULL,
  `certificate_name` varchar(100) NOT NULL,
  `note` text DEFAULT NULL,
  `token` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `username`, `password`, `register_date`, `phone`, `certificate_name`, `note`, `token`, `email_verified_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
('857a377d-b3d1-41c7-9f16-f257a805c825', 'Muhammad Ma\'dum', 'muhammad.madum2018@gmail.com', 'madum', '$2a$12$f9f.YYa7RLR.TDqMggQOYOsLz9IqYoT0iFXZ5skKDkA77qGWPfit6', '2023-05-30 09:53:54', '082135276133', 'Muhammad Ma\'dum', NULL, '401e07453266cdda0455cf9ffd99f24f4d6e1235', '2023-05-17 10:22:05', '2023-05-30 02:53:54', '2023-05-31 09:54:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `certificate` text DEFAULT NULL,
  `email` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `certificate`, `email`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'certificate/9UIx7hQCrN4YxLF7XTpDKwojRVNfoR31AweBf0x4.jpg', 'asdfa@gmail.com', '2023-05-30 02:39:41', '2023-05-31 01:44:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `level` enum('superadmin','admin','','') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `level`, `created_at`, `updated_at`, `deleted_at`) VALUES
('f3626b14-e2a2-451d-bf8a-b82f1d38150e', 'admin@gmail.com', 'admin', '$2a$12$cwx6k.bVEexiOofpE7titODl3jxSZ6kyIemVLvxJ2GzFMwjbshFdC', 'superadmin', '2023-05-29 09:24:17', '2023-05-29 09:24:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competition_categories`
--
ALTER TABLE `competition_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competition_joins`
--
ALTER TABLE `competition_joins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competition_join_categories`
--
ALTER TABLE `competition_join_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competition_join_payments`
--
ALTER TABLE `competition_join_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
