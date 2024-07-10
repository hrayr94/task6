<?php

namespace App\Models;

use PDO;

class Product
{
    private static PDO $db;

    public static function setConnection()
    {
        $database = Database::getInstance();
        self::$db = $database->getConnection();
    }

    public static function all()
    {
        self::setConnection();
        $stmt = self::$db->query('SELECT * FROM products');
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function find($id)
    {
        self::setConnection();
        $stmt = self::$db->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(self::class);
    }

    public function save()
    {
        self::setConnection();
        $stmt = self::$db->prepare('INSERT INTO products (name, description, price, image) VALUES (:name, :description, :price, :image)');
        $stmt->execute([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
        ]);
    }

    public function update($data)
    {
        self::setConnection();
        $stmt = self::$db->prepare('UPDATE products SET name = :name, description = :description, price = :price, image = :image WHERE id = :id');
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $data['image'],
            'id' => $this->id,
        ]);
    }

    public function delete()
    {
        self::setConnection();
        $stmt = self::$db->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute(['id' => $this->id]);
    }


}
