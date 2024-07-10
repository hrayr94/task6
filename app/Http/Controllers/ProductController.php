<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\RMVC\Route\Route;
use App\RMVC\View\View;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return View::view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::find($id);
        return View::view('products.show', compact('product'));
    }

    public function create()
    {
        return View::view('products.create');
    }

    public function store()
    {
        // Ensure POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Create a new Product instance with form data
            $product = new Product();
            $product->name = $_POST['name'];
            $product->description = $_POST['description'];
            $product->price = $_POST['price'];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['image'];
                $imagePath = basename($image['name']);
                $targetPath = __DIR__ . '/../../public/images' . $imagePath;
                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    $product->image = $imagePath;
                } else {
                    echo "Failed to upload image.";
                    // Handle error appropriately (e.g., redirect back to form)
                    return;
                }
            } else {
                // Handle case where no image is uploaded
                echo "No image uploaded.";
                // Handle error appropriately (e.g., redirect back to form)
                return;
            }

            // Save the product
            $product->save();

            // Redirect after successful save
            Route::redirect('/products');
        } else {
            // Handle cases where form submission method is not POST
            // Redirect or show an error message as needed
        }
    }


    public function edit($id)
    {
        $product = Product::find($id);
        return View::view('products.edit', compact('product'));
    }

    public function update($id)
    {
        $product = Product::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['image'];
                $imagePath = basename($image['name']);
                $targetPath = __DIR__ . '/../../public/images' . $imagePath;

                if (!file_exists(dirname($targetPath))) {
                    mkdir(dirname($targetPath), 0777, true);
                }

                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    if ($product->image && $product->image !== $imagePath) {
                        $oldImagePath = __DIR__ . '/../../public' . $product->image;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $product->image = $imagePath;
                } else {
                    echo "Failed to upload image.";
                }
            }

            $product->name = $name;
            $product->description = $description;
            $product->price = $price;

            $product->update([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'image' => $product->image ?? $product->image
            ]);
        }

        Route::redirect('/products');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        Route::redirect('/products');
    }
}
