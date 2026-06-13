<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    {{-- Header --}}
    <div class="p-8" style="background: linear-gradient(135deg, var(--brand-dark) 0%, #5A2D00 100%);">
        <div class="flex justify-between items-start">
            <div>
                <div class="text-white font-bold text-2xl" style="font-family: 'Calistoga', serif;">ZIEGO</div>
                <div class="text-xs mt-0.5" style="color: var(--gold); letter-spacing: 0.15em;">FURNITURE & INTERIORS</div>
                <div class="text-white/50 text-xs mt-3">RC: 9093335</div>
                <div class="text-white/50 text-xs">Nigeria | Nationwide Delivery</div>
                <div class="text-white/50 text-xs">09137652910</div>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-white">INVOICE</div>
                <div class="text-white/70 text-sm mt-2">{{ $invoice->invoice_number }}</div>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-bold" style="background: rgba(212,168,83,0.3); color: var(--gold);">
                    {{ strtoupper($invoice->status) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Details --}}
    <div class="p-8">
        <div class="grid sm:grid-cols-2 gap-8 mb-8">
            <div>
                <div class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Bill To</div>
                <div class="font-bold" style="color: var(--brand-dark);">{{ $invoice->order->shipping_name }}</div>
                <div class="text-sm text-gray-500">{{ $invoice->order->shipping_phone }}</div>
                @if($invoice->order->shipping_email)<div class="text-sm text-gray-500">{{ $invoice->order->shipping_email }}</div>@endif
                <div class="text-sm text-gray-500 mt-1">{{ $invoice->order->shipping_address }}</div>
                @if($invoice->order->shipping_city)<div class="text-sm text-gray-500">{{ $invoice->order->shipping_city }}, {{ $invoice->order->shipping_state }}</div>@endif
            </div>
            <div class="sm:text-right">
                <div class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Invoice Details</div>
                <div class="space-y-1 text-sm">
                    <div><span class="text-gray-400">Issue Date:</span> <span class="font-medium">{{ $invoice->issue_date->format('M d, Y') }}</span></div>
                    <div><span class="text-gray-400">Due Date:</span> <span class="font-medium">{{ $invoice->due_date->format('M d, Y') }}</span></div>
                    <div><span class="text-gray-400">Order:</span> <span class="font-medium">{{ $invoice->order->order_number }}</span></div>
                </div>
            </div>
        </div>

        {{-- Items table --}}
        <table class="w-full mb-6 text-sm">
            <thead>
                <tr style="background: var(--cream);">
                    <th class="text-left p-3 font-semibold text-gray-500 text-xs uppercase tracking-wider rounded-l-lg">Item</th>
                    <th class="text-center p-3 font-semibold text-gray-500 text-xs uppercase tracking-wider">Qty</th>
                    <th class="text-right p-3 font-semibold text-gray-500 text-xs uppercase tracking-wider">Unit Price</th>
                    <th class="text-right p-3 font-semibold text-gray-500 text-xs uppercase tracking-wider rounded-r-lg">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->order->items as $item)
                <tr class="border-b border-gray-50">
                    <td class="p-3">
                        <div class="font-medium" style="color: var(--brand-dark);">{{ $item->product_name }}</div>
                        @if($item->product_sku)<div class="text-xs text-gray-400">SKU: {{ $item->product_sku }}</div>@endif
                    </td>
                    <td class="p-3 text-center text-gray-600">{{ $item->quantity }}</td>
                    <td class="p-3 text-right text-gray-600">₦{{ number_format($item->unit_price) }}</td>
                    <td class="p-3 text-right font-semibold" style="color: var(--brand-dark);">₦{{ number_format($item->total_price) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="flex justify-end">
            <div class="w-full max-w-xs space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-400">Subtotal</span><span>₦{{ number_format($invoice->subtotal) }}</span></div>
                @if($invoice->discount > 0)<div class="flex justify-between text-green-600"><span>Discount</span><span>-₦{{ number_format($invoice->discount) }}</span></div>@endif
                @if($invoice->tax > 0)<div class="flex justify-between"><span class="text-gray-400">Tax</span><span>₦{{ number_format($invoice->tax) }}</span></div>@endif
                <div class="flex justify-between font-bold text-lg border-t border-gray-200 pt-2">
                    <span>Total</span>
                    <span style="color: var(--brand);">₦{{ number_format($invoice->total) }}</span>
                </div>
            </div>
        </div>

        @if($invoice->notes)
        <div class="mt-8 p-4 rounded-lg" style="background: var(--cream);">
            <div class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">Notes</div>
            <p class="text-sm text-gray-600">{{ $invoice->notes }}</p>
        </div>
        @endif

        <div class="mt-8 pt-8 border-t border-gray-100 text-center text-xs text-gray-400">
            <p>Thank you for your business! | Ziego Furniture & Interiors | RC: 9093335 | 09137652910</p>
        </div>
    </div>
</div>
