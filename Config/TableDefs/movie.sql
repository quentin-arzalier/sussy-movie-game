-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : jeu. 29 fév. 2024 à 08:18
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
  PRIMARY KEY (`id_actor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `director`
--

DROP TABLE IF EXISTS `director`;
CREATE TABLE IF NOT EXISTS `director` (
  `id_director` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  PRIMARY KEY (`id_director`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Déchargement des données de la table `director`
--

INSERT INTO `director` (`id_director`, `first_name`, `last_name`) VALUES
(1, 'Sckott', 'ridley');

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
  `original_language` char(2) NOT NULL,
  `release_date` date NOT NULL,
  `runtime` int(11) NOT NULL,
  PRIMARY KEY (`id_movie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Déchargement des données de la table `movie`
--

INSERT INTO `movie` (`id_movie`, `original_language`, `release_date`, `runtime`) VALUES
(1, 'fr', '2024-02-07', 120),
(2, 'en', '2017-02-08', 160);

-- --------------------------------------------------------

--
-- Structure de la table `movie_actor`
--

DROP TABLE IF EXISTS `movie_actor`;
CREATE TABLE IF NOT EXISTS `movie_actor` (
  `id_movie` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL,
  PRIMARY KEY (`id_actor`, `id_movie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Structure de la table `movie_director`
--

DROP TABLE IF EXISTS `movie_director`;
CREATE TABLE IF NOT EXISTS `movie_director` (
  `id_movie` int(11) NOT NULL,
  `id_director` int(11) NOT NULL,
  PRIMARY KEY (`id_movie`),
  KEY `id_director` (`id_director`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Déchargement des données de la table `movie_director`
--

INSERT INTO `movie_director` (`id_movie`, `id_director`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `movie_genre`
--

DROP TABLE IF EXISTS `movie_genre`;
CREATE TABLE IF NOT EXISTS `movie_genre` (
  `id_movie` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL,
  PRIMARY KEY (`id_movie`, `id_genre` )
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Déchargement des données de la table `movie_genre`
--

INSERT INTO `movie_genre` (`id_movie`, `id_genre`) VALUES
(1, 1);

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

--
-- Déchargement des données de la table `movie_name`
--

INSERT INTO `movie_name` (`country_code`, `id_movie`, `name`) VALUES
('FR', 1, 'Oui');

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
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`username`, `email_address`, `password_hash`, `is_admin`, `token_verify`, `email_chek`) VALUES
('Aaa', 'Aaa@ab.c', 'aze', 0, '', 0),
('Bb', 'B@b.b', 'admin', 1, '', 0),
('Larpeha', '5@gmail.com', '$2y$10$E4QSsddHK9mgj4ix45SYcu9hMNoeSS0gLs0Ss24zGk7FUtm4m.2cK', 0, 'e986a4fdc41766d30158a45c6e7434fa91a5b37900b32c2152d6fa5253df1b48b62436fad1b39bfe014a89985afb67ce3509', 1),
('zob', 'zob@init.fr', '$2y$10$oPbqD/4eUI./G4pIkhojPeCiCy6wsRk6ZVYc.KBl1OltnK/hxYm8i', 1, '406068983564b12da57a6fc740cfff0b2773cd0ed6b2443be46c65eb596329f596a6e0255ccbee41600e507bf73723880708', 1);
COMMIT;

-- --------------------------------------------------------

--
-- Structure de la table `usermoviehistory`
--

DROP TABLE IF EXISTS `usermoviehistory`;
CREATE TABLE IF NOT EXISTS `usermoviehistory` (
  `id_user` int(11) NOT NULL,
  `id_movie` int(11) NOT NULL,
  `attempt_count` int(11) NOT NULL,
  `date_of_success` date NOT NULL DEFAULT current_timestamp(),
  KEY `id_movie` (`id_movie`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Déchargement des données de la table `usermoviehistory`
--

INSERT INTO `usermoviehistory` (`id_user`, `id_movie`, `attempt_count`, `date_of_success`) VALUES
(1, 2, 28, '2024-04-11'),
(1, 1, 64, '2024-05-22');

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
  ADD CONSTRAINT `usermoviehistory_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
