<?php
require_once __DIR__ . "/../layout/header.php";
?>
<form action="/products" method="POST" enctype="multipart/form-data" class="container mt-5">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" id="name" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input type="number" class="form-control" name="price" id="price" required>
    </div>
    <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" class="form-control-file" name="image" id="image" required>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

<?php
require_once __DIR__ ."/../layout/footer.php";
?>
