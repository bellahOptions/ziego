<x-mail::message>
# Your Order Has Shipped

Hi {{ $order->shipping_name }},

Good news — order **{{ $order->order_number }}** is on its way to you.

<x-mail::panel>
**Order Number:** {{ $order->order_number }}<br>
@if($order->carrier)
**Carrier:** {{ $order->carrier }}<br>
@endif
@if($order->tracking_number)
**Tracking Number:** {{ $order->tracking_number }}<br>
@endif
**Shipped On:** {{ optional($order->shipped_at)->format('M d, Y') }}
</x-mail::panel>

**Shipping to:**<br>
{{ $order->shipping_address }}<br>
{{ $order->shipping_city }}{{ $order->shipping_city && $order->shipping_state ? ', ' : '' }}{{ $order->shipping_state }}

<x-mail::button :url="$order->tracking_url ?: route('orders.show', $order)">
{{ $order->tracking_url ? 'Track Package' : 'View Order' }}
</x-mail::button>

Thanks for shopping with us,<br>
{{ config('app.name') }}
</x-mail::message>
