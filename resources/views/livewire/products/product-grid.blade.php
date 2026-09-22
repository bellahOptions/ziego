<div>
    @if($showToolbar)
    <div class="mb-8 space-y-4">
        {{-- Category chips --}}
        <div class="flex flex-wrap gap-2">
            <button type="button" wire:click="filterCategory('')" class="chip {{ $category === '' ? 'chip-active' : '' }}">
                All
            </button>
            @foreach($categories as $cat)
            <button type="button" wire:click="filterCategory('{{ $cat->slug }}')" class="chip {{ $category === $cat->slug ? 'chip-active' : '' }}">
                {{ $cat->name }}
            </button>
            @endforeach
        </div>

        {{-- Search + sort --}}
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[220px] max-w-sm">
                <input type="text" wire:model.live.debounce.400ms="search" placeholder="Search the collection…" class="form-input text-sm pl-9 w-full">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <select wire:model.live="sort" class="form-input text-sm w-auto">
                <option value="">Sort by</option>
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
                <option value="popular">Most Popular</option>
            </select>
            <span wire:loading wire:target="search,sort,filterCategory" class="text-xs text-gray-400 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                Updating…
            </span>
        </div>
    </div>
    @endif

    <div class="mb-6">
        <p class="text-sm text-gray-500">
            {{ $total }} product{{ $total !== 1 ? 's' : '' }} found
            @if($search !== '') for "<strong>{{ $search }}</strong>"@endif
        </p>
    </div>

    @if($products->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($products as $product)
        <div class="product-card" wire:key="shop-product-{{ $product->id }}">
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
                    <livewire:cart.add-to-cart-button :product="$product" wire:key="shop-add-cart-{{ $product->id }}" />
                    <livewire:wishlist.wishlist-button :product="$product" wire:key="shop-wishlist-{{ $product->id }}" />
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

    {{-- Infinite scroll trigger --}}
    @if($hasMore)
    <div x-data x-init="
            let el = $el;
            let observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) { $wire.loadMore(); }
            }, { rootMargin: '400px' });
            observer.observe(el);
            window.addEventListener('beforeunload', () => observer.disconnect());
        " class="mt-10 flex justify-center">
        <button type="button" wire:click="loadMore" wire:loading.attr="disabled" wire:target="loadMore" class="px-6 py-2.5 rounded-lg text-sm font-semibold border transition-colors hover:bg-gray-50" style="color: var(--brand-dark); border-color: var(--brand);">
            <span wire:loading.remove wire:target="loadMore">Load More</span>
            <span wire:loading wire:target="loadMore" class="flex items-center gap-2">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                Loading…
            </span>
        </button>
    </div>
    @endif
    @else
    <div class="text-center py-20">
        <svg class="w-16 h-16 mx-auto mb-4 opacity-20" style="color: var(--brand);" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
        <h3 class="text-lg font-semibold text-gray-500 mb-2">No products found</h3>
        <p class="text-sm text-gray-400 mb-4">Try adjusting your filters or search term.</p>
        <a href="{{ route('products.index') }}" class="btn-primary btn-sm">Clear Filters</a>
    </div>
    @endif
</div>
