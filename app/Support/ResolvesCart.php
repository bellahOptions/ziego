<?php

namespace App\Support;

use App\Models\Cart;

trait ResolvesCart
{
    protected function resolveCart(): Cart
    {
        if (auth()->check()) {
            return Cart::firstOrCreate(['user_id' => auth()->id()]);
        }

        return Cart::firstOrCreate(['session_id' => session()->getId()]);
    }
}
