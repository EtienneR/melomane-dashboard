-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 07 Juillet 2014 à 13:12
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
-- Structure de la table `m_bg`
--

CREATE TABLE IF NOT EXISTS `m_bg` (
  `id_bg` int(11) NOT NULL AUTO_INCREMENT,
  `tag_bg` varchar(255) NOT NULL,
  `image_bg` varchar(255) NOT NULL,
  PRIMARY KEY (`id_bg`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `m_category`
--

CREATE TABLE IF NOT EXISTS `m_category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `title_category` varchar(255) NOT NULL,
  `description_category` varchar(255) NOT NULL,
  `cdate_category` datetime NOT NULL,
  `udate_category` datetime NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `m_news`
--

CREATE TABLE IF NOT EXISTS `m_news` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `title_news` varchar(255) NOT NULL,
  `content_news` text NOT NULL,
  `image_news` varchar(255) NOT NULL,
  `state_news` varchar(45) NOT NULL,
  `cdate_news` datetime DEFAULT NULL,
  `udate_news` datetime DEFAULT NULL,
  `fk_id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_news`),
  KEY `fk_news_user1_idx` (`fk_id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `m_playlist`
--

CREATE TABLE IF NOT EXISTS `m_playlist` (
  `id_playlist` int(11) NOT NULL AUTO_INCREMENT,
  `title_playlist` varchar(255) NOT NULL,
  `fk_id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_playlist`),
  KEY `fk_playlist_user1_idx` (`fk_id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `m_playlist_content`
--

CREATE TABLE IF NOT EXISTS `m_playlist_content` (
  `id_playlist_content` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `favorite_playlist_content` varchar(45) DEFAULT '0',
  `fk_id_song` int(11) NOT NULL,
  `fk_id_playlist` int(11) NOT NULL,
  PRIMARY KEY (`id_playlist_content`),
  KEY `fk_playlist_content_song_idx` (`fk_id_song`),
  KEY `fk_playlist_content_playlist1_idx` (`fk_id_playlist`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `m_song`
--

CREATE TABLE IF NOT EXISTS `m_song` (
  `id_song` int(11) NOT NULL AUTO_INCREMENT,
  `title_song` varchar(255) NOT NULL,
  `artist_song` varchar(255) NOT NULL,
  `punchline_song` varchar(255) NOT NULL,
  `image_song` varchar(255) NOT NULL,
  `vendor_song` varchar(255) DEFAULT NULL,
  `state_song` int(11) NOT NULL COMMENT '0: brouillon; 1: publié',
  `cdate_song` datetime NOT NULL,
  `udate_song` datetime NOT NULL,
  `id_soundcloud` int(11) NOT NULL,
  `url_soundcloud` varchar(255) NOT NULL,
  `duration_soundcloud` int(11) NOT NULL,
  `fk_id_user` int(11) NOT NULL,
  `fk_id_category` int(11) NOT NULL,
  `fk_id_bg` int(11) NOT NULL,
  PRIMARY KEY (`id_song`),
  KEY `fk_song_user1_idx` (`fk_id_user`),
  KEY `fk_song_category1_idx` (`fk_id_category`),
  KEY `fk_m_song_m_bg1_idx` (`fk_id_bg`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Structure de la table `m_songtags`
--

CREATE TABLE IF NOT EXISTS `m_songtags` (
  `id_songtags` int(11) NOT NULL AUTO_INCREMENT,
  `fk_id_song` int(11) NOT NULL,
  `fk_id_tag` int(11) NOT NULL,
  PRIMARY KEY (`id_songtags`),
  KEY `fk_m_songtags_m_song1_idx` (`fk_id_song`),
  KEY `fk_m_songtags_m_tag1_idx` (`fk_id_tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- Structure de la table `m_tag`
--

CREATE TABLE IF NOT EXISTS `m_tag` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `name_tag` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `m_user`
--

CREATE TABLE IF NOT EXISTS `m_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo_user` varchar(255) NOT NULL,
  `email_user` varchar(255) NOT NULL,
  `password_user` varchar(255) NOT NULL,
  `level_user` int(11) NOT NULL COMMENT '0: admin; 1: moderateur',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `m_news`
--
ALTER TABLE `m_news`
  ADD CONSTRAINT `fk_news_user1` FOREIGN KEY (`fk_id_user`) REFERENCES `m_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `m_playlist`
--
ALTER TABLE `m_playlist`
  ADD CONSTRAINT `fk_playlist_user1` FOREIGN KEY (`fk_id_user`) REFERENCES `m_user` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `m_playlist_content`
--
ALTER TABLE `m_playlist_content`
  ADD CONSTRAINT `fk_playlist_content_playlist1` FOREIGN KEY (`fk_id_playlist`) REFERENCES `m_playlist` (`id_playlist`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_playlist_content_song` FOREIGN KEY (`fk_id_song`) REFERENCES `m_song` (`id_song`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `m_song`
--
ALTER TABLE `m_song`
  ADD CONSTRAINT `fk_m_song_m_bg1` FOREIGN KEY (`fk_id_bg`) REFERENCES `m_bg` (`id_bg`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_song_category1` FOREIGN KEY (`fk_id_category`) REFERENCES `m_category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_song_user1` FOREIGN KEY (`fk_id_user`) REFERENCES `m_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `m_songtags`
--
ALTER TABLE `m_songtags`
  ADD CONSTRAINT `fk_m_songtags_m_song1` FOREIGN KEY (`fk_id_song`) REFERENCES `m_song` (`id_song`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_m_songtags_m_tag1` FOREIGN KEY (`fk_id_tag`) REFERENCES `m_tag` (`id_tag`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
