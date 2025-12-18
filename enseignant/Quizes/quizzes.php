<?php
require_once __DIR__ . "/../../includes/header.php";
require_once __DIR__ . "/../../config/database.php";
$quizzes = $pdo ->query("SELECT * FROM quiz ORDER BY createdAtQuiz DESC") -> fetchAll(PDO::FETCH_ASSOC);
$statQuestions = $pdo -> prepare("SELECT COUNT(*) FROM questions WHERE id_quiz = ?");
$statEtudiants = $pdo ->prepare("SELECT COUNT(DISTINCT id_etudiant) FROM resultats WHERE id_quiz = ?");

if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../../auth/login.php");
    exit;
}

/* Récupérer les catégories pour le select */
$categories = $pdo->query("SELECT id_categorie, nom_categorie FROM categories ORDER BY nom_categorie ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Quiz Section ============> Mli tel9a solution rje3 had hidden-->
<!-- Create Quiz Modal -->
<div id="createQuizModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-lg p-6 relative">
        <button onclick="closeModal('createQuizModal')" class="absolute top-3 right-3 text-gray-500 hover:text-red-500">
            <i class="fas fa-times"></i>
        </button>

        <h2 class="text-xl font-bold mb-4">Créer un quiz</h2>

        <form action="/qodex/enseignant/quizzes/createQuiz.php" method="POST">
            <div>
                <label class="block">Titre du quiz *</label>
                <input type="text" name="titre_quiz" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block">Description</label>
                <textarea name="description" class="w-full border p-2 rounded"></textarea>
            </div>

            <div>
                <label class="block">Catégorie *</label>
                <select name="id_categorie" class="w-full border p-2 rounded" required>
                    <option value="">-- Choisir --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id_categorie'] ?>">
                            <?= htmlspecialchars($cat['nom_categorie']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg">
                Créer
            </button>
        </form>
    </div>
</div>
        <!-- Quiz List -->
         <div class="flex mx-10 my-10 justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Mes Quiz</h2>
        <p class="text-gray-600 mt-2 ">Créez et gérez vos quiz</p>
    </div>

    <button onclick="openModal('createQuizModal')"
            class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
        <i class="fas fa-plus mr-2"></i>Créer un Quiz
    </button>
</div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($quizzes as $quiz) { ?>
                <?php
                    $statQuestions->execute([$quiz['id_quiz']]);
                    $totQuestions = $statQuestions->fetchColumn();

                    $statEtudiants->execute([$quiz['id_quiz']]);
                    $totEtudiants = $statEtudiants->fetchColumn();
                    ?>
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">HTML/CSS</span>
                        <div class="flex gap-2">
                            <button class="text-blue-600 hover:text-blue-700">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/qodex/enseignant/quizzes/deleteQuiz.php"
                                method="POST"
                                onsubmit="return confirm('Voulez-vous vraiment supprimer ce quiz ?');">

                                <input type="hidden" name="id_quiz" value="<?= $quiz['id_quiz'] ?>">

                                <button type="submit" class="text-red-600 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?= $quiz['titre_quiz'] ?></h3>
                    <p class="text-gray-600 mb-4 text-sm"><?= 
                    $quiz['description'] ?></p>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span><i class="fas fa-question-circle mr-1"></i><?= $totQuestions ?> questions</span>
                        <span><i class="fas fa-user-friends mr-1"></i><?= $totEtudiants ?> participants</span>
                    </div>
                    <button class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        <i class="fas fa-eye mr-2"></i>Voir les résultats
                    </button>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}
</script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>