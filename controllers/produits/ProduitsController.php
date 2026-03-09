<?php

namespace controllers\produits;

//Appel de la classe ProduitsModel.php du dossier models/produits
require_once __DIR__ . "/../../models/produits/ProduitsModel.php";

//Afficher tous les produits
function AfficherTousLesProduits(){
    //instance de la classe ProduitsModels stockée dans une variable
    $produits_model= new \models\produits\ProduitsModel();
    //appel de la méthode DisplayAllProduits() de la classe ProduitsModel.php pour récupérer tous les produits de la base de données
    $tous_les_produits=$produits_model -> DisplayAllProducts();
    //DEBUG SI BESOIN
    //var_dump($tous_les_produits);
    //La fonction retourne une variable qui stocke un tableau resultat de la requête SQL de la méthode DisplayAllProduits() de la classe ProduitsModel.php
    return $tous_les_produits;
}

//Afficher les détails d'un produit
function AfficherLesDetailsDuProduit(){
        //instance de la classe ProduitsModels stockée dans une variable
        $produits_model = new \models\produits\ProduitsModel();
        //La variable a accès au methode public du ProduitsModel
        $un_produit= $produits_model->DisplayProductDetails();
        //Debug si besoin
        //var_dump($un_produit);
        //La fonction retourne une variable qui stock le resultat de la requête SQL du model
        return $un_produit;
}

//Ajouter image
function handleUploadedImage(?array $file): ?string {
    if (empty($file) || !isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed, true)) {
        return null;
    }
    $ext= pathinfo($file['name'] ?? '', PATHINFO_EXTENSION);
    $name= uniqid ('prod_', true) . ($ext ? '.' . $ext :'');
    $base = defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__, 2);
    $destDir = rtrim($base, '/\\') . '/Assets/img/produits';
    if (!is_dir($destDir)) mkdir($destDir, 0755, true);
$dest = $destDir . '/' . $name;
if (move_uploaded_file($file['tmp_name'], $dest)){
    return $name;
}
return null;
}

//Ajouter un produit
function AjouterUnProduit(){
    //Instance de la classe ProduitsModels stockée dans une variable
    $produits_model = new \models\produits\ProduitsModel();
    //si le bouton de la vue n'est pas null et est cliquer => on effectue le traitement
    if(isset($_POST["btn-add-product"])){
        //champ du formulaire (on supprime les espaces et on luttle contre les failles)
        $name = trim($_POST["product_name"] ?? '');
        $desc = trim($_POST["product_description"] ?? '');
        $price = floatval($_POST["product_price"] ?? 0);

        //traitement de l'image uploadée
        $imageName = handleUploadedImage($_FILES['product_image'] ?? null);

        //Appel de la méthode du modèle avec ses paramètres
        $produits_model->AddProduct(
            $name,
            $desc,
            $price,
            $imageName
        );
            header("Location: ?url=afficher-produit");
            exit;
    }}

    //Supprimer un produit par ID
    function SupprimerProduitParID(){
        //instance de la classe ProduitsModels stockée dans une variable
        $produits_model= new \models\produits\ProduitsModel();
    if(isset($_GET['id_produit'])){
        // le modèle lit $_GET['id'] déjà -> on appelle directement
        return $produits_model->DeleteProductById();
    }
    return false;
    }

//Editer un produit
function EditerUnProduit(){
    //Instance de la classe ProduitsModels stockée dans une variable
    $produits_model = new \models\produits\ProduitsModel();
    //Si le bouton de la vue n'est pas null et est cliquer =>on effectue le traitement
    if(isset($_POST["btn-edit-product"])){
        //champs du formulaire (on supprime les espaces et on lutte contre la faille xss)
        $name = trim($_POST["product_name"] ?? '');
        $desc = trim($_POST["product_description"] ?? '');
        $price = floatval($_POST["product_price"] ?? 0);
        $id= isset($_GET['id_produit']) ? (int)$_GET['id_produit'] : 0;
        if($id <= 0) return;

        //traitement de l'image uploadée (null si aucun upload)
        $imageName = handleUploadedImage($_FILES['product_image'] ?? null);


        //Appel de la méthode du modèle avec ses paramètres
            $produits_model->EditProduct(
            $name,
            $desc,
            $price,
            $id,
            $imageName
        );
            header("Location: ?url=afficher-produit&success=1");
            exit;
        }

    }


?>