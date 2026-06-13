@extends('layouts.app')
@section('title', 'Order ' . $order->order_number . ' — Ziego Furniture')

@section('content')
<div class="pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('orders.index') }}" class="text-sm text-gray-400 hover:text-gray-600 flex items-center gap-1 mb-2">
                    ← Back to Orders
                </a>
                <h1 class="text-2xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Order {{ $order->order_number }}</h1>
                <p class="text-sm text-gray-400 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                <span class="badge badge-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            {{-- Items --}}
            <div class="md:col-span-2 space-y-4">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h2 class="font-bold mb-4" style="color: var(--brand-dark);">Order Items</h2>
                    <div class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                        <div class="flex gap-4 py-4 first:pt-0 last:pb-0">
                            <div class="w-16 h-14 rounded-lg overflow-hidden flex-shrink-0 bg-gray-50">
                                @if($item->product && $item->product->primaryImage)
                                    <img src="{{ `$item->product->primaryImage->url }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 opacity-20" style="color: var(--brand);" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-sm" style="color: var(--brand-dark);">{{ $item->product_name }}</div>
                                @if($item->product_sku)<div class="text-xs text-gray-400">SKU: {{ $item->product_sku }}</div>@endif
                                <div class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }} × ₦{{ number_format($item->unit_price) }}</div>
                            </div>
                            <div class="font-bold text-sm flex-shrink-0" style="color: var(--brand);">₦{{ number_format($item->total_price) }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 mt-4 pt-4 space-y-2">
                        <div class="flex justify-between text-sm"><span class="text-gray-400">Subtotal</span><span>₦{{ number_format($order->subtotal) }}</span></div>
                        @if($order->discount > 0)<div class="flex justify-between text-sm"><span class="text-gray-400">Discount</span><span class="text-green-600">-₦{{ number_format($order->discount) }}</span></div>@endif
                        @if($order->shipping_fee > 0)<div class="flex justify-between text-sm"><span class="text-gray-400">Shipping</span><span>₦{{ number_format($order->shipping_fee) }}</span></div>@endif
                        <div class="flex justify-between font-bold border-t border-gray-100 pt-2"><span>Total</span><span style="color: var(--brand);">₦{{ number_format($order->total) }}</span></div>
                    </div>
                </div>

                @if($order->invoice)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="font-bold" style="color: var(--brand-dark);">Invoice</h2>
                            <p class="text-sm text-gray-400 mt-0.5">{{ $order->invoice->invoice_number }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('invoices.show', $order->invoice) }}" class="btn-primary btn-sm">View Invoice</a>
                            <a href="{{ route('invoices.download', $order->invoice) }}" class="btn-outline btn-sm" style="color: var(--brand); border-color: var(--brand);">Download PDF</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-4">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h2 class="font-bold mb-4 text-sm" style="color: var(--brand-dark);">Shipping Address</h2>
                    <p class="font-semibold text-sm">{{ $order->shipping_name }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $order->shipping_phone }}</p>
                    @if($order->shipping_email)<p class="text-sm text-gray-500">{{ $order->shipping_email }}</p>@endif
                    <p class="text-sm text-gray-600 mt-2">{{ $order->shipping_address }}</p>
                    @if($order->shipping_city || $order->shipping_state)
                    <p class="text-sm text-gray-600">{{ $order->shipping_city }}{{ $order->shipping_city && $order->shipping_state ? ', ' : '' }}{{ $order->shipping_state }}</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h2 class="font-bold mb-4 text-sm" style="color: var(--brand-dark);">Order Timeline</h2>
                    <div class="space-y-3">
                        @foreach(['pending' => 'Order Placed', 'confirmed' => 'Confirmed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered'] as $status => $label)
                        @php
                            $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($order->status, $statuses);
                            $thisIndex = array_search($status, $statuses);
                            $isDone = $currentIndex !== false && $thisIndex <= $currentIndex && $order->status !== 'cancelled';
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0" style="background: {{ $isDone ? 'var(--brand)' : '#e5e7eb' }};">
                                @if($isDone)
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                @endif
                            </div>
                            <span class="text-sm {{ $isDone ? 'font-medium' : 'text-gray-400' }}" style="{{ $isDone ? 'color: var(--brand-dark)' : '' }}">{{ $label }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($order->notes)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h2 class="font-bold mb-2 text-sm" style="color: var(--brand-dark);">Notes</h2>
                    <p class="text-sm text-gray-500">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
