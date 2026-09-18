<div>
    @if($items->isEmpty())
    <div class="text-center py-20">
        <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6" style="background: var(--cream);">
            <svg class="w-12 h-12 opacity-30" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        </div>
        <h2 class="text-2xl font-bold mb-3" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Your wishlist is empty</h2>
        <p class="text-gray-400 mb-8">Save products you love and come back to them anytime.</p>
        <a href="{{ route('products.index') }}" class="btn-primary">Browse Products</a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($items as $item)
        @continue(!$item->product)
        <div class="product-card" wire:key="wishlist-item-{{ $item->id }}">
            <div class="overflow-hidden relative" style="aspect-ratio: 4/3;">
                <a href="{{ route('products.show', $item->product->slug) }}">
                    @if($item->product->primaryImage)
                        <img src="{{ $item->product->primaryImage->url }}" alt="{{ $item->product->name }}" class="product-card-img" loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background: var(--cream);">
                            <svg class="w-16 h-16 opacity-20" style="color: var(--brand);" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
                        </div>
                    @endif
                </a>
                <button type="button" wire:click="remove({{ $item->id }})" wire:loading.attr="disabled" wire:target="remove({{ $item->id }})"
                        class="absolute top-3 right-3 w-9 h-9 rounded-full flex items-center justify-center bg-white shadow-md hover:bg-red-50 transition-colors" title="Remove from Wishlist">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-4">
                <p class="text-xs mb-1" style="color: var(--brand);">{{ $item->product->category->name ?? '' }}</p>
                <a href="{{ route('products.show', $item->product->slug) }}">
                    <h3 class="font-semibold text-sm text-gray-800 hover:text-orange-800 transition-colors leading-snug mb-2">{{ $item->product->name }}</h3>
                </a>
                <div class="flex items-center justify-between">
                    <div>
                        @if($item->product->sale_price)
                            <span class="font-bold" style="color: var(--brand);">₦{{ number_format($item->product->sale_price) }}</span>
                            <span class="text-xs text-gray-400 line-through ml-1">₦{{ number_format($item->product->price) }}</span>
                        @else
                            <span class="font-bold" style="color: var(--brand);">₦{{ number_format($item->product->price) }}</span>
                        @endif
                    </div>
                    @if($item->product->stock > 0)
                        <livewire:cart.add-to-cart-button :product="$item->product" wire:key="wishlist-add-cart-{{ $item->product->id }}" />
                    @else
                        <span class="text-xs text-gray-400">Out of stock</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
