/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.6-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: autoskola
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Current Database: `autoskola`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `autoskola` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci */;

USE `autoskola`;

--
-- Table structure for table `auta`
--

DROP TABLE IF EXISTS `auta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `auta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `znacka` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `poznavaci_znacka` varchar(20) NOT NULL,
  `aktivni` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `poznavaci_znacka` (`poznavaci_znacka`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auta`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `auta` WRITE;
/*!40000 ALTER TABLE `auta` DISABLE KEYS */;
INSERT INTO `auta` VALUES
(1,'Škoda','Fabia IV','8P4 3212',1),
(2,'Toyota','Yaris Hybrid','6E0 4876',1),
(3,'Honda','CB500F','2A9 5520',0),
(4,'Škoda','Fabia IV','1P2 2552',1);
/*!40000 ALTER TABLE `auta` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `instruktori`
--

DROP TABLE IF EXISTS `instruktori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `instruktori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `heslo` varchar(255) DEFAULT NULL,
  `aktivni` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_instruktor_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruktori`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `instruktori` WRITE;
/*!40000 ALTER TABLE `instruktori` DISABLE KEYS */;
INSERT INTO `instruktori` VALUES
(1,'Pavel','Novák','+420603999789','novak@autoskola.cz','$2y$12$Y8ugakrEES5dvBGYdpkbaO7uc8ZYwCEXR39CJ6tMsZV3WjVqi8ERW',1),
(2,'Lucie','Výborná','+420732333444','vyborna@autoskola.cz','$2y$12$Y8ugakrEES5dvBGYdpkbaO7uc8ZYwCEXR39CJ6tMsZV3WjVqi8ERW',1),
(4,'huh','huh',NULL,'huh@huh.huh','$2y$12$MQ7otNQgV8i4WGmbgXzYOO3tfy1rR4LFo7sr4L1oNZYmIbxK2bLj2',1);
/*!40000 ALTER TABLE `instruktori` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jizdy`
--

DROP TABLE IF EXISTS `jizdy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jizdy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_studenta` int(11) NOT NULL,
  `id_instruktora` int(11) NOT NULL,
  `id_auta` int(11) NOT NULL,
  `zacatek` datetime NOT NULL,
  `konec` datetime DEFAULT NULL,
  `stav` enum('p','u','z','') NOT NULL DEFAULT 'p' COMMENT 'p-plánovaná, u-ukončená, z-zrušená',
  PRIMARY KEY (`id`),
  KEY `id_studenta` (`id_studenta`),
  KEY `id_instruktora` (`id_instruktora`),
  KEY `id_auta` (`id_auta`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jizdy`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jizdy` WRITE;
/*!40000 ALTER TABLE `jizdy` DISABLE KEYS */;
INSERT INTO `jizdy` VALUES
(101,1,1,1,'2026-02-05 14:00:00','2026-02-05 15:00:00','p'),
(102,1,1,1,'2026-02-10 13:00:00','2026-02-10 14:30:00','p'),
(103,2,2,4,'2026-02-05 14:00:00','2026-02-05 15:00:00','p'),
(104,2,2,2,'2026-02-14 09:00:00','2026-02-14 10:00:00','p'),
(106,5,4,4,'2026-06-04 06:41:00','2026-06-06 06:41:00','p');
/*!40000 ALTER TABLE `jizdy` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jizdy_view`
--

DROP TABLE IF EXISTS `jizdy_view`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jizdy_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `znacka` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `poznavaci_znacka` varchar(20) DEFAULT NULL,
  `zacatek` datetime DEFAULT NULL,
  `konec` datetime DEFAULT NULL,
  `stav` enum('p','u','z','') DEFAULT NULL,
  `instruktor_jmeno` varchar(50) DEFAULT NULL,
  `instruktor_prijmeni` varchar(50) DEFAULT NULL,
  `instruktor_telefon` varchar(20) DEFAULT NULL,
  `instruktor_email` varchar(100) DEFAULT NULL,
  `jmeno` varchar(50) DEFAULT NULL,
  `prijmeni` varchar(50) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `datum_narozeni` date DEFAULT NULL,
  `datum_registrace` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jizdy_view`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jizdy_view` WRITE;
/*!40000 ALTER TABLE `jizdy_view` DISABLE KEYS */;
/*!40000 ALTER TABLE `jizdy_view` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `studenti`
--

DROP TABLE IF EXISTS `studenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `studenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `datum_narozeni` date DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `heslo` varchar(255) DEFAULT NULL,
  `datum_registrace` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_student_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studenti`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `studenti` WRITE;
/*!40000 ALTER TABLE `studenti` DISABLE KEYS */;
INSERT INTO `studenti` VALUES
(1,'Lednička','Horák','2008-03-14','+420622456789','horak@google.com','$2y$12$Y8ugakrEES5dvBGYdpkbaO7uc8ZYwCEXR39CJ6tMsZV3WjVqi8ERW','2025-11-10'),
(2,'Petra','Veselá','2006-11-21','+420745869123','vesela@google.com','$2y$12$Y8ugakrEES5dvBGYdpkbaO7uc8ZYwCEXR39CJ6tMsZV3WjVqi8ERW','2025-12-01'),
(3,'Šimon','Hlavnička','1998-10-04','+420123123123','simonhlavnicka@gmail.com','$2y$12$Y8ugakrEES5dvBGYdpkbaO7uc8ZYwCEXR39CJ6tMsZV3WjVqi8ERW','2026-05-06'),
(5,'Václav','Kuuuuuuuuuuufurst','2026-06-17',NULL,'idk@idk.idk','$2y$12$72eMSQj/18GZJuxe.JAVIuH5U3b2QVC5S7AgNRD.Q0s3q/BevGH1C','2026-06-02');
/*!40000 ALTER TABLE `studenti` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-06-03  8:16:46
