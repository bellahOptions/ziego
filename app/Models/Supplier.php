<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'contact_person', 'email', 'phone', 'address', 'city', 'state',
        'products_supplied', 'credit_limit', 'outstanding_balance', 'status', 'notes',
    ];

    protected $casts = [
        'credit_limit'        => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
    ];

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }
}
