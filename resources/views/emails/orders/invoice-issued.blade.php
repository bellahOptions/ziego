<x-mail::message>
# Invoice for Your Order

Hi {{ $order->shipping_name }},

Please find attached your invoice for order **{{ $order->order_number }}**.

<x-mail::panel>
**Invoice Number:** {{ $invoice->invoice_number }}<br>
**Amount Due:** ₦{{ number_format($invoice->total) }}<br>
**Issue Date:** {{ $invoice->issue_date->format('M d, Y') }}<br>
**Due Date:** {{ $invoice->due_date->format('M d, Y') }}
</x-mail::panel>

<x-mail::button :url="route('invoices.show', $invoice)">
View Invoice
</x-mail::button>

Thanks for shopping with us,<br>
{{ config('app.name') }}
</x-mail::message>
