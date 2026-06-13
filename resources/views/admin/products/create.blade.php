@extends('layouts.admin')
@section('title', 'Add Product')

@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-xl font-bold" style="color: var(--brand-dark);">Add New Product</h1>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
            <h2 class="font-bold text-sm uppercase tracking-wider" style="color: var(--brand-dark);">Basic Information</h2>
            <div>
                <label class="form-label">Product Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="e.g. Executive Office Chair">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Category *</label>
                    <select name="category_id" required class="form-input">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="form-input" placeholder="ZF-001">
                </div>
            </div>
            <div>
                <label class="form-label">Short Description</label>
                <textarea name="short_description" rows="2" class="form-input" placeholder="Brief description shown on product listing">{{ old('short_description') }}</textarea>
            </div>
            <div>
                <label class="form-label">Full Description</label>
                <textarea name="description" rows="5" class="form-input" placeholder="Detailed product description...">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
            <h2 class="font-bold text-sm uppercase tracking-wider" style="color: var(--brand-dark);">Pricing & Stock</h2>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Regular Price (₦) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" required step="0.01" min="0" class="form-input" placeholder="0">
                    @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Sale Price (₦)</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0" class="form-input" placeholder="Optional">
                </div>
                <div>
                    <label class="form-label">Stock Quantity *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0" class="form-input">
                    @error('stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Minimum Order Quantity</label>
                    <input type="number" name="min_order_qty" value="{{ old('min_order_qty', 1) }}" min="1" class="form-input">
                </div>
                <div>
                    <label class="form-label">Status *</label>
                    <select name="status" required class="form-input">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="out_of_stock" {{ old('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} style="accent-color: var(--brand);">
                    <span class="text-sm font-medium">Featured Product</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_wholesale" value="1" {{ old('is_wholesale') ? 'checked' : '' }} style="accent-color: var(--brand);">
                    <span class="text-sm font-medium">Wholesale Available</span>
                </label>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
            <h2 class="font-bold text-sm uppercase tracking-wider" style="color: var(--brand-dark);">Product Details</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Material</label>
                    <input type="text" name="material" value="{{ old('material') }}" class="form-input" placeholder="e.g. Mahogany Wood">
                </div>
                <div>
                    <label class="form-label">Color</label>
                    <input type="text" name="color" value="{{ old('color') }}" class="form-input" placeholder="e.g. Walnut Brown">
                </div>
                <div>
                    <label class="form-label">Dimensions</label>
                    <input type="text" name="dimensions" value="{{ old('dimensions') }}" class="form-input" placeholder="e.g. 120cm x 60cm x 75cm">
                </div>
                <div>
                    <label class="form-label">Weight</label>
                    <input type="text" name="weight" value="{{ old('weight') }}" class="form-input" placeholder="e.g. 25kg">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-sm uppercase tracking-wider mb-4" style="color: var(--brand-dark);">Product Images</h2>
            <input type="file" name="images[]" multiple accept="image/*" class="form-input" id="images-input">
            <p class="text-xs text-gray-400 mt-2">First image will be set as primary. Max 2MB each. Recommended: 800×600px.</p>
            <div id="image-preview" class="flex flex-wrap gap-2 mt-3"></div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Save Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-5 py-3 border border-gray-200 rounded-lg text-sm font-medium text-gray-500 hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('images-input').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    [...e.target.files].forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `<img src="${e.target.result}" class="w-24 h-20 object-cover rounded-lg border-2 ${i === 0 ? 'border-orange-500' : 'border-gray-200'}">
            ${i === 0 ? '<span class="absolute top-1 left-1 bg-orange-500 text-white text-xs px-1 rounded">Primary</span>' : ''}`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
@endsection
