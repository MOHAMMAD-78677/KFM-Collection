<?php
declare(strict_types=1);

namespace models;

use PDO;
//2710
require_once __DIR__ . '/Database.php';

class Model {
    protected PDO $db;

    public function __construct()
    {   
        $database = new Database();
        $this->db = $database->getPDOconnection();
    }
}