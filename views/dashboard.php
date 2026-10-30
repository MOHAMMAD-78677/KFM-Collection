
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier que l'utilisateur est administrateur
if (
    !isset($_SESSION['user_id']) ||
    (int) ($_SESSION['user_role'] ?? 0) !== 2
) {
    http_response_code(403);
    exit("Accès réservé à l'administrateur.");
}

// Connexion à la base de données
require_once BASE_PATH . "/models/Database.php";

$database = new \models\Database();
$pdo = $database->getPDOconnection();

// Nombre total de produits
$nombreProduits = $pdo
    ->query("SELECT COUNT(*) FROM produits")
    ->fetchColumn();

// Nombre total d'utilisateurs
$nombreUtilisateurs = $pdo
    ->query("SELECT COUNT(*) FROM users")
    ->fetchColumn();
?>

<div class="container mt-5">

    <h1 class="text-primary mb-3">
        Tableau de bord administrateur
    </h1>

    <p>
        Bienvenue dans l'administration de KFM Collection.
    </p>

    <!-- Statistiques -->
    <div class="row mt-4">

        <!-- Nombre de produits -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">

                    <h5 class="card-title">
                        Nombre de produits
                    </h5>

                    <h2 class="text-primary">
                        <?= (int) $nombreProduits ?>
                    </h2>

                    <a href="<?= BASE_URL ?>/index.php?url=afficher-produit"
                       class="btn btn-primary">
                        Voir les produits
                    </a>

                </div>
            </div>
        </div>

        <!-- Nombre d'utilisateurs -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">

                    <h5 class="card-title">
                        Nombre d'utilisateurs
                    </h5>

                    <h2 class="text-primary">
                        <?= (int) $nombreUtilisateurs ?>
                    </h2>

                    <p class="text-muted">
                        Utilisateurs inscrits
                    </p>

                </div>
            </div>
        </div>

    </div>

    <!-- Gestion du catalogue -->
    <div class="card shadow-sm mt-4 mb-4">
        <div class="card-body">

            <h4 class="text-primary">
                Gestion du catalogue
            </h4>

            <p>
                Gérez les produits de KFM Collection.
            </p>

    <div class="d-flex flex-wrap" style="gap: 15px;">

        <a href="<?= BASE_URL ?>/index.php?url=afficher-produit"
class="btn btn-primary">
        Consulter les produits
        </a>

        <a href="<?= BASE_URL ?>/index.php?url=ajouter_produit"
class="btn btn-success">
        Ajouter un produit
        </a>

</div>

        </div>
    </div>

</div>
