<?php
declare(strict_types=1);
?>

<?php
$host="localhost";
$dbname="base_test";
$user="root";
$password="";
try {
    // Instance de la classe PDO + hote + nom de la BDD + encodage des caractères EUROPE + user PhpMyAdmin + MDP PhpMyAdmin
    $bdd_connexion=new PDO ("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$password);
    //debug
    $bdd_connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //echo de debug
    echo "Connexion à la base de donnéees base_test : SUCCES!";
} catch (PDOException $e) {
    //Erreur de connexion à PDO MySQL
    echo "Erreur de connexion à PDO MySQL!" .$e->getMessage();
}
?>