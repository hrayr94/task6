<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\RMVC\Route\Route;
use App\RMVC\View\View;

class ProductController extends Controller
{
    public function index(): string
    {
        $products = Product::all();
        return View::view('products.index', compact('products'));
    }

    public function show($id): string
    {
        $product = Product::find($id);
        return View::view('products.show', compact('product'));
    }

    public function create(): string
    {
        return View::view('products.create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = new Product();
            $product->name = $_POST['name'];
            $product->description = $_POST['description'];
            $product->price = $_POST['price'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['image'];
                $imagePath = basename($image['name']);
                $targetPath = __DIR__ . '/../../public/images' . $imagePath;
                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    $product->image = $imagePath;
                } else {
                    echo "Failed to upload image.";
                    return;
                }
            } else {
                echo "No image uploaded.";
                return;
            }

            $product->save();

            Route::redirect('/products');
        } else {
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
