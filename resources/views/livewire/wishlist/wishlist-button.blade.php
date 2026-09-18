<div>
    @if($variant === 'full')
        <button type="button" wire:click="toggle" wire:loading.attr="disabled" wire:target="toggle"
                class="flex items-center justify-center px-5 rounded-lg border transition-colors {{ $inWishlist ? 'border-red-200 bg-red-50' : 'border-gray-200 hover:bg-gray-50' }}"
                title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
            @if($inWishlist)
                <svg class="w-5 h-5" style="color: #DC2626;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            @else
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            @endif
        </button>
    @else
        <button type="button" wire:click="toggle" wire:loading.attr="disabled" wire:target="toggle"
                class="product-action-btn" title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
            @if($inWishlist)
                <svg class="w-4 h-4" style="color: #DC2626;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            @else
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            @endif
        </button>
    @endif
</div>
