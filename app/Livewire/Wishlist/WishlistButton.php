<?php

namespace App\Livewire\Wishlist;

use App\Models\Product;
use App\Models\Wishlist;
use Livewire\Component;

class WishlistButton extends Component
{
    public Product $product;

    public string $variant = 'icon';

    public bool $inWishlist = false;

    public function mount(Product $product, string $variant = 'icon'): void
    {
        $this->product = $product;
        $this->variant = $variant;
        $this->inWishlist = auth()->check()
            && Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
    }

    public function toggle(): void
    {
        if (!auth()->check()) {
            $this->dispatch('notify', type: 'error', message: 'Please log in to save items to your wishlist.');
            $this->redirect(route('login'));
            return;
        }

        $existing = Wishlist::where('user_id', auth()->id())->where('product_id', $this->product->id)->first();

        if ($existing) {
            $existing->delete();
            $this->inWishlist = false;
            $this->dispatch('notify', type: 'success', message: 'Removed from wishlist.');
        } else {
            Wishlist::create(['user_id' => auth()->id(), 'product_id' => $this->product->id]);
            $this->inWishlist = true;
            $this->dispatch('notify', type: 'success', message: 'Added to wishlist!');
        }

        $this->dispatch('wishlist-updated');
    }

    public function render()
    {
        return view('livewire.wishlist.wishlist-button');
    }
}
