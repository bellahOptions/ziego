<?php

namespace App\Livewire\Wishlist;

use App\Models\Wishlist;
use Livewire\Attributes\On;
use Livewire\Component;

class WishlistPage extends Component
{
    #[On('wishlist-updated')]
    public function refresh(): void
    {
        //
    }

    public function remove(int $wishlistId): void
    {
        Wishlist::where('id', $wishlistId)->where('user_id', auth()->id())->delete();
        $this->dispatch('wishlist-updated');
        $this->dispatch('notify', type: 'success', message: 'Removed from wishlist.');
    }

    public function render()
    {
        $items = Wishlist::with(['product.primaryImage', 'product.category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('livewire.wishlist.wishlist-page', ['items' => $items]);
    }
}
