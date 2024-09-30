<?php

namespace App\Livewire\Admin;

use App\Models\Property;
use App\Models\Rent;
use App\Models\Room;
use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;

class RoomComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rentalprice, $lightprice, $waterprice, $number, $type_id, $property_id, $room_id;
    public $isEditMode = false;
    public $searchTerm;
    public $types = [];
    public $properties = [];

    protected $listeners = ['delete'];

    protected $rules = [
        'rentalprice' => 'required',
        'lightprice' => 'required',
        'waterprice' => 'required',
        'number' => 'required|numeric',
        'type_id' => 'required|numeric',
        'property_id' => 'required|numeric',
    ];

    public function mount()
    {
        $this->types = Type::all();
        $this->properties = Property::all();
    }

    public function render()
    {
        $rooms = Room::with(['property', 'type'])
            ->where(function ($query) {
                $query->where('rentalprice', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('lightprice', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('waterprice', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('property', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchTerm . '%');
                    })
                    ->orWhereHas('type', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchTerm . '%');
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate(9);

        // Verifica si el room_id está en la tabla rents con status = 1
        $rents = Rent::where('status', 1)
            ->pluck('room_id')
            ->toArray();

        return view('livewire.admin.room-component', [
            'rooms' => $rooms,
            'rents' => $rents,
        ])
            ->extends('admin.layouts.app');
    }

    public function resetInputFields()
    {
        $this->rentalprice = '';
        $this->lightprice = '';
        $this->waterprice = '';
        $this->number = '';
        $this->type_id = '';
        $this->property_id = '';
        $this->room_id = '';
        $this->isEditMode = false;
    }

    public function storeOrUpdate()
    {
        $this->validate();

        Room::updateOrCreate(
            ['id' => $this->isEditMode ? $this->room_id : null],
            [
                'rentalprice' => $this->rentalprice,
                'lightprice' => $this->lightprice,
                'waterprice' => $this->waterprice,
                'number' => $this->number,
                'type_id' => $this->type_id,
                'property_id' => $this->property_id,
            ]
        );

        $message = $this->isEditMode ? 'Habitación actualizada exitosamente.' : 'Habitación creada con éxito.';
        session(null)->flash('message', $message);

        $this->resetInputFields();
        $this->dispatch('roomStoreOrUpdate');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $room = Room::findOrFail($id);
        $this->room_id = $id;
        $this->rentalprice = $room->rentalprice;
        $this->lightprice = $room->lightprice;
        $this->waterprice = $room->waterprice;
        $this->number = $room->number;
        $this->type_id = $room->type_id;
        $this->property_id = $room->property_id;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        $room = Room::find($id);
        if ($room) {
            $room->delete();
            $this->dispatch('roomDeleted');
        } else {
            session(null)->flash('message', 'Habitación no encontrada.');
        }
    }

    //LIBERAR
    public function liberar($id) {
        Rent::where('status', 1)->where('room_id', $id)->update([
            'status' => 0
        ]);
        session(null)->flash('message', 'Alquiler Liberado');
    }
}
