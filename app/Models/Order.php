<?php

namespace App\Models;

use PDO;
use PDOException;

class Order
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM orders");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching orders: " . $e->getMessage();
            return [];
        }
    }

    // Add more methods as needed, e.g., create, update, delete
}
