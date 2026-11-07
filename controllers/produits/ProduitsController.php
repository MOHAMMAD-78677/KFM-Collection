<?php

namespace controllers\produits;

//Appel de la classe ProduitsModel.php du dossier models/produits
require_once __DIR__ . "/../../models/produits/ProduitsModel.php";

class ProduitsController {
//Afficher tous les produits
public function AfficherTousLesProduits(){
    //instance de la classe ProduitsModels stockée dans une variable
    $produits_model= new \models\produits\ProduitsModel();
    //appel de la méthode DisplayAllProduits() de la classe ProduitsModel.php pour récupérer tous les produits de la base de données
    $tous_les_produits=$produits_model -> getAllProducts();
    //DEBUG SI BESOIN
    //var_dump($tous_les_produits);
    //La fonction retourne une variable qui stocke un tableau resultat de la requête SQL de la méthode DisplayAllProduits() de la classe ProduitsModel.php
    return $tous_les_produits;
}

//Afficher les détails d'un produit
public function AfficherLesDetailsDuProduit(){
        //instance de la classe ProduitsModels stockée dans une variable
        $produits_model = new \models\produits\ProduitsModel();
        //La variable a accès au methode public du ProduitsModel
        $id = isset($_GET['id_produit']) ? (int) $_GET['id_produit'] : 0;
        $un_produit = $produits_model->getProductById($id);
        //Debug si besoin
        //var_dump($un_produit);
        //La fonction retourne une variable qui stock le resultat de la requête SQL du model
        return $un_produit;
}

//Ajouter image
public function handleUploadedImage(?array $file): ?string {
    if (empty($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
    return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
    exit("Erreur pendant l'envoi du fichier.");
    }
    
    if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
    exit("Image trop grande : 2 Mo maximum.");
}

$allowed = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
    'image/webp' => 'webp'
];

$mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);

if (!isset($allowed[$mime])) {
    exit("Format refusé : JPG, PNG, GIF ou WebP uniquement.");
}

$ext = $allowed[$mime];
    $name= uniqid ('prod_', true) . ($ext ? '.' . $ext :'');
    $base = defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__, 2);
    $destDir = rtrim($base, '/\\') . '/Assets/img/produits';
    if (!is_dir($destDir)) mkdir($destDir, 0755, true);
$dest = $destDir . '/' . $name;
if (move_uploaded_file($file['tmp_name'], $dest)){
    return $name;
}
exit("Impossible d'enregistrer l'image.");
}

//Ajouter un produit
public function AjouterUnProduit(){
    //Instance de la classe ProduitsModels stockée dans une variable
    $produits_model = new \models\produits\ProduitsModel();
    //si le bouton de la vue n'est pas null et est cliquer => on effectue le traitement
    if(isset($_POST["btn-add-product"])){
        if (
    !isset($_SESSION['csrf_token'], $_POST['csrf_token']) ||
    !is_string($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    exit("Action non autorisée.");
}
        //champ du formulaire (on supprime les espaces et on luttle contre les failles)
        $name = trim($_POST["product_name"] ?? '');
        $desc = trim($_POST["product_description"] ?? '');
        $price = floatval($_POST["product_price"] ?? 0);

        //traitement de l'image uploadée
        $imageName = $this->handleUploadedImage($_FILES['product_image'] ?? null);        //Appel de la méthode du modèle avec ses paramètres
        $produits_model->addProduct(
            $name,
            $desc,
            $price,
            $imageName
        );
            header("Location: ?url=afficher-produit");
            exit;
    }}

    //Supprimer un produit par ID
public function SupprimerProduitParID(){
        //instance de la classe ProduitsModels stockée dans une variable
        $produits_model= new \models\produits\ProduitsModel();
    if(isset($_POST['id_produit'])){
        // le modèle lit $_GET['id'] déjà -> on appelle directement
    $id = (int) $_POST['id_produit'];
    return $produits_model->deleteProduct($id);    }
    return false;
    }

//Editer un produit
public function EditerUnProduit(){
    //Instance de la classe ProduitsModels stockée dans une variable
    $produits_model = new \models\produits\ProduitsModel();
    //Si le bouton de la vue n'est pas null et est cliquer =>on effectue le traitement
    if(isset($_POST["btn-edit-product"])){
        if (
    !isset($_SESSION['csrf_token'], $_POST['csrf_token']) ||
    !is_string($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    exit("Action non autorisée.");
}
        //champs du formulaire (on supprime les espaces et on lutte contre la faille xss)
        $name = trim($_POST["product_name"] ?? '');
        $desc = trim($_POST["product_description"] ?? '');
        $price = floatval($_POST["product_price"] ?? 0);
        $id= isset($_GET['id_produit']) ? (int)$_GET['id_produit'] : 0;
        if($id <= 0) return;

        //traitement de l'image uploadée (null si aucun upload)
        $imageName = $this->handleUploadedImage($_FILES['product_image'] ?? null);
        
        //Appel de la méthode du modèle avec ses paramètres
            $produits_model->updateProduct(
            $id,
            $name,
            $desc,
            $price,
            $imageName
        );
            header("Location: ?url=afficher-produit&success=1");
            exit;
        }

    }

}
?>