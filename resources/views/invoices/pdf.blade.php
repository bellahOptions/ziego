<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1A1A1A; margin: 0; padding: 20px; }
        .header { background: #341C02; color: white; padding: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 24px; color: #D4A853; }
        .header p { margin: 2px 0; font-size: 11px; opacity: 0.7; }
        .invoice-num { font-size: 20px; font-weight: bold; }
        .grid { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .section-title { font-size: 10px; text-transform: uppercase; color: #888; margin-bottom: 4px; letter-spacing: 1px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #FFF3E0; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; color: #666; }
        td { padding: 8px; border-bottom: 1px solid #f0e8e0; }
        .totals { float: right; width: 250px; }
        .totals .row { display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px solid #f0e8e0; }
        .total-final { font-weight: bold; font-size: 14px; color: #964B00; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #f0e8e0; text-align: center; font-size: 10px; color: #888; }
        .status { background: #D4A853; color: #341C02; padding: 2px 10px; border-radius: 20px; font-size: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h1>ZIEGO FURNITURE & INTERIORS</h1>
                <p>RC: 9093335 | Nigeria | Nationwide Delivery</p>
                <p>Tel: 09137652910 | info@ziegofurniture.com</p>
            </div>
            <div style="text-align: right;">
                <div class="invoice-num">INVOICE</div>
                <div style="color: #D4A853; margin-top: 4px;">{{ $invoice->invoice_number }}</div>
                <div style="margin-top: 8px;"><span class="status">{{ strtoupper($invoice->status) }}</span></div>
            </div>
        </div>
    </div>

    <div class="grid">
        <div>
            <div class="section-title">Bill To</div>
            <strong>{{ $invoice->order->shipping_name }}</strong><br>
            {{ $invoice->order->shipping_phone }}<br>
            @if($invoice->order->shipping_email){{ $invoice->order->shipping_email }}<br>@endif
            {{ $invoice->order->shipping_address }}<br>
            @if($invoice->order->shipping_city){{ $invoice->order->shipping_city }}, {{ $invoice->order->shipping_state }}@endif
        </div>
        <div style="text-align: right;">
            <div class="section-title">Invoice Details</div>
            Issue Date: {{ $invoice->issue_date->format('M d, Y') }}<br>
            Due Date: {{ $invoice->due_date->format('M d, Y') }}<br>
            Order #: {{ $invoice->order->order_number }}
        </div>
    </div>

    <table>
        <tr>
            <th>Item Description</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: right;">Unit Price</th>
            <th style="text-align: right;">Total</th>
        </tr>
        @foreach($invoice->order->items as $item)
        <tr>
            <td>
                {{ $item->product_name }}
                @if($item->product_sku)<br><small style="color:#888;">SKU: {{ $item->product_sku }}</small>@endif
            </td>
            <td style="text-align: center;">{{ $item->quantity }}</td>
            <td style="text-align: right;">₦{{ number_format($item->unit_price) }}</td>
            <td style="text-align: right; font-weight: bold;">₦{{ number_format($item->total_price) }}</td>
        </tr>
        @endforeach
    </table>

    <div style="display: flex; justify-content: flex-end;">
        <table style="width: 280px;">
            <tr><td>Subtotal</td><td style="text-align:right;">₦{{ number_format($invoice->subtotal) }}</td></tr>
            @if($invoice->discount > 0)<tr><td>Discount</td><td style="text-align:right; color:green;">-₦{{ number_format($invoice->discount) }}</td></tr>@endif
            @if($invoice->tax > 0)<tr><td>Tax</td><td style="text-align:right;">₦{{ number_format($invoice->tax) }}</td></tr>@endif
            <tr style="font-weight:bold; font-size:14px; color:#964B00;">
                <td style="padding-top:8px; border-top: 2px solid #964B00;">Total</td>
                <td style="text-align:right; padding-top:8px; border-top: 2px solid #964B00;">₦{{ number_format($invoice->total) }}</td>
            </tr>
        </table>
    </div>

    @if($invoice->notes)
    <div style="margin-top: 30px; padding: 15px; background: #FFF3E0; border-radius: 6px;">
        <strong>Notes:</strong><br>{{ $invoice->notes }}
    </div>
    @endif

    <div class="footer">
        Thank you for your business! | Ziego Furniture & Interiors | RC: 9093335 | Tel: 09137652910
    </div>
</body>
</html>
