<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'rent_id',
        'cashbox_id'      
    ];

    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }
}
