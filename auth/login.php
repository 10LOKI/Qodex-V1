<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
if (isset($_POST['action']) && $_POST['action'] === 'login') 
{
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id_utilisateur, nom, email, password_hash, role FROM utilisateurs WHERE email = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {

        $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'enseignant') {
            header("Location: ../enseignant/dashboard.php");
        } else {
            header("");
        }
        exit();

    } else {
        $message = "Email ou mot de passe incorrect";
    }
}
if (isset($_POST['action']) && $_POST['action'] === 'register') {

    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $check = $pdo->prepare("SELECT id_utilisateur FROM utilisateurs WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $message = "Cet email existe déjà";
    } else {
        $sql = "INSERT INTO utilisateurs (nom, email, password_hash, role)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $email, $password, $role]);

        $message = "Compte créé avec succès. Connectez-vous.";
    }
}
}
$errors =[];
$regex=[
    'nom' => "/^[a-zA-ZÀ-ÿ\s'-]{2,50}$/",
    'email' => "/^[\w\.-]+@[\w\.-]+\.\w{2,}$/",
    'password' => "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/"
];
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {

    if ($_POST['action'] === 'login') {
        if (!preg_match($regex['email'], $email)) {
            $errors[] = "Format d'email invalide";
        }

        if (empty($password)) {
            $errors[] = "Le mot de passe est obligatoire";
        }

        if (!empty($errors)) {
            $message = implode("<br>", $errors);
        }
    }

    if ($_POST['action'] === 'register') 
{
    if (!preg_match($regex['nom'], $nom)) {
        $errors[] = "Le nom doit contenir 2 à 50 lettres seulement";
    }

    if (!preg_match($regex['email'], $email)) {
        $errors[] = "Adresse email invalide";
    }

    if (!preg_match($regex['password'], $_POST['password'])) {
        $errors[] = "Mot de passe trop faible";
    }

    if (!in_array($role, ['etudiant', 'enseignant'])) {
        $errors[] = "Rôle invalide";
    }

    if (!empty($errors)) {
        $message = implode("<br>", $errors);
    }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion | QuizMaster</title>
    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: coral;
            padding: 40px;
            width: 420px;
            box-shadow: black;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .hidden {
    display: none;
}
select {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    cursor: pointer;
}
.switch {
    background-color: cyan;
    height: 50px;
    border-radius: 16px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 15px;
    cursor: pointer;
}

        label {
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
        }
        .login-btn {
            width: 100%;
            padding: 14px;
            background: purple;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 16px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2 id="title">Connexion</h2>
    <p>Connectez-vous à votre compte</p>

    <?php if ($message): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <!-- LOGIN -->
    <form method="POST" id="loginForm">
        <input type="hidden" name="action" value="login">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="login-btn">Se connecter</button>
    </form>

    <!-- REGISTER -->
    <form method="POST" id="registerForm" class="hidden">
        <input type="hidden" name="action" value="register">
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>

        <select name="role" required>
            <option value="etudiant">Étudiant</option>
            <option value="enseignant">Enseignant</option>
        </select>

        <button type="submit" class="login-btn">Créer un compte</button>
    </form>

    <!-- SWITCH -->
    <div class="switch" onclick="toggle()">
        <span id="switchText">Créer un compte</span>
    </div>
</div>

<script>
function toggle() {
    document.getElementById('loginForm').classList.toggle('hidden');
    document.getElementById('registerForm').classList.toggle('hidden');

    const title = document.getElementById('title');
    const text = document.getElementById('switchText');

    if (title.innerText === "Connexion") {
        title.innerText = "Inscription";
        text.innerText = "Déjà un compte ? Connexion";
    } else {
        title.innerText = "Connexion";
        text.innerText = "Créer un compte";
    }
}
</script>
</body>
</html>
