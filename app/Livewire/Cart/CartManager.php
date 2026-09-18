<?php

namespace App\Livewire\Cart;

use App\Models\CartItem;
use App\Support\ResolvesCart;
use Livewire\Component;

class CartManager extends Component
{
    use ResolvesCart;

    public function increment(int $itemId): void
    {
        $item = $this->ownedItem($itemId);
        if (!$item) return;

        $item->update(['quantity' => min($item->quantity + 1, $item->product->stock)]);
        $this->dispatch('cart-updated');
    }

    public function decrement(int $itemId): void
    {
        $item = $this->ownedItem($itemId);
        if (!$item) return;

        $min = max(1, $item->product->min_order_qty ?? 1);
        $item->update(['quantity' => max($min, $item->quantity - 1)]);
        $this->dispatch('cart-updated');
    }

    public function remove(int $itemId): void
    {
        $item = $this->ownedItem($itemId);
        if (!$item) return;

        $item->delete();
        $this->dispatch('cart-updated');
        $this->dispatch('notify', type: 'success', message: 'Item removed from cart.');
    }

    private function ownedItem(int $itemId): ?CartItem
    {
        $cart = $this->resolveCart();

        return $cart->items()->with('product')->find($itemId);
    }

    public function render()
    {
        $cart = $this->resolveCart();
        $cart->load('items.product.primaryImage', 'items.product.category');

        return view('livewire.cart.cart-manager', ['cart' => $cart]);
    }
}
