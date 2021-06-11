-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 04 juin 2021 à 07:34
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `swap`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

DROP TABLE IF EXISTS `annonce`;
CREATE TABLE IF NOT EXISTS `annonce` (
  `id_annonce` int(3) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `description_courte` varchar(255) DEFAULT NULL,
  `description_longue` text,
  `prix` double DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `pays` varchar(20) DEFAULT NULL,
  `ville` varchar(20) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `membre_id` int(3) NOT NULL,
  `photo_id` int(3) NOT NULL,
  `categorie_id` int(3) NOT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  PRIMARY KEY (`id_annonce`),
  KEY `fk_annonce_photo_idx` (`photo_id`),
  KEY `fk_annonce_membre1_idx` (`membre_id`),
  KEY `fk_annonce_categorie1_idx` (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int(3) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `motscles` text,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titre`, `motscles`) VALUES
(1, 'Emploi', 'Offres d\'emploi'),
(2, 'Véhicule', 'Voitures, Motos, Bateaux, vélos, Equipement'),
(3, 'Immobilier', 'ventes, Location, Colocations, Bureaux, Logement'),
(4, 'Vacances', 'Camping, Hôtels, hôte'),
(5, 'Multimédia', 'Jeux, Vidéos, Informatique, Image, Son, Téléphone'),
(6, 'Loisirs', 'Films, Musique, Livres'),
(7, 'Matériel', 'Outillage, Fournitures de Bureau, Matériel Agricole, ...'),
(8, 'Services', 'Prestations de services, Evénements, ...'),
(9, 'Maison', 'Ameublement, Electroménager, Bricolage, Jardinage, ...'),
(10, 'Vêtements', 'Jean, Chemise, Robe, Chaussure, ...'),
(11, 'Autres', '');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(3) NOT NULL AUTO_INCREMENT,
  `membre_id` int(3) NOT NULL,
  `annonce_id` int(3) NOT NULL,
  `commentaire` text,
  `date_enregistrement` datetime DEFAULT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `fk_commentaire_membre1_idx` (`membre_id`),
  KEY `fk_commentaire_annonce1_idx` (`annonce_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(3) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) DEFAULT NULL,
  `mdp` varchar(60) DEFAULT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `civilite` enum('m','f') DEFAULT NULL,
  `statut` int(1) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(5, 'graven', '$2y$10$wyrpBfrehAEMSJThwBe.y.lFGNoDAboOyGnPYuCbKCMM1dRflhpK.', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-29 16:04:39'),
(6, 'admin', '$2y$10$gQRt.vM4PjwzBAVl/aHhL.cyspcG7ILI/LbrXLRwMlsGuOs3J8.Sm', NULL, NULL, NULL, 'servam95@gmail.com', NULL, 1, '2021-05-29 16:05:09'),
(8, 'Naruto', '$2y$10$CTZBGEy.AmwmrZlMuJxLDOFSuuMhMWoRE/EbBRPbISxx52dCuNVqO', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-29 23:41:10'),
(9, 'mike', '$2y$10$OmE1XkUoyiWAjbKcNEf1delfQ.V/m2l/DSNOxuCIiQ69uKxKLxQAW', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 00:29:38'),
(10, 'fred', '$2y$10$7jqSgfJ3PBrlbNYdlYrQyejFN7.iLcRwlrH9nqMk2xOWWj4iyp4OC', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:10:02'),
(11, 'test', '$2y$10$rRq3naIWUWcn2J51UonTfu0BhLjX9EaefEehNkucN8KFZXxOZMkHq', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:14:41'),
(12, 'test2', '$2y$10$LzJzdiXSYyFrGs7Ex8nwW.ijGyZ2cI69TvRZr5mfDxNhyiJyh85nW', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:17:56'),
(13, 'test3', '$2y$10$KbpD2KNQTGUKgLAlOn5LnO1Z0PlHW2fgR85dgvnUUsbPvlFjjdPXa', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:18:24'),
(14, 'test4', '$2y$10$K5bH1zOeSoBCTga52OyrH.lO8z4GUp2uipO.Qey97l/nM3vXt2HRi', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:19:17'),
(15, 'test5', '$2y$10$24xERimGBjh2mbqpdWPVt.urQgjllNHscyrwmlKcAHuOaGUjbzuaC', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:19:57'),
(16, 'test8', '$2y$10$kGJRnbtBrq4ddlwMS.ZUP.F0Dtbokxl55VcgcGpwZazR.nm/0s6O.', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:21:01'),
(17, 'test10', '$2y$10$4.0iiJVq92B57rZrsOUNEerMyDsCkKBN/seT34ucHExEzYPP4P44W', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:21:29'),
(18, 'test11', '$2y$10$rHT8W49/RePHRfwaTDp39Og8gXg4G9AqZMRFJSM1ElJw.FrWoUkea', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:26:57'),
(19, 'test12', '$2y$10$yPba1y4IlnrshF2VTVG4eOkmLaJVkjcFdq3v8iwtR2.qTcihhpf5O', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:27:52'),
(20, 'test15', '$2y$10$7mnW9b2ukab9QSsqlGlgeurGWNQp9prRtvvt4nl6L9ki.d3vVIU.K', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:28:18'),
(21, 'test18', '$2y$10$bBGIjtGh4YtuIPRzvxlmqO76bevk6uQjS1WGOIMoU9Q7lGhOSTBoi', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:29:38'),
(22, 'test20', '$2y$10$PEsSpQnZaOkTpr4WagSBb.sHCw8zOUO4FvEIQCsfnWOWgq8CnAyLC', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:30:49'),
(23, 'ggg', '$2y$10$hGbtmeaM.4w6unFVgAk//uByJMVsvRM5lZ3/c8dCpNDjiyTWArry2', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:34:14'),
(24, 'tsunade', '$2y$10$6F8K07POek60y3tlm/aH6e/zfEgXaMfgETJvM10DkATScGSl9oXVu', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:43:00'),
(25, 'kakashi', '$2y$10$.fmJwPSCHms3KDEdXIlHY.eWX.Vrjs3PAX.1TIKWNdpwQJF24uCl6', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:43:50'),
(26, 'chou', '$2y$10$LGGYXDTh63pXNJLPFc18M.vC.tIHaPnM45Q.1C3cbo.PyA3DLrxzy', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:44:47'),
(27, 'garen', '$2y$10$H33FSJd2hh7lWCH3cxzLdO6jXVGMnyaav8cPMf2bYGCe2hn1WkfYu', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:45:28'),
(28, 'sasuke', '$2y$10$HHbL6.d69MYAunZjI4VEp.y.TiPLIFq1pV/IVQ9VTEdy9F7KtWqd6', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:46:26'),
(29, 'sasukesan', '$2y$10$D3vlID/Q3vVy3sz/3ZqWTOs8zaXvQ9CAqNL0cBBcLXVn27m3ufJWS', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:47:04'),
(30, 'narutosan', '$2y$10$X/IQ88nTI.AZBGouypM2B.rOnNkUSLWUMLkBZcyNrqnwY/bHexwby', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:48:15'),
(31, 'oroshimaru', '$2y$10$uAyDIPKLBgwhfpSIGL3wvudwFmMzuKzLoct9XM3.qxopf6x5uTI1C', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:49:45'),
(32, 'oroshimaru1', '$2y$10$TvF1YdJOBt8H/XgmrQUezek7ieIjETY7ldyqoWDN6BtNNKaXx2I9K', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:50:39'),
(33, 'oroshimaru2', '$2y$10$Z0UsGOLbyCRDbpZC34GX4uRT6FpAieS6kRL8YHoS8YDg8wu1nXrOO', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:51:12'),
(34, 'gravengng', '$2y$10$AlRZlQz2IV1v0AWbq.PqWO5kDnxSmxKEQSeLF6u/t5ULEZe7I0N4q', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:51:59'),
(35, 'gravengngll', '$2y$10$em0Y6N4eBPpG4zYrtmUD/.pjF5R3V.d.bvirsUOzSVOzw.YYf18bq', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:53:52'),
(36, 'gravenscs', '$2y$10$6byNzW4p.Y5lHhB/t7y7meHXX6UbvZuNzA9mZTBr6OPvCPC/ZChQK', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:55:17'),
(37, 'Narutocscs', '$2y$10$g6rIUV9u04pMhrxZFa1JouoJJ4o.d9j8LU8kgeqSB1GWHdsxdWTTm', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:55:37'),
(38, 'Narutocscsfdbsfbdsd', '$2y$10$4g3ICEiGYBa6JMVU5QcnG.hd2Yb50ts0g42.hU.JawLTiam9wVMrm', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:56:15'),
(39, 'ujuuuy', '$2y$10$D7CBLqVTnt4YRHbGhbJEgeFOmybs5J3sn/jq.oPlKcsqqwHVTBBk6', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:57:52'),
(40, 'sgsege', '$2y$10$YkknlO1P8sjtTZHi20o7hOGX0iII4OjvicjrwGEBcUeNE0XOS0T.K', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 01:58:01'),
(41, 'bddfbdfbdf', '$2y$10$h.U/nSTfInlped2yYjxGreW6dviXdo81d4CbJw1Sgk3LRLJGr8vO.', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 01:59:15'),
(42, 'NarutocZAAZZZD', '$2y$10$uP0bBbPK/HPTdj8DHSGqB.GSfhWyRe56maTw2KtzB.0gxy6ElT9sC', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 02:00:14'),
(43, 'kkQSCQSCSC', '$2y$10$5bvF.2IJl/hHbmL3pfbHROeywdSCKoYSbYD4fq1Y2PjANSECnHwQe', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 02:00:34'),
(44, 'NarutoGNFGNFG', '$2y$10$eYKcfUcOPHnvwuO2CX.yR.lEOqrjvYZex/jsTat7dddPnoGXzXa0y', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 15:16:09'),
(45, 'gravengngllhljk', '$2y$10$wyS6Mg91Swn7CC7GleHbkecEkq4sJA.MiTECItX9KugkNzZ3V9CCa', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 15:48:12'),
(46, 'gravenqxxq', '$2y$10$63JOLu5zGea.VwN/79k2aeUc/78gRTrVyxag.bS4RZdBWzJokY30i', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 21:07:47'),
(47, 'gravenqxxqaa', '$2y$10$AEdBG.WA55pk5lYw4KCule11eUOcbhDMmPO97kJGCk9tqzWggmM16', NULL, NULL, NULL, 'michael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-30 21:10:02'),
(48, 'adminfrferfe', '$2y$10$DOr84L9hK8MuJTOedKgQ3.tyvkkUgPvaUs4owvcvriovqn1.jrzF2', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 21:12:12'),
(49, 'Narutoyntyntynt', '$2y$10$QFzb6cjPjQnbGljEfzINqOHvnza45jL1Ir1Hf9cDHn8vg03pS2Bge', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 21:12:57'),
(50, 'Narutoggrfg4414', '$2y$10$LrA.DPlZ5LrzAzbb5KmOE.tUOIAzpBtIgPrue3v/XMRz4PyrR9lOy', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 21:16:05'),
(51, 'gravennfgnfgfgnfg', '$2y$10$YQ3yJM87OL305VM3yJNVzuwg8gcc9LUuvun3f3M/4XVDYSOub396e', NULL, NULL, NULL, 'servam95@gmail.com', NULL, NULL, '2021-05-30 21:18:31'),
(52, 'gaara', '$2y$10$kdcBo4TVte.4OLUNohlwpOyNY/dIabpanBZ28.fGSeiNnnnLNWnrO', NULL, NULL, NULL, 'gaara@formation-ifocop.fr', NULL, NULL, '2021-05-31 11:08:19'),
(53, 'hinata', '$2y$10$BUSFgFp93fHku17bakGDiOcBRVJp2MLI.hruawVHHJW/2Q4AOMhg2', NULL, NULL, NULL, 'hinata@formation-ifocop.fr', NULL, NULL, '2021-05-31 11:11:08'),
(54, 'sakura', '$2y$10$PWRkp8mcS.e205uz573ltOeg5YlfDZekYA1J7oK8D3zy86DqWeXNa', NULL, NULL, NULL, 'sakura@formation-ifocop.fr', NULL, NULL, '2021-05-31 11:27:55'),
(55, 'pain', '$2y$10$fetuIZDnAwdOKf0kQsr8kOfdFWLrKon4PibGyP8Epd73utjjsB1oG', NULL, NULL, NULL, 'pain@formation-ifocop.fr', NULL, NULL, '2021-05-31 11:32:37'),
(56, 'hththtth', '$2y$10$lh/8OLOVwVAcF6eDwU6Lre0Ba5G46SzunzmfLGWVolMsBhRJrsO9e', NULL, NULL, NULL, 'michdadzadazdaael.serva@formation-ifocop.fr', NULL, NULL, '2021-05-31 11:34:58'),
(57, 'gragbgbfbfven', '$2y$10$6QnYhSdw0TvkkfU5.du6heZ/FP5XHNmgpSgYEsSkXus.bYmwY.ggm', NULL, NULL, NULL, 'servamzdzdfzA95@gmail.com', NULL, NULL, '2021-05-31 11:37:47'),
(58, 'gragbgbfbfvenG', '$2y$10$9LFvVxbUnWx/HlL1alItBe9BZBvLYbgwSeQTM2r8W/Sdevs8Cr0Nq', NULL, NULL, NULL, 'servamzdzdfzA95@gmail.com', NULL, NULL, '2021-05-31 11:45:38'),
(59, 'gragbgbfbfvenGDVS', '$2y$10$Tq/NtcemkQvUcYgf.dryiO9xnzQXZZLAkpk37.tNWIoBteP7mzoPC', NULL, NULL, NULL, 'servamzdzdfzA95@gmail.com', NULL, NULL, '2021-05-31 11:46:45'),
(60, 'adminfqcqrg', '$2y$10$nFosOk2J5axdNvcU1dhC6uR22wxjNgoS7qojZTDWvDdm5pwtIzTVK', NULL, NULL, NULL, 'michaesdsl.sedcdcdrva@formation-ifocop.fr', NULL, NULL, '2021-05-31 11:59:43'),
(61, 'jessica', '$2y$10$9MX51mU2i5FQmT9bhMAH3uWJ.0GdE86bUuK5rP6B1.2FHfPjMz51W', NULL, NULL, NULL, 'jessica@formation-ifocop.fr', NULL, NULL, '2021-05-31 12:04:07'),
(62, 'nico', '$2y$10$PpjMD/JURm7vCqQgoIPCv.1MeROUiuz2nNCtsWtyeSw9C742TQwve', NULL, NULL, NULL, 'nico.serva@formation-ifocop.fr', NULL, 0, '2021-06-01 17:45:40');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `id_note` int(3) NOT NULL AUTO_INCREMENT,
  `membre_id1` int(3) NOT NULL,
  `membre_id2` int(3) NOT NULL,
  `note` int(3) DEFAULT NULL,
  `avis` text,
  `date_enregistrement` datetime DEFAULT NULL,
  PRIMARY KEY (`id_note`),
  KEY `fk_note_membre1_idx` (`membre_id1`),
  KEY `fk_note_membre2_idx` (`membre_id2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id_photo` int(3) NOT NULL AUTO_INCREMENT,
  `photo1` varchar(255) DEFAULT NULL,
  `photo2` varchar(255) DEFAULT NULL,
  `photo3` varchar(255) DEFAULT NULL,
  `photo4` varchar(255) DEFAULT NULL,
  `photo5` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_photo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `siteinfo`
--

DROP TABLE IF EXISTS `siteinfo`;
CREATE TABLE IF NOT EXISTS `siteinfo` (
  `id_info` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `valeur` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_info`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `siteinfo`
--

INSERT INTO `siteinfo` (`id_info`, `nom`, `valeur`) VALUES
(1, 'title', 'SWAP');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `fk_annonce_categorie1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_annonce_membre1` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_annonce_photo` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id_photo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_commentaire_annonce1` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id_annonce`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_commentaire_membre1` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `fk_note_membre1` FOREIGN KEY (`membre_id1`) REFERENCES `membre` (`id_membre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_note_membre2` FOREIGN KEY (`membre_id2`) REFERENCES `membre` (`id_membre`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
