<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.product.primaryImage')
            ->firstOrCreate(['user_id' => auth()->id()]);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name'    => 'required|string|max:100',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_email'   => 'nullable|email',
            'shipping_address' => 'required|string',
            'shipping_city'    => 'nullable|string|max:100',
            'shipping_state'   => 'nullable|string|max:100',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $cart = Cart::with('items.product')
            ->firstOrCreate(['user_id' => auth()->id()]);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $order = null;

        DB::transaction(function () use ($request, $cart, &$order) {
            $subtotal = $cart->items->sum(fn($i) => $i->product->current_price * $i->quantity);

            $order = Order::create([
                'user_id'          => auth()->id(),
                'status'           => 'pending',
                'payment_status'   => 'unpaid',
                'subtotal'         => $subtotal,
                'discount'         => 0,
                'shipping_fee'     => 0,
                'tax'              => 0,
                'total'            => $subtotal,
                'shipping_name'    => $request->shipping_name,
                'shipping_phone'   => $request->shipping_phone,
                'shipping_email'   => $request->shipping_email,
                'shipping_address' => $request->shipping_address,
                'shipping_city'    => $request->shipping_city,
                'shipping_state'   => $request->shipping_state,
                'notes'            => $request->notes,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_sku'  => $item->product->sku,
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->product->current_price,
                    'total_price'  => $item->product->current_price * $item->quantity,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            Invoice::create([
                'order_id'   => $order->id,
                'status'     => 'draft',
                'subtotal'   => $subtotal,
                'tax'        => 0,
                'discount'   => 0,
                'total'      => $subtotal,
                'issue_date' => now()->toDateString(),
                'due_date'   => now()->addDays(7)->toDateString(),
            ]);

            $cart->items()->delete();

            session(['last_order_id' => $order->id]);
        });

        $order->load('items', 'invoice', 'user');

        try {
            $recipient = $order->shipping_email ?: $order->user->email;
            Mail::to($recipient)->cc(User::adminEmails())->send(new OrderConfirmation($order));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully! We will confirm your order soon.');
    }
}
