-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 13 Août 2017 à 12:21
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `todo`
--

-- --------------------------------------------------------

--
-- Structure de la table `TACHES`
--

CREATE TABLE `TACHES` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tache` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `TACHES`
--

INSERT INTO `TACHES` (`id`, `id_user`, `tache`) VALUES
(26, 1, 'Faire mes comptes');

-- --------------------------------------------------------

--
-- Structure de la table `USERS`
--

CREATE TABLE `USERS` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `sexe` enum('m','f') NOT NULL,
  `age` int(11) NOT NULL,
  `date_inscription` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `USERS`
--

INSERT INTO `USERS` (`id`, `prenom`, `nom`, `email`, `pass`, `sexe`, `age`, `date_inscription`) VALUES
(1, 'Smartful', 'TV', 'smartful_tv@worldcompany.com', '$2y$10$iEI/f.w.8.SpkkIZcJ/S..zGroOhcESzOvMPp2nVrm9wVmdlOUqoW', 'm', 31, '2017-05-01 15:42:12');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `TACHES`
--
ALTER TABLE `TACHES`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `TACHES`
--
ALTER TABLE `TACHES`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
