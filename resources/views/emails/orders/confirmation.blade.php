<x-mail::message>
# Order Confirmed

Hi {{ $order->shipping_name }},

Thank you for your order! We've received it and it's now being processed. Your invoice is attached to this email as a PDF.

<x-mail::panel>
**Order Number:** {{ $order->order_number }}<br>
**Order Date:** {{ $order->created_at->format('M d, Y') }}<br>
**Total:** ₦{{ number_format($order->total) }}
</x-mail::panel>

<x-mail::table>
| Item | Qty | Total |
| :--- | :-: | ----: |
@foreach($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | ₦{{ number_format($item->total_price) }} |
@endforeach
</x-mail::table>

**Shipping to:**<br>
{{ $order->shipping_address }}<br>
{{ $order->shipping_city }}{{ $order->shipping_city && $order->shipping_state ? ', ' : '' }}{{ $order->shipping_state }}

<x-mail::button :url="route('orders.show', $order)">
View Order
</x-mail::button>

Thanks for shopping with us,<br>
{{ config('app.name') }}
</x-mail::message>
