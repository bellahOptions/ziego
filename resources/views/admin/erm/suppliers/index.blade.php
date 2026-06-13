@extends('layouts.admin')
@section('title', 'Suppliers — ERM')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold" style="color: var(--brand-dark);">Suppliers</h1>
    <button onclick="document.getElementById('add-supplier-modal').classList.remove('hidden')" class="btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Supplier
    </button>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-4">
    <form action="{{ route('admin.erm.suppliers.index') }}" method="GET" class="flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search supplier..." class="form-input text-sm w-48">
        <select name="status" class="form-input text-sm w-36">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="blacklisted" {{ request('status') === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
        </select>
        <button type="submit" class="btn-primary btn-sm">Filter</button>
    </form>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Contact Person</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Credit Limit</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                <tr>
                    <td>
                        <div class="font-medium text-sm">{{ $supplier->name }}</div>
                        @if($supplier->email)<div class="text-xs text-gray-400">{{ $supplier->email }}</div>@endif
                    </td>
                    <td class="text-sm">{{ $supplier->contact_person ?? '—' }}</td>
                    <td class="text-sm">{{ $supplier->phone }}</td>
                    <td class="text-xs text-gray-500">{{ $supplier->city }}{{ $supplier->city && $supplier->state ? ', ' : '' }}{{ $supplier->state }}</td>
                    <td class="text-sm">₦{{ number_format($supplier->credit_limit) }}</td>
                    <td class="text-sm {{ $supplier->outstanding_balance > 0 ? 'text-red-500 font-semibold' : 'text-gray-500' }}">₦{{ number_format($supplier->outstanding_balance) }}</td>
                    <td><span class="badge badge-{{ $supplier->status === 'active' ? 'active' : ($supplier->status === 'blacklisted' ? 'cancelled' : 'inactive') }}">{{ ucfirst($supplier->status) }}</span></td>
                    <td>
                        <form action="{{ route('admin.erm.suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Remove supplier?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($suppliers->isEmpty())
                <tr><td colspan="8" class="text-center py-12 text-gray-400">No suppliers found</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">{{ $suppliers->withQueryString()->links() }}</div>
</div>

{{-- Add Supplier Modal --}}
<div id="add-supplier-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold" style="color: var(--brand-dark);">Add Supplier</h2>
            <button onclick="document.getElementById('add-supplier-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.erm.suppliers.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="form-label">Company Name *</label>
                    <input type="text" name="name" required class="form-input" placeholder="Supplier name">
                </div>
                <div>
                    <label class="form-label">Contact Person</label>
                    <input type="text" name="contact_person" class="form-input">
                </div>
                <div>
                    <label class="form-label">Phone *</label>
                    <input type="text" name="phone" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input">
                </div>
                <div>
                    <label class="form-label">Credit Limit (₦)</label>
                    <input type="number" name="credit_limit" class="form-input" value="0">
                </div>
                <div>
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-input">
                </div>
                <div>
                    <label class="form-label">State</label>
                    <input type="text" name="state" class="form-input">
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Products Supplied</label>
                    <textarea name="products_supplied" rows="2" class="form-input" placeholder="e.g. Office chairs, wooden tables..."></textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="2" class="form-input"></textarea>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 justify-center">Add Supplier</button>
                <button type="button" onclick="document.getElementById('add-supplier-modal').classList.add('hidden')" class="flex-1 px-4 py-3 border border-gray-200 rounded-lg text-sm text-gray-500 hover:bg-gray-50">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
