<?php
declare(strict_types=1);
?>
<link rel="stylesheet" href="Assets/CSS/bootstrap.css">

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

//Ecrire la rêquete SQL avec le prediquat WHERE + cle de l'url soit :
/*
    <a href="details_produit.php?id_produit=<?= $row["id_produit"] ?>" class="btn btn-info">Détails du produit</a>
*/
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
    //Afficher les champs de la table
    ?>

<div class="container">
    <ul class = "list-group">
    <li class= "list-group-item">ID du produit : <?= $produit ["id_produit"] ?> </li>
    <li class= "list-group-item">Nom du produit : <?= $produit ["nom_produit"] ?></li>
    <li class= "list-group-item">Description du produit : <?= $produit ["description_produit"] ?></li>
    <li class= "list-group-item">Prix du produit : <?= $produit ["prix_produit"] ?></li>
    <li class= "list-group-item">
        <a href="index.php" class="btn btn-danger">Retour</a>
    </li>
    <li class= "list-group-item">
        <a class="btn btn-warning" href="supprimer_produit.php?id_produit=<?= $produit ["id_produit"] ?>">Supprimer</a>
    </li>
</ul>
</div>

<li class="list-group-item">
    <a class="btn btn-info" href="editer_produit.php?id_produit=<?= $produit ["id_produit"] ?>">Éditer</a>
</li>

<?php
?>
</body>
</html>