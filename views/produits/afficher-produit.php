<?php
declare(strict_types=1);
?>

<h1 class="text-center my-4" style="color: darkblue;"> KFM Collection - Nos produits </h1>

<?php if(isset($_SESSION["success"])): ?>

<div class="alert alert-success">
    <?= $_SESSION["success"]; ?>
</div>

<?php unset($_SESSION["success"]); ?>

<?php endif; ?>

<?php
if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success text-center">
        Modification du produit réussie !
    </div>
<?php endif; ?>


<div class="container">
    <div class="row justify-content-start g-4">

    <?php

    ?>




<?php
//boucle de parcours du tableau de produits stocké dans la variable $tous_les_produits
foreach($tous_les_produits as $row): 
        $imageToShow = !empty($row["produit_image"]) ? $row["produit_image"] : 'not_found.jpg';
?>
    <!-- les champs de la table-->
     <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
        <div class="card h-100 w-100">
            <img src="<?=  BASE_URL ?>/Assets/img/produits/<?= htmlspecialchars($imageToShow) ?>" class="card-img-top" alt=" <?= htmlspecialchars($row["nom_produit"]) ?>" title="<?= htmlspecialchars($row["nom_produit"]) ?>">
        <div class="card-body d-flex flex-column">
            <?php
            $nomProduit = $row["nom_produit"];
            $shortNom = strlen($nomProduit) > 70
                ? substr($nomProduit, 0, 70) . "..."
                : $nomProduit;
            ?>
            <h5 class="card-title product-title"><?= htmlspecialchars($shortNom) ?></h5>
            <?php
            $description = $row["description_produit"];
            $shortDescription = strlen($description) > 100
                ? substr($description, 0, 100) . "..."
                : $description;
            ?>
            <p class="card-text">
                <?=  htmlspecialchars($shortDescription) ?>
            </p>
            <p> Prix : <?= $row["prix_produit"] ?> € </p>
            <div class="mt-auto">
            <a href="?url=details_produit&id_produit=<?= $row["id_produit"] ?>" class="btn btn-primary w-100 ">plus d'information</a>
        </div>
        </div>
        </div>

    </div>
<?php endforeach ?>

</div>
</div>

<div class="text-bottom">
            <a href="ajouter_produit" class="btn btn-success mb-3">Ajouter un produit</a>
        </div>


