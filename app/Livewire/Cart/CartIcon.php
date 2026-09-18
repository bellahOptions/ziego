<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class CartIcon extends Component
{
    #[On('cart-updated')]
    public function refresh(): void
    {
        //
    }

    protected function count(): int
    {
        $cart = Cart::query()
            ->when(
                auth()->check(),
                fn ($q) => $q->where('user_id', auth()->id()),
                fn ($q) => $q->where('session_id', session()->getId()),
            )
            ->withSum('items', 'quantity')
            ->first();

        return (int) ($cart->items_sum_quantity ?? 0);
    }

    public function render()
    {
        return view('livewire.cart.cart-icon', ['count' => $this->count()]);
    }
}
