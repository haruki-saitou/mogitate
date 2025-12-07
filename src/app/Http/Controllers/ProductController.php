<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index() {
        $products = Product::paginate(6);
        return view('products.index', compact('products'));
    }

    public function show(Product $product_id) {
        $allSeasons = Season::orderBy('id')->get();
        return view('products.show', compact('product_id', 'allSeasons'));
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

        return redirect()->route('products.index')->with('success', '商品情報を登録しました');
    }

    public function update(ProductRequest $request, $product_id) {

        $product = Product::findOrFail($product_id);

        $validatedData = $request->validated();

        $updateData = $validatedData;

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products','public');
            $updateData['image'] = basename($path);

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
        } else {
            unset($updateData['image_file']);
        }

        $seasons = $validatedData['seasons'] ?? [];
        unset($updateData['seasons']);

        $product->update($updateData);
        $product->seasons()->sync($seasons);

        return redirect()->route('products.index', ['product_id' => $product_id])->with('success', '商品情報を更新しました');
    }

    public function search(Request $request) {
        $query = Product::query();
        $keyword = $request->input('keyword');
        $sort = $request->input('sort');

        if ($keyword) {
            $query->KeywordSearch($keyword);
        }
        if ($sort) {
            if ($sort ==='price_desc') {
                $query->orderBy('price', 'desc');
            }elseif ($sort ==='price_asc') {
                $query->orderBy('price', 'asc');
            }
        }

        if (!$sort) {
            $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(6);
        $products->appends($request->query());

        $is_empty = $products->isEmpty();

        return view('products.index', compact('products', 'keyword', 'sort', 'is_empty'));
    }

    public function destroy(Product $product_id) {
        $product_id->delete();
        return redirect()->route('products.index')->with('success', '商品情報を削除しました');
    }

}