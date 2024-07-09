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
        // Add validation and file handling here
        $product = new Product($_POST);
        $product->save();
        Route::redirect('/products');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return View::view('products.edit', compact('product'));
    }

    public function update($id)
    {
        // Add validation and file handling here
        $product = Product::find($id);
        $product->update($_POST);
        Route::redirect('/products');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        Route::redirect('/products');
    }
}
