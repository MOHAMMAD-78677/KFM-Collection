<?php
declare(strict_types=1);


//debug si besoin
//var_dump($produit);

?>

<div class="container">
    <h1 class="text-info text-center"><?= htmlspecialchars((string)$produit["nom_produit"] ?? "Produit inconnu") ?></h1>
</div>
<div class="container">
    <ul class="list-group">
        <li class="list-group">
            <div class="text-center">
                <?php 
                $img = htmlspecialchars((string)$produit['produit_image'] ?? 'not_found.jpg');
                $base = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '/projet%20php';
                echo '<img src="' . $base . '/Assets/img/produits/' .$img  .'" class="img-fluid" width="25%" alt="' . htmlspecialchars((string)$produit["nom_produit"] ?? '') .'" title="' . htmlspecialchars((string)$produit["nom_produit"] ?? '') . '">';
            ?>
            </div>
        </li> 
    <li class= "list-group-item id-color">ID du produit : <?= $produit ["id_produit"] ?> </li>
    <!-- <li class= "list-group-item product-title">Nom du produit : <?= $produit ["nom_produit"] ?></li> -->
    <!-- <li class= "list-group-item">Description du produit : <?= $produit ["description_produit"] ?></li> -->
        <li class="list-group-item">
    Description du produit :
    <?= nl2br(htmlentities($produit["description_produit"] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')) ?>
    </li>
    <li class= "list-group-item">Prix du produit : <?= $produit ["prix_produit"] ?></li>
    <li class= "list-group-item">
        <a class="btn btn-info" href="?url=editer_produit&id_produit=<?=  $produit["id_produit"] ?>"> Editer le produit </a>
    </li>
    <li class= "list-group-item">
        <a class="btn btn-danger" href="?url=supprimer_produit&id_produit=<?= $produit ["id_produit"] ?>"onclick="return confirm('Confirmer la suppression ?')">
            Supprimer le produit
        </a>
    </li>
    <li class="list-group-item">
    <a class="btn btn-success" href="?url=afficher-produit">Retour</a>
    </li>
</ul>
</div>

