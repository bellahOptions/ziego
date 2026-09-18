<?php

namespace App\Livewire\Wishlist;

use App\Models\Wishlist;
use Livewire\Attributes\On;
use Livewire\Component;

class WishlistIcon extends Component
{
    #[On('wishlist-updated')]
    public function refresh(): void
    {
        //
    }

    public function render()
    {
        $count = auth()->check()
            ? Wishlist::where('user_id', auth()->id())->count()
            : 0;

        return view('livewire.wishlist.wishlist-icon', ['count' => $count]);
    }
}
