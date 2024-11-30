<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'period_type',
        'product_name',
        'quantity',
        'start_date',
        'end_date',
        'is_processed'
    ];
}
