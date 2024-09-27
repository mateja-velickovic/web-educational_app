-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Sep 12, 2024 at 08:01 AM
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
-- Table structure for table `t_activite`
--

DROP TABLE IF EXISTS `t_activite`;
CREATE TABLE `t_activite` (
  `idActivite` int NOT NULL,
  `actLibelle` varchar(50) NOT NULL,
  `actDate` date NOT NULL,
  `actLieu` varchar(50) NOT NULL,
  `actCapacite` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `t_inscription`
--

DROP TABLE IF EXISTS `t_inscription`;
CREATE TABLE `t_inscription` (
  `idInscription` int NOT NULL,
  `fkUser` int NOT NULL,
  `fkActivite` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `t_role`
--

DROP TABLE IF EXISTS `t_role`;
CREATE TABLE `t_role` (
  `idRole` int NOT NULL,
  `rolNom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `idUser` int NOT NULL,
  `useNom` varchar(50) NOT NULL,
  `usePrenom` varchar(50) NOT NULL,
  `usePassword` varchar(20) NOT NULL,
  `fkRole` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_activite`
--
ALTER TABLE `t_activite`
  ADD PRIMARY KEY (`idActivite`);

--
-- Indexes for table `t_inscription`
--
ALTER TABLE `t_inscription`
  ADD PRIMARY KEY (`idInscription`),
  ADD KEY `fkUser` (`fkUser`,`fkActivite`),
  ADD KEY `fkActivite` (`fkActivite`);

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
-- AUTO_INCREMENT for table `t_activite`
--
ALTER TABLE `t_activite`
  MODIFY `idActivite` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_inscription`
--
ALTER TABLE `t_inscription`
  MODIFY `idInscription` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_role`
--
ALTER TABLE `t_role`
  MODIFY `idRole` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_inscription`
--
ALTER TABLE `t_inscription`
  ADD CONSTRAINT `t_inscription_ibfk_1` FOREIGN KEY (`fkActivite`) REFERENCES `t_activite` (`idActivite`),
  ADD CONSTRAINT `t_inscription_ibfk_2` FOREIGN KEY (`fkUser`) REFERENCES `t_user` (`idUser`);

--
-- Constraints for table `t_user`
--
ALTER TABLE `t_user`
  ADD CONSTRAINT `t_user_ibfk_1` FOREIGN KEY (`fkRole`) REFERENCES `t_role` (`idRole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
