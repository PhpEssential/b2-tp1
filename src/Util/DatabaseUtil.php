<?php
namespace App\Util;

use PDO;
use PDOException;

class DatabaseUtil {
    static function databaseConnection() {
        $host = 'localhost';
        $dbname = 'article_management';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Connexion échouée: " . $e->getMessage());
        }
    }
} 
?>