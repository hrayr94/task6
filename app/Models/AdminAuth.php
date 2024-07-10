<?php

namespace App\Models;

use PDO;
use PDOException;

class AdminAuth
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function login($username, $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM admin WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && $password === $admin['password']) {
                $_SESSION['user'] = [
                    'id' => $admin['id'],
                    'username' => $admin['username'],
                ];
                return true;
            }
        } catch (PDOException $e) {
            echo "Login failed: " . $e->getMessage();
        }

        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }
}
?>
