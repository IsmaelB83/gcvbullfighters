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
-- Table structure for table `gcv_zcondecoraciones`
--

CREATE TABLE `gcv_zcondecoraciones` (
  `condecoracion` varchar(20) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `imagen` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gcv_zcondecoraciones`
--

INSERT INTO `gcv_zcondecoraciones` (`condecoracion`, `descripcion`, `imagen`) VALUES
('1_aaw_viii_2022', 'VIII Torneo Dogfight WW2', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/1stplace.jpg'),
('1_aa_viii_2022', 'VIII Torneo Dogfight', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/1stplace.jpg'),
('1_ag_viii_2022', 'VIII Torneo Aire Suelo', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/1stplace.jpg'),
('1_apon_viii_2022', 'VIII Torneo Apontaje', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/1stplace.jpg'),
('2_aaw_viii_2022', 'VIII Torneo Dogfight WW2', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/2ndplace.png'),
('2_aa_viii_2022', 'VIII Torneo Dogfight', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/2ndplace.png'),
('2_ag_viii_2022', 'VIII Torneo Aire Suelo', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/2ndplace.png'),
('2_apon_viii_2022', 'VIII Torneo Apontaje', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/2ndplace.png'),
('3_aaw_viii_2022', 'VIII Torneo Dogfight WW2', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/3rdplace.jpg'),
('3_aa_viii_2022', 'VIII Torneo Dogfight', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/3rdplace.jpg'),
('3_ag_viii_2022', 'VIII Torneo Aire Suelo', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/3rdplace.jpg'),
('3_apon_viii_2022', 'VIII Torneo Apontaje', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/3rdplace.jpg'),
('C-01', 'Constancia en el servicio Bronce', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_13a.jpg'),
('C-02', 'Constancia en el servicio Plata', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_13b2.jpg'),
('C-03', 'Constancia en el servicio Oro', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_13c.jpg'),
('E-01', 'Editor Misión Bronce', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_14.jpg'),
('E-02', 'Editor Misión Plata', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_15.jpg'),
('E-03', 'Editor Misión Oro', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_15c.jpg'),
('G-01', 'Gran Cruz del Mérito Aeronáutico', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_22.jpg'),
('G-02', 'Gran Cruz del Mérito Aeronáutico distintivo rojo', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_19b.jpg'),
('G-03', 'Gran Cruz del Mérito Aeronáutico distintivo azul', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_18c.jpg'),
('I-01', 'Instructor Bronce', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_16a.jpg'),
('I-02', 'Instructor Plata', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_16.jpg'),
('I-03', 'Instructor Oro', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_16c.jpg'),
('O-01', 'Mencion OTAN', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_23b.jpg'),
('O-02', 'Mencion OTAN Especial', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_17b.jpg'),
('P-01', 'Participación en Campaña [xxxxxx]', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_09.jpg'),
('P-02', 'Participación en Campaña [xxxxxx]', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_07.jpg'),
('P-03', 'Participación en Campaña [xxxxxx]', 'https://gcvbullfighters.com/wp-content/uploads/2023/08/Medalla_02b.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gcv_zcondecoraciones`
--
ALTER TABLE `gcv_zcondecoraciones`
  ADD PRIMARY KEY (`condecoracion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
