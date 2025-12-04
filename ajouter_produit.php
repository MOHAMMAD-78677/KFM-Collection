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
?>

<div class="container">
    <form action="" method="POST">
<div class="mt-3">
    <input type="text" name="nom_produit" placeholder="Nom du produit" class="form-control">
</div>
<div class="mt-3">
    <textarea name="description_produit" rows="5" class="form-control"></textarea>
</div>
<div class="mt-3">
    <input type="number" step="0.01" name="prix_produit" placeholder="Prix du produit" class="form-control">
</div>
<button type="submit" class="btn btn-success" name="buton_ajouter">Ajouter le produit</button>
    </form>
</div>

<?php
//Test de validation du formulaire
if(isset($_POST['buton_ajouter'])){
    //On insert les 3 valeurs inconues ??? dans la table produits dans les champs nom_produit, description_produit, prix_produit
    //ID pdt généré automatiquement par la BDD en AUTO INCREMENT
    $sql="INSERT INTO produits (nom_produit,description_produit,prix_produit) VALUES (?,?,?)";
    //Créer une requête préparée pour éviter les injections SQl
    $query=$bdd_connexion->prepare($sql);
    //on lie les valeurs des champs du formulaire auux champs de la table via bindParam SQL
    $query->bindParam(1,$_POST['nom_produit']);//Le 1er ? =<input name="nom_produit>"
    $query->bindParam(2,$_POST['description_produit']);//Le 2eme ? =<textarea name="description_produit">
    $query->bindParam(3,$_POST['prix_produit']);//Le 3eme ? =<input name="prix_produit">
    //Executer la requête
    try{
        $query->execute();
        //si cela marche ==> on appel un alert js + une redirection PHP
    ?>
        <script>
            alert("Votre produit a bien été ajouté !");
            window.location.href = 'index.php';
        </script>"

    <?php
    } catch (PDOException $e) {
        //Erreur de connexion à PDO MySQL
        echo "Erreur lors de l'ajout du produit!" .$e->getMessage();
    }}
?>

<a href="index.php" class="btn btn-success">Retour</a>

</body>
</html>