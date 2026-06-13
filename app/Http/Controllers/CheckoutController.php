<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = Cart::with('items.product.primaryImage')
            ->where('user_id', auth()->id())
            ->firstOrFail();

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
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::transaction(function () use ($request, $cart) {
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

        return redirect()->route('orders.index')->with('success', 'Order placed successfully! We will confirm your order soon.');
    }
}
