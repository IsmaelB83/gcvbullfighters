-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 10, 2023 at 06:21 AM
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
-- Table structure for table `gcv_zmemcond`
--

CREATE TABLE `gcv_zmemcond` (
  `nickname` varchar(20) NOT NULL,
  `condecoracion` varchar(20) NOT NULL,
  `fecha` date NOT NULL,
  `observaciones` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gcv_zmemcond`
--

INSERT INTO `gcv_zmemcond` (`nickname`, `condecoracion`, `fecha`, `observaciones`) VALUES
('bogart', '3_aaw_viii_2022', '2022-12-31', '3er puesto en la VIII edición del Torneo de Navidad en Dogfight World War II'),
('bogart', '3_ag_viii_2022', '2022-12-31', '3er puesto en la VIII edición del Torneo de Navidad en Ataque de precisión Aire-Suelo'),
('hawkman', '2_aaw_viii_2022', '2022-12-31', '2do puesto en la VIII edición del Torneo de Navidad en Dogfight World War II'),
('hawkman', '3_aa_viii_2022', '2022-12-31', '3er puesto en la VIII edición del Torneo de Navidad en Dogfight Moderno'),
('kikety', '1_ag_viii_2022', '2022-12-31', '1er puesto en la VIII edición del Torneo de Navidad en Ataque de precisión Aire-Suelo'),
('loken', '2_aa_viii_2022', '2022-12-31', '2do puesto en la VIII edición del Torneo de Navidad en Dogfight Moderno'),
('loken', '3_apon_viii_2022', '2022-12-31', '3er puesto en la VIII edición del Torneo de Navidad en Apontajes Case I'),
('paco', '2_apon_viii_2022', '2022-12-31', '2do puesto en la VIII edición del Torneo de Navidad en Apontajes Case I'),
('zaz0', '1_aaw_viii_2022', '2022-12-31', '1er puesto en la VIII edición del Torneo de Navidad en Dogfight World War II'),
('zaz0', '1_aa_viii_2022', '2022-12-31', '1er puesto en la VIII edición del Torneo de Navidad en Dogfight Moderno'),
('zaz0', '1_apon_viii_2022', '2022-12-31', '1er puesto en la VIII edición del Torneo de Navidad en Apontajes Case I');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gcv_zmemcond`
--
ALTER TABLE `gcv_zmemcond`
  ADD PRIMARY KEY (`nickname`,`condecoracion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
