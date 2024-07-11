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

    public function getByCustomerId($customerId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM orders WHERE customer_id = :customer_id");
            $stmt->bindParam(':customer_id', $customerId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching orders by customer ID: " . $e->getMessage();
            return [];
        }
    }

}
