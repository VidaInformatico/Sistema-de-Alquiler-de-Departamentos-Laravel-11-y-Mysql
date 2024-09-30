<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'rentalprice',
        'lightprice',
        'waterprice',
        'number',
        'property_id',
        'type_id',
    ];

    // Define the relationship with the Property model
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Define the relationship with the Type model
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // Relación con Rent
    public function rents()
    {
        return $this->hasMany(Rent::class);
    }
}
