-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 11:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
CREATE DATABASE IF NOT EXISTS mydb;
USE mydb;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `drawnumbers`
--

CREATE TABLE `drawnumbers` (
  `numbers` varchar(255) NOT NULL,
  `week` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `drawnumbers`
--

INSERT INTO `drawnumbers` (`numbers`, `week`) VALUES
('32, 68, 60, 5, 24, 49', '16');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `username`, `quantity`, `total_price`) VALUES
(1, 'pékpetyus', 2, 2400.00),
(2, 'pékpetyus', 1, 1200.00),
(3, 'pékpetyus', 4, 4800.00),
(4, 'leverkusen04', 0, 7200.00),
(5, 'leverkusen04', 0, 7200.00);

-- --------------------------------------------------------

--
-- Table structure for table `szamok`
--

CREATE TABLE `szamok` (
  `username` varchar(255) NOT NULL,
  `selected_numbers` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_validated` tinyint(1) NOT NULL,
  `week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `szamok`
--

INSERT INTO `szamok` (`username`, `selected_numbers`, `timestamp`, `is_validated`, `week`) VALUES
('pékpetyus', '13 23 33 43 53 63', '2024-04-19 07:30:49', 1, ''),
('pékpetyus', '54 55 56 57 64 67', '2024-04-19 07:30:49', 1, ''),
('pékpetyus', '10 32 42 66 75 90', '2024-04-19 07:30:49', 1, ''),
('pékpetyus', '14 16 22 24 25 26', '2024-04-19 07:30:49', 1, ''),
('pékpetyus', '24 25 26 34 35 36', '2024-04-19 07:30:49', 1, ''),
('pékpetyus', '11 12 13 21 22 23', '2024-04-19 07:30:49', 1, ''),
('pékpetyus', '28 38 48 58 68 78', '2024-04-19 07:42:52', 1, ''),
('pékpetyus', '41 42 51 52 61 62', '2024-04-19 07:42:52', 1, ''),
('pékpetyus', '64 65 74 75 84 85', '2024-04-19 07:42:52', 1, ''),
('pékpetyus', '75 76 77 78 79 80', '2024-04-19 07:42:52', 1, ''),
('pékpetyus', '1 2 3 11 12 13', '2024-04-19 07:42:52', 1, ''),
('pékpetyus', '15 22 23 24 25 26', '2024-04-19 07:42:52', 1, ''),
('pékpetyus', '85 86 87 88 89 90', '2024-04-19 16:57:08', 1, ''),
('pékpetyus', '81 82 83 84 85 86', '2024-04-19 16:57:08', 1, ''),
('pékpetyus', '53 63 73 81 82 83', '2024-04-19 16:57:08', 1, ''),
('pékpetyus', '5 6 7 8 9 10', '2024-04-19 16:57:08', 1, ''),
('pékpetyus', '1 2 3 4 5 6', '2024-04-19 16:57:08', 1, ''),
('pékpetyus', '3 13 23 33 43 53', '2024-04-19 16:57:08', 1, ''),
('leverkusen04', '1 2 3 4 6 32', '2024-04-21 00:18:23', 1, ''),
('leverkusen04', '32 52 62 68 72 81', '2024-04-21 00:18:23', 1, ''),
('leverkusen04', '55 56 57 58 59 60', '2024-04-21 00:18:23', 1, ''),
('leverkusen04', '1 3 5 32 60 68', '2024-04-21 00:18:23', 1, ''),
('leverkusen04', '49 86 87 88 89 90', '2024-04-21 00:18:23', 1, ''),
('leverkusen04', '5 24 32 49 60 68', '2024-04-21 00:18:23', 1, ''),
('leverkusen04', '1 2 11 12 21 22', '2024-04-21 08:47:57', 1, '16'),
('leverkusen04', '31 32 41 42 51 52', '2024-04-21 08:47:57', 1, '16'),
('leverkusen04', '51 52 53 61 62 63', '2024-04-21 08:47:57', 1, '16'),
('leverkusen04', '57 58 59 60 69 70', '2024-04-21 08:47:57', 1, '16'),
('leverkusen04', '64 65 74 75 84 85', '2024-04-21 08:47:57', 1, '16'),
('leverkusen04', '5 83 84 85 86 87', '2024-04-21 08:47:57', 1, '16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `firstname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telnumber` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`firstname`, `surname`, `birthdate`, `username`, `email`, `password`, `telnumber`, `role`) VALUES
('Péter', 'Pék', '2001-09-29', 'pékpetyus', 'pekpetya@gmail.com', '$2y$10$8oEUE3dFAhj8gFmwRCmjFec8O6v7e2gTZ.MMKiMNbeZvKPM9Axwv6', '0673243643563', 'admin'),
('Zinedine', 'Zidane', '1985-03-18', 'zizou', 'ziza@gmail.com', '$2y$10$lCwBydGGvajzirOLGs0MW.2n4Q0YC5dQqHg5zCOEGIR2xrj0SgQiG', '04638548343', 'guest'),
('Xabi', 'Alonso', '1981-11-25', 'leverkusen04', 'xabi.alonso@gmail.com', '$2y$10$ty1AU7rNfd9sWBfPEW3OlOYSlLBzdUDwyIsuWaXwo4q8qAsDogI2y', '06201234567', 'admin'),
('Péter', 'Pék', '1111-01-01', 'peterpeti', 'peti@gmail.com', '$2y$10$zW7II50w2e9htCG3qB2OaefVt0UiUrADAkwhsIxPrZkrU7r9FOtf6', '06307654321', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
