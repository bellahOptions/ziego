<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('order.user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest()->paginate(20)->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('order.items.product', 'order.user');
        return view('admin.invoices.show', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate(['status' => 'required|in:draft,sent,paid,overdue,cancelled']);

        $data = ['status' => $request->status];
        if ($request->status === 'sent') $data['sent_at'] = now();
        if ($request->status === 'paid') $data['paid_at'] = now();

        $invoice->update($data);

        if ($request->status === 'paid') {
            $invoice->order->update(['payment_status' => 'paid']);
        }

        return back()->with('success', 'Invoice status updated!');
    }

    public function download(Invoice $invoice)
    {
        $invoice->load('order.items.product', 'order.user');
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }
}
