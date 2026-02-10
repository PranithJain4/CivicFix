-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2026 at 08:03 AM
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
-- Database: `civicfix`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `complaint_id` varchar(20) NOT NULL,
  `corporator_id` int(11) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `complaint_id`, `corporator_id`, `assigned_at`) VALUES
(1, 'CIV-612180', 1, '2026-02-05 15:38:10'),
(2, 'CIV-804824', 2, '2026-02-10 06:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `tracking_id` varchar(20) NOT NULL,
  `category` varchar(100) NOT NULL,
  `location` text NOT NULL,
  `landmark` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `work_notes` text DEFAULT NULL,
  `work_image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending Investigation',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `tracking_id`, `category`, `location`, `landmark`, `description`, `image_path`, `work_notes`, `work_image`, `status`, `created_at`) VALUES
(1, 'CIV-612180', 'Roads & Maintenance', 'Nataraj badavane, Harapanahalli', 'atishaya house', 'fix this pothole asap!', 'uploads/1770305817_pothhole.jpeg', 'fixed!.', 'uploads/work_1770305961_pothole.webp', 'Resolved', '2026-02-05 15:36:57'),
(2, 'CIV-804824', 'Sanitation', '28th Cross Road, Dharmagiri Ward, Bengaluru', 'B.N.M institute of technology', 'Garbage has been dumped on the sidewalk in front of BNMIT College. Please arrange for its immediate removal.', 'uploads/1770705118_garbage.webp', 'Issue resolved!', 'uploads/work_1770705616_garbage1.jpg', 'Resolved', '2026-02-10 06:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `corporators`
--

CREATE TABLE `corporators` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `coverage` text NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `corporators`
--

INSERT INTO `corporators` (`id`, `name`, `category`, `coverage`, `type`) VALUES
(1, 'Pranith Jain', 'Roads & Maintenance', 'Jayanagara', 'Department'),
(2, 'Kumar Karthik', 'Sanitation', 'banashankari', 'Department');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('citizen','admin','corporator') DEFAULT 'citizen',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'System Admin', 'admin@civicfix.com', '$2y$10$Xt7SbwqD/cFRmoEL0wdQpur25.Qv5hWwquZyXLkWyBurr4/tC/i2i', 'admin', '2026-02-02 18:24:00'),
(3, 'Pranith Jain', 'pranithjain2006@gmail.com', '$2y$10$K9C79NTxstqSXR7L1FfGP.AyqRmV.h942V42IWi/odCHUmJDOLZdK', 'corporator', '2026-02-02 18:30:11'),
(4, 'Chandan DK', 'chandan2006@gmail.com', '$2y$10$2XmV19FjCP6VRIesTiR6WuGgcyPOk28sHPTjRpfAJe0JnERDA8CuG', 'citizen', '2026-02-03 17:53:01'),
(5, 'Mardan Ali', 'mardan2006@gmail.com', '$2y$10$mwgt.ptB2ILREGbw.Dh6NehHO5mCUqX6MYCp2pRS17lDaaIvuerC.', 'citizen', '2026-02-04 18:14:38'),
(6, 'Sanjana', 'sanjana2006@gmail.com', '$2y$10$tmluAHLnEqS/zzxaZt7/eu9REGrtGsUQzZ/ypxL0OqP5j9ht6p242', 'citizen', '2026-02-05 15:20:48'),
(7, 'trisha', 'trisha2006@gmail.com', '$2y$10$wcCVZXeHhXqrfAUU4DxcIewlrIcFKvIIj3kEzEt2lxhWCDJHUHmpu', 'citizen', '2026-02-06 15:25:13'),
(8, 'Preetham', 'preetham2006@gmail.com', '$2y$10$KdyN1lSg29kEsctMN78qP.C/RFebHbeyizTm52PBSQiQY6t174ORS', 'citizen', '2026-02-10 06:25:59'),
(9, 'Kumar Karthik', 'kumarkarthik2006@gmail.com', '$2y$10$krsU45c93YnMPA515.CTt.rZ4yONtoEJ4D9NOyUahpg7vCTqVZ.P.', 'corporator', '2026-02-10 06:35:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaint_id` (`complaint_id`),
  ADD KEY `corporator_id` (`corporator_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tracking_id` (`tracking_id`);

--
-- Indexes for table `corporators`
--
ALTER TABLE `corporators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `corporators`
--
ALTER TABLE `corporators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`tracking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`corporator_id`) REFERENCES `corporators` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
