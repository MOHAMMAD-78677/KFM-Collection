<?php
declare(strict_types=1);
//1.Demarrer la session pour enregistrer l'utilisateur
session_start();


//inclure la connexion a la BDD
require_once "models/Database.php";

$database = new \models\Database();
$pdo=$database->getPDOconnection();

//déclaration de variables pour les messages
$error="";

//Vérification de la soumission du formulaire
if(isset($_POST["btn_login"])){
    //2. Récupération et nettoyage des données du formulaire
    //on utiliser trim() pour supprimer les espaces inutiles autoir
    $email=trim($_POST['email']);
    $password=$_POST['password'];

    //3.Validation des données
    if(empty($email) || empty($password)){
        $error="Veuillez entrer votre email et votre mot de passe!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error="Format d'email invalide.";
    } else {
    
    //4.rechercher l'utilisateur dans la BDD
    try{
        //utiliser une requête préparée pour la sécurité
        $check=$bdd_connexion->prepare("SELECT id_user, email_user, password_user, role_user FROM users WHERE email_user=?");
        $check->execute (array($email));
        $user=$check->fetch(PDO::FETCH_ASSOC);
    
    //vérifier si un utilisateur a été trouvé
    if ($user){
    
    //5.vérification du  mot de passe haché (étape cruciale)
    //utiliser password_verify() pour comparer le mot de passe saisi 
    //avec le haché stocké dans la colonne 'password_user'
    if (password_verify($password, $user['password_user'])){
        //mdp correct -> Connexion réussie
        //Enregistrer les informations de l'utilisateur dans la session
        $_SESSION['user_id']=$user['id_user'];
        $_SESSION['user_email']=$user['email_user'];
        $_SESSION['user_role']=$user['role_user'];
        
        //Redirection vers la page d'accueil ou tableau de bord
        //vous pouvez adopter la redirection selon le rôle
        if ($user['role_user'] == 1){
            //Utilisateur standard
            header("Location: tableau_de_bord.php");
        } else {
            header ("Location : index.php");
        }
        exit();

    } else {
        //mot de passe incorrect
        $error="Mot de passe incorrect.";
    } 
}else {
        //aucun utilisateur trouvé avec cet email
        $error="Email incorrect.";
    }}     
        catch (PDOException $e) {
        //Gestion des erreurs PDO
        $error="Erreur lors de la connexion: " . $e->getMessage();
    }
}
}
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
    <div class="container mt-5 shadow rounded w-25 p-3"></div>
    <h1 class="text-primary">Connexion</h1>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

    <form action="" method="POST">
        <div class="mt-3">
            <label for="email">Email</label>
            <input type="email" required class="form-control" name="email" id="email"
            value="<?= htmlspecialchars($_POST['email']??"")?>">
        </div>
        <div class="mt-3">
            <label for="password">Mot de passe</label>
            <input type="password" required class="form-control" name="password" id="password">
        </div>
        <div class="mt-3">
            <button type="submit" name="btn_login" class="btn btn-primary">Se connecter</button>
        </div>
    </form>
</div>
</body>
</html>