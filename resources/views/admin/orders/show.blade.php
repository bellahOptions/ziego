@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:text-gray-600">← Back</a>
    <h1 class="text-xl font-bold" style="color: var(--brand-dark);">Order: {{ $order->order_number }}</h1>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
        {{-- Status Update --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h2 class="font-bold mb-4 text-sm" style="color: var(--brand-dark);">Update Order Status</h2>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex gap-3">
                @csrf @method('PATCH')
                <select name="status" class="form-input text-sm">
                    @foreach(['pending','confirmed','processing','shipped','delivered','cancelled','refunded'] as $s)
                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary btn-sm">Update</button>
            </form>
        </div>

        {{-- Items --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-sm" style="color: var(--brand-dark);">Order Items</h2>
                @if(!$order->invoice)
                <form action="{{ route('admin.orders.invoice', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary btn-sm">Generate Invoice</button>
                </form>
                @else
                <a href="{{ route('admin.invoices.show', $order->invoice) }}" class="btn-primary btn-sm">View Invoice</a>
                @endif
            </div>
            <table class="admin-table">
                <thead><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded bg-gray-50 flex-shrink-0">
                                    @if($item->product && $item->product->primaryImage)
                                        <img src="{{ `$item->product->primaryImage->url }}" class="w-full h-full object-cover rounded">
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-medium">{{ $item->product_name }}</div>
                                    @if($item->product_sku)<div class="text-xs text-gray-400">SKU: {{ $item->product_sku }}</div>@endif
                                </div>
                            </div>
                        </td>
                        <td class="text-sm">{{ $item->quantity }}</td>
                        <td class="text-sm">₦{{ number_format($item->unit_price) }}</td>
                        <td class="font-bold text-sm" style="color: var(--brand);">₦{{ number_format($item->total_price) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-5 border-t border-gray-50 space-y-1">
                <div class="flex justify-between text-sm"><span class="text-gray-400">Subtotal</span><span>₦{{ number_format($order->subtotal) }}</span></div>
                @if($order->discount > 0)<div class="flex justify-between text-sm text-green-600"><span>Discount</span><span>-₦{{ number_format($order->discount) }}</span></div>@endif
                @if($order->shipping_fee > 0)<div class="flex justify-between text-sm"><span class="text-gray-400">Shipping</span><span>₦{{ number_format($order->shipping_fee) }}</span></div>@endif
                <div class="flex justify-between font-bold text-base pt-2 border-t border-gray-100"><span>Total</span><span style="color: var(--brand);">₦{{ number_format($order->total) }}</span></div>
            </div>
        </div>
    </div>

    <div class="space-y-5">
        {{-- Status badges --}}
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
            </div>
        </div>

        {{-- Shipping --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h2 class="font-bold mb-3 text-sm" style="color: var(--brand-dark);">Shipping Details</h2>
            <div class="text-sm space-y-1">
                <div class="font-semibold">{{ $order->shipping_name }}</div>
                <div class="text-gray-500">{{ $order->shipping_phone }}</div>
                @if($order->shipping_email)<div class="text-gray-500">{{ $order->shipping_email }}</div>@endif
                <div class="text-gray-600 mt-2">{{ $order->shipping_address }}</div>
                @if($order->shipping_city)<div class="text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }}</div>@endif
            </div>
        </div>

        @if($order->notes)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h2 class="font-bold mb-2 text-sm" style="color: var(--brand-dark);">Notes</h2>
            <p class="text-sm text-gray-500">{{ $order->notes }}</p>
        </div>
        @endif

        @if($order->user)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h2 class="font-bold mb-3 text-sm" style="color: var(--brand-dark);">Customer</h2>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm" style="background: var(--brand); color: white;">{{ substr($order->user->name, 0, 1) }}</div>
                <div>
                    <div class="font-medium text-sm">{{ $order->user->name }}</div>
                    <div class="text-xs text-gray-400">{{ $order->user->email }}</div>
                </div>
            </div>
            <a href="{{ route('admin.customers.show', $order->user) }}" class="text-xs font-medium hover:underline mt-3 block" style="color: var(--brand);">View Profile →</a>
        </div>
        @endif
    </div>
</div>
@endsection
