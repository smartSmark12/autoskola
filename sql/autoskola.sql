-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3306
-- Vytvořeno: Sob 29. lis 2025, 18:05
-- Verze serveru: 5.7.31
-- Verze PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `autoskola`
--
CREATE DATABASE IF NOT EXISTS `autoskola` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci;
USE `autoskola`;

-- --------------------------------------------------------

--
-- Struktura tabulky `auta`
--

DROP TABLE IF EXISTS `auta`;
CREATE TABLE IF NOT EXISTS `auta` (
  `id` int(11) NOT NULL,
  `znacka` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `model` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `poznavaci_znacka` varchar(20) COLLATE utf8mb4_czech_ci NOT NULL,
  `aktivni` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `poznavaci_znacka` (`poznavaci_znacka`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `auta`
--

INSERT INTO `auta` (`id`, `znacka`, `model`, `poznavaci_znacka`, `aktivni`) VALUES
(1, 'Škoda', 'Fabia IV', '8P4 3212', 1),
(2, 'Toyota', 'Yaris Hybrid', '6E0 4876', 1),
(3, 'Honda', 'CB500F', '2A9 5520', 0),
(4, 'Škoda', 'Fabia IV', '1P2 2552', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `instruktori`
--

DROP TABLE IF EXISTS `instruktori`;
CREATE TABLE IF NOT EXISTS `instruktori` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `prijmeni` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `telefon` varchar(20) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `aktivni` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `instruktori`
--

INSERT INTO `instruktori` (`id`, `jmeno`, `prijmeni`, `telefon`, `email`, `aktivni`) VALUES
(1, 'Pavel', 'Novák', '+420603999789', 'novak@autoskola.cz', 1),
(2, 'Lucie', 'Výborná', '+420732333444', 'vyborna@autoskola.cz', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `jizdy`
--

DROP TABLE IF EXISTS `jizdy`;
CREATE TABLE IF NOT EXISTS `jizdy` (
  `id` int(11) NOT NULL,
  `id_studenta` int(11) NOT NULL,
  `id_instruktora` int(11) NOT NULL,
  `id_auta` int(11) NOT NULL,
  `zacatek` datetime NOT NULL,
  `konec` datetime DEFAULT NULL,
  `stav` enum('p','u','z','') COLLATE utf8mb4_czech_ci NOT NULL DEFAULT 'p' COMMENT 'p-plánovaná, u-ukončená, z-zrušená',
  PRIMARY KEY (`id`),
  KEY `id_studenta` (`id_studenta`),
  KEY `id_instruktora` (`id_instruktora`),
  KEY `id_auta` (`id_auta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `jizdy`
--

INSERT INTO `jizdy` (`id`, `id_studenta`, `id_instruktora`, `id_auta`, `zacatek`, `konec`, `stav`) VALUES
(101, 1, 1, 1, '2026-02-05 14:00:00', '2026-02-05 15:00:00', 'p'),
(102, 1, 1, 1, '2026-02-10 13:00:00', '2026-02-10 14:30:00', 'p'),
(103, 2, 2, 4, '2026-02-05 14:00:00', '2026-02-05 15:00:00', 'p'),
(104, 2, 2, 2, '2026-02-14 09:00:00', '2026-02-14 10:00:00', 'p'),
(105, 1, 1, 1, '2026-02-20 15:30:00', '2026-02-20 17:00:00', 'p');

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `jizdy_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `jizdy_view`;
CREATE TABLE IF NOT EXISTS `jizdy_view` (
`id` int(11)
,`znacka` varchar(50)
,`model` varchar(50)
,`poznavaci_znacka` varchar(20)
,`zacatek` datetime
,`konec` datetime
,`stav` enum('p','u','z','')
,`instruktor_jmeno` varchar(50)
,`instruktor_prijmeni` varchar(50)
,`instruktor_telefon` varchar(20)
,`instruktor_email` varchar(100)
,`jmeno` varchar(50)
,`prijmeni` varchar(50)
,`telefon` varchar(20)
,`email` varchar(100)
,`datum_narozeni` date
,`datum_registrace` date
);

-- --------------------------------------------------------

--
-- Struktura tabulky `studenti`
--

DROP TABLE IF EXISTS `studenti`;
CREATE TABLE IF NOT EXISTS `studenti` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `prijmeni` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `datum_narozeni` date DEFAULT NULL,
  `telefon` varchar(20) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `datum_registrace` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `studenti`
--

INSERT INTO `studenti` (`id`, `jmeno`, `prijmeni`, `datum_narozeni`, `telefon`, `email`, `datum_registrace`) VALUES
(1, 'Jan', 'Horák', '2008-03-14', '+420622456789', 'horak@google.com', '2025-11-10'),
(2, 'Petra', 'Veselá', '2006-11-21', '+420745869123', 'vesela@google.com', '2025-12-01');

-- --------------------------------------------------------

