<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use App\Support\ResolvesCart;
use Livewire\Component;

class AddToCartButton extends Component
{
    use ResolvesCart;

    public Product $product;

    public string $variant = 'icon';

    public int $quantity = 1;

    public bool $justAdded = false;

    public function mount(Product $product, string $variant = 'icon'): void
    {
        $this->product = $product;
        $this->variant = $variant;
        $this->quantity = max(1, $product->min_order_qty ?? 1);
    }

    public function increment(): void
    {
        $this->quantity = min($this->quantity + 1, $this->product->stock);
    }

    public function decrement(): void
    {
        $min = max(1, $this->product->min_order_qty ?? 1);
        $this->quantity = max($min, $this->quantity - 1);
    }

    public function add(): void
    {
        $this->product->refresh();

        if ($this->product->status !== 'active' || $this->product->stock < 1) {
            $this->dispatch('notify', type: 'error', message: 'This product is currently unavailable.');
            return;
        }

        $qty = $this->variant === 'full' ? max(1, $this->quantity) : 1;

        $cart = $this->resolveCart();
        $item = $cart->items()->where('product_id', $this->product->id)->first();

        $newQuantity = min(($item?->quantity ?? 0) + $qty, $this->product->stock);

        if ($item) {
            $item->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $this->product->id,
                'quantity'   => $newQuantity,
            ]);
        }

        $this->justAdded = true;
        $this->dispatch('cart-updated');
        $this->dispatch('notify', type: 'success', message: $this->product->name . ' added to cart!');
    }

    public function render()
    {
        return view('livewire.cart.add-to-cart-button');
    }
}
