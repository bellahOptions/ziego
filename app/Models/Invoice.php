<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invoice) {
            $invoice->invoice_number = 'INV-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        });
    }
}
