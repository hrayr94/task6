<?php
require_once __DIR__ . "/../layout/header.php";

//$prodModel = new App\Models\Product();
//$product = $prodModel::find($_GET['id']);
?>

<form action="/products/<?= $product->id ?>" method="POST" enctype="multipart/form-data" class="container mt-5">
    <input type="hidden" name="_method" value="PUT">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" id="name" value="<?= $product->name ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" name="description" id="description" rows="3" required><?= $product->description ?></textarea>
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input type="number" class="form-control" name="price" id="price" value="<?= $product->price ?>" required>
    </div>
    <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" class="form-control-file" name="image" id="image">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php
require_once __DIR__ ."/../layout/footer.php";
?>