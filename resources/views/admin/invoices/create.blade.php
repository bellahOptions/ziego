@extends('layouts.admin')
@section('title', 'Create Invoice')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.invoices.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <h1 class="text-xl font-bold" style="color: var(--brand-dark);">Create Invoice</h1>
</div>

<livewire:admin.invoices.create-form />
@endsection
