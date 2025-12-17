<?php
session_start();
require __DIR__ . "/../../includes/header.php";
require __DIR__ . "/../../config/database.php";

$categories = $pdo->query("SELECT * FROM categories ORDER BY createdAtCat DESC")->fetchAll(PDO::FETCH_ASSOC);
$statQuiz = $pdo->prepare("SELECT COUNT(*) FROM quiz WHERE id_categorie =?");
$statEtudiants = $pdo->prepare("SELECT COUNT(DISTINCT r.id_etudiant) FROM resultats r JOIN quiz q ON q.id_quiz = r.id_quiz WHERE q.id_categorie = ?");
?>
<!-- Categories Section -->
<div id="categories" class="section-content ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Gestion des Catégories</h2>
                <p class="text-gray-600 mt-2">Organisez vos quiz par catégories</p>
            </div>
            <a href="?openModal=1"
                class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Nouvelle Catégorie
            </a>
        </div>

        <!-- Categories List -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- start -->
            <?php foreach ($categories as $catg) { ?>
                <?php
                $statQuiz->execute([$catg['id_categorie']]);
                $totQuiz = $statQuiz->fetchColumn();

                $statEtudiants->execute([$catg['id_categorie']]);
                $totEtudiants = $statEtudiants->fetchColumn();
                ?>
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900"><?= $catg['nom_categorie'] ?></h3>
                            <p class="text-gray-600 text-sm mt-1"><?= $catg['description'] ?></p>
                        </div>
                        <div class="flex gap-2">
                            <button class="text-blue-600 hover:text-blue-700">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500"><i class="fas fa-clipboard-list mr-2"></i><?= $totQuiz ?> quiz</span>
                        <span class="text-gray-500"><i class="fas fa-user-friends mr-2"></i><?= $totEtudiants ?> étudiants</span>
                    </div>
                </div>
            <?php } ?>
            <!-- end -->
        </div>
    </div>
</div>
<!-- Modal: Créer Catégorie -->
<div id="createCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 <?= isset($_GET['openModal']) ? 'flex' : 'hidden' ?> items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold">Nouvelle Catégorie</h3>
                <a href="categories.php" class="text-xl">✕</a>
            </div>

            <!-- FORM -->
            <form method="POST" action="/qodex/enseignant/categories/createCategory.php">

                <div class="mb-4">
                    <label class="block font-semibold mb-2">
                        Nom *
                    </label>
                    <input type="text" name="nom_categorie" required
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-2">
                        Description
                    </label>
                    <textarea name="description" rows="4"
                        class="w-full border rounded-lg px-4 py-2"></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button"
                        onclick="closeModal('createCategoryModal')"
                        class="flex-1 border rounded-lg py-2">
                        Annuler
                    </button>

                    <button type="submit"
                        name="create_category"
                        class="flex-1 bg-indigo-600 text-white rounded-lg py-2">
                        Créer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>