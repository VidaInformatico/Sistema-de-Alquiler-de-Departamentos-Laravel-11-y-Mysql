<?php

namespace App\Exports;

use App\Models\Expense;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpensesExport implements FromCollection, WithHeadings, WithMapping
{
    public $fromDate;
    public $toDate;
    public $searchTerm;

    public function __construct($fromDate, $toDate, $searchTerm)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->searchTerm = $searchTerm;
    }

    public function collection()
    {
        $query = Expense::query();

        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('amount', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        if (!empty($this->fromDate) && !empty($this->toDate)) {
            $fromDate = Carbon::parse($this->fromDate)->startOfDay();
            $toDate = Carbon::parse($this->toDate)->endOfDay();
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Monto',
            'Fecha/Hora',
            'Descripción'
        ];
    }

    public function map($expense): array
    {
        return [
            $expense->amount,
            Carbon::parse($expense->created_at)->format('d/m/Y H:i'),
            $expense->description,
        ];
    }
}