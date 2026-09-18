<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Invoice $invoice)
    {
        $this->invoice->loadMissing('order.user');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Payment Received — {$this->invoice->order->order_number}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.payment-receipt',
            with: ['invoice' => $this->invoice, 'order' => $this->invoice->order],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->invoice->pdfBytes(), "invoice-{$this->invoice->invoice_number}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
