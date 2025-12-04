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

$sql="DELETE FROM produits WHERE id_produit=?";
//Créer une requête préparée pour éviter les injections SQl
$query=$bdd_connexion->prepare($sql);
//récuperer la valeur de l'ID dans l'URL grâce à la superglobale $_GET
$id_produit=$_GET["id_produit"];
//lié les id de l'url à la requête = bind params
$query->bindParam(1,$id_produit);

//Executer la requête
try{
    $query->execute();
    //Redirection vers la page index.php après la suppression
//Si ça marche => on appel un alert js + une redirection PHP_ROUND_HALF_DOWN
?>
<script>
    alert("Confirmer la supression du produit :<?= $id_produit ?>!");
</script>
<?php
    //header("Location:index.php"); header n'affiche pas l'alerte
     // Redirection vers index.php avec GET pour afficher l’alerte
    header("Location:index.php?deleted=1&id=$id_produit");
    exit;
} catch (PDOException $e) {
    //Erreur de connexion à PDO MySQL
    echo "Erreur de suppression du produit!" .$e->getMessage();
}
?>
</body>
</html>