<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Season;

class ProductController extends Controller
{
    public function index() {
        $products = Product::paginate(6);
        return view('products.index', compact('products'));
    }

    public function show(Product $product_id) {
        return view('products.show', compact('product_id'));
    }

    public function create() {
        $seasons = Season::orderBy('name')->get();
        return view('products.create', compact('seasons'));
    }

    public function store(ProductRequest $request) {

        $validatedData = $request->validated();

        $file_name = $request->file('image_file')->getClientOriginalName();

        $product = Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'image' => $file_name,
            'description' => $validatedData['description'],
        ]);

        $product->seasons()->sync($validatedData['seasons']);

        return redirect()->route('products.index');
    }


}
