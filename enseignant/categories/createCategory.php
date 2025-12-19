<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../../auth/login.php");
    exit;
}

if (isset($_POST['nom_categorie'])) 
{
$nom = trim($_POST['nom_categorie']);
$description = trim($_POST['description']);

if ($nom === '') {
    header("Location: categories.php?error=nom");
    exit;
}

$sql = "INSERT INTO categories (nom_categorie, description, createdAtCat) VALUES (?, ?, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nom, $description]);

header("Location: categories.php?success=1");
exit;
}
