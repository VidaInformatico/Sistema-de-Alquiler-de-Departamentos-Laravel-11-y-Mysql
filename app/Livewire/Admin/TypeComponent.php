<?php

namespace App\Livewire\Admin;

use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;

class TypeComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $description, $type_id;
    public $isEditMode = false;
    public $searchTerm;

    protected $listeners = ['delete'];

    protected $rules = [
        'name' => 'required|string'
    ];

    public function render()
    {
        $types = Type::where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.type-component', ['types' => $types])
            ->extends('admin.layouts.app');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->type_id = '';
        $this->isEditMode = false;
    }

    public function storeOrUpdate()
    {
        $this->validate();

        Type::updateOrCreate(
            ['id' => $this->isEditMode ? $this->type_id : null],
            [
                'name' => $this->name,
                'description' => $this->description
            ]
        );

        $message = $this->isEditMode ? 'Tipo actualizada exitosamente.' : 'Tipo creada con éxito.';
        session(null)->flash('message', $message);

        $this->resetInputFields();
        $this->dispatch('typeStoreOrUpdate');
    }


    public function edit($id)
    {
        $this->resetValidation();
        $type = Type::findOrFail($id);
        $this->type_id = $id;
        $this->name = $type->name;
        $this->description = $type->description;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        $type = Type::find($id);
        if ($type) {
            $type->delete();
            $this->dispatch('typeDeleted');
        } else {
            session(null)->flash('message', 'Tipo no encontrada.');
        }
    }
}