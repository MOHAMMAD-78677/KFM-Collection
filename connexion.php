<?php
declare(strict_types=1);

// 1. Démarrer la session pour enregistrer l'utilisateur
session_start();

// Inclure la connexion à la BDD
require_once "models/Database.php";

$database = new \models\Database();
$pdo = $database->getPDOconnection();

// Déclaration de variable pour les messages
$error = "";

// Vérification de la soumission du formulaire
if (isset($_POST["btn_login"])) {

    // 2. Récupération et nettoyage des données
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // 3. Validation des données
    if (empty($email) || empty($password)) {
        $error = "Veuillez entrer votre email et votre mot de passe !";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format d'email invalide.";
    } else {

        // 4. Rechercher l'utilisateur dans la BDD
        try {
            $check = $pdo->prepare(
                "SELECT id_user, email_user, password_user, role_user
                 FROM users WHERE email_user=?"
            );

            $check->execute(array($email));
            $user = $check->fetch(\PDO::FETCH_ASSOC);

            // 5. Vérifier le mot de passe
            if ($user) {

                if (password_verify($password, $user['password_user'])) {

                    // Enregistrer les informations dans la session
                    session_regenerate_id(true);

                    $_SESSION['user_id'] = $user['id_user'];
                    $_SESSION['user_email'] = $user['email_user'];
                    $_SESSION['user_role'] = $user['role_user'];

                    // Redirection vers l'accueil
                    header("Location: index.php");
                    exit();

                } else {
                    $error = "Mot de passe incorrect.";
                }

            } else {
                $error = "Email incorrect.";
            }

        } catch (\PDOException $e) {
            $error = "Erreur lors de la connexion.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/minty/bootstrap.min.css">

    <link rel="stylesheet" href="Assets/CSS/Style.css">

    <title>KFM Collection - Connexion</title>
</head>

<body>

<div class="container mt-5 shadow rounded p-4" style="max-width: 500px;">

    <h1 class="text-primary">Connexion</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['inscription']) && $_GET['inscription'] === 'ok'): ?>
        <div class="alert alert-success">
            Inscription réussie ! Vous pouvez maintenant vous connecter.
        </div>
    <?php endif; ?>

    <form action="" method="POST">

        <div class="mt-3">
            <label for="email">Email</label>
            <input type="email"
                   required
                   class="form-control"
                   name="email"
                   id="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="mt-3">
            <label for="password">Mot de passe</label>
            <input type="password"
                   required
                   class="form-control"
                   name="password"
                   id="password">
        </div>

        <div class="mt-3">
            <button type="submit" name="btn_login" class="btn btn-primary">
                Se connecter
            </button>

            <a href="index.php" class="btn btn-secondary ml-2">
                Retour à l'accueil
            </a>
        </div>

    </form>

</div>

</body>
</html>
