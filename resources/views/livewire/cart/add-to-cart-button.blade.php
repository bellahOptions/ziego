<div>
    @if($variant === 'full')
        <div class="flex gap-3 mb-4">
            <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                <button type="button" wire:click="decrement" class="px-4 py-3 hover:bg-gray-50 text-gray-600 font-bold">−</button>
                <input type="number" value="{{ $quantity }}" readonly class="w-14 text-center border-x border-gray-200 py-3 text-sm font-medium outline-none bg-white">
                <button type="button" wire:click="increment" class="px-4 py-3 hover:bg-gray-50 text-gray-600 font-bold">+</button>
            </div>
            <button type="button" wire:click="add" wire:loading.attr="disabled" wire:target="add" class="btn-primary flex-1 justify-center">
                <svg wire:loading.remove wire:target="add" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <svg wire:loading wire:target="add" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                <span wire:loading.remove wire:target="add">Add to Cart</span>
                <span wire:loading wire:target="add">Adding…</span>
            </button>
        </div>
    @else
        <button type="button" wire:click="add" wire:loading.attr="disabled" wire:target="add" class="product-action-btn" title="Add to Cart">
            <svg wire:loading.remove wire:target="add" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <svg wire:loading wire:target="add" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
        </button>
    @endif
</div>
