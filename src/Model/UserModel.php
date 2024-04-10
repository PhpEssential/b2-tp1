<?php
namespace App\Model;

use PDO;
use App\Model\BaseModel;

class UserModel extends BaseModel {

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsersWithLimitOffsetAndSearch($limit, $offset, $search) {
        $searchTerm = '%' . $search . '%';
        
        // Fetch total count
        $totalStmt = $this->pdo->prepare("SELECT COUNT(*) FROM users");
        $totalStmt->execute();
        $total = $totalStmt->fetchColumn();
    
        // Fetch filtered count
        $filteredStmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE name LIKE ? OR email LIKE ?");
        $filteredStmt->execute([$searchTerm, $searchTerm]);
        $filtered = $filteredStmt->fetchColumn();
    
        // Fetch users with limit, offset, and search parameters
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE name LIKE :search OR email LIKE :search LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':search', $searchTerm);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return [
            'total' => $total,
            'filtered' => $filtered,
            'users' => $users
        ];
    }

    public function createUser($name, $email, $password, $role) {
        $stmt = $this->pdo->prepare("INSERT INTO users (`name`, email, `password`, `role`) VALUES (:name, :email, :password, :role)");
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':role', (int) $role, PDO::PARAM_INT);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $name, $email, $role) {
        $stmt = $this->pdo->prepare("UPDATE users SET `name` = :name, email = :email, `role` = :role WHERE id = :id");
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':role', (int) $role, PDO::PARAM_INT);
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>