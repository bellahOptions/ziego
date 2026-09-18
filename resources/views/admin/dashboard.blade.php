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
        ['Total Orders', $stats['total_orders'], 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', '#DBEAFE', '#1E40AF', route('admin.orders.index')],
        ['Pending Orders', $stats['pending_orders'], 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', '#FEF3C7', '#92400E', route('admin.orders.index', ['status' => 'pending'])],
        ['Revenue (Paid)', '₦' . number_format($stats['total_revenue']), 'M12 8c-1.657 0-3 .672-3 1.5S10.343 11 12 11s3 .672 3 1.5-1.343 1.5-3 1.5m0-8v1m0 8v1m9-5a9 9 0 11-18 0 9 9 0 0118 0z', '#D1FAE5', '#065F46', route('admin.invoices.index')],
        ['Total Products', $stats['total_products'], 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', '#EDE9FE', '#5B21B6', route('admin.products.index')],
        ['Low Stock Items', $stats['low_stock'], 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', '#FFF3E0', '#B5651D', route('admin.products.index')],
        ['Out of Stock', $stats['out_of_stock'], 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z', '#FEE2E2', '#991B1B', route('admin.products.index')],
        ['Customers', $stats['total_customers'], 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', '#D1FAE5', '#065F46', route('admin.customers.index')],
        ['Employees', $stats['total_employees'], 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', '#DBEAFE', '#1E40AF', route('admin.erm.employees.index')],
    ] as [$label, $value, $icon, $bg, $color, $link])
    <a href="{{ $link }}" class="stat-card block">
        <div class="flex items-start justify-between mb-3">
            <span class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: {{ $bg }};">
                <svg class="w-5 h-5" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
            </span>
        </div>
        <div class="text-2xl font-bold mb-1" style="color: var(--brand-dark);">{{ $value }}</div>
        <div class="text-xs text-gray-400 uppercase tracking-wider">{{ $label }}</div>
    </a>
    @endforeach
</div>

{{-- Revenue Chart --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-6">
    <div class="p-5 border-b border-gray-100">
        <h3 class="font-bold" style="color: var(--brand-dark);">Revenue &amp; Orders (Last 6 Months)</h3>
    </div>
    <div class="p-5">
        <canvas id="revenueChart" height="90"></canvas>
    </div>
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
        ['Add Product', route('admin.products.create'), 'M12 4v16m8-8H4'],
        ['Manage Orders', route('admin.orders.index'), 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['Manage Invoices', route('admin.invoices.index'), 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['Upload 3D Model', route('admin.showroom.index'), 'M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
    ] as [$label, $link, $icon])
    <a href="{{ $link }}" class="bg-white border border-gray-100 rounded-xl p-4 text-center card-hover block">
        <div class="w-9 h-9 mx-auto mb-2 rounded-lg flex items-center justify-center" style="background: var(--brand-pale);">
            <svg class="w-5 h-5" fill="none" stroke="var(--brand)" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
        </div>
        <div class="text-sm font-semibold" style="color: var(--brand-dark);">{{ $label }}</div>
    </a>
    @endforeach
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    type: 'line',
                    label: 'Revenue (₦)',
                    data: @json($chartRevenue),
                    borderColor: '#964B00',
                    backgroundColor: '#964B00',
                    yAxisID: 'y',
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: '#964B00',
                },
                {
                    type: 'bar',
                    label: 'Orders',
                    data: @json($chartOrders),
                    backgroundColor: '#D4A853',
                    yAxisID: 'y1',
                    borderRadius: 4,
                    barThickness: 24,
                },
            ],
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true } },
            },
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    beginAtZero: true,
                    ticks: { callback: (v) => '₦' + v.toLocaleString() },
                    grid: { color: '#f5ede5' },
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    beginAtZero: true,
                    ticks: { precision: 0 },
                    grid: { drawOnChartArea: false },
                },
            },
        },
    });
</script>
@endpush
@endsection
