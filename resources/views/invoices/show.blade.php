@extends('layouts.app')
@section('title', 'Invoice ' . $invoice->invoice_number)

@section('content')
<div class="pt-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">
        <div class="flex items-center justify-between mb-6 no-print">
            <a href="{{ route('orders.show', $invoice->order) }}" class="text-sm text-gray-400 hover:text-gray-600">← Back to Order</a>
            <a href="{{ route('invoices.download', $invoice) }}" class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download PDF
            </a>
        </div>

        @include('invoices.partials.invoice-content')
    </div>
</div>
@endsection
