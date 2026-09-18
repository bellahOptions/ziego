<?php

namespace App\Livewire\Admin\Orders;

use App\Mail\ShippingUpdate;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class StatusForm extends Component
{
    public Order $order;

    public string $status;

    public ?string $carrier = null;

    public ?string $trackingNumber = null;

    public ?string $trackingUrl = null;

    public function mount(Order $order): void
    {
        $this->order = $order;
        $this->status = $order->status;
        $this->carrier = $order->carrier;
        $this->trackingNumber = $order->tracking_number;
        $this->trackingUrl = $order->tracking_url;
    }

    public function update(): void
    {
        $this->validate([
            'status'         => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
            'carrier'        => 'nullable|string|max:100',
            'trackingNumber' => 'nullable|string|max:100',
            'trackingUrl'    => 'nullable|url|max:255',
        ]);

        $wasAlreadyShipped = $this->order->status === 'shipped';

        $data = ['status' => $this->status];

        if ($this->status === 'confirmed') $data['confirmed_at'] = now();
        if ($this->status === 'shipped') {
            $data['shipped_at']      = now();
            $data['carrier']         = $this->carrier;
            $data['tracking_number'] = $this->trackingNumber;
            $data['tracking_url']    = $this->trackingUrl;
        }
        if ($this->status === 'delivered') $data['delivered_at'] = now();

        $this->order->update($data);

        if ($this->status === 'shipped' && !$wasAlreadyShipped) {
            try {
                $this->order->load('items', 'user');
                $recipient = $this->order->shipping_email ?: $this->order->user->email;
                Mail::to($recipient)->cc(User::adminEmails())->send(new ShippingUpdate($this->order));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $this->dispatch('order-updated');
        $this->dispatch('notify', type: 'success', message: 'Order status updated to ' . ucfirst($this->status) . '.');
    }

    public function render()
    {
        return view('livewire.admin.orders.status-form');
    }
}
