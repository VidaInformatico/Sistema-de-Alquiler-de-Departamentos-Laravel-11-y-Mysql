<?php

namespace App\Livewire\Admin;

use App\Models\CashBox;
use App\Models\Expense;
use Livewire\Component;
use Livewire\WithPagination;

class CashComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $initial_amount, $description, $cashbox_id;
    public $isEditMode = false;
    public $searchTerm;
    public $cajaExiste;

    protected $listeners = ['delete'];

    protected $rules = [
        'initial_amount' => 'required'
    ];

    public function render()
    {
        $this->cajaExiste = CashBox::where('status', 1)->first();

        $cashboxs = CashBox::where('initial_amount', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('status', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.cash-component', ['cashboxs' => $cashboxs])
            ->extends('admin.layouts.app');
    }

    public function resetInputFields()
    {
        $this->initial_amount = '';
        $this->cashbox_id = '';
        $this->isEditMode = false;
    }

    public function storeOrUpdate()
    {
        $this->validate();

        CashBox::updateOrCreate(
            ['id' => $this->isEditMode ? $this->cashbox_id : null],
            [
                'initial_amount' => $this->initial_amount,
                'user_id' => auth()->user()->id
            ]
        );

        $message = $this->isEditMode ? 'Monto inicial actualizada exitosamente.' : 'Monto inicial creada con éxito.';
        session(null)->flash('message', $message);

        $this->resetInputFields();
        $this->dispatch('cashStoreOrUpdate');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $type = CashBox::findOrFail($id);
        $this->cashbox_id = $id;
        $this->initial_amount = $type->initial_amount;
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        $type = CashBox::find($id);
        if ($type) {
            $type->delete();
        } else {
            session(null)->flash('message', 'Monto inicial no encontrada.');
        }
    }

    public function cerrarCaja() {
        $gasto = Expense::where('cashbox_id', $this->cajaExiste->id)->sum('amount');
        $this->cajaExiste->status = 0;
        $this->cajaExiste->closing_date = date('Y-m-d H:i:s');
        $this->cajaExiste->spent = $gasto;
        $this->cajaExiste->update();
        session(null)->flash('message', 'Caja Cerrado.');
    }
}
