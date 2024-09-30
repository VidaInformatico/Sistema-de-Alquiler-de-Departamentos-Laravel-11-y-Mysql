<?php

namespace App\Livewire\Admin;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $full_name, $date_of_birth, $gender, $phone, $email, $address, $city, $state, $postal_code, $country, $identification_number, $identification_type;
    public $client_id;
    public $isEditMode = false;
    public $searchTerm;

    protected $listeners = ['delete'];

    protected function rules()
    {
        $rules = [
            'full_name' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|string',
            'state' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
            'identification_number' => 'nullable|string',
            'identification_type' => 'nullable|string'
        ];

        if ($this->isEditMode) {
            $rules['email'] .= '|unique:clients,email,' . $this->client_id;
        } else {
            $rules['email'] .= '|unique:clients,email';
        }

        return $rules;
    }

    public function render()
    {
        $clients = Client::where('full_name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('city', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('address', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.client-component', ['clients' => $clients])
            ->extends('admin.layouts.app');
    }

    public function resetInputFields()
    {
        $this->full_name = '';
        $this->date_of_birth = '';
        $this->gender = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->city = '';
        $this->state = '';
        $this->postal_code = '';
        $this->country = '';
        $this->identification_number = '';
        $this->identification_type = '';
        $this->client_id = '';
        $this->isEditMode = false;
    }

    public function storeOrUpdate()
    {
        $this->validate();

        Client::updateOrCreate(
            ['id' => $this->client_id],
            [
                'full_name' => $this->full_name,
                'date_of_birth' => $this->date_of_birth,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'country' => $this->country,
                'identification_number' => $this->identification_number,
                'identification_type' => $this->identification_type
            ]
        );

        $message = $this->isEditMode ? 'Cliente actualizado exitosamente.' : 'Cliente creado con éxito.';
        session(null)->flash('message', $message);

        $this->resetInputFields();
        $this->dispatch('clientStoreOrUpdate');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $client = Client::findOrFail($id);
        $this->client_id = $id;
        $this->full_name = $client->full_name;
        $this->date_of_birth = $client->date_of_birth;
        $this->gender = $client->gender;
        $this->phone = $client->phone;
        $this->email = $client->email;
        $this->address = $client->address;
        $this->city = $client->city;
        $this->state = $client->state;
        $this->postal_code = $client->postal_code;
        $this->country = $client->country;
        $this->identification_number = $client->identification_number;
        $this->identification_type = $client->identification_type;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        $client = Client::find($id);
        if ($client) {
            $client->delete();
            $this->dispatch('clientDeleted');
        } else {
            session(null)->flash('message', 'Cliente no encontrado.');
        }
    }
}
