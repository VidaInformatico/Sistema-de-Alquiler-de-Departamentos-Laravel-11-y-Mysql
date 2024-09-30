<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'identification_number',
        'identification_type'
    ];

    // Relación con Rent
    public function rents()
    {
        return $this->hasMany(Rent::class);
    }
}
