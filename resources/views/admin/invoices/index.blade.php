@extends('layouts.admin')
@section('title', 'Invoices')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold" style="color: var(--brand-dark);">Invoices</h1>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-4">
    <form action="{{ route('admin.invoices.index') }}" method="GET" class="flex gap-3 flex-wrap">
        <select name="status" class="form-input text-sm w-36">
            <option value="">All Status</option>
            @foreach(['draft','sent','paid','overdue','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary btn-sm">Filter</button>
    </form>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Customer</th>
                    <th>Order</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td class="font-bold text-xs" style="color: var(--brand);">{{ $invoice->invoice_number }}</td>
                    <td class="text-sm">{{ $invoice->order->shipping_name ?? '—' }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $invoice->order) }}" class="text-xs hover:underline" style="color: var(--brand);">{{ $invoice->order->order_number ?? '—' }}</a>
                    </td>
                    <td class="font-bold text-sm" style="color: var(--brand);">₦{{ number_format($invoice->total) }}</td>
                    <td>
                        <form action="{{ route('admin.invoices.status', $invoice) }}" method="POST" class="flex items-center gap-1">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-200 rounded px-2 py-1.5 outline-none">
                                @foreach(['draft','sent','paid','overdue','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $invoice->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="text-xs {{ $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'text-red-500 font-bold' : 'text-gray-400' }}">
                        {{ $invoice->due_date->format('M d, Y') }}
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="text-xs font-medium hover:underline" style="color: var(--brand);">View</a>
                            <a href="{{ route('admin.invoices.download', $invoice) }}" class="text-xs font-medium text-gray-500 hover:text-gray-700">PDF</a>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($invoices->isEmpty())
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No invoices found</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">{{ $invoices->withQueryString()->links() }}</div>
</div>
@endsection
