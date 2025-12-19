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

$categories = $pdo->query("SELECT id_categorie, nom_categorie FROM categories ORDER BY nom_categorie ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Quiz Section ============> Mli tel9a solution rje3 had hidden-->
<!-- Create Quiz Modal -->
<div id="createQuizModal"
     class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-50">

    <!-- Modal Box -->
    <div class="bg-white rounded-xl w-full max-w-3xl p-6 relative
                max-h-[90vh] overflow-y-auto shadow-2xl">

        <!-- Close Button -->
        <button onclick="closeModal('createQuizModal')"
                class="absolute top-4 right-4 text-gray-400 hover:text-red-600 text-xl">
            <i class="fas fa-times"></i>
        </button>

        <h2 class="text-2xl font-bold mb-6">Créer un quiz</h2>

        <form action="createQuiz.php" method="POST" class="space-y-4">

            <!-- Titre -->
            <div>
                <label class="block font-semibold mb-1">Titre du quiz *</label>
                <input type="text" name="titre_quiz"
                       class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500"
                       required>
            </div>

            <!-- Description -->
            <div>
                <label class="block font-semibold mb-1">Description</label>
                <textarea name="description"
                          class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500"
                          rows="3"></textarea>
            </div>

            <!-- Catégorie -->
            <div>
                <label class="block font-semibold mb-1">Catégorie *</label>
                <select name="id_categorie"
                        class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        required>
                    <option value="">-- Choisir --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id_categorie'] ?>">
                            <?= htmlspecialchars($cat['nom_categorie']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Questions Section -->
            <div class="border-t pt-6 mt-6">

                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-bold">Questions</h4>
                    <button type="button" onclick="addQuestion()"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                        <i class="fas fa-plus mr-2"></i>Ajouter une question
                    </button>
                </div>

                <div id="questionsContainer">

                    <!-- Question Block -->
                    <div class="bg-gray-50 border rounded-lg p-4 mb-6 question-block">

                        <div class="flex justify-between items-center mb-4">
                            <h5 class="font-bold">Question 1</h5>
                            <button type="button" onclick="removeQuestion(this)"
                                    class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                        <div class="mb-4">
                            <input type="text" name="questions[0][question]"
                                   class="w-full border px-3 py-2 rounded-lg"
                                   required>
                        </div>

                        <div class="grid md:grid-cols-2 gap-3 mb-4">
                            <input type="text" name="questions[0][option1]" placeholder="Option 1"
                                   class="border px-3 py-2 rounded-lg" required>
                            <input type="text" name="questions[0][option2]" placeholder="Option 2"
                                   class="border px-3 py-2 rounded-lg" required>
                            <input type="text" name="questions[0][option3]" placeholder="Option 3"
                                   class="border px-3 py-2 rounded-lg" required>
                            <input type="text" name="questions[0][option4]" placeholder="Option 4"
                                   class="border px-3 py-2 rounded-lg" required>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Réponse correcte *</label>
                            <select name="questions[0][correct]"
                                    class="w-full border px-3 py-2 rounded-lg" required>
                                <option value="">-- Choisir --</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                Créer le quiz
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
function openModal(id) 
{
    document.getElementById(id).classList.remove('hidden');
}
function closeModal(id) 
{
    document.getElementById(id).classList.add('hidden');
}
</script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>