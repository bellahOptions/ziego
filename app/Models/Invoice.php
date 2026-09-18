<?php

namespace App\Models;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invoice extends Model
{
    protected $fillable = [
        'order_id', 'invoice_number', 'status', 'subtotal', 'tax',
        'discount', 'total', 'issue_date', 'due_date', 'notes', 'pdf_path', 'sent_at', 'paid_at',
    ];

    protected $casts = [
        'subtotal'   => 'decimal:2',
        'tax'        => 'decimal:2',
        'discount'   => 'decimal:2',
        'total'      => 'decimal:2',
        'issue_date' => 'date',
        'due_date'   => 'date',
        'sent_at'    => 'datetime',
        'paid_at'    => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function pdfBytes(): string
    {
        $this->loadMissing('order.items.product', 'order.user');

        return Pdf::loadView('invoices.pdf', ['invoice' => $this])->output();
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invoice) {
            $invoice->uuid = (string) Str::uuid();
            $invoice->invoice_number = 'INV-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        });
    }
}
