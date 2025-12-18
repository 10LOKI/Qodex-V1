<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

/* Sécurité */
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../../auth/login.php");
    exit;
}

/* Vérifier soumission */
if (isset($_POST['titre_quiz'], $_POST['id_categorie'])) {

    $titre = trim($_POST['titre_quiz']);
    $description = trim($_POST['description'] ?? '');
    $id_categorie = (int) $_POST['id_categorie'];
    $id_enseignant = $_SESSION['id_utilisateur'];

    if ($titre === '' || $id_categorie === 0) {
        header("Location: quizzes.php?error=1");
        exit;
    }

    $sql = "INSERT INTO quiz 
            (titre_quiz, description, id_categorie, id_enseignant, createdAtQuiz)
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $description, $id_categorie, $id_enseignant]);

    header("Location: quizzes.php?success=1");
    exit;
}