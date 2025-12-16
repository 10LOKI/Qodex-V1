<?php
// Démarrer la session si pas encore démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sécurité : si pas connecté → login
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Sécurité : si pas enseignant → espace étudiant
if ($_SESSION['role'] !== 'enseignant') {
    header("Location: ../etudiant/dashboard.php");
    exit;
}

// Initiales du nom
$initials = strtoupper(substr($_SESSION['nom'], 0, 2));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizMaster - Espace Enseignant</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">

<!-- Navigation Enseignant -->
<nav class="bg-white shadow-lg fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center">
                <i class="fas fa-graduation-cap text-3xl text-indigo-600"></i>
                <span class="ml-2 text-2xl font-bold text-gray-900">QuizMaster</span>
                <span class="ml-3 px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                    Enseignant
                </span>
            </div>

            <!-- Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="../enseignant/dashboard.php" class="text-gray-700 hover:text-indigo-600 font-medium">
                    <i class="fas fa-home mr-2"></i>Tableau de bord
                </a>
                <a href="#categories" class="text-gray-700 hover:text-indigo-600 font-medium">
                    <i class="fas fa-folder mr-2"></i>Catégories
                </a>
                <a href="../enseignant/add_quiz.php" class="text-gray-700 hover:text-indigo-600 font-medium">
                    <i class="fas fa-clipboard-list mr-2"></i>Mes Quiz
                </a>
                <a href="../enseignant/view_results.php" class="text-gray-700 hover:text-indigo-600 font-medium">
                    <i class="fas fa-chart-bar mr-2"></i>Résultats
                </a>
            </div>

            <!-- Profil -->
            <div class="flex items-center">
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                            <?= $initials ?>
                        </div>
                        <div class="hidden md:block text-left">
                            <div class="text-sm font-medium text-gray-900">
                                <?= htmlspecialchars($_SESSION['nom']) ?>
                            </div>
                            <div class="text-xs text-gray-500">Enseignant</div>
                        </div>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </button>

                    <!-- Dropdown -->
                    <div id="userDropdown"
                         class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Mon Profil
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i>Paramètres
                        </a>
                        <hr class="my-1">
                        <a href="../etudiant/dashboard.php"
                           class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">
                            <i class="fas fa-exchange-alt mr-2"></i>Espace Étudiant
                        </a>
                        <a href="../auth/logout.php"
                           class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>

<!-- CONTENU -->
<div class="pt-16">
