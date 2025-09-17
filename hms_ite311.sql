-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2025 at 03:04 AM
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
-- Database: `hms_ite311`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-08-18-034205', 'App\\Database\\Migrations\\CreateUserTable', 'default', 'App', 1755566189, 1),
(2, '2025-08-18-042341', 'App\\Database\\Migrations\\CreateUserTable', 'default', 'App', 1755567062, 2),
(3, '2025-08-19-000001', 'App\\Database\\Migrations\\AddEmailToUsers', 'default', 'App', 1755567062, 2),
(4, '2025-08-25-200935', 'App\\Database\\Migrations\\AddUserFields', 'default', 'App', 1756123825, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','doctor','nurse','receptionist','pharmacist','laboratorist','accountant','it_staff') NOT NULL DEFAULT 'receptionist',
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `hire_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `first_name`, `last_name`, `phone`, `department`, `employee_id`, `status`, `hire_date`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$v3Mhf/haHLKSfyGo3XHzYOXU8I/PSxYwA9cyDJJyXaAK8S9MOoL..', 'admin', 'admin@hospital.com', 'System', 'Administrator', '+1234567890', 'Administration', 'ADM001', 'active', '2024-01-01', NULL, NULL),
(2, 'dr.smith', '$2y$10$CGv0HP2nJ8JeP86NmUyWT.O/26g05fb/mhMejKpPGCGsPSPN8zrxa', 'doctor', 'doctor@hospital.com', 'John', 'Smith', '+1234567891', 'Cardiology', 'DOC001', 'active', '2024-01-15', NULL, NULL),
(3, 'dr.johnson', '$2y$10$0d5Hp3vTJ6xJ2J6ZyC7qLukZ2XJZ/P1ghbT28sNN6gUVC18ZLdGRu', 'doctor', 'doctor2@hospital.com', 'Sarah', 'Johnson', '+1234567892', 'Pediatrics', 'DOC002', 'active', '2024-02-01', NULL, NULL),
(4, 'acc.martinez', '$2y$10$mvzYxCten7ZulPTtlLsEY./16DznUECl94NR7FHvAJEQfq1kAJHi2', 'accountant', 'accountant@hospital.com', 'Maria', 'Martinez', '+1234567893', 'Finance', 'ACC001', 'active', '2024-01-20', NULL, NULL),
(5, 'acc.wilson', '$2y$10$o9q5/.AE3DF2juYosTObI.sfqpa/vFL6iSwS9L4xihLzc8reLm.1q', 'accountant', 'accountant2@hospital.com', 'Robert', 'Wilson', '+1234567894', 'Finance', 'ACC002', 'active', '2024-02-15', NULL, NULL),
(6, 'nurse.johnson', '$2y$10$.9kUflOukN8lbBC7U0KDe.XspKmxbEu4ShJjthnWW//6zr3S7jlf.', 'nurse', 'nurse@hospital.com', 'Sarah', 'Johnson', '+1234567803', 'General Ward', 'NUR001', 'active', '2024-01-12', NULL, NULL),
(7, 'nurse.williams', '$2y$10$OIOa0tcA6QLKigb2j0isruODnwkYJkMjZ8vuYdcv8aRuKcAlkpiSe', 'nurse', 'nurse2@hospital.com', 'Jennifer', 'Williams', '+1234567804', 'ICU', 'NUR002', 'active', '2024-02-08', NULL, NULL),
(8, 'pharm.davis', '$2y$10$Cv4ey/eFm5LLs1VCvRGc8eBUP9GsDZIYalOlW6REOH/hsR.p/8296', 'pharmacist', 'pharmacist@hospital.com', 'Emily', 'Davis', '+1234567895', 'Pharmacy', 'PHR001', 'active', '2024-01-25', NULL, NULL),
(9, 'pharm.brown', '$2y$10$QbIb91Z9jVayz74MyThkKeLoLMrqFbOPkpzyLaEsr2cN21e30Hudy', 'pharmacist', 'pharmacist2@hospital.com', 'Michael', 'Brown', '+1234567896', 'Pharmacy', 'PHR002', 'active', '2024-03-01', NULL, NULL),
(10, 'lab.garcia', '$2y$10$5JEAO2Wrj.os35bINBr84e/g5kHfIA5rkafJJtzKuozynjLvBlAUq', '', 'laboratory_staff@hospital.com', 'Ana', 'Garcia', '+1234567897', 'Laboratory', 'LAB001', 'active', '2024-02-10', NULL, NULL),
(11, 'lab.taylor', '$2y$10$XueeAY.vXqBgB11nUVVpPOm.rtKc5Pe0mfhAsDLBMBO473k5pHPH.', '', 'laboratory_staff2@hospital.com', 'James', 'Taylor', '+1234567898', 'Laboratory', 'LAB002', 'active', '2024-02-20', NULL, NULL),
(12, 'it.anderson', '$2y$10$jLnKeSvPttNe/epXsJ58t.4bn9lRZji7sOB90QCTuNNx9gusA/F7K', 'it_staff', 'it_staff@hospital.com', 'David', 'Anderson', '+1234567899', 'Information Technology', 'IT001', 'active', '2024-01-10', NULL, NULL),
(13, 'it.thomas', '$2y$10$P1cZGbWvJXk2u0X4A6WsouRQV23nnFJo4mGyGVYJCmrCv7hE4Aze6', 'it_staff', 'it_staff2@hospital.com', 'Lisa', 'Thomas', '+1234567800', 'Information Technology', 'IT002', 'active', '2024-03-05', NULL, NULL),
(14, 'rec.white', '$2y$10$nfMmWfCB8z7ihl4RmQoyMuf/0zlcpA41FFyhR7xFzNB2S6i8fn4wS', 'receptionist', 'receptionist@hospital.com', 'Jennifer', 'White', '+1234567801', 'Front Desk', 'REC001', 'active', '2024-01-05', NULL, NULL),
(15, 'rec.harris', '$2y$10$4FLJHi8CRAnD1xlfiClVBuLDh0DDUySXXHSqiHy0GvCqNiICGVDdW', 'receptionist', 'receptionist2@hospital.com', 'Michelle', 'Harris', '+1234567802', 'Front Desk', 'REC002', 'active', '2024-02-25', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
