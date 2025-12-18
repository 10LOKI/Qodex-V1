<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../../auth/login.php");
    exit;
}

if (empty($_POST['id_categorie']) || empty($_POST['nom_categorie'])) {
    header("Location: categories.php?error=missing");
    exit;
}

$id = (int) $_POST['id_categorie'];
$nom = trim($_POST['nom_categorie']);
$description = trim($_POST['description']);

$stmt = $pdo->prepare(
    "UPDATE categories SET nom_categorie = ?, description = ? WHERE id_categorie = ?"
);
$stmt->execute([$nom, $description, $id]);

header("Location: categories.php?success=update");
exit;
