-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Oct 03, 2024 at 07:15 AM
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

CREATE TABLE `t_activity` (
  `idActivite` int NOT NULL,
  `actName` varchar(50) NOT NULL,
  `actDate` date NOT NULL,
  `actPlace` varchar(50) NOT NULL,
  `actCapacity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `t_activity`
--

INSERT INTO `t_activity` (`idActivite`, `actName`, `actDate`, `actPlace`, `actCapacity`) VALUES
(1, 'Yoga Session', '2024-10-05', 'Gym', 30),
(2, 'Coding Workshop', '2024-11-10', 'Room 203', 25),
(3, 'Art Class', '2024-10-15', 'Studio 12', 15),
(4, 'Math Tutoring', '2024-12-01', 'Library', 10),
(5, 'Science Fair', '2024-11-25', 'Auditorium', 50),
(6, 'Music Concert', '2024-10-20', 'Main Hall', 100),
(7, 'Drama Play', '2024-10-30', 'Theater', 75),
(8, 'Cooking Class', '2024-11-05', 'Cafeteria', 20),
(9, 'Photography Workshop', '2024-12-15', 'Room 101', 12),
(10, 'Robotics Demo', '2024-11-18', 'Lab 5', 40);

-- --------------------------------------------------------

--
-- Table structure for table `t_registration`
--

CREATE TABLE `t_registration` (
  `idRegistration` int NOT NULL,
  `fkUser` int NOT NULL,
  `fkActivity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `t_registration`
--

INSERT INTO `t_registration` (`idRegistration`, `fkUser`, `fkActivity`) VALUES
(2, 1, 8),
(3, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `t_role`
--

CREATE TABLE `t_role` (
  `idRole` int NOT NULL,
  `rolName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `t_role`
--

INSERT INTO `t_role` (`idRole`, `rolName`) VALUES
(1, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `idUser` int NOT NULL,
  `useUsername` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `usePassword` varchar(255) NOT NULL,
  `fkRole` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`idUser`, `useUsername`, `usePassword`, `fkRole`) VALUES
(1, 'root', 'root', 1);

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
  MODIFY `idRole` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `t_registration_ibfk_1` FOREIGN KEY (`fkActivity`) REFERENCES `t_activity` (`idActivite`),
  ADD CONSTRAINT `t_registration_ibfk_2` FOREIGN KEY (`fkUser`) REFERENCES `t_user` (`idUser`);

--
-- Constraints for table `t_user`
--
ALTER TABLE `t_user`
  ADD CONSTRAINT `t_user_ibfk_1` FOREIGN KEY (`fkRole`) REFERENCES `t_role` (`idRole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
