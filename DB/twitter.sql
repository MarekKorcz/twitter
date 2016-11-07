-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 07 Lis 2016, 10:02
-- Wersja serwera: 5.5.50-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `twitter`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Comment`
--

CREATE TABLE IF NOT EXISTS `Comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_date` datetime DEFAULT NULL,
  `comment_text` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `comment_owner` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `t_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `t_id` (`t_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Message`
--

CREATE TABLE IF NOT EXISTS `Message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_text` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `sender_name` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `receiver_name` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `s_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `receiver_switch` tinyint(3) unsigned zerofill DEFAULT NULL,
  `message_date` datetime DEFAULT NULL,
  PRIMARY KEY (`message_id`),
  KEY `s_id` (`s_id`),
  KEY `r_id` (`r_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Tweet`
--

CREATE TABLE IF NOT EXISTS `Tweet` (
  `tweet_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `u_name` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `tweet_text` varchar(140) COLLATE utf8_polish_ci DEFAULT NULL,
  `tweet_creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`tweet_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=83 ;

--
-- Zrzut danych tabeli `Tweet`
--

INSERT INTO `Tweet` (`tweet_id`, `u_id`, `u_name`, `tweet_text`, `tweet_creation_date`) VALUES
(73, 1, 'Marek', 'Najwidoczniej tak!!', '2016-10-31 12:24:42'),
(74, 1, 'Marek', 'ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', '2016-10-31 12:39:00'),
(75, 1, 'Marek', 'lalalalalalaalallala', '2016-10-31 08:57:41'),
(77, 1, 'Marek', 'ajajaj', '2016-11-02 11:05:34'),
(80, 26, 'Igor', 'dobry dzien', '2016-11-07 06:56:07'),
(81, 20, 'Bogna', 'pozdrawiam wszystkich polakow', '2016-11-07 06:57:18'),
(82, 20, 'Bogna', 'La la la ala lalalalalala', '2016-11-07 07:35:59');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `username` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `hashed_password` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=27 ;

--
-- Zrzut danych tabeli `User`
--

INSERT INTO `User` (`user_id`, `email`, `username`, `hashed_password`, `creation_date`) VALUES
(1, 'mark.korcz@gmail.com', 'Marek', '$2y$10$IdBSS9b/dfsVzlarlMF/s.UXp1l/97q7AmEmJ95j0YzO4c/23bgRy', '2016-10-23 10:58:52'),
(2, 'mark.korcz2@gmail.com', 'Marek', '$2y$10$TDr5eZIl4k4i.h6o75wNZuEXW1SP8KhFqfF2Y8.Kx0dvyK3DKWGi6', '2016-10-23 11:02:57'),
(4, 'steffff@pa.cg', 'Stefan', '$2y$10$Ffbne0O6MPlQHWS4LG54EeYGGR6qsoqdrcPRuZJCdEKqMaXxjJZYq', '2016-10-24 07:47:13'),
(5, 'patrycja@gmail.com', 'Patrycja', '$2y$10$V54aIwmyFIRSCrHqqL2yIuHZCq6Gg5drLcahvnpDORdU9IilCFTpK', '2016-10-24 10:10:36'),
(11, 'romek@gmail.com', 'Romek', '$2y$10$xNbX/JZBXiCnNxJ4AlcP/OES7XX5/Couah/TS/zxgLcs2bG93SqgO', '2016-10-24 09:32:14'),
(13, 'jozef.stalin@gmail.com', 'Jozef', '$2y$10$.SrsIYA.zzjqBYdqahok.ugioRB0VeEZqq17o4bWX2SlczKXn0iaq', '2016-10-25 09:36:02'),
(14, 'bogumil@gmail.com', 'Bogumil', '$2y$10$EizW4hPxxErNSuuEqkIOI.cxDS2ZYyM182bkRQtn/9RyyvOnoEDuK', '2016-10-25 10:38:53'),
(15, 'ernest@gmail.com', 'Ernest', '$2y$10$PzAZrZEn2wQXlPf5tHImbuQZUMPVOv2dW4U7SxfwGQDoyYzpXn8fu', '2016-10-26 12:11:09'),
(16, 'zygmunt@gmail.com', 'Zygmunt', '$2y$10$Ps/rnzhg6WXlbhwhte0VLOPTuaX.FnJigFGhZ1dqKwQ8NhY25rizW', '2016-10-26 06:51:27'),
(17, 'marko.korczu@gmail.com', 'Marko', '$2y$10$/TkPuhPkibyBLLmY3nM2VOMsPDohdYDMtGJmIm1uQl6ZDHUPK75H2', '2016-10-26 11:29:01'),
(19, 'mirek@gmail.com', 'Mirek', '$2y$10$z7TyEUSfF1GooWysUJFdwuT1xhURpxu1FgRj296ilNBC1xDs0Hxme', '2016-10-27 08:11:53'),
(20, 'bogna@gmail.com', 'Bogna', '$2y$10$HOkqVDhCBuAlxI79mbJ1Eu/3HvmHTCM9WsRxMlRHkb9IxnMBSh0DS', '2016-10-27 08:42:02'),
(21, 'lololo@gmail.com', 'lololo', '$2y$10$Z.EWLQ.tx/72ZPM6.iSwxu70oa35B77/2PNF2/XNuNhRFp45GfTPK', '2016-10-27 12:19:49'),
(22, 'kakademona@gmail.com', 'kakademona', '$2y$10$.9qwTs2QmJqmidw.YKbv8.6avXD94lJLtBuwFSIrVKqAYSpgIxfs6', '2016-10-27 09:57:53'),
(23, 'aaaaaaaaa@aaaaaa.pl', 'aaaaaaaaaa', '$2y$10$DXx1JZWVi26QehLYJfQQMONbzt1k/xE7dv37CMZAZgzg.leRCeXdS', '2016-10-27 10:43:33'),
(26, 'igor@gmail.com', 'Igor', '$2y$10$8x2i/7.8sS/T.TRVURD8YeekV8BUTVMoBITphv4QBksTtCPhkWuXi', '2016-11-07 06:56:01');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`t_id`) REFERENCES `Tweet` (`tweet_id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `Message_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Message_ibfk_2` FOREIGN KEY (`r_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `Tweet`
--
ALTER TABLE `Tweet`
  ADD CONSTRAINT `Tweet_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
