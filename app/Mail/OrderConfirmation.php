<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
        $this->order->loadMissing('items', 'invoice', 'user');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Order Confirmed — {$this->order->order_number}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.confirmation',
            with: ['order' => $this->order],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        if (!$this->order->invoice) {
            return [];
        }

        $invoice = $this->order->invoice;

        return [
            Attachment::fromData(fn () => $invoice->pdfBytes(), "invoice-{$invoice->invoice_number}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
