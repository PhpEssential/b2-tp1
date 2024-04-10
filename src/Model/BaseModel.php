<?php
namespace App\Model;

use PDO;

class BaseModel {
    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

}