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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `m_category`
--

INSERT INTO `m_category` (`id_category`, `title_category`, `description_category`, `cdate_category`, `udate_category`) VALUES
(1, 'folk', 'de la folk', '2014-05-14 15:22:22', '2014-05-14 15:22:22'),
(2, 'Lounge / Electro', 'Lounge / Electro', '2014-05-14 15:50:44', '2014-05-14 15:50:44'),
(3, 'test', 'test lorem ipsum', '2014-07-02 15:15:27', '2014-07-02 16:45:17');

-- --------------------------------------------------------

--
-- Structure de la table `m_news`
--

CREATE TABLE IF NOT EXISTS `m_news` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `title_news` varchar(255) NOT NULL,
  `content_news` text NOT NULL,
  `state_news` int(11) NOT NULL COMMENT '0: brouillon; 1: publié',
  `cdate_news` datetime DEFAULT NULL,
  `udate_news` datetime DEFAULT NULL,
  `user_id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_news`,`user_id_user`),
  KEY `fk_news_user1_idx` (`user_id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `m_news`
--

INSERT INTO `m_news` (`id_news`, `title_news`, `content_news`, `state_news`, `cdate_news`, `udate_news`, `user_id_user`) VALUES
(1, 'first news 1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum."\r\n		', 1, '2014-07-01 00:00:00', '2014-07-02 16:42:59', 1),
(3, 'second news', 'btrbhtrjbpjp gtrji jtphj', 0, '2014-07-01 19:52:49', '2014-07-02 16:38:17', 1);

-- --------------------------------------------------------

--
-- Structure de la table `m_playlist`
--

CREATE TABLE IF NOT EXISTS `m_playlist` (
  `id_playlist` int(11) NOT NULL AUTO_INCREMENT,
  `title_playlist` varchar(45) NOT NULL,
  `user_id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_playlist`,`user_id_user`),
  KEY `fk_playlist_user1_idx` (`user_id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `m_playlist`
--

INSERT INTO `m_playlist` (`id_playlist`, `title_playlist`, `user_id_user`) VALUES
(1, 'Du paté', 1),
(2, 'La playlist de tata', 2),
(3, 'vide', 1);

-- --------------------------------------------------------

--
-- Structure de la table `m_playlist_content`
--

CREATE TABLE IF NOT EXISTS `m_playlist_content` (
  `id_playlist_content` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `favorite_playlist_content` varchar(45) DEFAULT '0',
  `song_id_song` int(11) NOT NULL,
  `playlist_id_playlist` int(11) NOT NULL,
  PRIMARY KEY (`id_playlist_content`,`song_id_song`,`playlist_id_playlist`),
  KEY `fk_playlist_content_song_idx` (`song_id_song`),
  KEY `fk_playlist_content_playlist1_idx` (`playlist_id_playlist`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `m_playlist_content`
--

INSERT INTO `m_playlist_content` (`id_playlist_content`, `favorite_playlist_content`, `song_id_song`, `playlist_id_playlist`) VALUES
(1, '1', 1, 1),
(2, '0', 2, 1),
(3, '0', 3, 1),
(4, '1', 4, 1),
(5, '0', 1, 2),
(6, '1', 4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `m_song`
--

CREATE TABLE IF NOT EXISTS `m_song` (
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
  `user_id_user` int(11) NOT NULL,
  `category_id_category` int(11) NOT NULL,
  PRIMARY KEY (`id_song`,`user_id_user`,`category_id_category`),
  KEY `fk_song_user1_idx` (`user_id_user`),
  KEY `fk_song_category1_idx` (`category_id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `m_song`
--

INSERT INTO `m_song` (`id_song`, `title_song`, `author_song`, `description_song`, `image_song`, `tag_song`, `state_song`, `cdate_song`, `udate_song`, `id_soundcloud`, `user_id_user`, `category_id_category`) VALUES
(1, 'aaa', 'gerger', 'regergreg', '0', 'soul;rap', 1, '2014-04-17 20:30:16', '2014-04-17 21:06:28', 0, 1, 2),
(2, 'bbbb', 'author_song', '<p>aaa<br></p>', '0', 'rap;blues', 1, '2014-04-17 21:13:35', '2014-04-17 21:13:35', 0, 1, 1),
(3, 'ccc', 'cc', '<p>fezfez<br></p>', '0', 'tag_song;soul;corse', 1, '2014-04-19 14:02:22', '2014-05-14 16:26:25', 0, 1, 1),
(4, 'crèpes2', 'Suzanne', '<p>lorem<br></p>', '0', 'celtic;corse;', 1, '2014-04-19 14:25:40', '2014-04-19 17:05:51', 0, 2, 1),
(5, 'si si gros', 'MC Burger', '<p>lorem<br></p>', '0', 'rap;', 1, '2014-04-19 17:05:39', '2014-04-19 17:05:39', 0, 1, 2),
(6, 'title_song', 'author_song', '<p>test<br></p>', '0', 'tag_song', 1, '2014-04-19 21:44:38', '2014-04-19 21:44:38', 0, 1, 2),
(7, 'abc', 'author_song', 'description_song', '0', 'tag_song', 1, '2014-04-19 22:18:12', '2014-04-19 22:18:12', 0, 1, 1),
(9, 'xxx', 'author_song', '<p>fezfez<br></p>', '0', 'tag_song', 1, '2014-04-19 22:20:44', '2014-04-19 22:20:44', 0, 1, 1),
(10, 'vvv', 'author_song', '<p>fezfez<br></p>', '0', 'tag_song', 0, '2014-04-19 22:21:36', '2014-04-19 22:30:17', 0, 1, 1),
(11, 'test', 'author_song', 'description_song', '0', 'tag_song', 1, '2014-04-21 11:49:34', '2014-04-21 11:49:34', 0, 1, 1),
(12, 'nnn', 'nnn', '<p>nn<br></p>', '0', 'nn', 0, '2014-04-21 11:52:19', '2014-04-21 11:52:19', 0, 1, 1),
(15, 'fezfezfez', 'author_song', '<p>fezfez<br></p>', '0', 'tag_song', 0, '2014-04-21 12:20:35', '2014-05-14 17:50:57', 0, 1, 2),
(16, '1234', 'author_song', '', 'http://localhost/meloman/assets/img/thumb/batiment_thumb.jpg', 'soul;rap', 1, '2014-05-13 16:57:21', '2014-07-03 18:35:52', 0, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `m_user`
--

INSERT INTO `m_user` (`id_user`, `pseudo_user`, `email_user`, `password_user`, `level_user`) VALUES
(1, 'etienne', 'toto@toto.com', 'ce98f808ec06a02fbc9a61543c89983f', 0),
(2, 'tata', 'aa@aa.com', '49d02d55ad10973b7b9d0dc9eba7fdf0', 1),
(3, 'toto', 'aaa@aaa.com', 'f71dbe52628a3f83a77ab494817525c6', 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `m_news`
--
ALTER TABLE `m_news`
  ADD CONSTRAINT `fk_news_user1` FOREIGN KEY (`user_id_user`) REFERENCES `m_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `m_playlist`
--
ALTER TABLE `m_playlist`
  ADD CONSTRAINT `fk_playlist_user1` FOREIGN KEY (`user_id_user`) REFERENCES `m_user` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `m_playlist_content`
--
ALTER TABLE `m_playlist_content`
  ADD CONSTRAINT `fk_playlist_content_playlist1` FOREIGN KEY (`playlist_id_playlist`) REFERENCES `m_playlist` (`id_playlist`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_playlist_content_song` FOREIGN KEY (`song_id_song`) REFERENCES `m_song` (`id_song`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `m_song`
--
ALTER TABLE `m_song`
  ADD CONSTRAINT `fk_song_category1` FOREIGN KEY (`category_id_category`) REFERENCES `m_category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_song_user1` FOREIGN KEY (`user_id_user`) REFERENCES `m_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;