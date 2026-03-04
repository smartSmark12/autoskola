-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 04. bře 2026, 08:58
-- Verze serveru: 10.4.32-MariaDB
-- Verze PHP: 8.2.12

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

-- --------------------------------------------------------

--
-- Struktura tabulky `auta`
--

CREATE TABLE `auta` (
  `id` int(11) NOT NULL,
  `znacka` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `poznavaci_znacka` varchar(20) NOT NULL,
  `aktivni` tinyint(1) DEFAULT 1
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

CREATE TABLE `instruktori` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `aktivni` tinyint(1) DEFAULT 1
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

CREATE TABLE `jizdy` (
  `id` int(11) NOT NULL,
  `id_studenta` int(11) NOT NULL,
  `id_instruktora` int(11) NOT NULL,
  `id_auta` int(11) NOT NULL,
  `zacatek` datetime NOT NULL,
  `konec` datetime DEFAULT NULL,
  `stav` enum('p','u','z','') NOT NULL DEFAULT 'p' COMMENT 'p-plánovaná, u-ukončená, z-zrušená'
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
-- Struktura tabulky `jizdy_view`
--

CREATE TABLE `jizdy_view` (
  `id` int(11) NOT NULL,
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
  `datum_registrace` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `studenti`
--

CREATE TABLE `studenti` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `datum_narozeni` date DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `datum_registrace` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `studenti`
--

INSERT INTO `studenti` (`id`, `jmeno`, `prijmeni`, `datum_narozeni`, `telefon`, `email`, `datum_registrace`) VALUES
(1, 'Jan', 'Horák', '2008-03-14', '+420622456789', 'horak@google.com', '2025-11-10'),
(2, 'Petra', 'Veselá', '2006-11-21', '+420745869123', 'vesela@google.com', '2025-12-01');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `auta`
--
ALTER TABLE `auta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `poznavaci_znacka` (`poznavaci_znacka`) USING BTREE;

--
-- Indexy pro tabulku `instruktori`
--
ALTER TABLE `instruktori`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `jizdy`
--
ALTER TABLE `jizdy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_studenta` (`id_studenta`),
  ADD KEY `id_instruktora` (`id_instruktora`),
  ADD KEY `id_auta` (`id_auta`);

--
-- Indexy pro tabulku `jizdy_view`
--
ALTER TABLE `jizdy_view`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `auta`
--
ALTER TABLE `auta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `instruktori`
--
ALTER TABLE `instruktori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `jizdy`
--
ALTER TABLE `jizdy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pro tabulku `jizdy_view`
--
ALTER TABLE `jizdy_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `studenti`
--
ALTER TABLE `studenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
