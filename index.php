<?php
declare(strict_types=1);
require_once "db_connexion.php";
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
?>
    <div class="d-flex gap-3 mt-3">
    <a href="inscription.php" class="btn btn-success w-20">Inscription</a>
    <a href="connexion.php" class="btn btn-success w-20">Connexion</a>
</div>

<?php
//Ecrire la rêquete SQL
$sql=$bdd_connexion->query("SELECT * FROM produits");
//Debug de la variable
var_dump($sql);
//Boucle de parcours du tableau
foreach($sql as $row){
    //afficher le champs de la table
    ?>



<div class="container">
    <ul class = "list-group">
    <li class= "list-group-item">ID du produit : <?= $row ["id_produit"] ?> </li>
    <li class= "list-group-item">Nom du produit : <?= $row ["nom_produit"] ?></li>
    <li class= "list-group-item">Description du produit : <?= $row ["description_produit"] ?></li>
    <li class= "list-group-item">Prix du produit : <?= $row ["prix_produit"] ?></li>
    <li class= "list-group-item">
        <a href="details_produit.php?id_produit=<?= $row["id_produit"] ?>" class="btn btn-info">Détails du produit</a>
    </li>
</ul>
</div>

<?php
}
?>
<?php
//rajouter car supprimer_produit.php -> header ne fonctionne pas seul
// redirection vers index sans paramètres windows location href

if(isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    $id_produit = htmlspecialchars($_GET['id']);
    echo "<script>
        alert('Produit supprimé avec succès ! ID : $id_produit');
        window.location.href = 'index.php';
    </script>";
}
?>

<div class="container">
    <a href="ajouter_produit.php" class="btn btn-success">Ajouter un produit</a>
</div>
<br><br>

</body>
</html>