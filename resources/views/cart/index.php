<?php
$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

$cartTotal = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My E-Commerce Store - Cart</title>
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
    <h1>Your Shopping Cart</h1>
    <div class="row">
        <?php foreach ($cart as $productId => $quantity): ?>
            <?php
            $product = App\Models\Product::find($productId);
            if ($product):
                $subtotal = $product->price * $quantity;
                $cartTotal += $subtotal;
                ?>
                <div class="col-md-4 mb-4" id="product-<?= $productId ?>">
                    <div class="card shadow-sm">
                        <img src="/images/<?= $product->image ?>" class="card-img-top product-img img-fluid"
                             alt="Product Image" style="object-fit: cover; height: 300px;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product->name ?></h5>
                            <p class="card-text"><?= $product->description ?></p>
                            <p class="card-text" id="product-price-<?= $productId ?>"><?= $product->price ?>$</p>
                            <div class="quantity-group">
                                <button class="btn btn-outline-secondary quantity-button quantity-decrease" type="button" data-product-id="<?= $productId ?>">-</button>
                                <input type="number" class="form-control quantity-input" value="<?= $quantity ?>" min="1" data-product-id="<?= $productId ?>">
                                <button class="btn btn-outline-secondary quantity-button quantity-increase" type="button" data-product-id="<?= $productId ?>">+</button>
                                <button class="btn btn-danger remove-from-cart-button" type="button" data-product-id="<?= $productId ?>">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="mt-4">
        <h4 id="cart-total">Total: <?= $cartTotal ?>$</h4>
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
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            let expires = "; expires=" + date.toUTCString();
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function updateCartCookie(productId, quantity) {
            let cart = JSON.parse(getCookie('cart') || '{}');
            if (quantity <= 0) {
                delete cart[productId];
            } else {
                cart[productId] = quantity;
            }
            if (Object.keys(cart).length === 0) {
                document.cookie = 'cart=; Max-Age=-99999999;';
            } else {
                setCookie('cart', JSON.stringify(cart), 7);
            }
            updateCartTotal();
        }

        function updateCartTotal() {
            let total = 0;
            $('.quantity-input').each(function() {
                let productId = $(this).data('product-id');
                let quantity = parseInt($(this).val());
                let productPrice = parseFloat($('#product-price-' + productId).text().replace('$', ''));
                if (!isNaN(productPrice)) {
                    total += quantity * productPrice;
                }
            });
            $('#cart-total').text('Total: ' + total.toFixed(2) + '$');
        }

        $('.quantity-decrease').on('click', function() {
            let productId = $(this).data('product-id');
            let quantityInput = $('.quantity-input[data-product-id="' + productId + '"]');
            let quantity = parseInt(quantityInput.val());
            if (quantity > 1) {
                quantityInput.val(quantity - 1);
                updateCartCookie(productId, quantity - 1);
            }
        });

        $('.quantity-increase').on('click', function() {
            let productId = $(this).data('product-id');
            let quantityInput = $('.quantity-input[data-product-id="' + productId + '"]');
            let quantity = parseInt(quantityInput.val());
            quantityInput.val(quantity + 1);
            updateCartCookie(productId, quantity + 1);
        });

        $('.remove-from-cart-button').on('click', function() {
            let productId = $(this).data('product-id');
            $('#product-' + productId).remove();
            updateCartCookie(productId, 0);
        });

        $('.clear-cart-button').on('click', function() {
            document.cookie = 'cart=; Max-Age=-99999999;';
            $('.row').empty();
            updateCartTotal();
        });

        $('.add-to-cart-button').on('click', function() {
            let productId = $(this).data('product-id');
            let quantity = $('.quantity-input[data-product-id="' + productId + '"]').val();
            updateCartCookie(productId, quantity);
            alert('Product added to cart!');
        });


        updateCartTotal();
    });
</script>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>

</body>
</html>
