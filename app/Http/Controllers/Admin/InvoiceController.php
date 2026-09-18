<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceIssued;
use App\Mail\PaymentReceipt;
use App\Models\Invoice;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function create()
    {
        return view('admin.invoices.create');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('order.items.product', 'order.user');
        return view('admin.invoices.show', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate(['status' => 'required|in:draft,sent,paid,overdue,cancelled']);

        $wasAlreadySent = $invoice->status === 'sent';
        $wasAlreadyPaid = $invoice->status === 'paid';

        $data = ['status' => $request->status];
        if ($request->status === 'sent') $data['sent_at'] = now();
        if ($request->status === 'paid') $data['paid_at'] = now();

        $invoice->update($data);

        if ($request->status === 'sent' && !$wasAlreadySent) {
            try {
                $invoice->load('order.items.product', 'order.user');
                $recipient = $invoice->order->shipping_email ?: $invoice->order->user->email;
                Mail::to($recipient)->cc(User::adminEmails())->send(new InvoiceIssued($invoice));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        if ($request->status === 'paid') {
            $invoice->order->update(['payment_status' => 'paid']);

            if (!$wasAlreadyPaid) {
                try {
                    $invoice->load('order.items.product', 'order.user');
                    $recipient = $invoice->order->shipping_email ?: $invoice->order->user->email;
                    Mail::to($recipient)->cc(User::adminEmails())->send(new PaymentReceipt($invoice));
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        }

        return back()->with('success', $request->status === 'sent' ? 'Invoice issued and emailed to the customer!' : 'Invoice status updated!');
    }

    public function download(Invoice $invoice)
    {
        $invoice->load('order.items.product', 'order.user');
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }
}
