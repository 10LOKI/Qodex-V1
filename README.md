# 📚 Plateforme de Quiz Sécurisée (PHP / MySQL)

## 🧠 Contexte du projet

Ce projet consiste à développer une **plateforme de gestion et de passage de quiz** destinée aux enseignants et aux étudiants, avec un fort accent sur la **sécurité**, la **gestion des rôles**, et le **respect des bonnes pratiques backend en PHP**.

Le projet est réalisé dans un cadre pédagogique et individuel.

---

## 🎯 Objectifs

* Permettre aux **enseignants** de créer, gérer et analyser des quiz
* Permettre aux **étudiants** de passer des quiz et consulter leurs résultats
* Mettre en œuvre des **mécanismes de sécurité robustes**
* Respecter une architecture claire et maintenable

---

## 👤 Rôles utilisateurs

### 👨‍🏫 Enseignant

* Création de catégories
* Création, modification et suppression de quiz
* Consultation des résultats

### 👨‍🎓 Étudiant (Bonus)

* Consultation des catégories
* Passage des quiz
* Consultation de l’historique des résultats

---

## 🧩 User Stories & Sécurité

### US1 – Créer une catégorie (Enseignant)

**Sécurité :**

* Session active + rôle enseignant
* Sanitization des champs
* Token CSRF
* Requêtes préparées (PDO)

### US2 – Créer un quiz (Enseignant)

**Sécurité :**

* Vérification du rôle enseignant
* Validation de l’existence de la catégorie
* Sanitization de tous les champs
* Minimum une question obligatoire
* Token CSRF

### US3 – Modifier / Supprimer un quiz (Enseignant)

**Sécurité :**

* Vérification du propriétaire du quiz
* Confirmation avant suppression
* Token CSRF
* Suppression en cascade des questions

### US4 – Consulter les résultats (Enseignant)

**Sécurité :**

* Accès limité aux quiz de l’enseignant
* Aucune donnée sensible exposée
* Pagination des résultats (Bonus)

### US5 – Voir les catégories (Étudiant – Bonus)

**Sécurité :**

* Session active requise
* Affichage uniquement des quiz actifs

### US6 – Passer un quiz (Étudiant – Bonus)

**Sécurité :**

* Token CSRF
* Validation du statut actif du quiz
* Vérification que toutes les réponses sont fournies
* Enregistrement sécurisé du résultat
* Résultat non modifiable

### US7 – Voir ses résultats (Étudiant – Bonus)

**Sécurité :**

* Accès strictement limité à ses propres résultats
* Historique des scores
* Aucun accès aux résultats des autres utilisateurs

---

## 🛠️ Stack technique

* **Langage** : PHP (PDO)
* **Base de données** : MySQL
* **Frontend** : HTML, Tailwind CSS
* **Sécurité** :

  * CSRF Tokens
  * Sessions PHP
  * Validation & Sanitization
  * Requêtes préparées

---

## 🗂️ Structure du projet (exemple)

```
/quiz-platform
│── config/
│   └── database.php
│── includes/
│   ├── header.php
│   ├── footer.php
│   └── csrf.php
│── enseignants/
│   ├── categories/
│   ├── quiz/
│   └── resultats/
│── etudiants/
│   ├── quiz/
│   └── resultats/
│── sql/
│   └── database.sql
│── uml/
│   ├── diagramme_classes.png
│   └── cas_utilisation.png
│── README.md
```

---

## 🧪 Sécurité implémentée

* Vérification des rôles (enseignant / étudiant)
* Protection CSRF sur tous les formulaires
* Requêtes SQL sécurisées (PDO + bindParam)
* Validation côté serveur
* Contrôle des accès par session

---

## 📊 UML & Documentation

* Diagramme de classes
* Diagramme de cas d’utilisation
* Scripts SQL fournis
* Compte rendu du livrable

---

## 📅 Modalités pédagogiques

* **Travail** : Individuel
* **Durée** : 7 jours
* **Date de lancement** : 04/12/2025
* **Deadline** : 19/12/2025 à 17:00

---

## 🎤 Évaluation

**Présentation de 20 minutes :**

* 5 min : Démonstration du livrable
* 10 min : Explication du code
* 5 min : Questions / Réponses

---

## 📦 Livrables

* ✔️ Lien Jira (planification des tâches)
* ✔️ Repository GitHub
* ✔️ README.md
* ✔️ Scripts PHP fonctionnels
* ✔️ Script SQL
* ✔️ UML (classes & cas d’utilisation)
* ✔️ Compte rendu du projet
* ✔️ Lien d’hébergement (facultatif)

---

## 👨‍💻 Auteur

**Ayoub Ouharda**
Projet réalisé dans le cadre de la formation.

---

## ✅ Statut du projet

🟢 Terminé / En cours de validation pédagogique
