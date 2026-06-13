@extends('layouts.admin')
@section('title', 'Invoice ' . $invoice->invoice_number)

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.invoices.index') }}" class="text-gray-400 hover:text-gray-600">← Back</a>
        <h1 class="text-xl font-bold" style="color: var(--brand-dark);">{{ $invoice->invoice_number }}</h1>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.invoices.download', $invoice) }}" class="btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Download PDF
        </a>
    </div>
</div>

<div class="max-w-3xl">
    @include('invoices.partials.invoice-content')
</div>
@endsection
