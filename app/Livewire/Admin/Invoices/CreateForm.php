<?php

namespace App\Livewire\Admin\Invoices;

use App\Mail\OrderConfirmation;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CreateForm extends Component
{
    // Customer selection
    public string $customerSearch = '';

    public ?int $customerId = null;

    public bool $showNewCustomerForm = false;

    public string $newCustomerName = '';

    public string $newCustomerEmail = '';

    // Shipping
    public string $shippingName = '';

    public string $shippingPhone = '';

    public string $shippingEmail = '';

    public string $shippingAddress = '';

    public string $shippingCity = '';

    public string $shippingState = '';

    // Line items
    public string $productSearch = '';

    /** @var array<int, array{product_id:int,name:string,sku:?string,price:float,qty:int,stock:int}> */
    public array $items = [];

    public string $orderStatus = 'confirmed';

    public int $dueInDays = 7;

    public string $notes = '';

    public function selectCustomer(int $id): void
    {
        $customer = User::where('role', 'customer')->findOrFail($id);

        $this->customerId = $customer->id;
        $this->customerSearch = '';
        $this->showNewCustomerForm = false;

        $this->shippingName    = $customer->name;
        $this->shippingPhone   = $customer->phone ?? '';
        $this->shippingEmail   = $customer->email;
        $this->shippingAddress = $customer->address ?? '';
    }

    public function clearCustomer(): void
    {
        $this->customerId = null;
        $this->shippingName = $this->shippingPhone = $this->shippingEmail = $this->shippingAddress = $this->shippingCity = $this->shippingState = '';
    }

    public function toggleNewCustomerForm(): void
    {
        $this->clearCustomer();
        $this->showNewCustomerForm = !$this->showNewCustomerForm;
    }

    public function addItem(int $productId): void
    {
        $product = Product::findOrFail($productId);

        foreach ($this->items as $i => $item) {
            if ($item['product_id'] === $productId) {
                if ($item['qty'] < $item['stock']) {
                    $this->items[$i]['qty']++;
                }
                return;
            }
        }

        if ($product->stock < 1) {
            $this->addError('items', "{$product->name} is out of stock.");
            return;
        }

        $this->items[] = [
            'product_id' => $product->id,
            'name'       => $product->name,
            'sku'        => $product->sku,
            'price'      => (float) $product->current_price,
            'qty'        => 1,
            'stock'      => $product->stock,
        ];

        $this->productSearch = '';
    }

    public function removeItem(int $index): void
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function incrementItem(int $index): void
    {
        if ($this->items[$index]['qty'] < $this->items[$index]['stock']) {
            $this->items[$index]['qty']++;
        }
    }

    public function decrementItem(int $index): void
    {
        if ($this->items[$index]['qty'] > 1) {
            $this->items[$index]['qty']--;
        }
    }

    public function getSubtotalProperty(): float
    {
        return collect($this->items)->sum(fn ($i) => $i['price'] * $i['qty']);
    }

    public function getFilteredProductsProperty()
    {
        if (trim($this->productSearch) === '') {
            return collect();
        }

        return Product::query()
            ->where('status', 'active')
            ->where(function ($q) {
                $q->where('name', 'like', "%{$this->productSearch}%")
                  ->orWhere('sku', 'like', "%{$this->productSearch}%");
            })
            ->orderBy('name')
            ->take(8)
            ->get();
    }

    public function getFilteredCustomersProperty()
    {
        if (trim($this->customerSearch) === '') {
            return collect();
        }

        return User::where('role', 'customer')
            ->where(function ($q) {
                $q->where('name', 'like', "%{$this->customerSearch}%")
                  ->orWhere('email', 'like', "%{$this->customerSearch}%");
            })
            ->orderBy('name')
            ->take(8)
            ->get();
    }

    public function save()
    {
        $this->validate([
            'shippingName'    => 'required|string|max:100',
            'shippingPhone'   => 'required|string|max:20',
            'shippingEmail'   => 'nullable|email',
            'shippingAddress' => 'required|string',
            'shippingCity'    => 'nullable|string|max:100',
            'shippingState'   => 'nullable|string|max:100',
            'orderStatus'     => 'required|in:pending,confirmed,processing',
            'dueInDays'       => 'required|integer|min:1|max:90',
            'notes'           => 'nullable|string|max:1000',
        ]);

        if (!$this->customerId && !$this->showNewCustomerForm) {
            $this->addError('customerId', 'Please select an existing customer or add a new one.');
            return;
        }

        if ($this->showNewCustomerForm) {
            $this->validate([
                'newCustomerName'  => 'required|string|max:100',
                'newCustomerEmail' => 'required|email|unique:users,email',
            ]);
        }

        if (empty($this->items)) {
            $this->addError('items', 'Add at least one product to the invoice.');
            return;
        }

        foreach ($this->items as $item) {
            if ($item['qty'] > $item['stock']) {
                $this->addError('items', "{$item['name']} only has {$item['stock']} in stock.");
                return;
            }
        }

        $order = DB::transaction(function () {
            if ($this->showNewCustomerForm) {
                $customer = User::create([
                    'name'      => $this->newCustomerName,
                    'email'     => $this->newCustomerEmail,
                    'password'  => Hash::make(str()->password(16)),
                    'role'      => 'customer',
                    'phone'     => $this->shippingPhone,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
            } else {
                $customer = User::findOrFail($this->customerId);
            }

            $subtotal = $this->subtotal;

            $order = Order::create([
                'user_id'          => $customer->id,
                'status'           => $this->orderStatus,
                'payment_status'   => 'unpaid',
                'subtotal'         => $subtotal,
                'discount'         => 0,
                'shipping_fee'     => 0,
                'tax'              => 0,
                'total'            => $subtotal,
                'shipping_name'    => $this->shippingName,
                'shipping_phone'   => $this->shippingPhone,
                'shipping_email'   => $this->shippingEmail ?: null,
                'shipping_address' => $this->shippingAddress,
                'shipping_city'    => $this->shippingCity ?: null,
                'shipping_state'   => $this->shippingState ?: null,
                'notes'            => $this->notes ?: null,
                'confirmed_at'     => $this->orderStatus === 'confirmed' ? now() : null,
            ]);

            foreach ($this->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_sku'  => $item['sku'],
                    'quantity'     => $item['qty'],
                    'unit_price'   => $item['price'],
                    'total_price'  => $item['price'] * $item['qty'],
                ]);

                Product::whereKey($item['product_id'])->decrement('stock', $item['qty']);
            }

            Invoice::create([
                'order_id'   => $order->id,
                'status'     => 'draft',
                'subtotal'   => $subtotal,
                'tax'        => 0,
                'discount'   => 0,
                'total'      => $subtotal,
                'issue_date' => now()->toDateString(),
                'due_date'   => now()->addDays($this->dueInDays)->toDateString(),
            ]);

            return $order;
        });

        $order->load('items', 'invoice', 'user');

        try {
            $recipient = $order->shipping_email ?: $order->user->email;
            Mail::to($recipient)->cc(User::adminEmails())->send(new OrderConfirmation($order));
        } catch (\Throwable $e) {
            report($e);
        }

        session()->flash('success', "Invoice created for order {$order->order_number}.");

        return $this->redirect(route('admin.invoices.show', $order->invoice));
    }

    public function render()
    {
        return view('livewire.admin.invoices.create-form');
    }
}
