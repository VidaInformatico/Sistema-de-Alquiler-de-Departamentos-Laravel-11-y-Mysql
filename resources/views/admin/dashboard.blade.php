@extends('admin.layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Clientes <i class="mdi mdi-account-group mdi-24px float-right"></i>
                    </h4>
                    <h2 class="">{{ $data['totalClient'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Habitaciones <i
                            class="mdi mdi-room-service mdi-24px float-right"></i>
                    </h4>
                    <h2 class="">{{ $data['totalRoom'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Alquileres <i class="mdi mdi-calendar-alert mdi-24px float-right"></i>
                    </h4>
                    <h2 class="">{{ $data['totalRent'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <h4 class="card-title float-left">Alquiler por Mes</h4>
                    </div>
                    <canvas id="comparisonChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pagos por Mes</h4>
                    <canvas id="comparisonChart1"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/vendors/chart.js/Chart.min.js') }}"></script>
    <script>
        const ctx = document.getElementById('comparisonChart').getContext('2d');
        const comparisonChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($data['months']),
                datasets: [{
                    label: 'Rentas',
                    data: @json($data['rentCounts']),
                    backgroundColor: 'rgba(218, 140, 255, 1)',
                    borderColor: 'rgba(218, 140, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx1 = document.getElementById('comparisonChart1').getContext('2d');
        const comparisonChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($data['months']),
                datasets: [{
                    label: 'Pagos',
                    data: @json($data['paymentTotals']),
                    backgroundColor: 'rgba(254, 112, 150, 1)',
                    borderColor: 'rgba(254, 112, 150, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
