<?php
require_once "config/database.php";

$totQuiz= $pdo->query("SELECT COUNT(*) FROM quiz") -> fetchColumn();
$totCategories = $pdo -> query("SELECT COUNT(*) FROM categories") -> fetchColumn();
$totStudents = $pdo -> query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'etudiant'") -> fetchColumn();
$tauxReussite = $pdo ->query("SELECT ROUND(AVG(score),0) FROM resultats") ->fetchColumn();
$tauxReussite = $tauxReussite ?? 0;
?>