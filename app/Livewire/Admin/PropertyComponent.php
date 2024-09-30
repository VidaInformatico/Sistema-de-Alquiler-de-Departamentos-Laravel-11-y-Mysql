<?php

namespace App\Livewire\Admin;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $city, $address, $property_id;
    public $isEditMode = false;
    public $searchTerm;

    protected $listeners = ['delete'];

    protected $rules = [
        'name' => 'required|string',
        'city' => 'required|string',
        'address' => 'required|string',
    ];

    public function render()
    {
        $properties = Property::where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('city', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('address', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.property-component', ['properties' => $properties])
            ->extends('admin.layouts.app');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->city = '';
        $this->address = '';
        $this->property_id = '';
        $this->isEditMode = false;
    }

    public function storeOrUpdate()
    {
        $this->validate();

        Property::updateOrCreate(
            ['id' => $this->isEditMode ? $this->property_id : null],
            [
                'name' => $this->name,
                'city' => $this->city,
                'address' => $this->address,
            ]
        );

        $message = $this->isEditMode ? 'Propiedad actualizada exitosamente.' : 'Propiedad creada con éxito.';
        session(null)->flash('message', $message);

        $this->resetInputFields();
        $this->dispatch('propertyStoreOrUpdate');
    }


    public function edit($id)
    {
        $this->resetValidation();
        $property = Property::findOrFail($id);
        $this->property_id = $id;
        $this->name = $property->name;
        $this->city = $property->city;
        $this->address = $property->address;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        $property = Property::find($id);
        if ($property) {
            $property->delete();
            $this->dispatch('propertyDeleted');
        } else {
            session(null)->flash('message', 'Propiedad no encontrada.');
        }
    }
}
