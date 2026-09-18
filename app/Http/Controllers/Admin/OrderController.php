<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('order_number', 'like', "%{$request->search}%")
                  ->orWhere('shipping_name', 'like', "%{$request->search}%")
                  ->orWhere('shipping_phone', 'like', "%{$request->search}%");
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product.primaryImage', 'invoice');
        return view('admin.orders.show', compact('order'));
    }

    public function generateInvoice(Order $order)
    {
        if ($order->invoice) {
            return redirect()->route('admin.invoices.show', $order->invoice);
        }

        $invoice = Invoice::create([
            'order_id'   => $order->id,
            'status'     => 'draft',
            'subtotal'   => $order->subtotal,
            'tax'        => $order->tax,
            'discount'   => $order->discount,
            'total'      => $order->total,
            'issue_date' => now()->toDateString(),
            'due_date'   => now()->addDays(7)->toDateString(),
        ]);

        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Invoice generated!');
    }
}
