<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
    <h2 class="font-bold mb-3 text-sm" style="color: var(--brand-dark);">Status</h2>
    <div class="space-y-2">
        <div class="flex items-center justify-between"><span class="text-sm text-gray-500">Order</span><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></div>
        <div class="flex items-center justify-between"><span class="text-sm text-gray-500">Payment</span><span class="badge badge-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></div>
    </div>
    <div class="mt-3 pt-3 border-t border-gray-100 text-xs text-gray-400">
        <div>Placed: {{ $order->created_at->format('M d, Y g:i A') }}</div>
        @if($order->confirmed_at)<div>Confirmed: {{ $order->confirmed_at->format('M d, Y') }}</div>@endif
        @if($order->shipped_at)<div>Shipped: {{ $order->shipped_at->format('M d, Y') }}</div>@endif
        @if($order->delivered_at)<div>Delivered: {{ $order->delivered_at->format('M d, Y') }}</div>@endif
        @if($order->tracking_number)<div>Tracking: {{ $order->tracking_number }}{{ $order->carrier ? " ({$order->carrier})" : '' }}</div>@endif
    </div>
</div>
