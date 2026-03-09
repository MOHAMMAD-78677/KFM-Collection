<?php
declare(strict_types=1); //typage des éléments du code pour éviter les erreurs de type
namespace models;

/* Colision de nom entre le code vous créer, les classes, fonctions ou constantes internes de PHP, ou celle de bibliothèques tierces.
la capacité de faire des alias ou de raccourcir des Noms_extrement_Long pour aider à la résolution du 1er problème et 
améliorer la lisibilité du code.*/ 
use PDO;
//importer la classe PDO de PHP pour la connexion à la base de données

class Database
{
//Pour l'encapsulation, on rend les propriétés privées pour éviter les accès directs depuis l'extérieur de la classe
//ces données sont sensibles et doivent être protégées, elles doivent être accessibles uniquement via des méthodes de la classe parente

private string $db_host="localhost";
private string $db_name="base_test";
private string $db_user="root";
private string $db_password="";

private PDO|bool $connexion=false;

//Les méthodes (fonctions dans une classe) ont une portée public et sont accessibles depuis l'extérieur de la classe 
//pour permettre l'interaction avec les objets créés à partir de cette classe    
public function getPDOconnection(){
    try{
        //instance de la classe PDO dans une variable de classe pour la réutiliser dans les autres méthodes
        // La pseudo-variable $this est dispo lorsqu'une méthode est appelée depuis un contexte objet
        //$this est la valeur de l'objet courant, elle permet d'accéder aux propriétés et méthodes de cet objet
        $this->connexion=new PDO ("mysql:host=" .$this->db_host. ";dbname=" .$this->db_name. ";charset=utf8",$this->db_user, $this->db_password);
        //on utiliser l'opérateur :: pour acceder au constante de la classe PDO et - ou des méthodes statiques de la classe PDO
        //ces constantes servent au debug de vos requête HTTP
        $this->connexion->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // // Removed the echo statement that was causing issues
        // echo '<div class="container mt-3 w-50 alert alert-success p-3">Connexion à la base de données réussie!</div>';
        //en cas de succès, la méthode retounr le booleen TRUE
        return $this->connexion;
        }catch (\PDOException $e){
            //en cas d'erreur, la méthode retourne le message d'erreur de PDO
            Echo "Erreur de connexion à la base de donnée via PDO!" . $e->getMessage();
            die(); //Alias de exit() pour arrêter l'exécution du script en cas d'erreur critique - avec un code d'état ou un message
        }
}
}
?>