-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 14 Juin 2018 à 13:54
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `brainblue`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `IdAdmin` int(11) NOT NULL AUTO_INCREMENT,
  `Passwordadmin` char(100) NOT NULL,
  `pseudoadmin` varchar(30) NOT NULL,
  PRIMARY KEY (`IdAdmin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`IdAdmin`, `Passwordadmin`, `pseudoadmin`) VALUES
(2, 'f1ba847181793b3babd9059e9eaa6a3d1ee9d95d', 'olympe98');

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

CREATE TABLE IF NOT EXISTS `auteur` (
  `profil` varchar(200) DEFAULT NULL,
  `IdAut` int(11) NOT NULL AUTO_INCREMENT,
  `bibiographie` text,
  `IdUser` int(11) NOT NULL,
  PRIMARY KEY (`IdAut`),
  KEY `IdUser` (`IdUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `auteur`
--

INSERT INTO `auteur` (`profil`, `IdAut`, `bibiographie`, `IdUser`) VALUES
('/public/ProfilAuteur/{6185050a5e5c41509e7b4e6c73115438}.jpg', 1, 'Le meilleur auteur de tous les temps', 4);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `IdCat` int(11) NOT NULL AUTO_INCREMENT,
  `LibCat` varchar(30) NOT NULL,
  `delai` int(11) NOT NULL,
  PRIMARY KEY (`IdCat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`IdCat`, `LibCat`, `delai`) VALUES
(1, 'Roman', 3),
(2, 'Science', 2),
(3, 'Conte', 2),
(4, 'Dictionaire', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commenter_pub`
--

CREATE TABLE IF NOT EXISTS `commenter_pub` (
  `IdCom` int(11) NOT NULL AUTO_INCREMENT,
  `IdPub` int(11) NOT NULL,
  `text` text NOT NULL,
  `IdUser` int(11) NOT NULL,
  `DateCom` bigint(20) NOT NULL,
  PRIMARY KEY (`IdCom`),
  KEY `idPub` (`IdPub`),
  KEY `IdUser` (`IdUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `commenter_pub`
--

INSERT INTO `commenter_pub` (`IdCom`, `IdPub`, `text`, `IdUser`, `DateCom`) VALUES
(1, 7, 'First comment', 4, 1525644355),
(2, 6, 'comment', 4, 1525644538),
(3, 7, 'The best read of my life', 4, 1525646796),
(4, 7, 'let''s begin', 4, 1525646891),
(5, 7, 'I never freez', 4, 1525646924),
(6, 5, 'i don''t really like your idea...', 4, 1525654745),
(7, 3, 'The last of us...', 4, 1525657845),
(8, 3, 'what else...', 4, 1525657870),
(9, 7, 'what else...', 4, 1526294947),
(10, 8, 'what else...', 4, 1526294959),
(11, 8, 'what else...', 4, 1526294961),
(12, 8, 'The last of us...', 4, 1528101409),
(13, 8, 'it very good i like it', 4, 1528101885);

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE IF NOT EXISTS `favoris` (
  `idFav` int(11) NOT NULL AUTO_INCREMENT,
  `idLi` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  PRIMARY KEY (`idFav`),
  KEY `idLi` (`idLi`),
  KEY `IdUser` (`IdUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `favoris`
--

INSERT INTO `favoris` (`idFav`, `idLi`, `IdUser`) VALUES
(15, 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `liker`
--

CREATE TABLE IF NOT EXISTS `liker` (
  `IdLike` int(11) NOT NULL AUTO_INCREMENT,
  `IdUser` int(11) NOT NULL,
  `IdPub` int(11) NOT NULL,
  `DateLike` bigint(20) NOT NULL,
  PRIMARY KEY (`IdLike`),
  KEY `IdUser` (`IdUser`),
  KEY `IdPub` (`IdPub`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `liker`
--

INSERT INTO `liker` (`IdLike`, `IdUser`, `IdPub`, `DateLike`) VALUES
(20, 4, 6, 1526285597),
(21, 4, 7, 1526288954),
(24, 4, 3, 1526294612),
(27, 4, 5, 1528101435),
(30, 4, 8, 1528377324);

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE IF NOT EXISTS `livre` (
  `IdLi` int(11) NOT NULL AUTO_INCREMENT,
  `IdCat` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `auteur` varchar(100) NOT NULL,
  `cover` varchar(200) NOT NULL,
  `lien` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `Vues` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdLi`),
  KEY `IdCat` (`IdCat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `livre`
--

INSERT INTO `livre` (`IdLi`, `IdCat`, `titre`, `auteur`, `cover`, `lien`, `description`, `status`, `Vues`) VALUES
(3, 3, 'Le livre de la jungle', 'moliere', '/public/PropositionCover/{aad06b80c428c43964c714ba91321d0d}.jpg', '/public/PropositionDoc/{7c9af28ebbd47504b5debb7175d9679d}.docx', 'Mougli un jeune home ayant grandit dans la foret', NULL, 7),
(5, 1, 'Casa De Papell', 'El professor', '/public/LivreCover/{04707647574a65a26802a4bf51413345}.png', '/public/LivreDoc/{70223c4691fc849193768775756c1a04}.pdf', 'El professor les conduira a la richesse', NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `pret`
--

CREATE TABLE IF NOT EXISTS `pret` (
  `idPret` int(11) NOT NULL AUTO_INCREMENT,
  `IdLi` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `DatePret` bigint(20) NOT NULL,
  `DateRetour` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idPret`),
  KEY `idLi` (`IdLi`),
  KEY `IdUser` (`IdUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `pret`
--

INSERT INTO `pret` (`idPret`, `IdLi`, `IdUser`, `DatePret`, `DateRetour`) VALUES
(17, 3, 4, 1528369222, 1529578822),
(18, 5, 5, 1528369572, 1530183972),
(19, 3, 5, 1528369576, 1529579176),
(20, 5, 4, 1528377306, 1530191706);

-- --------------------------------------------------------

--
-- Structure de la table `proposition`
--

CREATE TABLE IF NOT EXISTS `proposition` (
  `IdPro` int(11) NOT NULL AUTO_INCREMENT,
  `IdLi` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `IdAdmin` int(11) DEFAULT NULL,
  `DatePro` bigint(20) NOT NULL,
  `Status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`IdPro`),
  KEY `idLi` (`IdLi`),
  KEY `IdUser` (`IdUser`),
  KEY `IdAdmin` (`IdAdmin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `proposition`
--

INSERT INTO `proposition` (`IdPro`, `IdLi`, `IdUser`, `IdAdmin`, `DatePro`, `Status`) VALUES
(1, 3, 5, NULL, 1525053293, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE IF NOT EXISTS `publication` (
  `IdPub` int(11) NOT NULL AUTO_INCREMENT,
  `IdAut` int(11) NOT NULL,
  `LienLivre` varchar(200) NOT NULL,
  `cover` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `DatePub` bigint(20) NOT NULL,
  `Titre` varchar(30) NOT NULL,
  `Vues` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdPub`),
  KEY `IdAut` (`IdAut`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `publication`
--

INSERT INTO `publication` (`IdPub`, `IdAut`, `LienLivre`, `cover`, `text`, `DatePub`, `Titre`, `Vues`) VALUES
(2, 1, '/public/PublicationDoc/{f50e9f518ac1cb25ad9900be92757d57}.pdf', '/public/PublicationCover/{f2d2a455e98f0bd675941d56f4ade47d}.jpg', 'Le dernier oppus de la saga', 1525387233, 'Harry potter et le prince de s', 1),
(3, 1, '/public/PublicationDoc/{bab325cadb219dcae372280470dd0e02}.docx', '/public/PublicationCover/{e661d9a3f5c4bfcbda7376ffe72a1da6}.jpg', 'Le 7eme oppus de la saga', 1525611841, 'Game of Throne', 10),
(5, 1, '/public/PublicationDoc/{889455679b331da3e34c64fb788f70ce}.txt', '/public/PublicationCover/{005745e3e79593c0d5717cbabf3cf0bc}.jpg', 'I''ll be back.', 1525612062, 'le retour du hero', 8),
(6, 1, '/public/PublicationDoc/{9e0f36ad6bc7196c2b0b1f8b6b32bddf}.pdf', '/public/PublicationCover/{f73cd4873eab8600fa3be727d77ce04a}.jpg', 'Aprennez les rudiments de la guerre mentale', 1525612128, 'L''art de la guerre', 6),
(7, 1, '/public/PublicationDoc/{5e9bd2f5ff1960e278e0dc1cf378836e}.pdf', '/public/PublicationCover/{f96ee03ac6c0082f187af4de30f09aae}.jpg', 'Tous vos cauchemar sont desormais realite', 1525613151, 'Grimm', 24),
(8, 1, '/public/PublicationDoc/{ce40fc7ff65c247bae807584fdeb9d78}.docx', '/public/PublicationCover/{330051553052f5c7cee011c079ac7165}.jpg', 'comment', 1525735062, 'Physique', 15);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `IdUser` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(22) NOT NULL,
  `Prenom` varchar(22) NOT NULL,
  `Mail` varchar(40) NOT NULL,
  `DateNaiss` bigint(20) NOT NULL,
  `Password` char(100) NOT NULL,
  `statut` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`IdUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`IdUser`, `Nom`, `Prenom`, `Mail`, `DateNaiss`, `Password`, `statut`) VALUES
(4, 'QUENUM', 'Prima', 'cadet.quenum@gmail.com', 934149600, 'f1ba847181793b3babd9059e9eaa6a3d1ee9d95d', NULL),
(5, 'QUENUM', 'olympe', 'olympe.quenum@gmail.com', 1524607200, 'f1ba847181793b3babd9059e9eaa6a3d1ee9d95d', NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD CONSTRAINT `auteur_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `user` (`IdUser`);

--
-- Contraintes pour la table `commenter_pub`
--
ALTER TABLE `commenter_pub`
  ADD CONSTRAINT `commenter_pub_ibfk_2` FOREIGN KEY (`IdPub`) REFERENCES `publication` (`IdPub`),
  ADD CONSTRAINT `commenter_pub_ibfk_3` FOREIGN KEY (`IdUser`) REFERENCES `user` (`IdUser`);

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `favoris_ibfk_2` FOREIGN KEY (`idLi`) REFERENCES `livre` (`IdLi`),
  ADD CONSTRAINT `favoris_ibfk_3` FOREIGN KEY (`IdUser`) REFERENCES `user` (`IdUser`);

--
-- Contraintes pour la table `liker`
--
ALTER TABLE `liker`
  ADD CONSTRAINT `liker_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `user` (`IdUser`),
  ADD CONSTRAINT `liker_ibfk_2` FOREIGN KEY (`IdPub`) REFERENCES `publication` (`IdPub`);

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `livre_ibfk_1` FOREIGN KEY (`IdCat`) REFERENCES `categorie` (`IdCat`);

--
-- Contraintes pour la table `pret`
--
ALTER TABLE `pret`
  ADD CONSTRAINT `pret_ibfk_2` FOREIGN KEY (`idLi`) REFERENCES `livre` (`IdLi`),
  ADD CONSTRAINT `pret_ibfk_3` FOREIGN KEY (`IdUser`) REFERENCES `user` (`IdUser`);

--
-- Contraintes pour la table `proposition`
--
ALTER TABLE `proposition`
  ADD CONSTRAINT `proposition_ibfk_1` FOREIGN KEY (`IdLi`) REFERENCES `livre` (`IdLi`),
  ADD CONSTRAINT `proposition_ibfk_2` FOREIGN KEY (`IdUser`) REFERENCES `user` (`IdUser`),
  ADD CONSTRAINT `proposition_ibfk_3` FOREIGN KEY (`IdAdmin`) REFERENCES `admin` (`IdAdmin`);

--
-- Contraintes pour la table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `publication_ibfk_1` FOREIGN KEY (`IdAut`) REFERENCES `auteur` (`IdAut`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
