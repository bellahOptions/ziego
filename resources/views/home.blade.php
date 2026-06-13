@extends('layouts.app')
@section('title', 'Ziego Furniture & Interiors — Furniture That Speaks Style')
@section('content')

{{-- ============ HERO SLIDESHOW ============ --}}
<section
    x-data="{ current: 0, total: 5, next() { this.current = (this.current + 1) % this.total }, prev() { this.current = (this.current - 1 + this.total) % this.total }, go(i) { this.current = i } }"
    x-init="setInterval(() => next(), 6000)"
    class="relative overflow-hidden" style="min-height: 100vh;">

    {{-- Slide images --}}
    <div x-show="current === 0" x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1555041469-9b86f7c9c3dd?w=1920&q=90&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="hero-overlay"></div>
    </div>
    <div x-show="current === 1" x-cloak x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1920&q=90&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="hero-overlay"></div>
    </div>
    <div x-show="current === 2" x-cloak x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=1920&q=90&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="hero-overlay"></div>
    </div>
    <div x-show="current === 3" x-cloak x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1449247709967-d4461a6a6103?w=1920&q=90&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="hero-overlay"></div>
    </div>
    <div x-show="current === 4" x-cloak x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1586023492157-ac6decaa0b0c?w=1920&q=90&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="hero-overlay"></div>
    </div>

    {{-- Content overlay --}}
    <div class="relative z-10 flex flex-col justify-center" style="min-height: 100vh; padding-top: 5rem;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 w-full py-16">

            <div x-show="current === 0" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0">
                <span class="hero-badge mb-6 inline-flex"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> Living Room Collection</span>
                <h1 class="hero-title text-5xl md:text-6xl lg:text-7xl text-white mb-6">Furniture That<br><span style="color: var(--gold);">Speaks Style</span></h1>
                <p class="text-lg text-white/75 mb-10 max-w-xl leading-relaxed">Transform your living space with premium sofa collections. Trusted by <strong class="text-white">1,000+</strong> offices and homes across Nigeria.</p>
            </div>

            <div x-show="current === 1" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0">
                <span class="hero-badge mb-6 inline-flex"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg> Bedroom Collection</span>
                <h1 class="hero-title text-5xl md:text-6xl lg:text-7xl text-white mb-6">Transform Your<br><span style="color: var(--gold);">Bedroom</span></h1>
                <p class="text-lg text-white/75 mb-10 max-w-xl leading-relaxed">Luxury beds, wardrobes and bedroom sets crafted for comfort and elegance. Quality sleep starts with quality furniture.</p>
            </div>

            <div x-show="current === 2" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0">
                <span class="hero-badge mb-6 inline-flex"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> Office Furniture</span>
                <h1 class="hero-title text-5xl md:text-6xl lg:text-7xl text-white mb-6">Elevate Your<br><span style="color: var(--gold);">Workspace</span></h1>
                <p class="text-lg text-white/75 mb-10 max-w-xl leading-relaxed">Executive desks, ergonomic chairs and conference furniture. Equip your office with furniture that commands respect.</p>
            </div>

            <div x-show="current === 3" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0">
                <span class="hero-badge mb-6 inline-flex"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Dining Room Collection</span>
                <h1 class="hero-title text-5xl md:text-6xl lg:text-7xl text-white mb-6">Dine in<br><span style="color: var(--gold);">Elegance</span></h1>
                <p class="text-lg text-white/75 mb-10 max-w-xl leading-relaxed">Stunning dining tables and chairs for every occasion. From intimate family meals to grand corporate dining rooms.</p>
            </div>

            <div x-show="current === 4" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0">
                <span class="hero-badge mb-6 inline-flex"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg> Wholesale & Bulk Orders</span>
                <h1 class="hero-title text-5xl md:text-6xl lg:text-7xl text-white mb-6">Best Prices for<br><span style="color: var(--gold);">Bulk Orders</span></h1>
                <p class="text-lg text-white/75 mb-10 max-w-xl leading-relaxed">Unbeatable wholesale prices for hotels, schools, hospitals and corporate offices. Nationwide delivery to all 36 states.</p>
            </div>

            {{-- CTAs --}}
            <div class="flex flex-wrap gap-4 mb-12">
                <a href="{{ route('products.index') }}" class="btn-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Shop Now
                </a>
                <a href="{{ route('showroom') }}" class="btn-outline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
                    View 3D Showroom
                </a>
            </div>

            {{-- Trust signals --}}
            <div class="flex flex-wrap gap-5">
                <div class="flex items-center gap-2 text-sm text-white/80">
                    <svg class="w-4 h-4 flex-shrink-0" style="color: var(--gold);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Bulk Orders
                </div>
                <div class="flex items-center gap-2 text-sm text-white/80">
                    <svg class="w-4 h-4 flex-shrink-0" style="color: var(--gold);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    Wholesale Prices
                </div>
                <div class="flex items-center gap-2 text-sm text-white/80">
                    <svg class="w-4 h-4 flex-shrink-0" style="color: var(--gold);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    Nationwide Delivery
                </div>
                <div class="flex items-center gap-2 text-sm text-white/80">
                    <svg class="w-4 h-4 flex-shrink-0" style="color: var(--gold);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    09137652910
                </div>
            </div>
        </div>
    </div>

    {{-- Dot indicators --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex gap-2 items-center">
        @for ($i = 0; $i < 5; $i++)
        <button @click="go({{ $i }})" class="slide-dot h-1 transition-all duration-300" :class="current === {{ $i }} ? 'active w-8' : 'w-4'" style="min-width: 1rem;"></button>
        @endfor
    </div>

    {{-- Arrows --}}
    <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    </button>
</section>

{{-- ============ STATS ============ --}}
<section class="stats-bar py-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            @foreach([['1,000+', 'Offices Served'], ['500+', 'Products'], ['36', 'States Covered'], ['5 Star', 'Average Rating']] as [$num, $label])
            <div>
                <div class="text-2xl font-bold" style="color: var(--gold); font-family: 'Calistoga', serif;">{{ $num }}</div>
                <div class="text-xs text-white/60 mt-1 uppercase tracking-wider">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ CATEGORIES ============ --}}
<section id="categories" class="py-20 px-4 sm:px-6" style="background: var(--cream);">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <span class="section-label">Our Collections</span>
            <h2 class="section-title">Shop by Category</h2>
        </div>
        @if($categories->isNotEmpty())
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="category-card card-hover group">
                @if($category->image_url)
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" loading="lazy">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);">
                        <svg class="w-12 h-12 opacity-30 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    </div>
                @endif
                <div class="category-card-overlay">
                    <h3 class="text-white font-semibold text-sm">{{ $category->name }}</h3>
                </div>
            </a>
            @endforeach
            <a href="{{ route('products.index') }}" class="category-card card-hover flex items-center justify-center" style="background: var(--brand);">
                <div class="text-center p-4">
                    <div class="w-12 h-12 rounded-full border-2 border-white/30 flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </div>
                    <span class="text-white text-sm font-semibold">View All</span>
                </div>
            </a>
        </div>
        @endif
    </div>
</section>

{{-- ============ FEATURED PRODUCTS ============ --}}
<section class="py-20 px-4 sm:px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-end justify-between mb-12">
            <div>
                <span class="section-label">Curated Picks</span>
                <h2 class="section-title">Featured Products</h2>
            </div>
            <a href="{{ route('products.index') }}" class="hidden md:inline-flex items-center gap-2 text-sm font-semibold hover:underline" style="color: var(--brand);">
                View all products
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        @if($featuredProducts->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            <div class="product-card">
                <div class="overflow-hidden relative" style="aspect-ratio: 4/3;">
                    <a href="{{ route('products.show', $product->slug) }}">
                        @if($product->primaryImage)
                            <img src="{{ $product->primaryImage->url }}" alt="{{ $product->name }}" class="product-card-img" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background: var(--cream);">
                                <svg class="w-16 h-16 opacity-20" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                            </div>
                        @endif
                    </a>
                    @if($product->featured)<span class="product-badge">Featured</span>@endif
                    @if($product->sale_price)<span class="product-badge product-badge-sale" style="top: {{ $product->featured ? '2.5rem' : '0.75rem' }};">-{{ $product->discount_percentage }}%</span>@endif
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
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->sale_price)
                                <span class="font-bold" style="color: var(--brand);">&#8358;{{ number_format($product->sale_price) }}</span>
                                <span class="text-xs text-gray-400 line-through ml-1">&#8358;{{ number_format($product->price) }}</span>
                            @else
                                <span class="font-bold" style="color: var(--brand);">&#8358;{{ number_format($product->price) }}</span>
                            @endif
                        </div>
                        @if($product->stock > 0)
                            <span class="text-xs px-2 py-0.5 rounded-full" style="background: #D1FAE5; color: #065F46;">In Stock</span>
                        @else
                            <span class="text-xs px-2 py-0.5 rounded-full" style="background: #FEE2E2; color: #991B1B;">Sold Out</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        <div class="text-center mt-10 md:hidden">
            <a href="{{ route('products.index') }}" class="btn-primary">View All Products</a>
        </div>
    </div>
</section>

{{-- ============ 3D SHOWROOM PREVIEW ============ --}}
<section class="showroom-bg py-24 px-4 sm:px-6 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 2px 2px, rgba(212,168,83,0.5) 1px, transparent 0); background-size: 40px 40px;"></div>
    <div class="max-w-7xl mx-auto relative">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="hero-badge mb-6 inline-flex">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Immersive Experience
                </span>
                <h2 class="section-title text-white mb-6">Explore Our 3D<br><span style="color: var(--gold);">Virtual Showroom</span></h2>
                <p class="text-white/70 mb-6 leading-relaxed">Walk through our fully furnished rooms in 3D. See how each piece looks in a real space before you buy.</p>
                <ul class="space-y-3 mb-8">
                    @foreach(['Rotate and zoom 360 degrees', 'See real-scale furniture', 'Multiple room setups', 'Updated regularly by our team'] as $feature)
                    <li class="flex items-center gap-3 text-white/80 text-sm">
                        <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0" style="background: var(--gold);">
                            <svg class="w-3 h-3" style="color: var(--brand-dark);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('showroom') }}" class="btn-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
                    Launch Showroom
                </a>
            </div>
            <div class="relative">
                <div class="rounded-2xl overflow-hidden" style="border: 1px solid rgba(212,168,83,0.2); aspect-ratio: 4/3; position: relative;">
                    <img src="https://images.unsplash.com/photo-1618219908412-a29a1bb7b86e?w=1200&q=80&fit=crop" alt="Virtual Showroom" class="w-full h-full object-cover opacity-70">
                    <div class="absolute inset-0 flex items-center justify-center" style="background: rgba(52,28,2,0.4);">
                        <a href="{{ route('showroom') }}" class="flex flex-col items-center gap-3 text-center">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center animate-float border-2 border-white/30" style="background: rgba(212,168,83,0.3); backdrop-filter: blur(8px);">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
                            </div>
                            <span class="text-white font-semibold text-sm">Enter 3D Showroom</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ WHY CHOOSE US ============ --}}
<section class="py-20 px-4 sm:px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14">
            <span class="section-label">Why Ziego</span>
            <h2 class="section-title">Why Choose Us?</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach([
                ['M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'Bulk Orders', 'We cater to large volume orders for offices, hotels and institutions at unbeatable prices.'],
                ['M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z', 'Wholesale Prices', 'Our wholesale pricing model ensures you get maximum value for every naira spent.'],
                ['M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9', 'Nationwide Delivery', 'Safe and timely delivery to all 36 states. Your furniture arrives in perfect condition.'],
                ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Premium Quality', 'Every piece is crafted with the finest materials and undergoes strict quality control.'],
                ['M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42', 'Custom Designs', 'Need something unique? Our team creates bespoke furniture to your exact specifications.'],
                ['M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', '24/7 Support', 'Our customer care team is always ready to help. Call 09137652910 anytime.'],
            ] as [$path, $title, $desc])
            <div class="p-6 rounded-xl border border-gray-100 card-hover group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: var(--brand-pale);">
                    <svg class="w-6 h-6" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/></svg>
                </div>
                <h3 class="font-bold text-lg mb-2 group-hover:text-orange-800 transition-colors" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">{{ $title }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ TESTIMONIALS ============ --}}
@if($testimonials->isNotEmpty())
<section class="py-20 px-4 sm:px-6" style="background: var(--cream);">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14">
            <span class="section-label">Testimonials</span>
            <h2 class="section-title">What Our Clients Say</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card">
                <div class="flex gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 {{ $i < $testimonial->rating ? '' : 'opacity-20' }}" style="color: var(--gold);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-6 relative z-10">{{ $testimonial->content }}</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm" style="background: var(--brand); color: white;">{{ substr($testimonial->name, 0, 1) }}</div>
                    <div>
                        <div class="font-semibold text-sm" style="color: var(--brand-dark);">{{ $testimonial->name }}</div>
                        @if($testimonial->company)<div class="text-xs text-gray-400">{{ $testimonial->company }}</div>@endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ CTA ============ --}}
<section class="py-20 px-4 sm:px-6" style="background: var(--brand);">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6" style="font-family: 'Calistoga', serif;">Ready to Furnish Your Space?</h2>
        <p class="text-white/80 text-lg mb-8">Contact us today for bulk orders, wholesale pricing, and bespoke furniture solutions across Nigeria.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('products.index') }}" class="btn-gold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Browse Products
            </a>
            <a href="tel:09137652910" class="btn-outline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Call 09137652910
            </a>
            <a href="{{ route('contact') }}" class="btn-outline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Send Message
            </a>
        </div>
    </div>
</section>

@endsection
