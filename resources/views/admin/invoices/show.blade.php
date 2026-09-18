@extends('layouts.admin')
@section('title', 'Invoice ' . $invoice->invoice_number)

@section('content')
@php
$statusBadge = match($invoice->status) {
    'draft'     => 'badge-inactive',
    'sent'      => 'badge-processing',
    'paid'      => 'badge-paid',
    'overdue'   => 'badge-cancelled',
    'cancelled' => 'badge-cancelled',
    default     => 'badge-inactive',
};
@endphp

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.invoices.index') }}" class="text-gray-400 hover:text-gray-600">← Back</a>
        <h1 class="text-xl font-bold" style="color: var(--brand-dark);">{{ $invoice->invoice_number }}</h1>
        <span class="badge {{ $statusBadge }}">{{ ucfirst($invoice->status) }}</span>
    </div>
    <div class="flex items-center gap-2">
        @if($invoice->status === 'draft')
        <form action="{{ route('admin.invoices.status', $invoice) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="sent">
            <button type="submit" class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Issue Invoice
            </button>
        </form>
        @elseif($invoice->status === 'sent')
        <form action="{{ route('admin.invoices.status', $invoice) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="paid">
            <button type="submit" class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Mark as Paid
            </button>
        </form>
        @endif
        <a href="{{ route('admin.invoices.download', $invoice) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold border transition-colors hover:bg-gray-50" style="color: var(--brand-dark); border-color: var(--brand);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Download PDF
        </a>
    </div>
</div>

@if($invoice->status === 'draft')
<div class="mb-6 p-4 rounded-lg text-sm flex items-center gap-3" style="background: var(--brand-pale); border: 1px solid rgba(150,75,0,0.2);">
    <svg class="w-5 h-5 flex-shrink-0" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    This invoice is still a draft and hasn't been sent to the customer. Click <strong>Issue Invoice</strong> to email it to them with the PDF attached.
</div>
@endif

<div class="max-w-3xl">
    @include('invoices.partials.invoice-content')
</div>
@endsection
