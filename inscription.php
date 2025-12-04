<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>

<?php
//inclure la connexion a la BDD
require_once 'db_connexion.php';

//déclaration de variables pour les messages
$error="";
$success="";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assets/CSS/bootstrap.css">
    <title>Document</title>
</head>

<body>
<div class="container">
    <form action="" method="post">
    <div class="mt-3">
        <label for="email">Email</label>
        <input type="email" required class="form-control" name="email" id="email">
    </div> 
    <div class="mt-3">
        <label for="password">Mot de passe</label>
        <input type="password" required class="form-control" name="password" id="password">
    </div> 
    <div class="mt-3">
        <label for="password_repeat">Mot de passe</label>
        <input type="password" required class="form-control" name="password_repeat" id="password_repeat">
    </div>

    <div class="mt-3">
        <button type="submit" name="btn_register_user" class="btn btn-info">S'inscrire</button>
    </div>
    </form>
</div>


<?php
//vérification de la soumission du formulaire
if(isset($_POST["btn_register_user"])){

    //1. Récupération et nettoyage des données du formulaire
    //on utiliser trim() pour supprimer les espaces inutiles autoir
    $email=trim($_POST['email']);
    $password=$_POST['password'];
    $password_repeat=$_POST['password_repeat'];

    //valeur par défaut pour le rôle, correspondant à la colonne 'role_user' INT
$default_role=1;

//2.Validation des données
if (empty($email) || empty($password) || empty($password_repeat)) {
    $error="Tous les champs sont obligatoires.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error="Format d'email invalide."; 
} elseif ($password !== $password_repeat) {
    $error="Les mots de passe ne correspondent pas.";
} elseif (strlen($password) < 6){
    $error="Le mot de passe doit contenir au moins 6 caractères.";
} else {

//3. Vérification de l'unicité de l'email
try{
    //requête préparée pour éviter les injection SQL
    $check=$bdd_connexion->prepare('SELECT email_user FROM users WHERE email_user=?');
    $check->execute (array($email));
    $row=$check->fetch();

    if($row){
        $error="Cet email est déjà utilisé.";
    }else{
    
    //4.Hachage sécurisé du mot de passe
    $hashed_password=password_hash($password,PASSWORD_DEFAULT);

    //5.Insertion des données dans la base de données
    $insert=$bdd_connexion->prepare('INSERT INTO users (email_user,password_user,role_user) VALUES (:email,:password,:role)'
);
$insert->execute(array(
    'email'=>$email,
    'password'=>$hashed_password,
    'role'=>$default_role//vous pouvez ajuster cette valeur si besoin
));

$success="Inscription réussie! Vous pouvez maintenant vous connecter.";
//optionnel :redirection vers une page de connexion
//header("Location:login.php");
//exit;
    }
} catch (PDOException $e) {
    //Gestion des erreurs PDO
    $error="Erreur lors de l'inscription: " . $e->getMessage();

}
}
}
?>

<?php if(!empty($error)) echo '<div style="color:red;">'.$error.'</div>'; ?>
<?php if(!empty($success)) echo '<div style="color:green;">'.$success.'</div>'; ?>

</body>
</html>
