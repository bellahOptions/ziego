<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('products.index', compact('categories'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['images', 'category'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $product->increment('views');

        $related = Product::with(['primaryImage'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
