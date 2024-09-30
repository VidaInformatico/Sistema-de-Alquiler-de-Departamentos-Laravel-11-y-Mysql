<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'initial_amount',
        'spent',
        'closing_date',
        'status',
        'user_id'
    ];
}
