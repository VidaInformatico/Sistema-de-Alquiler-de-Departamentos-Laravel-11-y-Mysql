<?php

namespace App\Livewire\Admin;

use App\Exports\ExpensesExport;
use App\Models\CashBox;
use App\Models\Expense;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseComponent extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $amount, $description, $expense_id;
    public $isEditMode = false;
    public $searchTerm;
    public $fromDate;
    public $toDate;
    public $photo;

    protected $listeners = ['delete'];

    protected $rules = [
        'amount' => 'required|numeric',
        'description' => 'required|string|max:255',
        'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Regla para la foto
    ];

    public function render()
    {
        $query = Expense::query();

        // Filtrar por el término de búsqueda
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('amount', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Filtrar por fechas
        if (!empty($this->fromDate) && !empty($this->toDate)) {
            $fromDate = Carbon::parse($this->fromDate)->startOfDay();
            $toDate = Carbon::parse($this->toDate)->endOfDay();
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $expenses = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.admin.expense-component', ['expenses' => $expenses])
            ->extends('admin.layouts.app');
    }

    public function resetInputFields()
    {
        $this->amount = '';
        $this->description = '';
        $this->photo = null; // Resetear la foto
        $this->expense_id = '';
        $this->isEditMode = false;
    }

    public function storeOrUpdate()
    {
        $this->validate();

        //COMPORBAR CAJA
        $caja = CashBox::where('status', 1)->first();

        if ($caja) {
            //GASTOS
            $gasto = Expense::where('cashbox_id', $caja->id)->sum('amount');
            $pagos = Payment::where('cashbox_id', $caja->id)->sum('amount');
            //COMPORBAR SALDO
            $saldo = ($caja->initial_amount + $pagos) - $gasto;
            if ($this->isEditMode) {
                //GASTO ANTERIOR
                $anterior = Expense::findOrFail($this->expense_id);
                $saldo = ($caja->initial_amount + $pagos + $anterior->amount) - $gasto;
            }

            if ($saldo >=  $this->amount) {
                $expenseData = [
                    'amount' => $this->amount,
                    'description' => $this->description,
                    'cashbox_id' => $caja->id
                ];

                if ($this->isEditMode) {
                    $expense = Expense::find($this->expense_id);

                    // Verificar si se ha cargado una nueva imagen
                    if ($this->photo) {
                        // Eliminar la imagen anterior si existe
                        if ($expense->photo) {
                            Storage::disk('public')->delete($expense->photo);
                        }

                        // Guardar la nueva imagen
                        $path = $this->photo->store('photos', 'public');
                        $expenseData['photo'] = $path;
                    } else {
                        // Mantener la imagen existente si no se carga una nueva
                        $expenseData['photo'] = $expense->photo;
                    }
                } else {
                    // Guardar la imagen si es una nueva creación
                    if ($this->photo) {
                        $path = $this->photo->store('photos', 'public');
                        $expenseData['photo'] = $path;
                    }
                }

                Expense::updateOrCreate(
                    ['id' => $this->isEditMode ? $this->expense_id : null],
                    $expenseData
                );

                $message = $this->isEditMode ? 'Gasto actualizado exitosamente.' : 'Gasto creado con éxito.';
                session(null)->flash('message', $message);

                $this->resetInputFields();
                $this->dispatch('expenseStoreOrUpdate');
            } else {
                session(null)->flash('warning', 'Saldo no disponible');
            }
        } else {
            session(null)->flash('warning', 'La caja esta cerrada');
        }
    }


    public function edit($id)
    {
        $this->resetValidation();
        $expense = Expense::findOrFail($id);
        $this->expense_id = $id;
        $this->amount = $expense->amount;
        $this->description = $expense->description;
        $this->photo = null; // Limpiar la foto en el modo de edición
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        $expense = Expense::find($id);
        if ($expense) {
            // Eliminar la foto si existe
            if ($expense->photo) {
                Storage::disk('public')->delete($expense->photo);
            }
            $expense->delete();
            $this->dispatch('expenseDeleted');
        } else {
            session(null)->flash('message', 'Gasto no encontrado.');
        }
    }

    public function exportExcel()
    {
        return Excel::download(new ExpensesExport($this->fromDate, $this->toDate, $this->searchTerm), 'expenses.xlsx');
    }
}
