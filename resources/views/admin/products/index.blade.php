@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold" style="color: var(--brand-dark);">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Product
    </a>
</div>

{{-- Filters --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-4">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="form-input text-sm w-48">
        <select name="category" class="form-input text-sm w-40">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status" class="form-input text-sm w-36">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="out_of_stock" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
        </select>
        <button type="submit" class="btn-primary btn-sm">Filter</button>
        @if(request()->hasAny(['search','category','status']))
            <a href="{{ route('admin.products.index') }}" class="btn-sm px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-500 hover:bg-gray-50">Clear</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-gray-50">
                                @if($product->primaryImage)
                                    <img src="{{ `$product->primaryImage->url }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 opacity-20" style="color: var(--brand);" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="font-medium text-sm">{{ $product->name }}</div>
                                @if($product->sku)<div class="text-xs text-gray-400">SKU: {{ $product->sku }}</div>@endif
                            </div>
                        </div>
                    </td>
                    <td class="text-sm">{{ $product->category->name ?? '—' }}</td>
                    <td>
                        <div class="font-semibold text-sm" style="color: var(--brand);">₦{{ number_format($product->price) }}</div>
                        @if($product->sale_price)<div class="text-xs text-green-600">Sale: ₦{{ number_format($product->sale_price) }}</div>@endif
                    </td>
                    <td>
                        <span class="{{ $product->stock <= 0 ? 'text-red-500 font-bold' : ($product->stock <= 5 ? 'text-orange-500 font-semibold' : 'text-gray-700') }} text-sm">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $product->status === 'active' ? 'active' : 'inactive' }}">{{ ucfirst(str_replace('_', ' ', $product->status)) }}</span>
                        @if($product->featured)<span class="badge badge-confirmed ml-1">Featured</span>@endif
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-medium hover:underline" style="color: var(--brand);">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-600">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($products->isEmpty())
                <tr><td colspan="6" class="text-center py-12 text-gray-400">No products found. <a href="{{ route('admin.products.create') }}" style="color: var(--brand);" class="hover:underline">Add one</a></td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
