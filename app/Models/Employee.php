<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id', 'name', 'email', 'phone', 'department', 'position',
        'salary', 'hire_date', 'termination_date', 'status', 'avatar', 'address', 'notes',
    ];

    protected $casts = [
        'hire_date'        => 'date',
        'termination_date' => 'date',
        'salary'           => 'decimal:2',
    ];
}
