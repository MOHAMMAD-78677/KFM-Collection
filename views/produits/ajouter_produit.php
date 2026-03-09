<?php
declare(strict_types=1);

?>



<div class="container shadow w-50 rounded mt-5 p-3">
    <h1 class="text-warning">Ajouter un produit</h1>
    <h2 class="test-success">Remplir le formulaire</h2>
    <form action="?url=ajouter_produit" method="POST" enctype="multipart/form-data">
<div class="mt-3">
    <input type="text" name="product_name" placeholder="Nom du produit" class="form-control">
</div>
<div class="mt-3">
    <textarea name="product_description" class="form-control" rows="6"></textarea>
</div>
<div class="mt-3">
    <input type="number" step="0.01" name="product_price" class="form-control">
</div>
<div class="mt-3">
    <input type="file" name="product_image" accept="image/*" class="form-control">
</div>
<button type="submit" class="btn btn-success" name="btn-add-product">Ajouter le produit</button>
<a href="index.php" class="btn btn-secondary">Retour</a>
    </form>
</div>

