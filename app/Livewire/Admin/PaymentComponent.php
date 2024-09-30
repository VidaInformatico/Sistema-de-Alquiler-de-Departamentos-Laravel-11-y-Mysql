<?php

namespace App\Livewire\Admin;

use App\Models\CashBox;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $rent;
    public $searchTerm = '';
    public $amount;
    public $payment_date;
    public $total = 0;

    public function mount($rent)
    {
        $this->rent = $rent;
        $room = Room::findOrFail($this->rent->room_id);
        $rentalPrice = $room->rentalprice;
        $lightPrice = $room->lightprice;
        $waterPrice = $room->waterprice;
        $this->total = ($rentalPrice + $lightPrice + $waterPrice);
    }

    public function resetInputFields()
    {
        $this->amount = '';
        $this->payment_date = '';
    }

    public function storePayment()
    {
        $this->validate([
            'amount' => 'required|numeric'
        ]);

        //COMPORBAR CAJA
        $caja = CashBox::where('status', 1)->first();
        if ($caja) {

            $payment = Payment::create([
                'amount' => $this->amount,
                'rent_id' => $this->rent->id,
                'cashbox_id' => $caja->id
            ]);

            $pdfPath = route('payment.pdf', ['id' => Crypt::encrypt($payment->id)]);

            session(null)->flash('message', 'Pago agregado exitosamente. El ticket se abrirá en una nueva ventana.');

            $this->dispatch('paymentStored', ['pdfPath' => $pdfPath]);

            $this->resetInputFields();
        } else {
            session(null)->flash('warning', 'La caja esta cerrada');
        }
    }

    public function render()
    {
        $payments = Payment::where('created_at', 'like', '%' . $this->searchTerm . '%')
            ->where('rent_id', $this->rent->id)
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('livewire.admin.payment-component', compact('payments'));
    }
}
