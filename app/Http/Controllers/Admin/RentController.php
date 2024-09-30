<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rent;
use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;

class RentController extends Controller
{
    public function index(Request $request, $encript_id)
    {
        $id = Crypt::decrypt($encript_id);
        $room = Room::with(['property', 'type'])->findOrFail($id);
        return view('admin.rooms.rent', compact('room'));
    }

    public function payment(Request $request, $encript_id)
    {
        $id = Crypt::decrypt($encript_id);
        $rent = Rent::with(['client', 'room'])->findOrFail($id);
            
        return view('admin.rooms.payment', compact('rent'));
    }

    public function ticketPago($encript_id) {

        $id = Crypt::decrypt($encript_id);

        $payment = Payment::with([
            'rent',
            'rent.room.property',  // Cargar las relaciones anidadas
            'rent.room.type'
        ])->findOrFail($id);

        $html = View::make('admin.rooms.ticket', ['payment' => $payment])->render();
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = Pdf::loadHTML($html)->setPaper([0, 0, 180, 500], 'portrait')->setWarnings(false);
        
        return $pdf->stream('ticket.pdf');
    }
}
