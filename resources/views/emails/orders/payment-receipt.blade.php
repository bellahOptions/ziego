<x-mail::message>
# Payment Received

Hi {{ $order->shipping_name }},

We've received your payment for order **{{ $order->order_number }}**. Your receipt is attached to this email as a PDF.

<x-mail::panel>
**Invoice Number:** {{ $invoice->invoice_number }}<br>
**Amount Paid:** ₦{{ number_format($invoice->total) }}<br>
**Paid On:** {{ optional($invoice->paid_at)->format('M d, Y') }}
</x-mail::panel>

<x-mail::button :url="route('orders.show', $order)">
View Order
</x-mail::button>

Thank you for your business,<br>
{{ config('app.name') }}
</x-mail::message>
