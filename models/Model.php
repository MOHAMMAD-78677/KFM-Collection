<?php
declare(strict_types=1);

namespace models;

use PDO;

class Model {
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}