@extends('layouts.admin')
@section('title', 'Customers')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold" style="color: var(--brand-dark);">Customers</h1>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-4">
    <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, phone..." class="form-input text-sm w-56">
        <button type="submit" class="btn-primary btn-sm">Search</button>
    </form>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Orders</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0" style="background: var(--brand); color: white;">{{ substr($customer->name, 0, 1) }}</div>
                            <div>
                                <div class="font-medium text-sm">{{ $customer->name }}</div>
                                <div class="text-xs text-gray-400">{{ $customer->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-sm">{{ $customer->phone ?? '—' }}</td>
                    <td class="text-sm text-gray-500">{{ $customer->company ?? '—' }}</td>
                    <td class="text-sm font-semibold" style="color: var(--brand);">{{ $customer->orders_count }}</td>
                    <td class="text-xs text-gray-400">{{ $customer->created_at->format('M d, Y') }}</td>
                    <td>
                        <span class="badge {{ $customer->is_active ? 'badge-active' : 'badge-cancelled' }}">
                            {{ $customer->is_active ? 'Active' : 'Suspended' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-xs font-medium hover:underline" style="color: var(--brand);">View</a>
                            <form action="{{ route('admin.customers.toggle', $customer) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-xs {{ $customer->is_active ? 'text-red-400 hover:text-red-600' : 'text-green-500 hover:text-green-700' }}">
                                    {{ $customer->is_active ? 'Suspend' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($customers->isEmpty())
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No customers found</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">{{ $customers->withQueryString()->links() }}</div>
</div>
@endsection
