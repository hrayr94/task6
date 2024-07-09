<form action="/products/<?= $product->id ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?= $product->name ?>" required>
    <label for="description">Description:</label>
    <textarea name="description" id="description" required><?= $product->description ?></textarea>
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" value="<?= $product->price ?>" required>
    <label for="image">Image:</label>
    <input type="file" name="image" id="image">
    <button type="submit">Update</button>
</form>
