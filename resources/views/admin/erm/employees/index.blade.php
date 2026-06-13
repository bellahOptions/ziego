@extends('layouts.admin')
@section('title', 'Employees — ERM')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold" style="color: var(--brand-dark);">Employees</h1>
    <button onclick="document.getElementById('add-modal').classList.remove('hidden')" class="btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Employee
    </button>
</div>

{{-- Filters --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-4">
    <form action="{{ route('admin.erm.employees.index') }}" method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, position..." class="form-input text-sm w-48">
        <select name="department" class="form-input text-sm w-40">
            <option value="">All Departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
            @endforeach
        </select>
        <select name="status" class="form-input text-sm w-32">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="on_leave" {{ request('status') === 'on_leave' ? 'selected' : '' }}>On Leave</option>
            <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>Terminated</option>
        </select>
        <button type="submit" class="btn-primary btn-sm">Filter</button>
    </form>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Hire Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $emp)
                <tr>
                    <td class="font-mono text-xs" style="color: var(--brand);">{{ $emp->employee_id }}</td>
                    <td>
                        <div class="font-medium text-sm">{{ $emp->name }}</div>
                        @if($emp->email)<div class="text-xs text-gray-400">{{ $emp->email }}</div>@endif
                    </td>
                    <td class="text-sm">{{ $emp->department }}</td>
                    <td class="text-sm">{{ $emp->position }}</td>
                    <td class="text-xs text-gray-400">{{ $emp->hire_date->format('M d, Y') }}</td>
                    <td>
                        <span class="badge {{ $emp->status === 'active' ? 'badge-active' : ($emp->status === 'on_leave' ? 'badge-pending' : 'badge-cancelled') }}">
                            {{ ucfirst(str_replace('_',' ',$emp->status)) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.erm.employees.destroy', $emp) }}" method="POST" onsubmit="return confirm('Remove employee?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($employees->isEmpty())
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No employees found</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-100">{{ $employees->withQueryString()->links() }}</div>
</div>

{{-- Add Employee Modal --}}
<div id="add-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold" style="color: var(--brand-dark);">Add Employee</h2>
            <button onclick="document.getElementById('add-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.erm.employees.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" required class="form-input" placeholder="John Doe">
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input">
                </div>
                <div>
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-input">
                </div>
                <div>
                    <label class="form-label">Department *</label>
                    <input type="text" name="department" required class="form-input" placeholder="e.g. Sales, Delivery">
                </div>
                <div>
                    <label class="form-label">Position *</label>
                    <input type="text" name="position" required class="form-input" placeholder="e.g. Store Manager">
                </div>
                <div>
                    <label class="form-label">Salary (₦)</label>
                    <input type="number" name="salary" class="form-input">
                </div>
                <div>
                    <label class="form-label">Hire Date *</label>
                    <input type="date" name="hire_date" required value="{{ date('Y-m-d') }}" class="form-input">
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Address</label>
                    <textarea name="address" rows="2" class="form-input"></textarea>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 justify-center">Add Employee</button>
                <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')" class="flex-1 px-4 py-3 border border-gray-200 rounded-lg text-sm text-gray-500 hover:bg-gray-50">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
