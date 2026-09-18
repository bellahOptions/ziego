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
                <div class="flex items-center justify-end mb-6 flex-wrap gap-4">
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

                {{-- Product Grid (infinite scroll) --}}
                <livewire:products.product-grid />
            </div>
        </div>
    </div>
</div>
@endsection
