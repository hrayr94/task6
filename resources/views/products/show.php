<?php
require_once __DIR__ . "/../layout/header.php";
?>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <img src="/images/<?= $product->image ?>" class="card-img-top img-fluid" alt="<?= $product->name ?>" style="object-fit: cover; height: 400px;">
                <div class="card-body">
                    <h1 class="card-title"><?= $product->name ?></h1>
                    <p class="card-text"><?= $product->description ?></p>
                    <p class="card-text"><strong>Price:</strong> <?= $product->price ?>$</p>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="/products" class="btn btn-outline-secondary">Back to Products</a>
                        <a href="/products/<?= $product->id ?>/edit" class="btn btn-outline-primary">Edit</a>
                        <form action="/products/<?= $product->id?>/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
require_once __DIR__ . "/../layout/footer.php";
?>
