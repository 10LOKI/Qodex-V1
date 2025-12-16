-- 1. Initialisation de la base de données
CREATE DATABASE IF NOT EXISTS qodex;
USE qodex;

-- Désactiver les vérifications de clés étrangères temporairement pour la suppression propre
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS resultats;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS quiz;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS utilisateurs;
SET FOREIGN_KEY_CHECKS = 1;

-- 2. Table Utilisateurs (Enseignants et Étudiants)
CREATE TABLE utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('enseignant', 'etudiant') NOT NULL,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Table Categories (Liée à US1)
CREATE TABLE categories (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(255) NOT NULL,
    description TEXT,
    createdBy INT,
    createdAtCat DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (createdBy) REFERENCES utilisateurs(id_utilisateur) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 4. Table Quiz (Liée à US2 et US3)
CREATE TABLE quiz (
    id_quiz INT AUTO_INCREMENT PRIMARY KEY,
    titre_quiz VARCHAR(255) NOT NULL,
    description TEXT,
    id_categorie INT NOT NULL,
    id_enseignant INT NOT NULL,
    duree_minutes INT NOT NULL,
    isActive BOOLEAN DEFAULT 1, -- Pour US5 (Affichage quiz actifs)
    createdAtQuiz DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAtQuiz DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie) ON DELETE CASCADE,
    FOREIGN KEY (id_enseignant) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 5. Table Questions (Nommée 'texte_question' sur l'ERD, mais 'questions' est plus standard)
CREATE TABLE questions (
    id_question INT AUTO_INCREMENT PRIMARY KEY,
    id_quiz INT NOT NULL,
    texte_question TEXT NOT NULL,
    option1 VARCHAR(255) NOT NULL,
    option2 VARCHAR(255) NOT NULL,
    option3 VARCHAR(255) NOT NULL,
    option4 VARCHAR(255) NOT NULL,
    reponse_correcte VARCHAR(255) NOT NULL, -- Stocke la valeur correcte (ex: "Paris")
    points INT DEFAULT 1,
    createdAtQ DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- Important pour US3 : Gestion en cascade (si on supprime le quiz, les questions partent)
    FOREIGN KEY (id_quiz) REFERENCES quiz(id_quiz) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Table Résultats (Liée à US4, US6, US7)
CREATE TABLE resultats (
    id_resultat INT AUTO_INCREMENT PRIMARY KEY,
    id_etudiant INT NOT NULL,
    id_quiz INT NOT NULL,
    score INT NOT NULL,
    totalQuestions INT NOT NULL,
    date_passage DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_etudiant) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_quiz) REFERENCES quiz(id_quiz) ON DELETE CASCADE
) ENGINE=InnoDB;

--------------------------------------------------------------------------------------------------------------------------

-- 1. Insérer des utilisateurs (1 Enseignant, 2 Étudiants)
INSERT INTO utilisateurs (nom, email, password_hash, role) VALUES 
('Professeur Dupont', 'prof@example.com', '$2y$10$ExempleDeHashPour123456', 'enseignant'),
('Étudiant Alice', 'alice@example.com', '$2y$10$ExempleDeHashPour123456', 'etudiant'),
('Étudiant Bob', 'bob@example.com', '$2y$10$ExempleDeHashPour123456', 'etudiant');

-- 2. Insérer des catégories (Créé par le prof ID 1)
INSERT INTO categories (nom_categorie, description, createdBy) VALUES 
('Développement Web', 'Questions sur HTML, CSS, JS et PHP', 1),
('Base de données', 'Questions sur SQL et Merise', 1);

-- 3. Insérer des Quiz
-- Quiz 1 : PHP Basics (Actif)
INSERT INTO quiz (titre_quiz, description, id_categorie, id_enseignant, duree_minutes, isActive) VALUES 
('PHP Fondamentaux', 'Testez vos connaissances sur PHP 8', 1, 1, 20, 1),
('SQL Avancé', 'Jointures et sous-requêtes', 2, 1, 30, 1),
('Quiz Inactif Test', 'Ce quiz ne devrait pas être visible par les étudiants', 1, 1, 10, 0);

-- 4. Insérer des Questions pour le Quiz "PHP Fondamentaux" (ID Quiz = 1)
INSERT INTO questions (id_quiz, texte_question, option1, option2, option3, option4, reponse_correcte, points) VALUES 
(1, 'Que signifie PHP ?', 'Personal Home Page', 'PHP: Hypertext Preprocessor', 'Private Hosting Page', 'Public Hypertext Page', 'PHP: Hypertext Preprocessor', 2),
(1, 'Quelle fonction affiche du texte en PHP ?', 'print()', 'echo', 'display()', 'write()', 'echo', 1),
(1, 'Comment commence une variable en PHP ?', '@', '#', '$', '%', '$', 1);

-- 5. Insérer des Questions pour le Quiz "SQL Avancé" (ID Quiz = 2)
INSERT INTO questions (id_quiz, texte_question, option1, option2, option3, option4, reponse_correcte, points) VALUES 
(2, 'Quelle commande supprime une table ?', 'DELETE TABLE', 'ERASE TABLE', 'DROP TABLE', 'REMOVE TABLE', 'DROP TABLE', 2);

-- 6. Insérer des résultats (Historique pour US7)
-- Alice a passé le quiz PHP
INSERT INTO resultats (id_etudiant, id_quiz, score, totalQuestions, date_passage) VALUES 
(2, 1, 3, 3, '2025-12-10 10:30:00');

-- Bob a passé le quiz PHP mais a raté une question
INSERT INTO resultats (id_etudiant, id_quiz, score, totalQuestions, date_passage) VALUES 
(3, 1, 2, 3, '2025-12-11 14:15:00');