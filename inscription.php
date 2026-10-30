<?php
declare(strict_types=1);

// Inclure la connexion à la BDD
require_once "models/Database.php";

$database = new \models\Database();
$pdo = $database->getPDOconnection();

// Déclaration de variables pour les messages
$error = "";
$success = "";

// Vérification de la soumission du formulaire
if (isset($_POST["btn_register_user"])) {

    // 1. Récupération et nettoyage des données
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_repeat = $_POST['password_repeat'] ?? '';

    // Valeur par défaut du rôle utilisateur
    $default_role = 1;

    // 2. Validation des données
    if (empty($email) || empty($password) || empty($password_repeat)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format d'email invalide.";
    } elseif ($password !== $password_repeat) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {

        // 3. Vérification de l'unicité de l'email
        try {
            $check = $pdo->prepare(
                'SELECT email_user FROM users WHERE email_user=?'
            );
            $check->execute(array($email));
            $row = $check->fetch();

            if ($row) {
                $error = "Cet email est déjà utilisé.";
            } else {

                // 4. Hachage sécurisé du mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // 5. Insertion dans la base de données
                $insert = $pdo->prepare(
                    'INSERT INTO users (email_user,password_user,role_user)
                     VALUES (:email,:password,:role)'
                );

                $insert->execute(array(
                    'email' => $email,
                    'password' => $hashed_password,
                    'role' => $default_role
                ));

                header("Location: connexion.php?inscription=ok");
                exit();
            }

        } catch (\PDOException $e) {
            $error = "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/minty/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/CSS/Style.css">

    <title>KFM Collection - Inscription</title>
</head>

<body>

<div class="container mt-5 shadow rounded p-4" style="max-width: 500px;">

    <h1 class="text-primary mb-3">Inscription</h1>
    <p class="text-muted">Créez votre compte KFM Collection.</p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">

        <div class="mt-3">
            <label for="email">Email</label>
            <input type="email" required class="form-control"
                   name="email" id="email">
        </div>

        <div class="mt-3">
            <label for="password">Mot de passe</label>
            <input type="password" required class="form-control"
                   name="password" id="password">
        </div>

        <div class="mt-3">
            <label for="password_repeat">Confirmez votre mot de passe</label>
            <input type="password" required class="form-control"
                   name="password_repeat" id="password_repeat">
        </div>

        <div class="mt-3">
            <button type="submit" name="btn_register_user" class="btn btn-info">
                S'inscrire
            </button>

                <a href="index.php" class="btn btn-secondary ml-2">
        Retour à l'accueil
    </a>
</div>
        </div>

    </form>
</div>

</body>
</html>
