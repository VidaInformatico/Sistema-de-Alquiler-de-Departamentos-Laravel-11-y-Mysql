@extends('admin.layouts.app')

@section('title', 'Alquilar Habitación')

@section('content')

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="jumbotron jumbotron-fluid position-relative">
                <span class="badge bg-primary position-absolute top-0 end-0 m-2">N° {{ $rent->room->number }}</span>
                <h1 class="display-4">{{ $rent->client->full_name }}</h1>
                @php
                    use Carbon\Carbon;
                @endphp
                <p class="lead">{{ Carbon::parse($rent['created_at'])->format('d') }} de {{ Carbon::parse($rent['created_at'])->translatedFormat('F') }} de {{ Carbon::parse($rent['created_at'])->format('Y') }} a las {{ Carbon::parse($rent['created_at'])->format('H:i') }}</p>
                <hr class="my-4">                
                <div class="table-responsive mb-3">
                    <table class="table table-striped table-hover table-borderless table-primary align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Precio Alquiler</th>
                                <th>Precio Luz</th>
                                <th>Precio Agua</th>
                            </tr>
                        </thead>
                        @php
                            $rentalPrice = $rent->room->rentalprice;
                            $lightPrice = $rent->room->lightprice;
                            $waterPrice = $rent->room->waterprice;

                            $total = number_format($rentalPrice + $lightPrice + $waterPrice, 2);
                        @endphp
                        <tbody class="table-group-divider">
                            <tr class="table-primary">
                                <td>{{ number_format($rent->room->rentalprice, 2) }}</td>
                                <td>{{ number_format($rent->room->lightprice, 2) }}</td>
                                <td>{{ number_format($rent->room->waterprice, 2) }}</td>
                            </tr>
                            <tr>
                                <td>TOTAL</td>
                                <td colspan="2">
                                    <h3>{{ $total }}</h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="">
                <h4>Pagos Mensuales</h4>
                <hr>
                @livewire('admin.payment-component', ['rent' => $rent])
            </div>
        </div>
    </div>

@endsection
