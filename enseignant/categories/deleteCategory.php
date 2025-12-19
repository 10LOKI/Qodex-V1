<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] !== 'enseignant') 
{
header("Location: ../../auth/login.php");
exit;
}

if (!isset($_POST['id_categorie'])) {
    header("Location: categories.php?error=missing");
    exit;
}

$id = (int) $_POST['id_categorie'];
$stmt = $pdo->prepare("DELETE FROM categories WHERE id_categorie = ?");
$stmt->execute([$id]);

header("Location: categories.php?success=delete");
exit;
