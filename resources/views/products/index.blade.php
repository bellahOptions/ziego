@extends('layouts.app')
@section('title', 'Our Products — Ziego Furniture & Interiors')

@section('content')
<div class="pt-20">

    {{-- Page header --}}
    <div class="py-12 px-4 sm:px-6" style="background: linear-gradient(135deg, var(--brand-dark) 0%, #5A2D00 100%);">
        <div class="max-w-7xl mx-auto">
            <nav class="text-sm mb-4">
                <a href="{{ route('home') }}" class="text-white/50 hover:text-white">Home</a>
                <span class="text-white/30 mx-2">›</span>
                <span class="text-white/80">Products</span>
            </nav>
            <h1 class="text-4xl font-bold text-white" style="font-family: 'Calistoga', serif;">Our Products</h1>
            <p class="text-white/60 mt-2">Premium furniture for every space</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <div class="flex gap-8">

            {{-- Sidebar Filters --}}
            <aside class="hidden lg:block w-60 flex-shrink-0">
                <div class="sticky top-24">
                    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm mb-4">
                        <h3 class="font-bold text-sm mb-4 uppercase tracking-wider" style="color: var(--brand-dark);">Categories</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('products.index') }}" class="text-sm {{ !request('category') ? 'font-semibold' : 'text-gray-500 hover:text-orange-800' }}" style="{{ !request('category') ? 'color: var(--brand)' : '' }}">
                                    All Products
                                </a>
                            </li>
                            @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="text-sm {{ request('category') === $cat->slug ? 'font-semibold' : 'text-gray-500 hover:text-orange-800' }}" style="{{ request('category') === $cat->slug ? 'color: var(--brand)' : '' }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-sm mb-4 uppercase tracking-wider" style="color: var(--brand-dark);">Price Range</h3>
                        <form action="{{ route('products.index') }}" method="GET">
                            @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                            <div class="space-y-3">
                                <div>
                                    <label class="form-label">Min Price (₦)</label>
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="form-input text-sm">
                                </div>
                                <div>
                                    <label class="form-label">Max Price (₦)</label>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="1,000,000" class="form-input text-sm">
                                </div>
                                <button type="submit" class="btn-primary w-full justify-center btn-sm">Apply</button>
                                @if(request()->hasAny(['min_price','max_price','search','sort']))
                                <a href="{{ route('products.index') }}" class="text-xs text-gray-400 hover:text-gray-600 text-center block">Clear filters</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- Main content --}}
            <div class="flex-1 min-w-0">
                {{-- Toolbar --}}
                <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                    <div>
                        <p class="text-sm text-gray-500">
                            {{ $products->total() }} product{{ $products->total() !== 1 ? 's' : '' }} found
                            @if(request('search')) for "<strong>{{ request('search') }}</strong>"@endif
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Search --}}
                        <form action="{{ route('products.index') }}" method="GET" class="relative">
                            @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="form-input text-sm pl-9 w-52">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </form>
                        {{-- Sort --}}
                        <form action="{{ route('products.index') }}" method="GET" id="sort-form">
                            @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                            @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                            <select name="sort" onchange="document.getElementById('sort-form').submit()" class="form-input text-sm">
                                <option value="">Sort by</option>
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                            </select>
                        </form>
                    </div>
                </div>

                {{-- Product Grid --}}
                @if($products->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($products as $product)
                    <div class="product-card">
                        <div class="overflow-hidden relative" style="aspect-ratio: 4/3;">
                            <a href="{{ route('products.show', $product->slug) }}">
                                @if($product->primaryImage)
                                    <img src="{{ $product->primaryImage->url }}" alt="{{ $product->name }}" class="product-card-img" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="background: var(--cream);">
                                        <svg class="w-16 h-16 opacity-20" style="color: var(--brand);" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
                                    </div>
                                @endif
                            </a>
                            @if($product->sale_price)
                                <span class="product-badge product-badge-sale">-{{ $product->discount_percentage }}%</span>
                            @endif
                            @if($product->is_wholesale)
                                <span class="product-badge" style="top: {{ $product->sale_price ? '2.5rem' : '0.75rem' }};">Wholesale</span>
                            @endif
                            <div class="product-actions">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="product-action-btn" title="Add to Cart">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </button>
                                </form>
                                <a href="{{ route('products.show', $product->slug) }}" class="product-action-btn">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>
                        </div>
                        <div class="p-4">
                            <p class="text-xs mb-1" style="color: var(--brand);">{{ $product->category->name ?? '' }}</p>
                            <a href="{{ route('products.show', $product->slug) }}">
                                <h3 class="font-semibold text-sm text-gray-800 hover:text-orange-800 transition-colors leading-snug mb-2">{{ $product->name }}</h3>
                            </a>
                            @if($product->material)
                                <p class="text-xs text-gray-400 mb-2">{{ $product->material }}</p>
                            @endif
                            <div class="flex items-center justify-between">
                                <div>
                                    @if($product->sale_price)
                                        <span class="font-bold" style="color: var(--brand);">₦{{ number_format($product->sale_price) }}</span>
                                        <span class="text-xs text-gray-400 line-through ml-1">₦{{ number_format($product->price) }}</span>
                                    @else
                                        <span class="font-bold" style="color: var(--brand);">₦{{ number_format($product->price) }}</span>
                                    @endif
                                </div>
                                @if($product->min_order_qty > 1)
                                    <span class="text-xs text-gray-400">Min: {{ $product->min_order_qty }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
                @else
                <div class="text-center py-20">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-20" style="color: var(--brand);" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
                    <h3 class="text-lg font-semibold text-gray-500 mb-2">No products found</h3>
                    <p class="text-sm text-gray-400 mb-4">Try adjusting your filters or search term.</p>
                    <a href="{{ route('products.index') }}" class="btn-primary btn-sm">Clear Filters</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
