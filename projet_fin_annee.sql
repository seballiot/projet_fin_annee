-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  mar. 23 jan. 2018 à 14:26
-- Version du serveur :  5.6.35
-- Version de PHP :  7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_fin_annee`
--

-- --------------------------------------------------------

--
-- Structure de la table `channels`
--

CREATE TABLE `channels` (
  `id_channel` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `channels`
--

INSERT INTO `channels` (`id_channel`, `name`) VALUES
(1, 'UX Design'),
(2, 'UI Design'),
(3, 'Web Design'),
(4, 'Motion Design'),
(5, 'Web Development');

-- --------------------------------------------------------

--
-- Structure de la table `channel_msg`
--

CREATE TABLE `channel_msg` (
  `id_msg` int(11) NOT NULL,
  `id_channel` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id_comment`, `id_post`, `id_user`, `id_parent`, `content`, `created_at`) VALUES
(20, 1, 2, 0, 'Je suis d\'accord avec toi Seb !', '2018-01-23 11:51:15'),
(24, 1, 1, 0, 'salut', '2018-01-23 12:34:05'),
(25, 1, 1, 20, 'salut', '2018-01-23 12:34:09');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id_notif` int(11) NOT NULL,
  `id_user_affect` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `rating` float(5,1) NOT NULL DEFAULT '0.0',
  `count_vote` int(11) NOT NULL DEFAULT '0',
  `count_comments` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id_post`, `title`, `content`, `rating`, `count_vote`, `count_comments`) VALUES
(1, 'Article 1', 'Voici le contenu de mon article 1.<br>\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, amet perferendis provident dolore aperiam ea commodi officia error rerum reiciendis obcaecati quisquam, dolorum numquam adipisci deserunt voluptate cum. Sequi, optio.<br>\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, amet perferendis provident dolore aperiam ea commodi officia error rerum reiciendis obcaecati quisquam, dolorum numquam adipisci deserunt voluptate cum. Sequi, optio.', 2.7, 3, 3),
(2, 'Article 2', 'Voici le contenu de mon article 2.<br>\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, amet perferendis provident dolore aperiam ea commodi officia error rerum reiciendis obcaecati quisquam, dolorum numquam adipisci deserunt voluptate cum. Sequi, optio.<br>\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, amet perferendis provident dolore aperiam ea commodi officia error rerum reiciendis obcaecati quisquam, dolorum numquam adipisci deserunt voluptate cum. Sequi, optio.', 3.7, 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `relations_friends`
--

CREATE TABLE `relations_friends` (
  `id_relation` int(11) NOT NULL,
  `id_user1` int(11) NOT NULL,
  `id_user2` int(11) NOT NULL,
  `waiting` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `name`, `password`) VALUES
(1, 'seb', 'root'),
(2, 'micka', 'root'),
(3, 'alex', 'root'),
(4, 'jack', 'root');

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

CREATE TABLE `vote` (
  `id_vote` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `vote`
--

INSERT INTO `vote` (`id_vote`, `id_post`, `id_user`, `vote`, `created_at`) VALUES
(40, 1, 1, 1, '2018-01-23 09:03:42'),
(41, 1, 2, 2, '2018-01-18 09:17:03'),
(42, 2, 1, 2, '2018-01-20 10:23:49'),
(43, 2, 3, 5, '2018-01-19 10:04:45'),
(44, 1, 3, 5, '2018-01-19 10:04:57'),
(45, 2, 4, 4, '2018-01-20 11:37:10');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `channels`
--
ALTER TABLE `channels`
  ADD PRIMARY KEY (`id_channel`);

--
-- Index pour la table `channel_msg`
--
ALTER TABLE `channel_msg`
  ADD PRIMARY KEY (`id_msg`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id_notif`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`);

--
-- Index pour la table `relations_friends`
--
ALTER TABLE `relations_friends`
  ADD PRIMARY KEY (`id_relation`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id_vote`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `channels`
--
ALTER TABLE `channels`
  MODIFY `id_channel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `channel_msg`
--
ALTER TABLE `channel_msg`
  MODIFY `id_msg` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `relations_friends`
--
ALTER TABLE `relations_friends`
  MODIFY `id_relation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `vote`
--
ALTER TABLE `vote`
  MODIFY `id_vote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
