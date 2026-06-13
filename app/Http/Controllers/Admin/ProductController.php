<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'primaryImage');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:200',
            'category_id'       => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'sku'               => 'nullable|string|unique:products,sku',
            'material'          => 'nullable|string|max:100',
            'dimensions'        => 'nullable|string|max:100',
            'weight'            => 'nullable|string|max:50',
            'color'             => 'nullable|string|max:100',
            'featured'          => 'boolean',
            'is_wholesale'      => 'boolean',
            'min_order_qty'     => 'nullable|integer|min:1',
            'status'            => 'required|in:active,inactive,out_of_stock',
            'images.*'          => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        $data['featured'] = $request->boolean('featured');
        $data['is_wholesale'] = $request->boolean('is_wholesale');

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        if ($product->stock > 0) {
            InventoryLog::create([
                'product_id'   => $product->id,
                'user_id'      => auth()->id(),
                'type'         => 'in',
                'quantity'     => $product->stock,
                'stock_before' => 0,
                'stock_after'  => $product->stock,
                'reason'       => 'Initial stock on product creation',
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:200',
            'category_id'       => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'sku'               => 'nullable|string|unique:products,sku,' . $product->id,
            'material'          => 'nullable|string|max:100',
            'dimensions'        => 'nullable|string|max:100',
            'weight'            => 'nullable|string|max:50',
            'color'             => 'nullable|string|max:100',
            'featured'          => 'boolean',
            'is_wholesale'      => 'boolean',
            'min_order_qty'     => 'nullable|integer|min:1',
            'status'            => 'required|in:active,inactive,out_of_stock',
            'images.*'          => 'nullable|image|max:2048',
        ]);

        $data['featured'] = $request->boolean('featured');
        $data['is_wholesale'] = $request->boolean('is_wholesale');

        $oldStock = $product->stock;
        $product->update($data);

        if ($data['stock'] !== $oldStock) {
            InventoryLog::create([
                'product_id'   => $product->id,
                'user_id'      => auth()->id(),
                'type'         => 'adjustment',
                'quantity'     => abs($data['stock'] - $oldStock),
                'stock_before' => $oldStock,
                'stock_after'  => $data['stock'],
                'reason'       => 'Manual stock adjustment by admin',
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => $path,
                    'is_primary' => false,
                    'sort_order' => $product->images()->max('sort_order') + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }
}
