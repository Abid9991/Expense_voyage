-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2025 at 02:36 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked_trips`
--

CREATE TABLE `booked_trips` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `booking_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booked_trips`
--

INSERT INTO `booked_trips` (`booking_id`, `user_id`, `trip_id`, `booking_date`) VALUES
(1, 9, 9, '2025-08-13 12:39:00'),
(2, 9, 9, '2025-08-13 13:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `saved_trips` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profile_id`, `user_id`, `first_name`, `last_name`, `age`, `phone`, `location`, `bio`, `image_path`, `updated_at`, `saved_trips`) VALUES
(2, 1, 'Abdul', 'Hayee', 18, '000000000', 'Hyd', 'Geoo', 'uploads/profile_1_1755069274.jpg', '2025-08-13 07:14:34', ''),
(3, 11, 'Sami', 'Ahmed', 18, '05754636', 'hydd', 'fgeoo', '', '2025-08-12 12:13:28', ''),
(4, 13, 'Jalil', 'Khan', 12, '2352375923', 'geo', 'geo', 'uploads/profile_13_1755070349.jpeg', '2025-08-13 07:32:29', ''),
(5, 9, 'gg', 'ggggg', 45, '5555555555555555', 'gggg', 'gggggggggg', 'uploads/profile_9_1755080887.jpeg', '2025-08-13 10:28:07', ''),
(6, 15, 'GG', 'GGGGGGGG', 23, '4544444444', 'hyd', 'geooooooooooooooo', '', '2025-08-13 11:37:21', ''),
(7, 16, 'Ahmed', 'sami', 12, '05754636', 'hyd', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'uploads/profile_16_1755088406.jpeg', '2025-08-13 12:33:27', '');

-- --------------------------------------------------------

--
-- Table structure for table `saved_trips`
--

CREATE TABLE `saved_trips` (
  `save_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `saved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_trips`
--

INSERT INTO `saved_trips` (`save_id`, `user_id`, `trip_id`, `saved_at`) VALUES
(4, 1, 8, '2025-08-13 10:19:46'),
(6, 9, 9, '2025-08-13 11:11:20'),
(7, 9, 8, '2025-08-13 11:11:20');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `trip_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trip_name` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `destination` varchar(100) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `trip_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`trip_id`, `user_id`, `trip_name`, `start_date`, `end_date`, `destination`, `budget`, `trip_image`) VALUES
(7, 0, 'New York Summer Trip', '2025-08-01', '2025-08-06', 'New York', 700.00, '1754991442_nycsummer.png'),
(8, 0, 'New York Times Square', '2025-08-06', '2025-08-12', 'New York', 500.00, '1754991546_download.webp'),
(9, 0, 'New York Super Tim', '2025-08-29', '2025-09-06', 'New York', 600.00, '1754994263_download (1).webp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password_hash`, `first_name`, `last_name`) VALUES
(1, 'hayee@gmail.com', '$2y$10$vnwA1fzUa2FuoxZ.S4gAD.SMoYoxKTP6WM4/vbg1Zd7HsaFdmG4wW', 'Abdul', 'Hayee'),
(9, 'huzaifa@gmail.com', '$2y$10$gQaFcFhLMiPHm0w7uzqkK.ey7cqCVwwh86971vlwRKnBtkscXdPpm', 'gfufufuff', 'hfdfdh'),
(11, 'sami@gmail.com', '$2y$10$bb7wD6RWKQT0QOULV3Yq4eCIVZKnV5Kc9zUhfqweDgwsX7e5QolUi', 'sami', 'saaaaa'),
(13, 'jalil@gmail.com', '$2y$10$x6g0j0kxCF83LGSmqKsileglMKY7axUEMhCYy4K/CklmiYrtPw5YS', 'Jalillll', 'Khan'),
(15, 'geo@gmail.com', '$2y$10$BMpjIMEWATd6EO8cD/pQneNPmwvzLJrW4uKzzyRnYk9wKntyXjWoG', 'Geo', 'Geooooooooooooooo'),
(16, 'ahmed@gmail.com', '$2y$10$ojl0z2IoeCwrjPfofZg.TurFSXam99Pj2Gk2AGYuP21CrCulJwbeW', 'Ahmed', 'sami');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked_trips`
--
ALTER TABLE `booked_trips`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `saved_trips`
--
ALTER TABLE `saved_trips`
  ADD PRIMARY KEY (`save_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`trip_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`trip_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_trips`
--
ALTER TABLE `booked_trips`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `saved_trips`
--
ALTER TABLE `saved_trips`
  MODIFY `save_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked_trips`
--
ALTER TABLE `booked_trips`
  ADD CONSTRAINT `booked_trips_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `booked_trips_ibfk_2` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`trip_id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`trip_id`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_trips`
--
ALTER TABLE `saved_trips`
  ADD CONSTRAINT `saved_trips_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `saved_trips_ibfk_2` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`trip_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
