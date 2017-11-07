-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Nov 07, 2017 alle 21:45
-- Versione del server: 5.5.57-MariaDB
-- Versione PHP: 5.6.31

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
(1, 'Prova accesso iniziale', 'codice: nullo', '2016-09-30 19:38:21', 'mio IP', 0, 0),
(3, 'Download ebook', '14052925607906', '2016-09-30 19:51:34', '5.90.77.206', 1, 0),
(4, 'Download ebook', '68569769352004', '2016-09-30 20:01:26', '192.168.1.170', 1, 0),
(5, 'Pagina scaricamento ebook', '38088314934900', '2016-09-30 20:05:43', '192.168.1.170', 0, 1),
(7, 'Codice non valido', 'codice sballato', '2016-09-30 20:12:23', '192.168.1.170', 0, 0),
(8, 'Pagina scaricamento ebook', '61269241290000', '2016-09-30 20:14:11', '192.168.1.170', 0, 1),
(9, 'Pagina scaricamento ebook', '68569769352004', '2016-10-01 10:05:51', '192.168.1.170', 0, 1),
(10, 'Download ebook', '68569769352004', '2016-10-01 10:05:55', '192.168.1.170', 1, 0),
(11, 'Pagina scaricamento ebook', '68569769352004', '2016-10-01 10:06:00', '192.168.1.170', 0, 1),
(12, 'Massimo scaricamento raggiunto', '68569769352004', '2016-10-01 10:06:00', '192.168.1.170', 0, 0),
(13, 'Pagina scaricamento ebook', '68569769352004', '2016-10-01 10:08:11', '192.168.1.170', 0, 1),
(14, 'Massimo scaricamento raggiunto', '68569769352004', '2016-10-01 10:08:11', '192.168.1.170', 0, 0),
(15, 'Codice non valido', '\" && ;', '2017-10-20 07:35:44', '79.16.225.166', 0, 0),
(16, 'Codice non valido', 'aaa', '2017-10-24 08:37:28', '79.16.225.166', 0, 0),
(17, 'Pagina scaricamento ebook', '14052925607906', '2017-11-07 15:10:33', '192.168.1.170', 0, 1),
(18, 'Massimo scaricamento raggiunto', '14052925607906', '2017-11-07 15:10:33', '192.168.1.170', 0, 0),
(19, 'Pagina scaricamento ebook', '14052925607906', '2017-11-07 17:54:19', '192.168.1.143', 0, 1),
(20, 'Massimo scaricamento raggiunto', '14052925607906', '2017-11-07 17:54:19', '192.168.1.143', 0, 0),
(21, 'Pagina scaricamento ebook', '14052925607906', '2017-11-07 17:54:45', '192.168.1.143', 0, 1),
(22, 'Download ebook', '14052925607906', '2017-11-07 17:55:06', '192.168.1.143', 1, 0),
(23, 'Pagina scaricamento ebook', '14052925607906', '2017-11-07 17:55:29', '192.168.1.143', 0, 1),
(24, 'Download ebook', '14052925607906', '2017-11-07 17:55:42', '192.168.1.143', 1, 0),
(25, 'Download ebook', '14052925607906', '2017-11-07 17:55:44', '192.168.1.143', 1, 0),
(26, 'Pagina scaricamento ebook', '14052925607906', '2017-11-07 17:55:53', '192.168.1.143', 0, 1),
(27, 'Massimo scaricamento raggiunto', '14052925607906', '2017-11-07 17:55:53', '192.168.1.143', 0, 0);

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
(3, 'Groppo Pietro', '16328270474701', 4, 0),
(4, 'Emilie Rollandin', '38088314934900', 2, 0),
(5, 'Rossi Mario', '68569769352004', 6, 3),
(6, 'Banana', '34022527143207', 8, 0),
(7, 'Rollandin Christine', '14052925607906', 8, 3);

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

-- --------------------------------------------------------

--
-- Struttura della tabella `tentativilogin`
--

CREATE TABLE `tentativilogin` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `tentativilogin`
--

INSERT INTO `tentativilogin` (`user_id`, `time`) VALUES
(1, '1475311432');

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
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `username`, `email`, `password`, `salt`) VALUES
(1, 'test_user', 'test@example.com', '00807432eae173f652f2064bdca1b61b290b52d40e429a7d295d76a71084aa96c0233b82f1feac45529e0726559645acaed6f3ae58a286b9f075916ebf66cacc', 'f9aab579fc1b41ed0c44fe4ecdbfcdb4cb99b9023abb241a6db833288f4eea3c02f76e0d35204a8695077dcf81932aa59006423976224be0390395bae152d4ef'),
(2, 'emilie', 'emilie.heisenberg@facebook.com', '73aa5cd35b5da01d563b1a10da2f2d43c6ab6bf0b82492e384aad581076e112cbfa78a0b59bc65445c57951454a9fe41b9df15277236edf17d8c4b1b72139467', 'b90301902d28633b94524f6f0eaf853902444ace400c24889ca2e5eade4d5571043dddc81a363d530052887df6685328520c6c31d02258c2888c8523f91cc5f3'),
(3, 'pippo', 'pippo@gmail.com', '3665f0cb4a27581b14650e7a09ee8c6a223430aa1de6667e3a0fd2e72d6adf9b648ffc493171854e636cfddbf99d4fa00579ccd3a79c0287b1cd447dbf189795', 'b317b6e04873a49f5839e2f05b60d68d17bacef39d27a1140ecfcc52a79de09443e3555a9ed0eb727a63a7c4d94449076b6ea72baa914d03b50ac39f9e0b3334');

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
  MODIFY `accessoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
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
--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
