@extends('layouts.admin')
@section('title', 'Edit Product')

@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-xl font-bold" style="color: var(--brand-dark);">Edit: {{ $product->name }}</h1>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
            <div>
                <label class="form-label">Product Name *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="form-input">
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Category *</label>
                    <select name="category_id" required class="form-input">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Short Description</label>
                <textarea name="short_description" rows="2" class="form-input">{{ old('short_description', $product->short_description) }}</textarea>
            </div>
            <div>
                <label class="form-label">Full Description</label>
                <textarea name="description" rows="5" class="form-input">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Regular Price (₦) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required step="0.01" class="form-input">
                </div>
                <div>
                    <label class="form-label">Sale Price (₦)</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" class="form-input">
                </div>
                <div>
                    <label class="form-label">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="form-input">
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Min Order Qty</label>
                    <input type="number" name="min_order_qty" value="{{ old('min_order_qty', $product->min_order_qty) }}" min="1" class="form-input">
                </div>
                <div>
                    <label class="form-label">Status *</label>
                    <select name="status" required class="form-input">
                        @foreach(['active' => 'Active', 'inactive' => 'Inactive', 'out_of_stock' => 'Out of Stock'] as $val => $label)
                            <option value="{{ $val }}" {{ old('status', $product->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} style="accent-color: var(--brand);">
                    <span class="text-sm">Featured</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_wholesale" value="1" {{ old('is_wholesale', $product->is_wholesale) ? 'checked' : '' }} style="accent-color: var(--brand);">
                    <span class="text-sm">Wholesale</span>
                </label>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Material</label>
                    <input type="text" name="material" value="{{ old('material', $product->material) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Color</label>
                    <input type="text" name="color" value="{{ old('color', $product->color) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Dimensions</label>
                    <input type="text" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Weight</label>
                    <input type="text" name="weight" value="{{ old('weight', $product->weight) }}" class="form-input">
                </div>
            </div>
        </div>

        {{-- Existing images --}}
        @if($product->images->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-sm uppercase tracking-wider mb-4" style="color: var(--brand-dark);">Current Images</h3>
            <div class="flex flex-wrap gap-3">
                @foreach($product->images as $img)
                <div class="relative">
                    <img src="{{ $img->url }}" class="w-24 h-20 object-cover rounded-lg border-2 {{ $img->is_primary ? 'border-orange-500' : 'border-gray-200' }}">
                    @if($img->is_primary)
                        <span class="absolute top-1 left-1 bg-orange-500 text-white text-xs px-1 rounded">Primary</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-sm uppercase tracking-wider mb-3" style="color: var(--brand-dark);">Add More Images</h3>
            <input type="file" name="images[]" multiple accept="image/*" class="form-input">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Update Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-5 py-3 border border-gray-200 rounded-lg text-sm font-medium text-gray-500 hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection
