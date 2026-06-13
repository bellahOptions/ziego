<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Invoice $invoice)
    {
        abort_unless($invoice->order->user_id === auth()->id() || auth()->user()->isAdmin(), 403);
        $invoice->load('order.items.product', 'order.user');
        return view('invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        abort_unless($invoice->order->user_id === auth()->id() || auth()->user()->isAdmin(), 403);
        $invoice->load('order.items.product', 'order.user');

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }
}
