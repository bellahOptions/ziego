@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Dashboard Overview</h1>
    <p class="text-gray-400 text-sm mt-1">Welcome back, {{ auth()->user()->name }}. Here's what's happening.</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['Total Orders', $stats['total_orders'], '📦', 'badge-confirmed', route('admin.orders.index')],
        ['Pending Orders', $stats['pending_orders'], '⏳', 'badge-pending', route('admin.orders.index', ['status' => 'pending'])],
        ['Revenue (Paid)', '₦' . number_format($stats['total_revenue']), '💰', 'badge-active', route('admin.invoices.index')],
        ['Total Products', $stats['total_products'], '🛋️', 'badge-confirmed', route('admin.products.index')],
        ['Low Stock Items', $stats['low_stock'], '⚠️', 'badge-pending', route('admin.products.index')],
        ['Out of Stock', $stats['out_of_stock'], '❌', 'badge-cancelled', route('admin.products.index')],
        ['Customers', $stats['total_customers'], '👥', 'badge-active', route('admin.customers.index')],
        ['Employees', $stats['total_employees'], '👔', 'badge-confirmed', route('admin.erm.employees.index')],
    ] as [$label, $value, $icon, $badge, $link])
    <a href="{{ $link }}" class="stat-card block">
        <div class="flex items-start justify-between mb-3">
            <span class="text-2xl">{{ $icon }}</span>
        </div>
        <div class="text-2xl font-bold mb-1" style="color: var(--brand-dark);">{{ $value }}</div>
        <div class="text-xs text-gray-400 uppercase tracking-wider">{{ $label }}</div>
    </a>
    @endforeach
</div>

<div class="grid lg:grid-cols-2 gap-6">
    {{-- Recent Orders --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold" style="color: var(--brand-dark);">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium hover:underline" style="color: var(--brand);">View all →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-xs hover:underline" style="color: var(--brand);">
                                {{ $order->order_number }}
                            </a>
                        </td>
                        <td>
                            <div class="text-xs font-medium">{{ $order->shipping_name }}</div>
                            <div class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="font-semibold text-xs" style="color: var(--brand);">₦{{ number_format($order->total) }}</td>
                        <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    </tr>
                    @endforeach
                    @if($recentOrders->isEmpty())
                    <tr><td colspan="4" class="text-center text-gray-400 py-8 text-sm">No orders yet</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold" style="color: var(--brand-dark);">Top Products</h3>
            <a href="{{ route('admin.products.index') }}" class="text-sm font-medium hover:underline" style="color: var(--brand);">View all →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($topProducts as $i => $product)
            <div class="flex items-center gap-4 p-4">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0" style="background: {{ $i === 0 ? 'var(--gold)' : 'var(--cream)' }}; color: var(--brand-dark);">{{ $i + 1 }}</div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium truncate" style="color: var(--brand-dark);">{{ $product->name }}</div>
                    <div class="text-xs text-gray-400">{{ $product->order_items_count }} orders</div>
                </div>
                <div class="font-bold text-sm" style="color: var(--brand);">₦{{ number_format($product->price) }}</div>
            </div>
            @endforeach
            @if($topProducts->isEmpty())
            <div class="text-center text-gray-400 py-8 text-sm p-4">No sales data yet</div>
            @endif
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach([
        ['Add Product', route('admin.products.create'), '➕'],
        ['Manage Orders', route('admin.orders.index'), '📦'],
        ['Manage Invoices', route('admin.invoices.index'), '🧾'],
        ['Upload 3D Model', route('admin.showroom.index'), '🏠'],
    ] as [$label, $link, $icon])
    <a href="{{ $link }}" class="bg-white border border-gray-100 rounded-xl p-4 text-center card-hover block">
        <div class="text-2xl mb-2">{{ $icon }}</div>
        <div class="text-sm font-semibold" style="color: var(--brand-dark);">{{ $label }}</div>
    </a>
    @endforeach
</div>
@endsection
