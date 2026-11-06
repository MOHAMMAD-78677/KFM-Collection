<?php
declare(strict_types=1);

// Debug si besoin
// var_dump($produit);
?>

<div class="container">
    <h1 class="text-info text-center">
        <?= htmlspecialchars((string)($produit["nom_produit"] ?? "Produit inconnu")) ?>
    </h1>
</div>

<div class="container">
    <ul class="list-group">
        <li class="list-group">
            <div class="text-center">
                <?php
                $img = htmlspecialchars((string)($produit['produit_image'] ?? 'not_found.jpg'));
                $base = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';

                echo '<img src="' . $base . '/Assets/img/produits/' . $img .
                    '" class="img-fluid" width="25%" alt="' .
                    htmlspecialchars((string)($produit["nom_produit"] ?? '')) .
                    '" title="' .
                    htmlspecialchars((string)($produit["nom_produit"] ?? '')) . '">';
                ?>
            </div>
        </li>

        <li class="list-group-item id-color">
            ID du produit : <?= $produit["id_produit"] ?>
        </li>

        <!--
        <li class="list-group-item product-title">
            Nom du produit : <?= $produit["nom_produit"] ?>
        </li>
        -->

        <li class="list-group-item">
            Description du produit :
            <?php
            $description = $produit["description_produit"] ?? '';

            for ($i = 0; $i < 5; $i++) {
                $decoded = html_entity_decode(
                    $description,
                    ENT_QUOTES | ENT_HTML5,
                    'UTF-8'
                );

                if ($decoded === $description) {
                    break;
                }

                $description = $decoded;
            }
            ?>

            <?= nl2br(htmlspecialchars($description, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')) ?>
        </li>

        <li class="list-group-item">
            Prix du produit : <?= $produit["prix_produit"] ?>
        </li>

        <!-- Boutons réservés aux utilisateurs connectés -->
        <?php if (isset($_SESSION['user_id'])): ?>

            <li class="list-group-item">
                <a class="btn btn-info"
                href="?url=editer_produit&id_produit=<?= (int)$produit["id_produit"] ?>">
                Editer le produit
                </a>
            </li>

            <li class="list-group-item">
                <form action="?url=supprimer_produit" method="POST"
                      onsubmit="return confirm('Confirmer la suppression ?')">

                    <input type="hidden" name="id_produit"
                           value="<?= (int)$produit['id_produit'] ?>">

                    <input type="hidden" name="csrf_token"
                           value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                    <button type="submit" class="btn btn-danger">
                        Supprimer le produit
                    </button>
                </form>
            </li>

        <?php endif; ?>
        <!-- Fin des boutons réservés -->

        <li class="list-group-item">
            <a class="btn btn-secondary" href="?url=afficher-produit">
                Retour
            </a>
        </li>
    </ul>
</div>

<div style="height: 40px;"></div>