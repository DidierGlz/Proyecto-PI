-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2025 at 03:27 AM
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
-- Database: `ldsw_mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `user_id`, `filename`, `title`, `category`, `created_at`) VALUES
(1, 2, '1763512839_aed99c86c07cba22ac4a.jpg', 'Ejemplo', 'Proyecto', '2025-11-19 00:40:39'),
(2, 4, '1764293387_238243e726c3ddaf949a.jpg', 'prueba001', 'Prueba', '2025-11-28 01:29:47'),
(4, 5, '1764294387_6589a999b3298588a342.jpg', 'Prueba 2', 'Prueba', '2025-11-28 01:46:27'),
(5, 5, '1764294409_98540479d70fc8a9ee7d.jpg', 'Prueba 3', 'Prueba', '2025-11-28 01:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(256) NOT NULL,
  `login` varchar(128) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `login`, `password_hash`, `role`) VALUES
(2, 'nestor', 'nestor97', '$2y$10$/cvfWTIshxfzafENAuaz6.oT60UGSnZY1Nwdveh4r9PAkAR7cjo/6', 'admin'),
(4, 'Prueba', 'prueba001', '$2y$10$oWTSTUdpQmdFElf4n6VagOVbeLCi6Fo.r/fmF/513pjnSef/EpQ.m', 'user'),
(5, 'Prueba 2', 'prueba002', '$2y$10$HFhf9i27kFFeQfFgjoVDQOKfJ8qUmY5RyRy7iwSAzbgfpN06cZ4Yu', 'user'),
(6, 'enrique', 'enrique92', '$2y$10$pK6J.7gkF0Z1nFftS2BWT.XLfCCIYWwol49Q2gY0dunyTbgfC5ADy', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_images_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
