<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShippingUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
        $this->order->loadMissing('items', 'user');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Order Has Shipped — {$this->order->order_number}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.shipping-update',
            with: ['order' => $this->order],
        );
    }
}
