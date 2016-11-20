-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 20 Lis 2016, 20:43
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
  `comment_text` varchar(60) COLLATE utf8_polish_ci DEFAULT NULL,
  `comment_owner` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `comment_owner_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `tweet_id` (`tweet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=10 ;

--
-- Zrzut danych tabeli `Comment`
--

INSERT INTO `Comment` (`comment_id`, `comment_date`, `comment_text`, `comment_owner`, `comment_owner_id`, `tweet_id`) VALUES
(1, '2016-11-17 11:51:57', 'a moze kos??', 'Patrycja', 2, 4),
(2, '2016-11-17 11:52:12', 'ja nie', 'Patrycja', 2, 3),
(3, '2016-11-17 11:52:26', 'hej', 'Patrycja', 2, 1),
(4, '2016-11-17 11:52:54', 'pffff', 'Zenia', 4, 4),
(5, '2016-11-17 11:53:09', 'to ja', 'Zenia', 4, 3),
(6, '2016-11-17 11:53:20', 'tra la la', 'Zenia', 4, 2),
(7, '2016-11-17 11:53:37', 'pozdrawiam wszystkich polakow', 'Zenia', 4, 1),
(8, '2016-11-20 08:35:25', 'jestes zwyciezca', 'Patrycja', 2, 5),
(9, '2016-11-20 08:36:13', 'czy zamawial pan budzenie?', 'Marek', 1, 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Message`
--

CREATE TABLE IF NOT EXISTS `Message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_text` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `sender_name` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `receiver_name` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `receiver_switch` varchar(1) COLLATE utf8_polish_ci DEFAULT NULL,
  `message_date` datetime DEFAULT NULL,
  PRIMARY KEY (`message_id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=14 ;

--
-- Zrzut danych tabeli `Message`
--

INSERT INTO `Message` (`message_id`, `message_text`, `sender_name`, `receiver_name`, `sender_id`, `receiver_id`, `receiver_switch`, `message_date`) VALUES
(1, 'Jak tam Zania?', 'Marek', 'Zenia', 1, 4, '0', '2016-11-20 08:38:40'),
(2, 'Kiedy sie widzimy Kajetan?', 'Marek', 'Kajetan', 1, 5, '0', '2016-11-20 08:38:52'),
(3, 'Czy Twoja siostra jest wolna?', 'Marek', 'Pacztam', 1, 6, '0', '2016-11-20 08:39:04'),
(4, 'Beckham?', 'Marek', 'david', 1, 7, '0', '2016-11-20 08:39:17'),
(5, 'pffffffffff', 'Marek', 'Bogna', 1, 8, '0', '2016-11-20 08:39:28'),
(6, 'Kiedy to sie skonczy?', 'Marek', 'Zenia', 1, 4, '0', '2016-11-20 08:39:54'),
(7, 'Nie wiem czemu do Ciebie pisze', 'Marek', 'Kajetan', 1, 5, '0', '2016-11-20 08:40:04'),
(8, 'Pozdrow matke!', 'Marek', 'Pacztam', 1, 6, '0', '2016-11-20 08:40:11'),
(9, 'Jak tam Victoria? Zdrowa?', 'Marek', 'david', 1, 7, '0', '2016-11-20 08:40:25'),
(10, 'NIe', 'Marek', 'Bogna', 1, 8, '0', '2016-11-20 08:40:30'),
(11, 'Spadaj', 'Patrycja', 'Marek', 2, 1, '0', '2016-11-20 08:40:55'),
(12, 'Niezla z Ciebie lisica', 'Pacztam', 'Marek', 6, 1, '0', '2016-11-20 08:41:49'),
(13, 'W Twoim imieniu brakuje kropki', 'Pacztam', 'Zenia', 6, 4, '0', '2016-11-20 08:42:07');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Tweet`
--

CREATE TABLE IF NOT EXISTS `Tweet` (
  `tweet_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `tweet_text` varchar(140) COLLATE utf8_polish_ci DEFAULT NULL,
  `tweet_creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`tweet_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=7 ;

--
-- Zrzut danych tabeli `Tweet`
--

INSERT INTO `Tweet` (`tweet_id`, `user_id`, `user_name`, `tweet_text`, `tweet_creation_date`) VALUES
(1, 1, 'Marek', 'JoÅ‚ joÅ‚', '2016-11-07 10:23:00'),
(2, 2, 'Patrycja', 'La la la', '2016-11-07 10:56:46'),
(3, 4, 'Zenia', 'co to kto to', '2016-11-13 06:44:16'),
(4, 1, 'Marek', 'Czyzby czyzyk', '2016-11-16 05:56:28'),
(5, 8, 'Bogna', 'Kim jestes?', '2016-11-20 08:34:36'),
(6, 2, 'Patrycja', 'kiedys zadzwoni sumienie', '2016-11-20 08:35:50');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `User`
--

INSERT INTO `User` (`user_id`, `email`, `username`, `hashed_password`, `creation_date`) VALUES
(1, 'mark.korcz@gmail.com', 'Marek', '$2y$10$dOwaGSshZpSQ5LcOqHLfc.D9YgUvUs/CYQpZVElp9IkdLOqIUX7SG', '2016-11-07 10:22:52'),
(2, 'patrycja@gmail.com', 'Patrycja', '$2y$10$UwNgA9FCUEny3Ch2sxj87u9i0kfH3PQG5WPgQ13CkkRNrvW2JkHIi', '2016-11-07 10:56:24'),
(4, 'zenia@gmail.com', 'Zenia', '$2y$10$P1zA7WtUIE3x9ltvHa5otunUtvqQt7/x689YbeutgTE5M.27drWKW', '2016-11-13 06:43:42'),
(5, 'kajetan@gmail.com', 'Kajetan', '$2y$10$UrJUMzon4MHgRQzEuGHWJOq.3fHUIbziPozcrYWGoL5yoHfVvOYfW', '2016-11-13 06:54:47'),
(6, 'pacztam@gmail.com', 'Pacztam', '$2y$10$zQPocjfXpg1TqtR11lJKtelA.N.m6ziYAuSh1ZCqeJqNg/0xEi3Me', '2016-11-13 06:58:54'),
(7, 'david@gmail.com', 'david', '$2y$10$uwZTW5PVgrd9L3uIGwgDEO2kQ7uu/UM42ZQUaeh5rfx5ZDZSzJQ3G', '2016-11-16 05:27:35'),
(8, 'bogna@gmail.com', 'Bogna', '$2y$10$VGGSsE4.OWwYI2dzBwMWDOyoiTR9DQ3FuzwgRGFfJz93GygdmqOvS', '2016-11-20 08:34:29');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`tweet_id`) REFERENCES `Tweet` (`tweet_id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `Message_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Message_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `Tweet`
--
ALTER TABLE `Tweet`
  ADD CONSTRAINT `Tweet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
