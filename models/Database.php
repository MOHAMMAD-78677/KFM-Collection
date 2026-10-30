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
        $this->connexion = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->db_user, $this->db_password);
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $this->connexion;
    } catch (\PDOException $e) {
        // Écrire le détail dans un log serveur, et renvoyer une erreur non détaillée à l’utilisateur
        error_log('[Database] ' . $e->getMessage());
        throw new \RuntimeException('Impossible de se connecter à la base de données. Veuillez réessayer plus tard.');
    }
}
}
?>