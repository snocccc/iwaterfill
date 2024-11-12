<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historical extends Model
{
    use HasFactory;
    protected $fillable = [
        'period_type',
        'start_date',
        'end_date',
        'total_sales',
    ];
}
