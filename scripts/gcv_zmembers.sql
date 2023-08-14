-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 10, 2023 at 06:22 AM
-- Server version: 8.0.34
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bullfighters`
--

-- --------------------------------------------------------

--
-- Table structure for table `gcv_zmembers`
--

CREATE TABLE `gcv_zmembers` (
  `nickname` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `capacitaciones` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gcv_zmembers`
--

INSERT INTO `gcv_zmembers` (`nickname`, `role`, `avatar`, `capacitaciones`) VALUES
('Arink', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_arink.webp', 'A-10C'),
('Bogart', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_bogart.webp', 'F/A-18C'),
('Carney', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_carney.webp', 'F/A-18C | A-10C | AV-8B'),
('Deute', 'invitado', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_deute.webp', 'F/A-18C | A-10C'),
('Fisu', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_fisu.webp', 'F/A-18C | F-16C'),
('Fulgrim', 'invitado', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_fulgrim.webp', 'F/A-18C | F-16C'),
('Geddon', 'invitado', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_geddon.webp', 'F/A-18C'),
('Hawkman', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_hawkman.webp', 'F/A-18C | F-16C | F-14A/B (P)'),
('Josenairbec', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_josenairbec.webp', 'F/A-18C'),
('Kikety', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatar_kikety.png', 'F/A-18C | A-10C | AV-8B'),
('Kuta', 'invitado', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_kuta.webp', ''),
('Loken', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_loken.webp', 'F/A-18C'),
('Lucifer', 'invitado', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_lucifer.webp', 'F/A-18C | A-10C | AV-8B'),
('Macaci', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_macaci.webp', 'F/A-18C'),
('Mikel', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_mikel.webp', 'F/A-18C | F-16C'),
('Paco', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares-paco.webp', 'F/A-18C | F-16C | F-14A/B (P)'),
('Paquete', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_paquete.webp', 'F/A-18C | A-10C'),
('PEPE', 'invitado', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_pepe.webp', ''),
('Shuodata', 'invitado', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_shuodata.webp', 'F/A-18C'),
('Trazador', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_traza.webp', 'F/A-18C | A-10C'),
('Yoyo', 'invitado', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_yoyo.webp', ''),
('Zaz0', 'bullfighter', 'https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_zazo.webp', 'F/A-18C | A-10C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gcv_zmembers`
--
ALTER TABLE `gcv_zmembers`
  ADD PRIMARY KEY (`nickname`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
