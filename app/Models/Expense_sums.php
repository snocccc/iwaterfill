<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense_sums extends Model
{
    use HasFactory;
    protected $fillable = [
        'period_type',
        'amount',
        'start_date',
        'end_date',
    ];
}

