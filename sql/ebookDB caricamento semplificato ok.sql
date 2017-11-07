-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Set 30, 2016 alle 16:05
-- Versione del server: 5.5.50-MariaDB
-- Versione PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebookDB`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `accesso`
--

CREATE TABLE `accesso` (
  `accessoid` int(11) NOT NULL,
  `codicefk` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `download` tinyint(1) NOT NULL,
  `login` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `codice`
--

CREATE TABLE `codice` (
  `codiceid` int(11) NOT NULL,
  `denominazione` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codice` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `librofk` int(11) NOT NULL,
  `download` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `codice`
--

INSERT INTO `codice` (`codiceid`, `denominazione`, `codice`, `librofk`, `download`) VALUES
(1, 'Rollandin Emilie', '41667561253008', 4, 0),
(2, 'Laurent Marisa', '61269241290000', 1, 0),
(3, 'Groppo Pietro', '16328270474701', 4, 3),
(4, 'Emilie Rollandin', '38088314934900', 2, 3),
(5, 'Rossi Mario', '68569769352004', 6, 1),
(6, 'Banana', '34022527143207', 8, 0),
(7, 'Rollandin Christine', '14052925607906', 8, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `libro`
--

CREATE TABLE `libro` (
  `libroid` int(11) NOT NULL,
  `titolo` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `autore` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `casaeditrice` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `isbn` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `prezzo` decimal(8,2) NOT NULL,
  `nomefile` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `libro`
--

INSERT INTO `libro` (`libroid`, `titolo`, `autore`, `casaeditrice`, `isbn`, `prezzo`, `nomefile`) VALUES
(1, 'Due non è il doppio di uno', 'Elettra Groppo', 'Elmi\'s World', '9788897192107', '9.99', 'duenoneildoppiodiuno.epub'),
(2, 'Corto circuito', 'Elettra Groppo', 'Elmi\'s World', '9788897192602', '5.49', 'cortocircuito.epub'),
(4, 'Il musicista', 'Christiano Cerasola', 'Elmi\'s World', '9788897192633', '4.49', 'ilmusicista.epub'),
(5, 'Diario di una 883', 'Sara Goria', 'Elmi\'s World', '9788897192909', '4.49', 'diariodiuna883.epub'),
(6, 'Libambos', 'Paolo Groppo', 'Elmi\'s World', '9788897192787', '5.99', 'libambos.epub'),
(8, 'Il rumore del suo silenzio', 'Elvira Borriello', 'Elmi\'s World', '9788897192343', '3.99', 'ilrumoredelsuosilenzio.epub');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `accesso`
--
ALTER TABLE `accesso`
  ADD PRIMARY KEY (`accessoid`);

--
-- Indici per le tabelle `codice`
--
ALTER TABLE `codice`
  ADD PRIMARY KEY (`codiceid`);

--
-- Indici per le tabelle `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`libroid`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `accesso`
--
ALTER TABLE `accesso`
  MODIFY `accessoid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `codice`
--
ALTER TABLE `codice`
  MODIFY `codiceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT per la tabella `libro`
--
ALTER TABLE `libro`
  MODIFY `libroid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
