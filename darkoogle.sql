-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 23 Février 2021 à 14:11
-- Version du serveur :  5.7.33-0ubuntu0.18.04.1
-- Version de PHP :  7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `darkoogle`
--

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `erreurs`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `erreurs` (
`id` int(11)
,`url` varchar(500)
,`date` timestamp
,`titreErreur` varchar(255)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `moteur_recherche`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `moteur_recherche` (
`id` int(11)
,`url` varchar(500)
,`titre` varchar(500)
,`date` timestamp
,`mc1` varchar(100)
,`mc2` varchar(100)
,`mc3` varchar(100)
,`mc4` varchar(100)
,`mc5` varchar(100)
,`mc6` varchar(100)
,`popularite` int(255)
);

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

CREATE TABLE `site` (
  `id` int(11) NOT NULL,
  `url` varchar(500) NOT NULL,
  `titre` varchar(500) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `erreur` int(1) NOT NULL DEFAULT '0',
  `titreErreur` varchar(255) DEFAULT NULL,
  `cat` varchar(15) DEFAULT NULL,
  `mc1` varchar(100) DEFAULT NULL,
  `mc2` varchar(100) DEFAULT NULL,
  `mc3` varchar(100) DEFAULT NULL,
  `mc4` varchar(100) DEFAULT NULL,
  `mc5` varchar(100) DEFAULT NULL,
  `mc6` varchar(100) DEFAULT NULL,
  `pop` int(255) NOT NULL DEFAULT '0',
  `enCours` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `sites_analyses`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `sites_analyses` (
`id` int(11)
,`url` varchar(500)
,`titre` varchar(500)
,`date` timestamp
,`cat` varchar(15)
,`pop` int(255)
);

-- --------------------------------------------------------

--
-- Structure de la vue `erreurs`
--
DROP TABLE IF EXISTS `erreurs`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`localhost` SQL SECURITY DEFINER VIEW `erreurs`  AS  select `site`.`id` AS `id`,`site`.`url` AS `url`,`site`.`date` AS `date`,`site`.`titreErreur` AS `titreErreur` from `site` where (`site`.`erreur` = 1) ;

-- --------------------------------------------------------

--
-- Structure de la vue `moteur_recherche`
--
DROP TABLE IF EXISTS `moteur_recherche`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`localhost` SQL SECURITY DEFINER VIEW `moteur_recherche`  AS  select `site`.`id` AS `id`,`site`.`url` AS `url`,`site`.`titre` AS `titre`,`site`.`date` AS `date`,`site`.`mc1` AS `mc1`,`site`.`mc2` AS `mc2`,`site`.`mc3` AS `mc3`,`site`.`mc4` AS `mc4`,`site`.`mc5` AS `mc5`,`site`.`mc6` AS `mc6`,`site`.`pop` AS `popularite` from `site` where ((`site`.`erreur` = 0) and (`site`.`enCours` = 2)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `sites_analyses`
--
DROP TABLE IF EXISTS `sites_analyses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`localhost` SQL SECURITY DEFINER VIEW `sites_analyses`  AS  select `site`.`id` AS `id`,`site`.`url` AS `url`,`site`.`titre` AS `titre`,`site`.`date` AS `date`,`site`.`cat` AS `cat`,`site`.`pop` AS `pop` from `site` where ((`site`.`erreur` = 0) and (`site`.`enCours` = 2)) ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `site`
--
ALTER TABLE `site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74333;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
