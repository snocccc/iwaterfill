<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;
    protected $fillable = [
        'order_id',
        'username',
        'product_Name',
        'quantity',
        'price',
        'phone',
        'location',
        'image_url',
        'purchase_date',
        'status',
    ];

    // Cast `purchase_date` to Carbon instance
    protected $casts = [
        'purchase_date' => 'datetime',
    ];
}
