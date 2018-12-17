-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 12 oct. 2017 à 13:28
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id_question` int(3) NOT NULL,
  `id_theme` int(3) NOT NULL,
  `id_bonne_reponse` int(1) NOT NULL,
  `intitule_question` varchar(255) NOT NULL,
  `indice` varchar(255) NOT NULL,
  `scoreMax` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id_question`, `id_theme`, `id_bonne_reponse`, `intitule_question`, `indice`, `scoreMax`) VALUES
(6, 6, 6, 'Oui ? ', 'Peut être ', 10),
(7, 6, 6, 'Non ?', 'Beh peut être', 20);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id_reponse` int(3) NOT NULL,
  `id_question` int(3) NOT NULL,
  `intitule_reponse` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`id_reponse`, `id_question`, `intitule_reponse`) VALUES
(1, 6, 'Oui !'),
(2, 7, 'Non');

-- --------------------------------------------------------

--
-- Structure de la table `score`
--

CREATE TABLE `score` (
  `id_question` int(3) NOT NULL,
  `id_utilisateur` int(3) NOT NULL,
  `score` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE `theme` (
  `id_theme` int(3) NOT NULL,
  `nom_theme` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`id_theme`, `nom_theme`) VALUES
(6, 'PHP');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(3) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom_utilisateur` varchar(255) NOT NULL,
  `prenom_utilisateur` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `pseudo`, `mdp`, `nom_utilisateur`, `prenom_utilisateur`) VALUES
(2, 'eleve1', 'azerty', 'Dupont', 'Thomas'),
(3, 'eleve2', 'azerty', 'Mathys', 'Geoffrey'),
(4, 'eleve3', 'azerty', 'Rodolphe', 'David'),
(5, 'eleve4', 'azerty', 'Jasmin', 'Gustave'),
(6, 'eleve5', 'azerty', 'Barthélémy', 'Alphonse');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id_question`),
  ADD UNIQUE KEY `id_question` (`id_question`),
  ADD KEY `id_theme` (`id_theme`),
  ADD KEY `id_bonne_reponse` (`id_bonne_reponse`),
  ADD KEY `id_bonne_reponse_2` (`id_bonne_reponse`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id_reponse`),
  ADD UNIQUE KEY `id_reponse` (`id_reponse`),
  ADD KEY `id_question` (`id_question`);

--
-- Index pour la table `score`
--
ALTER TABLE `score`
  ADD KEY `id_question` (`id_question`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id_theme`),
  ADD UNIQUE KEY `id_theme` (`id_theme`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id_question` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id_reponse` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `id_theme` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
