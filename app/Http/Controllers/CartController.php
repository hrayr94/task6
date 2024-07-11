<?php

namespace App\Http\Controllers;

use App\Models\Product;

class CartController
{
    public function index()
    {
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

        $products = [];
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $product->quantity = $quantity;
                $products[] = $product;
            }
        }

        require_once __DIR__ . "/../../../resources/views/cart/index.php";
    }

    public function addToCart()
    {
        $productId = $_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        setcookie('cart', json_encode($cart), time() + (2 * 24 * 60 * 60), '/');

        echo json_encode(['message' => 'Product added to cart successfully!']);
    }

    public function removeFromCart()
    {
        $productId = $_POST['product_id'];

        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        // Сохранить обновленную корзину в cookies
        setcookie('cart', json_encode($cart), time() + (2 * 24 * 60 * 60), '/');

        echo json_encode(['message' => 'Product removed from cart successfully!']);
    }
}
