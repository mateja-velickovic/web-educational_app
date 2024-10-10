SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `db_jpprod` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `db_jpprod`;

DROP TABLE IF EXISTS `t_activity`;
CREATE TABLE IF NOT EXISTS `t_activity` (
  `idActivite` int NOT NULL AUTO_INCREMENT,
  `actName` varchar(50) NOT NULL,
  `actDate` timestamp NOT NULL,
  `actPlace` varchar(50) NOT NULL,
  `actCapacity` int NOT NULL,
  PRIMARY KEY (`idActivite`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

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

DROP TABLE IF EXISTS `t_registration`;
CREATE TABLE IF NOT EXISTS `t_registration` (
  `idRegistration` int NOT NULL AUTO_INCREMENT,
  `fkUser` int NOT NULL,
  `fkActivity` int NOT NULL,
  PRIMARY KEY (`idRegistration`),
  KEY `fkUser` (`fkUser`,`fkActivity`),
  KEY `fkActivity` (`fkActivity`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `t_role`;
CREATE TABLE IF NOT EXISTS `t_role` (
  `idRole` int NOT NULL AUTO_INCREMENT,
  `rolName` varchar(50) NOT NULL,
  PRIMARY KEY (`idRole`),
  UNIQUE KEY `idRole` (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

INSERT INTO `t_role` (`idRole`, `rolName`) VALUES
(1, 'user'),
(2, 'admin');

DROP TABLE IF EXISTS `t_user`;
CREATE TABLE IF NOT EXISTS `t_user` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `useUsername` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `usePassword` varchar(255) NOT NULL,
  `fkRole` int NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `idUser` (`idUser`),
  KEY `fkRole` (`fkRole`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;


ALTER TABLE `t_registration`
  ADD CONSTRAINT `t_registration_ibfk_1` FOREIGN KEY (`fkActivity`) REFERENCES `t_activity` (`idActivite`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `t_user`
  ADD CONSTRAINT `t_user_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `t_registration` (`fkUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_user_ibfk_2` FOREIGN KEY (`fkRole`) REFERENCES `t_role` (`idRole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
