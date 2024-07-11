<?php
$prodModel = new App\Models\Product();
$products = $prodModel::all();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My E-Commerce Store</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .quantity-group {
            display: flex;
            align-items: center;
        }
        .quantity-input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }
        .quantity-button {
            width: 30px;
            height: 30px;
            padding: 0;
        }
    </style>
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">My E-Commerce Store</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/customer">User Page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cart">Cart</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<main class="container my-5">
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="/images/<?= $product->image ?>" class="card-img-top product-img img-fluid"
                         alt="Product Image" style="object-fit: cover; height: 300px;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product->name ?></h5>
                        <p class="card-text"><?= $product->description ?></p>
                        <p class="card-text"><?= $product->price ?>$</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary add-to-cart-button" data-product-id="<?= $product->id ?>">Add to Cart</button>
                            <div class="input-group quantity-group">
                                <button class="btn btn-outline-secondary quantity-button quantity-decrease" type="button" data-product-id="<?= $product->id ?>">-</button>
                                <input type="number" class="form-control quantity-input" value="1" min="1" data-product-id="<?= $product->id ?>">
                                <button class="btn btn-outline-secondary quantity-button quantity-increase" type="button" data-product-id="<?= $product->id ?>">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        function getCookie(name) {
            let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            if (match) return match[2];
            return null;
        }

        function setCookie(name, value, days) {
            let date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            let expires = "; expires=" + date.toUTCString();
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }

        function updateCartCookie(productId, quantity) {
            let cart = JSON.parse(getCookie('cart') || '{}');
            cart[productId] = quantity;
            setCookie('cart', JSON.stringify(cart), 7);
        }

        $('.quantity-decrease').on('click', function() {
            var productId = $(this).data('product-id');
            var quantityInput = $('.quantity-input[data-product-id="' + productId + '"]');
            var quantity = parseInt(quantityInput.val());
            if (quantity > 1) {
                quantityInput.val(quantity - 1);
            }
        });

        $('.quantity-increase').on('click', function() {
            var productId = $(this).data('product-id');
            var quantityInput = $('.quantity-input[data-product-id="' + productId + '"]');
            var quantity = parseInt(quantityInput.val());
            quantityInput.val(quantity + 1);
        });

        $('.add-to-cart-button').on('click', function() {
            var productId = $(this).data('product-id');
            var quantity = $('.quantity-input[data-product-id="' + productId + '"]').val();
            updateCartCookie(productId, quantity);
            alert('Product added to cart!');
        });
    });
</script>

<?php
require_once __DIR__ . "/../layout/footer.php";
?>
