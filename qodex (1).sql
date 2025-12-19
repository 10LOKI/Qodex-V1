-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 19 déc. 2025 à 16:51
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `qodex`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int(11) NOT NULL,
  `nom_categorie` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdAtCat` datetime DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `nom_categorie`, `description`, `createdBy`, `createdAtCat`, `updatedAt`) VALUES
(1, 'Développement Web', 'Questions sur HTML, CSS, JS et PHP', 1, '2025-12-14 15:18:48', '2025-12-14 15:18:48'),
(2, 'Base de données', 'Questions sur SQL et Merise', 1, '2025-12-14 15:18:48', '2025-12-14 15:18:48'),
(5, 'loki loco', 'art et la maniére', NULL, '2025-12-18 21:44:00', '2025-12-18 21:44:00'),
(6, 'Art et Musique', 'ko', NULL, '2025-12-18 21:53:21', '2025-12-18 21:53:21');

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id_question` int(11) NOT NULL,
  `id_quiz` int(11) NOT NULL,
  `texte_question` text NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `reponse_correcte` varchar(255) NOT NULL,
  `points` int(11) DEFAULT 1,
  `createdAtQ` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id_question`, `id_quiz`, `texte_question`, `option1`, `option2`, `option3`, `option4`, `reponse_correcte`, `points`, `createdAtQ`) VALUES
(1, 1, 'Que signifie PHP ?', 'Personal Home Page', 'PHP: Hypertext Preprocessor', 'Private Hosting Page', 'Public Hypertext Page', 'PHP: Hypertext Preprocessor', 2, '2025-12-14 15:18:48'),
(2, 1, 'Quelle fonction affiche du texte en PHP ?', 'print()', 'echo', 'display()', 'write()', 'echo', 1, '2025-12-14 15:18:48'),
(3, 1, 'Comment commence une variable en PHP ?', '@', '#', '$', '%', '$', 1, '2025-12-14 15:18:48'),
(4, 2, 'Quelle commande supprime une table ?', 'DELETE TABLE', 'ERASE TABLE', 'DROP TABLE', 'REMOVE TABLE', 'DROP TABLE', 2, '2025-12-14 15:18:48'),
(5, 1, 'Quel symbole commence une variable PHP ?', '$', '#', '@', '%', '$', 1, '2025-12-16 09:19:40'),
(6, 1, 'Quelle fonction affiche du texte ?', 'echo', 'print', 'show', 'display', 'echo', 1, '2025-12-16 09:19:40'),
(7, 2, 'Quelle commande joint deux tables ?', 'JOIN', 'MERGE', 'LINK', 'COMBINE', 'JOIN', 2, '2025-12-16 09:19:40'),
(8, 3, 'Quel index améliore les recherches ?', 'INDEX', 'KEY', 'PRIMARY', 'UNIQUE', 'INDEX', 2, '2025-12-16 09:19:40');

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

CREATE TABLE `quiz` (
  `id_quiz` int(11) NOT NULL,
  `titre_quiz` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `id_categorie` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `duree_minutes` int(11) NOT NULL,
  `isActive` tinyint(1) DEFAULT 1,
  `createdAtQuiz` datetime DEFAULT current_timestamp(),
  `updatedAtQuiz` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`id_quiz`, `titre_quiz`, `description`, `id_categorie`, `id_enseignant`, `duree_minutes`, `isActive`, `createdAtQuiz`, `updatedAtQuiz`) VALUES
(1, 'PHP Fondamentaux', 'Testez vos connaissances sur PHP 8', 1, 1, 20, 1, '2025-12-14 15:18:48', '2025-12-14 15:18:48'),
(2, 'SQL Avancé', 'Jointures et sous-requêtes', 2, 1, 30, 1, '2025-12-14 15:18:48', '2025-12-14 15:18:48'),
(3, 'Quiz Inactif Test', 'Ce quiz ne devrait pas être visible par les étudiants', 1, 1, 10, 0, '2025-12-14 15:18:48', '2025-12-14 15:18:48'),
(4, 'JavaScript Débutant', 'Bases du JS', 1, 1, 15, 1, '2025-12-16 09:19:40', '2025-12-16 09:19:40'),
(5, 'Laravel Avancé', 'Framework PHP Laravel', 1, 1, 30, 1, '2025-12-16 09:19:40', '2025-12-16 09:19:40'),
(6, 'MySQL Performance', 'Index et optimisation', 2, 1, 25, 1, '2025-12-16 09:19:40', '2025-12-16 09:19:40'),
(7, 'HTML / CSS', 'Fondamentaux du web', 1, 1, 10, 1, '2025-12-16 09:19:40', '2025-12-16 09:19:40'),
(8, 'Sécurité Web', 'OWASP Top 10', 1, 1, 40, 0, '2025-12-16 09:19:40', '2025-12-16 09:19:40'),
(9, 'culture generale', 'y\'a pas de descriptio,', 5, 10, 0, 1, '2025-12-19 09:20:31', '2025-12-19 09:20:31');

-- --------------------------------------------------------

--
-- Structure de la table `resultats`
--

CREATE TABLE `resultats` (
  `id_resultat` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `id_quiz` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `totalQuestions` int(11) NOT NULL,
  `date_passage` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `resultats`
--

INSERT INTO `resultats` (`id_resultat`, `id_etudiant`, `id_quiz`, `score`, `totalQuestions`, `date_passage`) VALUES
(1, 2, 1, 3, 3, '2025-12-10 10:30:00'),
(2, 3, 1, 2, 3, '2025-12-11 14:15:00'),
(3, 2, 2, 4, 5, '2025-12-12 09:00:00'),
(4, 2, 3, 3, 5, '2025-12-13 14:20:00'),
(5, 3, 2, 2, 5, '2025-12-14 16:45:00'),
(6, 3, 3, 5, 5, '2025-12-15 11:10:00');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('enseignant','etudiant') NOT NULL,
  `createdAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `email`, `password_hash`, `role`, `createdAt`) VALUES
(1, 'Professeur Dupont', 'prof@example.com', '$2y$10$wA7M0mZrV8v7nJ4FQzKkSe9Jr8N6YcD2LwZQyZB7U7J8N3m9nqR6W', 'enseignant', '2025-12-14 15:18:48'),
(2, 'Étudiant Alice', 'alice@example.com', '$2y$10$H3R9x7F2MZc1P8Y5vZK8KeR1L7W0YcQZqFZx0K9Yp8D5m3N6J2E1S', 'etudiant', '2025-12-14 15:18:48'),
(3, 'Étudiant Bob', 'bob@example.com', '$2y$10$H3R9x7F2MZc1P8Y5vZK8KeR1L7W0YcQZqFZx0K9Yp8D5m3N6J2E1S', 'etudiant', '2025-12-14 15:18:48'),
(4, 'Professeur Martin', 'martin@qodex.com', '$2y$10$wA7M0mZrV8v7nJ4FQzKkSe9Jr8N6YcD2LwZQyZB7U7J8N3m9nqR6W', 'enseignant', '2025-12-16 09:19:40'),
(5, 'Professeur Sarah', 'sarah@qodex.com', '$2y$10$wA7M0mZrV8v7nJ4FQzKkSe9Jr8N6YcD2LwZQyZB7U7J8N3m9nqR6W', 'enseignant', '2025-12-16 09:19:40'),
(6, 'Etudiant Karim', 'karim@qodex.com', '$2y$10$H3R9x7F2MZc1P8Y5vZK8KeR1L7W0YcQZqFZx0K9Yp8D5m3N6J2E1S', 'etudiant', '2025-12-16 09:19:40'),
(7, 'Etudiant Lina', 'lina@qodex.com', '$2y$10$H3R9x7F2MZc1P8Y5vZK8KeR1L7W0YcQZqFZx0K9Yp8D5m3N6J2E1S', 'etudiant', '2025-12-16 09:19:40'),
(8, 'Etudiant Youssef', 'youssef@qodex.com', '$2y$10$H3R9x7F2MZc1P8Y5vZK8KeR1L7W0YcQZqFZx0K9Yp8D5m3N6J2E1S', 'etudiant', '2025-12-16 09:19:40'),
(9, 'Ayoub', 'hey@email.com', '$2y$10$2iByjK0QwUz4bG4B8iFaeuKP2YC.n0.gj7v2Kt4sJcx5deHRFkP6u', 'enseignant', '2025-12-16 10:27:17'),
(10, 'loki', 'ayoubouharda33@gmail.com', '$2y$10$UA/PfK/qsR01woowMwpME.WDyrzOQ5MLzR/lCuO7p/cn8/su4IPJK', 'enseignant', '2025-12-16 16:44:22'),
(11, 'mohamed', 'mohamed@gmail.com', '$2y$10$luiS8eGCQLRNJau2uSwmFum62.VVid9pYAS5GJz9lrhFXNH09iaRO', 'enseignant', '2025-12-17 16:32:42'),
(12, 'Mehdi karbitou', 'mehdi55@gmail.com', '$2y$10$wahKu8CzTSl4NPAMXaug7O9Qf/XRSxIyzihTADu5UqaNkE/WVvNXS', 'enseignant', '2025-12-19 09:29:52');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`),
  ADD KEY `createdBy` (`createdBy`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `id_quiz` (`id_quiz`);

--
-- Index pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id_quiz`),
  ADD KEY `id_categorie` (`id_categorie`),
  ADD KEY `id_enseignant` (`id_enseignant`);

--
-- Index pour la table `resultats`
--
ALTER TABLE `resultats`
  ADD PRIMARY KEY (`id_resultat`),
  ADD KEY `id_etudiant` (`id_etudiant`),
  ADD KEY `id_quiz` (`id_quiz`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id_quiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `resultats`
--
ALTER TABLE `resultats`
  MODIFY `id_resultat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`createdBy`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE SET NULL;

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_ibfk_2` FOREIGN KEY (`id_enseignant`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `resultats`
--
ALTER TABLE `resultats`
  ADD CONSTRAINT `resultats_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `resultats_ibfk_2` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
