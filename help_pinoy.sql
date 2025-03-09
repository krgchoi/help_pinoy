-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 04:43 AM
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
-- Database: `help_pinoy`
--

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `reference_number` varchar(50) NOT NULL,
  `donor_id` int(11) DEFAULT NULL,
  `donor_name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_recieve` enum('Online','Onsite') NOT NULL DEFAULT 'Online',
  `donation_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `reference_number`, `donor_id`, `donor_name`, `amount`, `payment_method`, `payment_recieve`, `donation_date`) VALUES
(3, 'REF100001', 8, 'Juan Dela Cruz', 1500.00, 'GCash', 'Online', '2025-02-11 16:30:00'),
(4, 'REF100002', 9, 'Maria Santos', 2500.00, 'Bank Transfer', 'Online', '2025-02-11 17:00:00'),
(5, 'REF100003', 10, 'Jose Rizal', 5000.00, 'PayPal', 'Online', '2025-02-11 17:15:00'),
(6, 'REF100004', 11, 'Ana Mendoza', 1200.50, 'Credit Card', 'Online', '2025-02-11 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `address`, `latitude`, `longitude`, `created_at`) VALUES
(1, 'Jaro Plaza', 'Jaro Plaza, Iloilo City, Philippines', 10.72770000, 122.56210000, '2025-01-29 11:00:28'),
(2, 'PHINMA - University of Iloilo', 'Rizal St, Iloilo City Proper, Iloilo City, 5000 Iloilo, Philippines', 10.69610000, 122.56440000, '2025-02-11 19:38:59'),
(8, 'Rizal Park', 'Roxas Blvd, Ermita, Manila, 1000 Metro Manila, Philippines', 14.58260000, 120.97960000, '2025-02-13 18:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `otp_code` varchar(10) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `role` enum('Admin','Donor') NOT NULL DEFAULT 'Donor',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `password`, `otp_code`, `otp_expiry`, `is_verified`, `role`, `created_at`) VALUES
(5, 'Admin', 'admin@admin.com', NULL, 'scrypt:32768:8:1$iPkO3bFjl7jHk9JJ$a493985e62ce63f0e03dd54c513b5aeb13dc0290a7fc80faf9fa6f3313d31fddd21410f3d36f3dafd0c916bc140e4f7f422dc3f4b40c7a9347e0799a327b7427', NULL, NULL, 1, 'Admin', '2025-02-10 15:24:54'),
(8, 'Juan Dela Cruz', 'juan@user.com', NULL, 'scrypt:32768:8:1$sKXvR4PgHH0v2HkU$0e1fe22fd85205b9efcdacb7131097580f38db3475715b49f7a29c88e81e77fadc3bf410464ef968ea0784f7ad4cbbe0cfdc2194ca1cab5bacb1e8df656d182e', NULL, NULL, 0, 'Donor', '2025-02-11 15:58:24'),
(9, 'Maria Santos', 'maria@user.com', NULL, 'scrypt:32768:8:1$3iT7ScloKp2qS6e6$2d9e470bcd8d9229b990c05e5515c003ad1ccb0ab84b73bce6cd870cd78ca6e6dfb571f2a5f9a21cbeba819cf9855b2ac023664bd6c30a9d1110976644ba2576', NULL, NULL, 0, 'Donor', '2025-02-11 15:58:55'),
(10, 'Jose Rizal', 'jose@user.com', NULL, 'scrypt:32768:8:1$Y8VFIxMuT8SJ7pks$f4b6d07b804484739972134ce8e33c0bde5d04b7a81523f37b155dbece93d38fa8a84b6eac7a9ccf84360089df0a4626167527d9ff0b3b95296072a64171a8ad', NULL, NULL, 0, 'Donor', '2025-02-11 15:59:18'),
(11, 'Ana Mendoza', 'ana@user.com', NULL, 'scrypt:32768:8:1$tmZ7JnAdxStU46xM$2165afe13fa51c71fba5bf2d8046bc34c3a82543a5f5bba2329dc9164ee6fea4a9af10d66cf8d6663a75cc73783151ae19e45e18750a917f2577dc633019d92f', NULL, NULL, 0, 'Donor', '2025-02-11 15:59:36'),
(12, 'Kim Rholand', 'kim@donor.com', NULL, 'scrypt:32768:8:1$l8D5DbCpwzWhGeZY$5a5a22b4eeb1485b8568df129bc6e44463ab235a53bb50597146396beeee7e8a647304dbf40b1c840b990e663631a6e237a4a241cc5b4b112d3dc23d2bf67978', NULL, NULL, 0, 'Donor', '2025-02-11 19:42:51'),
(14, 'Kida Guillem', 'kida@donor.com', NULL, 'scrypt:32768:8:1$l3L1TIorcQ152SzL$7a23b5c551bb39a6f1ff97177466d08d24681e6bba37769306c865ed94b4eb6ca6bc8aac3e6de0b5d505d76b339dacd66cfade77fc42d76b78ae44365b9701c3', NULL, NULL, 0, 'Donor', '2025-02-11 19:45:55'),
(16, 'Kir Guillem', 'kir@donor.com', NULL, 'scrypt:32768:8:1$MOLpxEmMZCylKfq0$688f685963cb8b2b313c484fba95ce9f02ad7699c60006f0d62ce86827ce9a52f46e783e6c0357758d828c198fc1c5d1adccb88b403b0ee8ab90cddaa8ac3f28', NULL, NULL, 0, 'Donor', '2025-02-13 14:50:18'),
(17, 'kidas Guillem', 'kidas@donor.com', NULL, 'scrypt:32768:8:1$GvxIBfBSx8gOxuk6$b4669836bd4636ad15dd2d9846ce745da5c59b5491f443447b87e94ba422ca364c28715f3ebc20e2bc20bcd4b7eaf56238da013a375e7d77879f2c853c4d162f', NULL, NULL, 0, 'Donor', '2025-02-13 15:04:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_number` (`reference_number`),
  ADD KEY `donor_id` (`donor_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
