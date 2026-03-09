<?php
declare(strict_types=1);

?>

<div class="container">
    <form method="POST" enctype="multipart/form-data">
<div class="mt-3">
    <input type="text" name="product_name" value="<?= htmlspecialchars((string)($produit['nom_produit'] ?? '')) ?>" class="form-control">
</div>
<div class="mt-3">
    <textarea name="product_description" rows="5" class="form-control">
        <?= htmlspecialchars((string)($produit['description_produit'] ?? '')) ?>
    </textarea>
</div>
<div class="mt-3">
    <input type="number" step="0.01" name="product_price" value="<?= htmlspecialchars((string)($produit['prix_produit'] ?? '')) ?>" class="form-control">
</div>
<div class="mt-3">
        <input type="file" name="product_image" accept="image/*" class="form-control">
        <small>Si vous ne téléversez rien, l'image actuelle sera conservée.</small>
    </div>
<br>
<button type="submit" 
class="btn btn-secondary" 
name="btn-edit-product" 
onclick="return confirm('Voulez-vous vraiment modifier ce produit ?')">
    Editer le produit
</button>
<br><br>
<a href="afficher-produits" class="btn btn-success">Retour</a>
    </form>
</div>

