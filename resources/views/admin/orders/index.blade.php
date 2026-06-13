@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold" style="color: var(--brand-dark);">Orders</h1>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-4">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order #, customer..." class="form-input text-sm w-52">
        <select name="status" class="form-input text-sm w-36">
            <option value="">All Status</option>
            @foreach(['pending','confirmed','processing','shipped','delivered','cancelled','refunded'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary btn-sm">Filter</button>
        @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-500 hover:bg-gray-50">Clear</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-xs hover:underline" style="color: var(--brand);">{{ $order->order_number }}</a></td>
                    <td>
                        <div class="text-sm font-medium">{{ $order->shipping_name }}</div>
                        <div class="text-xs text-gray-400">{{ $order->shipping_phone }}</div>
                    </td>
                    <td class="text-sm text-gray-500">{{ $order->items->count() }} item(s)</td>
                    <td class="font-bold text-sm" style="color: var(--brand);">₦{{ number_format($order->total) }}</td>
                    <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td><span class="badge badge-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></td>
                    <td class="text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-medium hover:underline" style="color: var(--brand);">View</a>
                    </td>
                </tr>
                @endforeach
                @if($orders->isEmpty())
                <tr><td colspan="8" class="text-center py-12 text-gray-400">No orders found</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">{{ $orders->withQueryString()->links() }}</div>
</div>
@endsection
