-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mar. 21 mai 2024 à 06:39
-- Version du serveur : 11.2.2-MariaDB
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sussy_movie_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `actor`
--

DROP TABLE IF EXISTS `actor`;
CREATE TABLE IF NOT EXISTS `actor` (
  `id_actor` int(11) NOT NULL,
  `full_name` text NOT NULL,
  `profile_path` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_actor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `director`
--

DROP TABLE IF EXISTS `director`;
CREATE TABLE IF NOT EXISTS `director` (
  `id_director` int(11) NOT NULL,
  `full_name` text NOT NULL,
  `profile_path` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_director`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int(11) NOT NULL,
  `genre` text NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `movie`
--

DROP TABLE IF EXISTS `movie`;
CREATE TABLE IF NOT EXISTS `movie` (
  `id_movie` int(11) NOT NULL,
  `original_name` varchar(256) NOT NULL,
  `release_date` date NOT NULL,
  `runtime` int(11) NOT NULL,
  `poster_path` varchar(64) DEFAULT NULL,
  `backdrop_path` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_movie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `movie_actor`
--

DROP TABLE IF EXISTS `movie_actor`;
CREATE TABLE IF NOT EXISTS `movie_actor` (
  `id_movie` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL,
  PRIMARY KEY (`id_movie`,`id_actor`),
  KEY `movie_actor_ibfk_1` (`id_actor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `movie_director`
--

DROP TABLE IF EXISTS `movie_director`;
CREATE TABLE IF NOT EXISTS `movie_director` (
  `id_movie` int(11) NOT NULL,
  `id_director` int(11) NOT NULL,
  PRIMARY KEY (`id_movie`,`id_director`),
  KEY `movie_director_ibfk_1` (`id_director`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `movie_genre`
--

DROP TABLE IF EXISTS `movie_genre`;
CREATE TABLE IF NOT EXISTS `movie_genre` (
  `id_movie` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL,
  PRIMARY KEY (`id_movie`,`id_genre`),
  KEY `movie_genre_ibfk_1` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `movie_name`
--

DROP TABLE IF EXISTS `movie_name`;
CREATE TABLE IF NOT EXISTS `movie_name` (
  `country_code` char(2) NOT NULL,
  `id_movie` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`country_code`,`id_movie`),
  KEY `id_movie` (`id_movie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `iso_639_1` char(2) NOT NULL,
  `iso_3166_1` char(2) NOT NULL,
  PRIMARY KEY (`iso_639_1`,`iso_3166_1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(64) NOT NULL,
  `email_address` varchar(64) NOT NULL,
  `password_hash` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `token_verify` text NOT NULL,
  `email_chek` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email_address` (`email_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `usermoviehistory`
--

DROP TABLE IF EXISTS `usermoviehistory`;
CREATE TABLE IF NOT EXISTS `usermoviehistory` (
  `username` varchar(64) NOT NULL,
  `id_movie` int(11) NOT NULL,
  `attempt_count` int(11) NOT NULL,
  `date_of_success` date NOT NULL DEFAULT current_timestamp(),
  KEY `id_movie` (`id_movie`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `movie_actor`
--
ALTER TABLE `movie_actor`
  ADD CONSTRAINT `movie_actor_ibfk_1` FOREIGN KEY (`id_actor`) REFERENCES `actor` (`id_actor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movie_actor_ibfk_2` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id_movie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `movie_director`
--
ALTER TABLE `movie_director`
  ADD CONSTRAINT `movie_director_ibfk_1` FOREIGN KEY (`id_director`) REFERENCES `director` (`id_director`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movie_director_ibfk_2` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id_movie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `movie_genre`
--
ALTER TABLE `movie_genre`
  ADD CONSTRAINT `movie_genre_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movie_genre_ibfk_2` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id_movie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `movie_name`
--
ALTER TABLE `movie_name`
  ADD CONSTRAINT `movie_name_ibfk_1` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id_movie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `usermoviehistory`
--
ALTER TABLE `usermoviehistory`
  ADD CONSTRAINT `usermoviehistory_ibfk_1` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id_movie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usermoviehistory_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
