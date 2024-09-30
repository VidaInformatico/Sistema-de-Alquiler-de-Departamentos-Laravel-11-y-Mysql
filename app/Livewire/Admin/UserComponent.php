<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $email, $password, $password_confirmation;
    public $user_id;
    public $isEditMode = false;
    public $searchTerm;

    protected $listeners = ['delete'];

    protected function rules()
    {
        $rules = [
            'name' => 'required|string',
            'password' => $this->isEditMode ? 'nullable|string|confirmed' : 'required|string|confirmed',
            'email' => 'required|email'
        ];

        if ($this->isEditMode) {
            $rules['email'] .= '|unique:users,email,' . $this->user_id;
        } else {
            $rules['email'] .= '|unique:users,email';
        }

        return $rules;
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.user-component', ['users' => $users])
            ->extends('admin.layouts.app');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->user_id = '';
        $this->isEditMode = false;
    }

    public function storeOrUpdate()
    {
        // Validar los datos
        $this->validate();

        // Construir los datos para el modelo
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        // Añadir la contraseña solo si no está en modo de edición o si se ha proporcionado una nueva contraseña
        if (!$this->isEditMode && !empty($this->password)) {
            $userData['password'] = bcrypt($this->password);
        } elseif ($this->isEditMode && !empty($this->password)) {
            $userData['password'] = bcrypt($this->password);
        }

        // Guardar el usuario
        User::updateOrCreate(
            ['id' => $this->user_id],
            $userData
        );

        $message = $this->isEditMode ? 'Usuario actualizado exitosamente.' : 'Usuario creado con éxito.';
        session(null)->flash('message', $message);

        // Reiniciar los campos de entrada y despachar el evento
        $this->resetInputFields();
        $this->dispatch('userStoreOrUpdate');
    }


    public function edit($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $this->dispatch('userDeleted');
        } else {
            session(null)->flash('message', 'Usuario no encontrado.');
        }
    }
}
