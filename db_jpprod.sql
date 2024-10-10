-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Oct 10, 2024 at 08:15 AM
-- Server version: 8.0.30
-- PHP Version: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_jpprod`
--
CREATE DATABASE IF NOT EXISTS `db_jpprod` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `db_jpprod`;

-- --------------------------------------------------------

--
-- Table structure for table `t_activity`
--

DROP TABLE IF EXISTS `t_activity`;
CREATE TABLE `t_activity` (
  `idActivite` int NOT NULL,
  `actName` varchar(50) NOT NULL,
  `actDate` timestamp NOT NULL,
  `actPlace` varchar(50) NOT NULL,
  `actCapacity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `t_activity`
--

INSERT INTO `t_activity` (`idActivite`, `actName`, `actDate`, `actPlace`, `actCapacity`) VALUES
(1, 'Randonnée en montagne', '2024-10-15 09:00:00', 'Alpes Suisses', 30),
(2, 'Atelier de cuisine', '2024-10-20 14:00:00', 'Lausanne', 20),
(3, 'Conférence sur IA', '2024-10-25 10:30:00', 'EPFL', 100),
(4, 'Tournoi de football', '2024-11-01 15:00:00', 'Stade de Genève', 50),
(5, 'Séance de yoga', '2024-10-18 08:00:00', 'Parc de Lausanne', 25),
(6, 'Concert de musique', '2024-11-05 19:00:00', 'Palais de Beaulieu', 200),
(7, 'Atelier de peinture', '2024-11-10 11:00:00', 'Galerie art de Vevey', 15),
(8, 'Compétition de natation', '2024-11-12 17:00:00', 'Piscine de Pully', 40),
(9, 'Cours de photographie', '2024-11-18 13:00:00', 'Montreux', 12),
(10, 'Marathon de Genève', '2024-11-25 07:00:00', 'Genève', 300);

-- --------------------------------------------------------

--
-- Table structure for table `t_registration`
--

DROP TABLE IF EXISTS `t_registration`;
CREATE TABLE `t_registration` (
  `idRegistration` int NOT NULL,
  `fkUser` int NOT NULL,
  `fkActivity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `t_role`
--

DROP TABLE IF EXISTS `t_role`;
CREATE TABLE `t_role` (
  `idRole` int NOT NULL,
  `rolName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `t_role`
--

INSERT INTO `t_role` (`idRole`, `rolName`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `idUser` int NOT NULL,
  `useUsername` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `usePassword` varchar(255) NOT NULL,
  `fkRole` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_activity`
--
ALTER TABLE `t_activity`
  ADD PRIMARY KEY (`idActivite`);

--
-- Indexes for table `t_registration`
--
ALTER TABLE `t_registration`
  ADD PRIMARY KEY (`idRegistration`),
  ADD KEY `fkUser` (`fkUser`,`fkActivity`),
  ADD KEY `fkActivity` (`fkActivity`);

--
-- Indexes for table `t_role`
--
ALTER TABLE `t_role`
  ADD PRIMARY KEY (`idRole`),
  ADD UNIQUE KEY `idRole` (`idRole`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `idUser` (`idUser`),
  ADD KEY `fkRole` (`fkRole`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_activity`
--
ALTER TABLE `t_activity`
  MODIFY `idActivite` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `t_registration`
--
ALTER TABLE `t_registration`
  MODIFY `idRegistration` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_role`
--
ALTER TABLE `t_role`
  MODIFY `idRole` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_registration`
--
ALTER TABLE `t_registration`
  ADD CONSTRAINT `t_registration_ibfk_1` FOREIGN KEY (`fkUser`) REFERENCES `t_user` (`idUser`),
  ADD CONSTRAINT `t_registration_ibfk_2` FOREIGN KEY (`fkActivity`) REFERENCES `t_activity` (`idActivite`);

--
-- Constraints for table `t_user`
--
ALTER TABLE `t_user`
  ADD CONSTRAINT `t_user_ibfk_1` FOREIGN KEY (`fkRole`) REFERENCES `t_role` (`idRole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
