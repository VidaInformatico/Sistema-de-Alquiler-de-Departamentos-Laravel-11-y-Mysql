<?php

namespace App\Livewire\Admin;

use App\Models\Rent;
use Livewire\Component;
use Livewire\WithPagination;

class RentalComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $client = '';

    // Cargar la lista de clientes para el filtro
    public function render()
    {
        $rentals = Rent::with(['client', 'room'])
            ->when($this->client, function ($query) {
                $query->whereHas('client', function ($query) {
                    $query->where('full_name', 'like', '%' . $this->client . '%');
                });
            })
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('livewire.admin.rental-component', compact('rentals'))
            ->extends('admin.layouts.app');
    }

    //LIBERAR
    public function liberar(Rent $rent) {
        $rent->status = 0;
        $rent->update();
        session(null)->flash('message', 'Alquiler Liberado');
    }
}