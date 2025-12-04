<?php
declare(strict_types=1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assets/CSS/bootstrap.css">
    <title>1er doc php</title>
</head>
<body>

<?php
$host="localhost";
$dbname="base_test";
$user="root";
$password="";
try {
    // Instance de la classe PDO + hote + nom de la BDD + encodage des caractères EUROPE + user PhpMyAdmin + MDP PhpMyAdmin
    $bdd_connexion=new PDO ("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$password);
    echo "Connexion à la base de donnéees base_test : SUCCES!";
} catch (PDOException $e) {
    //Erreur de connexion à PDO MySQL
    echo "Erreur de connexion à PDO MySQL!" .$e->getMessage();
}


//récuperer les donnéees en fonction de l'ID du produit
$sql="SELECT * FROM produits WHERE id_produit=?";
//Crer une requête préparée pour éviter les injections SQl
$query=$bdd_connexion->prepare($sql);
//récuperer la valeur de l'ID dans l'URL
$id_produit=$_GET["id_produit"];
//Debug de l'id_produit concerné
var_dump($id_produit);

//lié l'id de l'url à la requête = bind params
$query->bindParam(1,$id_produit);
//Executer la requête
$query->execute();
//Parcourir le resultat avec la fonction fetch () PHP
$produit=$query->fetch();
?>
<div class="container">
    <form action="" method="POST">
<div class="mt-3">
    <input type="text" name="nom_produit" placeholder="<?= $produit["nom_produit"] ?>" class="form-control">
</div>
<div class="mt-3">
    <textarea name="description_produit" rows="5" class="form-control">
        <?= $produit ["description_produit"] ?>
    </textarea>
</div>
<div class="mt-3">
    <input type="number" step="0.01" name="prix_produit" placeholder="<?= $produit["prix_produit"]?>" class="form-control">
</div>
<button type="submit" class="btn btn-secondary" name="bouton_editer">Editer le produit</button>
<br>
<a href="index.php" class="btn btn-success">Retour</a>
    </form>
</div>

<?php 
//Test de validation du formulaire => on recupere l'attribut name du bouton de validation
if(isset($_POST['bouton_editer'])){
    //on recupère l'id du produit passée dans l'url => ci-dessus $id_produit=$_GET["id_produit"];
    $sql="UPDATE produits SET nom_produit=?, description_produit=?, prix_produit=? WHERE id_produit=?";
    //Créer une requête préparée pour éviter les injections SQl
    $query=$bdd_connexion->prepare($sql);
    //on lie les valeurs des champs du formulaire aux champs de la table via bindParam SQL
    $query->bindParam(1,$_POST['nom_produit']);//Le 1er ? =<input name="nom_produit">
    $query->bindParam(2,$_POST['description_produit']);//Le 2eme ? =<textarea name="description_produit">
    $query->bindParam(3,$_POST['prix_produit']);//Le 3
    $query->bindParam(4,$id_produit);
    //Executer la requête
    try{
        $query->execute();
        //si cela marche ==> on appel un alert js + une redirection PHP
        ?>
        <script>
            alert("Votre produit a bien été mis à jour !");
            window.location.href = 'index.php';
        </script>
        <?php
    } catch (PDOException $e) {
        //Erreur de connexion à PDO MySQL
        echo "Erreur lors de la mise à jour du produit!" .$e->getMessage();
    }}
    ?>

</body>
</html>