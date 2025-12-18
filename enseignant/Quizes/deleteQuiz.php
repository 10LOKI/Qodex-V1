<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

/* Sécurité */
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../../auth/login.php");
    exit;
}

/* Validation */
if (!isset($_POST['id_quiz'])) {
    header("Location: quizzes.php?error=missing");
    exit;
}

$id_quiz = (int) $_POST['id_quiz'];

/* Vérifier que le quiz appartient à l’enseignant */
$stmt = $pdo->prepare("
    SELECT id_quiz 
    FROM quiz 
    WHERE id_quiz = ? AND id_enseignant = ?
");
$stmt->execute([$id_quiz, $_SESSION['id_utilisateur']]);

if (!$stmt->fetch()) {
    header("Location: quizzes.php?error=unauthorized");
    exit;
}

/* Suppression */
$stmt = $pdo->prepare("DELETE FROM quiz WHERE id_quiz = ?");
$stmt->execute([$id_quiz]);

header("Location: quizzes.php?success=delete");
exit;
