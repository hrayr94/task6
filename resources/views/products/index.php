<?php
require_once __DIR__ . "/../layout/header.php";

$prodModel = new App\Models\Product();
$products = $prodModel::all();
?>
<main class="container my-5">
        <div class="row">
            <div class="col-md-12 mb-3">
                <a class="btn btn-outline-success" href="/products/create">Add Product</a>
            </div>
        </div>
    <div class="row">
        <?php foreach ($products as $product):  ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="/images/<?= $product->image ?>" class="card-img-top product-img img-fluid" alt="Product Image" style="object-fit: cover; height: 300px;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product->name ?></h5>
                        <p class="card-text"><?= $product->description ?></p>
                        <p class="card-text"><?= $product->price ?>$</p>
                        <div class="d-flex justify-content-between">
                            <a href="/products/<?= $product->id ?>" class="btn btn-outline-primary">View</a>
                            <a href="/products/<?= $product->id ?>/edit" class="btn btn-outline-secondary">Edit</a>
                            <form action="/products/<?= $product->id ?>/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php
require_once __DIR__ . "/../layout/footer.php";
?>
