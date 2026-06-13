@extends('layouts.app')
@section('title', 'My Orders — Ziego Furniture')

@section('content')
<div class="pt-20">
    <div class="py-10 px-4 sm:px-6" style="background: var(--cream);">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">My Orders</h1>
            <p class="text-gray-500 mt-1">Track your order history and status.</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
        @if($orders->isEmpty())
        <div class="text-center py-20">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-20" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <h2 class="text-xl font-bold mb-2" style="color: var(--brand-dark);">No orders yet</h2>
            <p class="text-gray-400 mb-6">Start shopping to see your orders here.</p>
            <a href="{{ route('products.index') }}" class="btn-primary">Shop Now</a>
        </div>
        @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-5 flex flex-wrap gap-4 items-center justify-between border-b border-gray-50">
                    <div class="flex gap-4 items-center flex-wrap">
                        <div>
                            <div class="text-xs text-gray-400 mb-0.5">Order</div>
                            <div class="font-bold text-sm" style="color: var(--brand-dark);">{{ $order->order_number }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 mb-0.5">Date</div>
                            <div class="text-sm">{{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 mb-0.5">Total</div>
                            <div class="font-bold text-sm" style="color: var(--brand);">₦{{ number_format($order->total) }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        <a href="{{ route('orders.show', $order) }}" class="text-sm font-medium hover:underline" style="color: var(--brand);">View Details →</a>
                    </div>
                </div>
                <div class="p-4 flex gap-3 overflow-x-auto">
                    @foreach($order->items->take(4) as $item)
                    <div class="text-center flex-shrink-0">
                        <div class="w-14 h-14 rounded-lg bg-gray-50 flex items-center justify-center mb-1">
                            <svg class="w-6 h-6 opacity-20" style="color: var(--brand);" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
                        </div>
                        <p class="text-xs text-gray-500 max-w-[56px] truncate">{{ $item->product_name }}</p>
                    </div>
                    @endforeach
                    @if($order->items->count() > 4)
                    <div class="text-center flex-shrink-0">
                        <div class="w-14 h-14 rounded-lg bg-gray-50 flex items-center justify-center mb-1 font-bold text-gray-400 text-sm">
                            +{{ $order->items->count() - 4 }}
                        </div>
                        <p class="text-xs text-gray-400">more</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
@endsection
