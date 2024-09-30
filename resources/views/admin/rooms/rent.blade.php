@extends('admin.layouts.app')

@section('title', 'Alquilar Habitación')

@section('content')

    <div class="container">
        <div class="jumbotron jumbotron-fluid position-relative">
            <span class="badge bg-primary position-absolute top-0 end-0 m-2">N° {{ $room->number }}</span>
            <h1 class="display-4">{{ $room->property->name }}</h1>
            <p class="lead">{{ $room->type->name }}</p>
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
                    <tbody class="table-group-divider">
                        <tr class="table-primary">
                            <td>{{ $room->rentalprice }}</td>
                            <td>{{ $room->lightprice }}</td>
                            <td>{{ $room->waterprice }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">Cliente</span>
                    <input class="form-control bg-white" id="cliente" type="text" placeholder="Cliente" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">Teléfono</span>
                    <input class="form-control bg-white" id="telefono" type="text" placeholder="Teléfono" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">Dirección</span>
                    <input class="form-control bg-white" id="direccion" type="text" placeholder="Dirección" readonly>
                </div>
            </div>
        </div>
    </div>

    @livewire('admin.rent-component', ['room' => $room])

@endsection

@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {
            Livewire.on('clientStore', function(res) {
                alertSw('success', res[0].message);
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalClient'));
                if (modal) {
                    modal.hide();
                }
            });

            Livewire.on('clientAdd', function(res) {
                alertSw('success', res[0].message);
                document.querySelector('#cliente').value = res[0].client;
                document.querySelector('#telefono').value = res[0].phone;
                document.querySelector('#direccion').value = res[0].address;
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalClients'));
                if (modal) {
                    modal.hide();
                }
            });
        });

        function alertSw(tipo, mensaje) {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: tipo,
                title: mensaje,
                showConfirmButton: false,
                timer: 1500
            });
        }
    </script>
@endpush
