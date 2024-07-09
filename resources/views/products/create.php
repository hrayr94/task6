<form action="/products" method="POST" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    <label for="description">Description:</label>
    <textarea name="description" id="description" required></textarea>
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" required>
    <label for="image">Image:</label>
    <input type="file" name="image" id="image" required>
    <button type="submit">Create</button>
</form>
