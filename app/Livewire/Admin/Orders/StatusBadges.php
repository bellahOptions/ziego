<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;

class StatusBadges extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        $this->order = $order;
    }

    #[On('order-updated')]
    public function refresh(): void
    {
        $this->order->refresh();
    }

    public function render()
    {
        return view('livewire.admin.orders.status-badges');
    }
}
