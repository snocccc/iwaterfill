<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'product_Name',
        'quantity',
        'price',
        'purchase_date',
    ];
    // Cast `purchase_date` to Carbon instance
    protected $casts = [
        'purchase_date' => 'datetime',
    ];
}
