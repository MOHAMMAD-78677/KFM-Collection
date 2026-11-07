<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/minty/bootstrap.min.css"> -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/Assets/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/CSS/Style.css">
    <!--en priorité le fichier suivant sera utilisé pour le style, sinon on utilisera celui de bootswatch-->
    <title><?= $title?></title>
    <!--Le titre de la page est dynamique, il est défini dans les vues et affiché dans le template-->
</head>
<body>
    <nav class="p-3 d-flex align-items-center flex-wrap">

    <a href="<?= BASE_URL ?>/">Accueil</a>

    <?php if (isset($_SESSION['user_id'])): ?>

        <span class="mx-3">
            Bonjour,
            <?= htmlspecialchars($_SESSION['user_email']) ?>
        </span>

        <a href="<?= BASE_URL ?>/deconnexion">
            Se déconnecter
        </a>
    <?php if (
    isset($_SESSION['user_id']) &&
    (int) ($_SESSION['user_role'] ?? 0) === 2
): ?>
    <a class="ml-auto" href="<?= BASE_URL ?>/index.php?url=dashboard">
        Tableau de bord
    </a>
<?php endif; ?>
    <?php else: ?>

        <a href="<?= BASE_URL ?>/inscription" class="mx-3">
            S'inscrire
        </a>

        <a href="<?= BASE_URL ?>/connexion">
            Se connecter
        </a>

    <?php endif; ?>

    </nav>
    <div class="container-fluid">
        <!--Le contenu de la page est dynamique, il est défini dans les vues et affiché dans le template-->
        <?= $content?>
    </div>  
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="<?= BASE_URL ?>/Assets/JS/bootstrap.bundle.min.js"></script>
</body>
</html>