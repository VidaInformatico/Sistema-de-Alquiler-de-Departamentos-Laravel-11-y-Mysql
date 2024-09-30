<div>
    <div class="row mb-4">
        <div class="col-md-12">
            <input type="text" wire:model.live="client" class="form-control" placeholder="Buscar...">
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="row">
        @if ($rentals->isEmpty())
            <div class="col-md-12">
                No se encontraron alquileres.
            </div>
        @else
            @foreach ($rentals as $rent)
                <div class="col-md-4 mb-2">
                    <div class="card shadow-lg">

                        <div class="card-header bg-info fw-bold fs-5 text-center">
                            {{ $rent->client->full_name }}
                        </div>
                        <div class="card-body position-relative">
                            <!-- Número de habitación en la esquina superior derecha -->
                            <div class="position-absolute top-0 end-0 p-3">
                                <span class="badge bg-warning">N° {{ $rent->room->number }}</span>
                            </div>
                            <h5 class="card-title fs-4">
                                {{ $rent->room->rentalprice }} <span class="text-secondary">/ Mensual</span>
                            </h5>
                            <ul class="list-unstyled">
                                <li><b class="text-dark">Precio luz:</b> {{ $rent->room->lightprice }}</li>
                                <li><b class="text-dark">Precio Agua:</b> {{ $rent->room->waterprice }}</li>
                                <li><b class="text-dark">Fecha:</b> {{ $rent->created_at }}</li>
                            </ul>

                            <a href="{{ route('rent.payment', Crypt::encrypt($rent->id)) }}"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-dollar-sign"></i>
                            </a>
                            <a href="#" onclick="confirmLiberar({{ $rent->id }})"
                                class="btn btn-sm btn-info">
                                Liberar
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>



    {{ $rentals->links() }}

</div>

<script>
    document.addEventListener('livewire:init', function() {
        Livewire.on('rentalstoreOrUpdate', function() {
            let modal = bootstrap.Modal.getInstance(document.getElementById('rentModal'));
            if (modal) {
                modal.hide();
            }
        });
    });

    function confirmLiberar(id) {
        Swal.fire({
            title: 'Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, liberar!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('liberar', id);
                Swal.fire(
                    'Liberado!',
                    'Alquiler ha sido liberado.',
                    'success'
                );
            }
        });
    }
</script>
