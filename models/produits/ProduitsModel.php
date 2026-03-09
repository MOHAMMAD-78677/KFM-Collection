<?php 
namespace models\produits;
//Appel de la classe parente models/Database.php dont ProduitsModel hérite
//Elle aura accès après instance au méthode de la classe Database.php pour la connexion à la base de données

use models\Database;
use PDO;

require_once __DIR__ . "/../Database.php";

class ProduitsModel extends Database
{
    //Les  variables ont toutes un accès privé (encapsulation) pour éviter les accès directs depuis l'extérieur de la classe,
    //donc elles sont accessibles uniquement à l'interieur de la classe parente et de ses méthodes
    private int $id_produit;
    private string $nom_produit;
    private string $description_produit;
    private float $prix_produit;
    
    //Accès à la BDD, la variable de classe $connexion est protégée et accessible uniquement via les méthodes de la classe parente Database.php
    private PDO $db;
    
    /*on utilise un constructeur pour initialiser la connexion à la base de données via la méthode getPDOconnection() 
    de la classe parente Database.php*/
    public function __construct()
    {
        //instante de la class parente
        $connexion= new Database();
        //appel de la méthode getPDOconnection() de la classe parente pour établir la connexion à la base de données
        $this->db=$connexion->getPDOconnection();
        //debug si besoin:
        //var_dump($this->db);
    }

//Afficher les produits => cette méthode sera appelée par le controlleur ProduitsController.php et retourne à la vue
public function DisplayAllProducts(){
    //La requête SQL pour sélectionner tous les produits de la table produits
    $sql="SELECT * FROM produits";
    //La requête préparée pour éviter les injections SQL
    $statement=$this->db->prepare($sql);
    //Exécuter la requête
    $statement->execute();
    //stocker le résultat de la requête dans une variable
    $products=$statement->fetchAll();
    //La variable est retournée par la méthode et sera récupérée par le controlleur pour être envoyée à la vue
    return $products;
}


//Afficher détails produits => cette méthode sera appelée par le controller ProduitsController.php

public function DisplayProductDetails(){
//La requête SQL avec un paramètre id dans URL
$sql= "SELECT * FROM produits WHERE id_produit =?";
//La requête préparée => lutte contre les injections SQL
$statement=$this->db->prepare($sql);
//Recuperer le paramètre ID passer dans l'url depuis la page afficher_produit.php
$this->id_produit = $_GET["id_produit"];
//Lier le paramètre id de l'URL a id_produit de la requête SQL
$statement->bindParam(1,$this->id_produit);
//Executer la requête
$statement->execute();
//Stocker le resultat de la requête dans une variable
$product_details= $statement->fetch();
//debug si besoin
//var_dump($product_details);
//Ma méthode retourne la variable qui sera utilisée dans ProduitsController
return $product_details;
}

//Ajouter produit
public function AddProduct(
    string $nom,
    string $desc,
    float $prix,
    ?string $image = null){
//Les paramètres valent les variable privée locale
$this->nom_produit=$nom;
$this->description_produit=$desc;
$this->prix_produit=$prix;


    // utiliser une valeur par défaut si $image est null
    $imageToSave = $image ?? 'not_found.jpg';

//La requête SQL
$sql = "INSERT INTO produits (nom_produit, description_produit, prix_produit, produit_image) VALUES (?,?,?,?)";
//La requête préparée pour lutter contre les injections SQL
$statement = $this->db->prepare($sql);
return $statement->execute([
    $nom,
    $desc,
    $prix,
    $imageToSave
]);
}

//supprimer un produit à l'aide de son ID
public function DeleteProductById(){
    //la requête SQL
    $sql= "DELETE FROM produits WHERE id_produit= ?";
    //connexion à la BDD et la requête préparée => lutte contre les injections SQL
    $statement = $this->db->prepare($sql);
    //Recuperer le paramètre ID passer dans l'url depuis la page afficher-produit.php
    $this->id_produit = $_GET["id_produit"] ?? 0;
    //Lier le paramètre id de l'url a id_produit de la requête SQL
    $statement->bindParam(1,$this->id_produit);
    //Executer la requête
    $statement->execute();
}

//Editer un produit => on passe en paramètre de la fonction tous les champs du formulaire
//Ces derniers seront envoyé au controlleur pares instance

public function EditProduct(string $nom, string $desc, float $prix, int $id, ?string $image = null){
    if ($image !== null) {
        $sql = "UPDATE produits SET nom_produit=?, description_produit=?, prix_produit=?, produit_image=? WHERE id_produit=?";
        $params = [$nom, $desc, $prix, $image, $id];
    } else {
        $sql = "UPDATE produits SET nom_produit=?, description_produit=?, prix_produit=? WHERE id_produit=?";
        $params = [$nom, $desc, $prix, $id];
    }
    $stmt = $this->db->prepare($sql);
    return $stmt->execute($params);
}

}
?>

