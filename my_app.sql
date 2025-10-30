-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 03:42 PM
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
-- Database: `my_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `latihan_progress`
--

CREATE TABLE `latihan_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `latihan1` int(11) DEFAULT 0,
  `latihan2` int(11) DEFAULT 0,
  `latihan3` int(11) DEFAULT 0,
  `latihan4` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nota_statistic`
--

CREATE TABLE `nota_statistic` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nota_name` varchar(100) NOT NULL,
  `opened_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nota_progress` float DEFAULT 0,
  `latihan_progress` float DEFAULT 0,
  `quiz_progress` float DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `quiz_score` int(11) DEFAULT 0,
  `test_score` int(11) DEFAULT 0,
  `quiz1_score` int(11) DEFAULT 0,
  `quiz2_score` int(11) DEFAULT 0,
  `quiz3_score` int(11) DEFAULT 0,
  `quiz4_score` int(11) DEFAULT 0,
  `test1_score` int(11) DEFAULT 0,
  `test2_score` int(11) DEFAULT 0,
  `test3_score` int(11) DEFAULT 0,
  `test4_score` int(11) DEFAULT 0,
  `latihan1_progress` int(11) DEFAULT 0,
  `latihan2_progress` int(11) DEFAULT 0,
  `latihan3_progress` int(11) DEFAULT 0,
  `latihan4_progress` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`id`, `user_id`, `nota_progress`, `latihan_progress`, `quiz_progress`, `updated_at`, `quiz_score`, `test_score`, `quiz1_score`, `quiz2_score`, `quiz3_score`, `quiz4_score`, `test1_score`, `test2_score`, `test3_score`, `test4_score`, `latihan1_progress`, `latihan2_progress`, `latihan3_progress`, `latihan4_progress`) VALUES
(1, 2, 0, 0, 0, '2025-10-27 14:15:10', 0, 100, 1, 1, 40, 20, 100, 0, 0, 0, 100, 0, 0, 0),
(2, 4, 0, 0, 0, '2025-10-26 10:51:43', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 0, 0, 0),
(3, 5, 50, 60, 70, '2025-10-27 13:21:44', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users1`
--

CREATE TABLE `users1` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users1`
--

INSERT INTO `users1` (`id`, `name`, `email`, `password`, `photo`) VALUES
(1, 'AFIQ MUQRIM', 'Afiqmuqrim@gmail.com', '$2y$10$6esIjV3Qmqnzh2kd1AqceePZtMnd0CLuS4nApxDR95s7aoVrg8E16', NULL),
(2, 'TEST AKAUN', 'test@akaun.com', '$2y$10$lUk/Qo/QuQ05rldmlMt3Me8sMpbtScPUUfDf6EIQPXKJ.7oH.fLbe', NULL),
(3, 'jojiq', 'jojiq@gmail.com', '$2y$10$Pe0Yr/pLx.bN/YyN/kHhduMsD9uu7sriXK6/iJeDA/.CHmYIrz6IW', NULL),
(4, 'MUHAMMAD ZHARFAN BIN ZAINUDDIN', 'zapan@gmail.com', '$2y$10$hjy8R8MCCFULYjpENUGWcuT/xJGMxxaIhqVEyiF8ElDdCSLncPF86', NULL),
(5, 'Test User 2', 'test2@example.com', '12345', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `latihan_progress`
--
ALTER TABLE `latihan_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nota_statistic`
--
ALTER TABLE `nota_statistic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users1`
--
ALTER TABLE `users1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `latihan_progress`
--
ALTER TABLE `latihan_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nota_statistic`
--
ALTER TABLE `nota_statistic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users1`
--
ALTER TABLE `users1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD CONSTRAINT `leaderboard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users1` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
