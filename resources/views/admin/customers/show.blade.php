@extends('layouts.admin')
@section('title', $customer->name)

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.customers.index') }}" class="text-gray-400 hover:text-gray-600">← Back</a>
    <h1 class="text-xl font-bold" style="color: var(--brand-dark);">{{ $customer->name }}</h1>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Profile --}}
    <div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 text-center">
            <div class="w-20 h-20 rounded-full flex items-center justify-center font-bold text-2xl mx-auto mb-4" style="background: var(--brand); color: white;">
                {{ substr($customer->name, 0, 1) }}
            </div>
            <h2 class="font-bold text-lg" style="color: var(--brand-dark);">{{ $customer->name }}</h2>
            <p class="text-gray-400 text-sm">{{ $customer->email }}</p>

            <div class="mt-4 space-y-2 text-sm text-left">
                @if($customer->phone)
                <div class="flex items-center gap-2 text-gray-500"><span>📞</span> {{ $customer->phone }}</div>
                @endif
                @if($customer->company)
                <div class="flex items-center gap-2 text-gray-500"><span>🏢</span> {{ $customer->company }}</div>
                @endif
                @if($customer->address)
                <div class="flex items-start gap-2 text-gray-500"><span>📍</span> {{ $customer->address }}</div>
                @endif
            </div>

            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="text-2xl font-bold" style="color: var(--brand);">{{ $customer->orders->count() }}</div>
                <div class="text-xs text-gray-400 mt-0.5">Total Orders</div>
            </div>

            <div class="mt-4">
                <span class="badge {{ $customer->is_active ? 'badge-active' : 'badge-cancelled' }}">
                    {{ $customer->is_active ? 'Active' : 'Suspended' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Orders --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h2 class="font-bold" style="color: var(--brand-dark);">Order History</h2>
            </div>
            <table class="admin-table">
                <thead><tr><th>Order #</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                    @foreach($customer->orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-xs hover:underline" style="color: var(--brand);">{{ $order->order_number }}</a>
                        </td>
                        <td class="text-sm text-gray-500">{{ $order->items->count() }}</td>
                        <td class="font-bold text-sm" style="color: var(--brand);">₦{{ number_format($order->total) }}</td>
                        <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td class="text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                    @if($customer->orders->isEmpty())
                    <tr><td colspan="5" class="text-center py-8 text-gray-400">No orders yet</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
