-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: m-07.th.seeweb.it
-- Creato il: Nov 10, 2017 alle 22:26
-- Versione del server: 5.6.36
-- Versione PHP: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elmiswor31674`
--
-- CREATE DATABASE IF NOT EXISTS `elmiswor31674` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
-- USE `elmiswor31674`;

-- --------------------------------------------------------

--
-- Struttura della tabella `accesso`
--

CREATE TABLE `accesso` (
  `accessoid` int(11) NOT NULL,
  `descrizione` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codice` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `download` tinyint(1) NOT NULL,
  `login` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `accesso`
--

INSERT INTO `accesso` (`accessoid`, `descrizione`, `codice`, `data`, `ip`, `download`, `login`) VALUES
(1, 'Pagina scaricamento ebook', '14433108141107', '2017-11-10 19:31:12', '2.235.188.10', 0, 1),
(2, 'Pagina scaricamento ebook', '14433108141107', '2017-11-10 19:31:16', '2.235.188.10', 0, 1),
(3, 'Download', '14433108141107 - Prendimi adesso', '2017-11-10 19:31:16', '2.235.188.10', 1, 1),
(4, 'Pagina scaricamento ebook', '14433108141107', '2017-11-10 19:31:21', '2.235.188.10', 0, 1),
(5, 'Download', '14433108141107 - Prendimi adesso', '2017-11-10 19:31:21', '2.235.188.10', 1, 1),
(6, 'Pagina scaricamento ebook', '14433108141107', '2017-11-10 19:31:45', '2.235.188.10', 0, 1),
(7, 'Pagina scaricamento ebook', '14433108141107', '2017-11-10 19:31:52', '2.235.188.10', 0, 1),
(8, 'Download', '14433108141107 - Prendimi adesso', '2017-11-10 19:31:52', '2.235.188.10', 1, 1),
(9, 'Pagina scaricamento ebook', '14433108141107', '2017-11-10 19:31:56', '2.235.188.10', 0, 1),
(10, 'Massimo scaricamento raggiunto', '14433108141107', '2017-11-10 19:31:56', '2.235.188.10', 0, 0),
(11, 'Pagina scaricamento ebook', '27175724764404', '2017-11-10 21:17:59', '2.235.188.10', 0, 1);

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
(10, 'Prendimi adesso', 'Elettra Groppo', 'Elmi\'s World', '9788897192824', 5.49, '0849f05228'),
(11, 'Wheels in a Tale', 'Sara Goria', 'Elmi\'s World', '9788885490000', 4.99, 'aa97f72db2'),
(13, 'L\'ultima luna', 'Elvira Borriello', 'Elmi\'s World', '9788897192862', 4.49, '9b9e78b9a3'),
(14, 'Il gigantesco abbaglio', 'Christiano Cerasola', 'Elmi\'s World', '9788897192992', 4.49, '7cfebf971a'),
(17, 'Fuori dal coro', 'Francesco Gallieri', 'Elmi\'s World', '9788897192961', 3.99, 'b111c903c1'),
(18, 'Over 60 - Women', 'AA.VV.', 'Elmi\'s World', '9788897192923', 5.49, '40d0707096'),
(19, 'La moneta d\'oro del fattore', 'Giuliana Borghesani', 'Elmi\'s World', '9788897192848', 4.49, '6c8f10b1fe'),
(20, 'Il cuore di Solomon', 'Silvia Vitrò', 'Elmi\'s World', '9788897192947', 5.49, 'd9f782a33a'),
(21, 'Talvolta un libro', 'Antonella Polenta', 'Elmi\'s World', '9788897192800', 5.49, 'd4cab76c05'),
(22, 'Diario di una 883', 'Sara Goria', 'Elmi\'s World', '9788897192909', 4.49, 'c5cfe80c75'),
(23, 'Over 60 - Men', 'AA.VV.', 'Elmi\'s World', '9788897192886', 5.49, '853280e202'),
(24, 'Libambos', 'Paolo Groppo', 'Elmi\'s World', '9788897192787', 5.99, '978a134fdd'),
(25, 'Il musicista', 'Christiano Cerasola', 'Elmi\'s World', '9788897192633', 4.49, '6b96e085c2'),
(26, 'Corto circuito', 'Elettra Groppo', 'Elmi\'s World', '9788897192619', 5.49, '13a7daa990'),
(27, 'Seconda classe, lato finestrino', 'Sara Goria', 'Elmi\'s World', '9788897192565', 4.99, '9e008b724d'),
(28, 'Le long hiver de Spitak', 'Mario Massimo Simonelli', 'Elmi\'s World', '9788897192589', 8.99, 'fc74556e82'),
(29, 'Paola per sempre', 'Elvira Borriello', 'Elmi\'s World', '9788897192534', 4.49, 'e3f8f7c16e'),
(30, 'Oxygen', 'Christiano Cerasola', 'Elmi\'s World', '9788897192251', 4.99, 'd0fc9eeeaf'),
(31, 'Le pagine strappate', 'Pietro Ratto', 'Elmi\'s World', '9788897192398', 5.99, 'f95e2b9f55'),
(32, 'Il rumore del suo silenzio', 'Elvira Borriello', 'Elmi\'s World', '9788897192343', 3.99, '6360bf911c'),
(33, 'Marne Rosse', 'Paolo Groppo', 'Elmi\'s World', '9788897192367', 6.49, '08ee25fb12'),
(34, 'Desideri sommersi', 'Barbara Ferri', 'Elmi\'s World', '9788897192299', 4.99, '3559536442'),
(35, 'Al di là del fiume', 'Elettra Groppo', 'Elmi\'s World', '9788897192510', 5.49, 'f38997ca30'),
(36, 'Il custode di Izu', 'Christiano Cerasola', 'Elmi\'s World', '9788897192275', 0.99, '0ec61ecec1'),
(37, 'Cripta', 'Ezio Gerbore', 'Elmi\'s World', '9788897192305', 5.49, '08aca7d74c'),
(38, 'Poi ho smesso', 'Sofia Green', 'Elmi\'s World', '9788897192220', 6.49, '66b629fd8c'),
(39, 'Sogni inquinati', 'Elettra Groppo', 'Elmi\'s World', '9788897192206', 1.49, 'c72d8b420a'),
(40, 'Uova sbattute', 'Christiano Cerasola', 'Elmi\'s World', '9788897192176', 6.49, '102e14b5bf'),
(41, 'L\'occasione fa l\'uomo laico', 'Francesco Belais', 'Elmi\'s World', '9788897192169', 8.99, '2358a92ebf'),
(42, 'Due non è il doppio di uno', 'Elettra Groppo', 'Elmi\'s World', '9788897192107', 9.99, 'cebe22a896'),
(43, 'Il lungo inverno di Spitak', 'Mario Massimo Simonelli', 'Elmi\'s World', '9788897192190', 8.99, 'f0c9565a85');

-- --------------------------------------------------------

--
-- Struttura della tabella `tentativilogin`
--

CREATE TABLE `tentativilogin` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(128) COLLATE utf8_unicode_ci NOT NULL,
  `salt` char(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `accesso`
--
ALTER TABLE `accesso`
  MODIFY `accessoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT per la tabella `codice`
--
ALTER TABLE `codice`
  MODIFY `codiceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT per la tabella `libro`
--
ALTER TABLE `libro`
  MODIFY `libroid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
