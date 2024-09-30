<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'client_id',
        'room_id',
        'status'        
    ];

    // Relación con Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relación con Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
