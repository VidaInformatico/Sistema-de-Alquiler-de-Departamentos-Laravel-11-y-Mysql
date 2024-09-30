<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Rent;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class Principal extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        $rents = DB::table('rents')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $payments = DB::table('payments')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthNames = [
            1 => 'Ene',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dic'
        ];

        // Normalizar los datos para Chart.js
        $months = range(1, 12);
        $rentCounts = [];
        $paymentTotals = [];
        $labels = [];

        foreach ($months as $month) {
            $rentCounts[] = $rents->get($month, 0);
            $paymentTotals[] = $payments->get($month, 0);
            $labels[] = $monthNames[$month];
        }

        $data = [
            'totalRent' => Rent::count(),
            'totalRoom' => Room::count(),
            'totalClient' => Client::count(),
            'rentCounts' => $rentCounts,
            'paymentTotals' => $paymentTotals,
            'months' => $labels
        ];

        return view('admin.dashboard', compact('data'));
    }
}
