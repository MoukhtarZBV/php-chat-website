-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 30 mars 2024 à 16:15
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `minichat`
--

-- --------------------------------------------------------

--
-- Structure de la table `chatjs`
--

CREATE TABLE `chatjs` (
  `idMessage` int(11) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  `userPseudo` varchar(30) DEFAULT NULL,
  `horaire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chatjs`
--

INSERT INTO `chatjs` (`idMessage`, `contenu`, `userPseudo`, `horaire`) VALUES
(2, 'Salut tout le monde ', 'Nautilus', 1711809080),
(3, 'Vous en dites quoi d\'une petite sortie bowling demain ?', 'Nautilus', 1711809106),
(4, 'Je suis chaud !', 'YouChen', 1711809165),
(5, 'Carrément !', 'FruitsEnjoyer', 1711809243),
(6, '<script>alert(\"Danger\")</script>', 'ember', 1711809313),
(7, 'Ah...', 'ember', 1711809324),
(8, 'Ca n\'a pas marché..', 'ember', 1711809345),
(9, '?', 'Nautilus', 1711809348),
(10, '<strong>T\'essayais de faire quoi au juste ?</strong>', 'YouChen', 1711809385),
(11, 'Jamais 2 sans 3 ', 'Nautilus', 1711809433),
(13, '<hr>', 'Nautilus', 1711809586),
(14, ':(', 'Nautilus', 1711809591),
(15, 'Faut savoir abandonner à un moment', 'FruitsEnjoyer', 1711809598),
(16, 'Quel bowling ducoup ?', 'FruitsEnjoyer', 1711809665),
(17, '!$#~?&', NULL, 1711813251),
(18, 'C\'est pas très cool ca', 'YouChen', 1711814896),
(19, 'Répondez par pitié, ca fait 30 minutes...', 'FruitsEnjoyer', 1711811756);

-- --------------------------------------------------------

--
-- Structure de la table `userjs`
--

CREATE TABLE `userjs` (
  `username` varchar(30) NOT NULL,
  `password` varchar(500) NOT NULL,
  `pfp` varchar(1000) NOT NULL,
  `lastSeen` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `userjs`
--

INSERT INTO `userjs` (`username`, `password`, `pfp`, `lastSeen`) VALUES
('ember', '$2y$10$6JxN5nG/IS41uOUd3ud/2eNkVvPmjA7k3LSnUVGUx76rIuxV6mHz2', 'random-profile-picture (18).png', '2024-03-30 14:35:54'),
('FruitsEnjoyer', '$2y$10$3fX.5eIOvWLCluiUseQuuuEzMV/wjSQlveCkD0fG.eXSH4dGwf3eW', 'random-profile-picture (28).png', '2024-03-30 14:56:03'),
('Nautilus', '$2y$10$MuEFmBV8YnP8XiBqwAfhB.2eKxQM1VTeYfdLuF0we69cWEeVhe.4C', 'random-profile-picture (26).png', '2024-03-30 14:54:11'),
('YouChen', '$2y$10$sQzmjbj4qGSymPbOCCBG3uafoEhjDDaDaCMQwQHPbI.h5DjtOTPjC', 'random-profile-picture (17).png', '2024-03-30 15:14:35');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chatjs`
--
ALTER TABLE `chatjs`
  ADD PRIMARY KEY (`idMessage`),
  ADD KEY `fk_chatjs_user` (`userPseudo`);

--
-- Index pour la table `userjs`
--
ALTER TABLE `userjs`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chatjs`
--
ALTER TABLE `chatjs`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chatjs`
--
ALTER TABLE `chatjs`
  ADD CONSTRAINT `fk_chatjs_user` FOREIGN KEY (`userPseudo`) REFERENCES `userjs` (`username`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_chatjs_userjs` FOREIGN KEY (`userPseudo`) REFERENCES `userjs` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
