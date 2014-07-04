-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 01 Juillet 2014 à 19:00
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `meloman`
--
CREATE DATABASE IF NOT EXISTS `meloman` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `meloman`;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `title_category` varchar(255) NOT NULL,
  `description_category` varchar(255) NOT NULL,
  `cdate_category` datetime NOT NULL,
  `udate_category` datetime NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id_category`, `title_category`, `description_category`, `cdate_category`, `udate_category`) VALUES
(1, 'folk', 'de la folk', '2014-05-14 15:22:22', '2014-05-14 15:22:22'),
(2, 'Lounge / Electro', 'Lounge / Electro', '2014-05-14 15:50:44', '2014-05-14 15:50:44');

-- --------------------------------------------------------

--
-- Structure de la table `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `id_playlist` int(11) NOT NULL AUTO_INCREMENT,
  `title_playlist` varchar(45) NOT NULL,
  `user_id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_playlist`,`user_id_user`),
  KEY `fk_playlist_user1_idx` (`user_id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `playlist`
--

INSERT INTO `playlist` (`id_playlist`, `title_playlist`, `user_id_user`) VALUES
(1, 'Du paté', 1),
(2, 'La playlist de tata', 2),
(3, 'vide', 1);

-- --------------------------------------------------------

--
-- Structure de la table `playlist_content`
--

CREATE TABLE IF NOT EXISTS `playlist_content` (
  `id_playlist_content` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `favorite_playlist_content` varchar(45) DEFAULT '0',
  `song_id_song` int(11) NOT NULL,
  `playlist_id_playlist` int(11) NOT NULL,
  PRIMARY KEY (`id_playlist_content`,`song_id_song`,`playlist_id_playlist`),
  KEY `fk_playlist_content_song_idx` (`song_id_song`),
  KEY `fk_playlist_content_playlist1_idx` (`playlist_id_playlist`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `playlist_content`
--

INSERT INTO `playlist_content` (`id_playlist_content`, `favorite_playlist_content`, `song_id_song`, `playlist_id_playlist`) VALUES
(1, '1', 1, 1),
(2, '0', 2, 1),
(3, '0', 3, 1),
(4, '1', 4, 1),
(5, '0', 1, 2),
(6, '1', 4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `song`
--

CREATE TABLE IF NOT EXISTS `song` (
  `id_song` int(11) NOT NULL AUTO_INCREMENT,
  `title_song` varchar(255) NOT NULL,
  `author_song` varchar(255) NOT NULL,
  `description_song` text NOT NULL,
  `image_song` varchar(255) NOT NULL,
  `tag_song` varchar(255) NOT NULL,
  `state_song` int(11) NOT NULL COMMENT '0: brouillon; 1: publié',
  `cdate_song` datetime NOT NULL,
  `udate_song` datetime NOT NULL,
  `id_soundcloud` int(11) DEFAULT NULL,
  `id_youtube` int(11) DEFAULT NULL,
  `id_bootcamp` int(11) DEFAULT NULL,
  `user_id_user` int(11) NOT NULL,
  `category_id_category` int(11) NOT NULL,
  PRIMARY KEY (`id_song`,`user_id_user`,`category_id_category`),
  KEY `fk_song_user1_idx` (`user_id_user`),
  KEY `fk_song_category1_idx` (`category_id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `song`
--

INSERT INTO `song` (`id_song`, `title_song`, `author_song`, `description_song`, `image_song`, `tag_song`, `state_song`, `cdate_song`, `udate_song`, `id_soundcloud`, `id_youtube`, `id_bootcamp`, `user_id_user`, `category_id_category`) VALUES
(1, 'aaa', 'gerger', 'regergreg', '0', 'soul;rap', 1, '2014-04-17 20:30:16', '2014-04-17 21:06:28', 0, 0, 0, 1, 2),
(2, 'bbbb', 'author_song', '<p>aaa<br></p>', '0', 'rap;blues', 1, '2014-04-17 21:13:35', '2014-04-17 21:13:35', 0, 0, 0, 1, 1),
(3, 'ccc', 'cc', '<p>fezfez<br></p>', '0', 'tag_song;soul;corse', 1, '2014-04-19 14:02:22', '2014-05-14 16:26:25', 0, 0, 0, 1, 1),
(4, 'crèpes2', 'Suzanne', '<p>lorem<br></p>', '0', 'celtic;corse;', 1, '2014-04-19 14:25:40', '2014-04-19 17:05:51', 0, 0, 0, 2, 1),
(5, 'si si gros', 'MC Burger', '<p>lorem<br></p>', '0', 'rap;', 1, '2014-04-19 17:05:39', '2014-04-19 17:05:39', 0, 0, 0, 1, 2),
(6, 'title_song', 'author_song', '<p>test<br></p>', '0', 'tag_song', 1, '2014-04-19 21:44:38', '2014-04-19 21:44:38', 0, 0, 0, 1, 2),
(7, 'abc', 'author_song', 'description_song', '0', 'tag_song', 1, '2014-04-19 22:18:12', '2014-04-19 22:18:12', 0, 0, 0, 1, 1),
(9, 'xxx', 'author_song', '<p>fezfez<br></p>', '0', 'tag_song', 1, '2014-04-19 22:20:44', '2014-04-19 22:20:44', 0, 0, 0, 1, 1),
(10, 'vvv', 'author_song', '<p>fezfez<br></p>', '0', 'tag_song', 0, '2014-04-19 22:21:36', '2014-04-19 22:30:17', 0, 0, 0, 1, 1),
(11, 'test', 'author_song', 'description_song', '0', 'tag_song', 1, '2014-04-21 11:49:34', '2014-04-21 11:49:34', 0, 0, 0, 1, 1),
(12, 'nnn', 'nnn', '<p>nn<br></p>', '0', 'nn', 0, '2014-04-21 11:52:19', '2014-04-21 11:52:19', 0, 0, 0, 1, 1),
(15, 'fezfezfez', 'author_song', '<p>fezfez<br></p>', '0', 'tag_song', 0, '2014-04-21 12:20:35', '2014-05-14 17:50:57', 0, 0, 0, 1, 2),
(16, '1234', 'author_song', '', '0', 'soul;rap', 0, '2014-05-13 16:57:21', '2014-05-14 17:48:13', 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo_user` varchar(255) NOT NULL,
  `email_user` varchar(255) NOT NULL,
  `password_user` varchar(255) NOT NULL,
  `level_user` int(11) NOT NULL COMMENT '0: admin; 1: moderateur',
  `newsletter_user` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email_user` (`email_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id_user`, `pseudo_user`, `email_user`, `password_user`, `level_user`, `newsletter_user`) VALUES
(1, 'etienne', 'toto@toto.com', 'ce98f808ec06a02fbc9a61543c89983f', 0, 0),
(2, 'tata', 'aa@aa.com', '49d02d55ad10973b7b9d0dc9eba7fdf0', 1, 0),
(3, 'toto', 'aaa@aaa.com', 'f71dbe52628a3f83a77ab494817525c6', 1, 0),
(8, '', 'etienne@toto.com', '', 0, 1),
(9, '', 'titi@toto.com', '', 0, 1),
(10, '', 'tata@toto.com', '', 0, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `fk_playlist_user1` FOREIGN KEY (`user_id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `playlist_content`
--
ALTER TABLE `playlist_content`
  ADD CONSTRAINT `fk_playlist_content_playlist1` FOREIGN KEY (`playlist_id_playlist`) REFERENCES `playlist` (`id_playlist`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_playlist_content_song` FOREIGN KEY (`song_id_song`) REFERENCES `song` (`id_song`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `fk_song_category1` FOREIGN KEY (`category_id_category`) REFERENCES `category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_song_user1` FOREIGN KEY (`user_id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
