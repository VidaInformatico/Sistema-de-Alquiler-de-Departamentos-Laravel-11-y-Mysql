<div>
    @php
        use Carbon\Carbon;
    @endphp

    <div class="row mb-4">
        <div class="col-md-6">
            <input expense="text" wire:model.live="searchTerm" class="form-control" placeholder="Buscar...">
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#expenseModal"
                wire:click="resetInputFields"><i class="fas fa-plus-circle"></i></button>
            <button class="btn btn-success" wire:click="exportExcel">
                <i class="fas fa-file-excel"></i> Exportar a Excel
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="d-flex">
        <div class="form-group">
            <label for="desde">Desde</label>
            <input id="desde" class="form-control" type="date" wire:model.live="fromDate">
        </div>
        <div class="form-group">
            <label for="hasta">Hasta</label>
            <input id="hasta" class="form-control" type="date" wire:model.live="toDate">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" style="width: 100%">
            <thead>
                <tr>
                    <th>Monto</th>
                    <th>Fecha/Hora</th>
                    <th>Descripción</th>
                    <th>Foto</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @if ($expenses->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No se encontraron gastos.</td>
                    </tr>
                @else
                    @foreach ($expenses as $expense)
                        <tr>
                            <td>{{ $expense->amount }}</td>
                            <td>{{ Carbon::parse($expense->created_at)->format('d/m/Y H:i') }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>
                                @if ($expense->photo)
                                    <img src="{{ asset('storage/' . $expense->photo) }}" width="100" alt="Foto">
                                @else
                                    <span>No disponible</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="edit({{ $expense->id }})" class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#expenseModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $expense->id }})">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>

    {{ $expenses->links() }}

    <!-- Property Modal -->
    <div wire:ignore.self class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="expenseModalLabel">
                        {{ $isEditMode ? 'Editar gasto' : 'Crear gasto' }}</h5>
                    <button expense="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form wire:submit.prevent="storeOrUpdate" enctype="multipart/form-data">
                    <div class="modal-body">
                        @if (session()->has('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="amount">Monto</label>
                            <input type="text" class="form-control" placeholder="Monto" id="amount"
                                wire:model="amount">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <input type="text" class="form-control" placeholder="Descripción" id="description"
                                wire:model="description">
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="photo">Foto</label>
                            <input type="file" class="form-control" id="photo" wire:model="photo">
                            @error('photo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" width="100" />
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button expense="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', function() {
        Livewire.on('expenseStoreOrUpdate', function() {
            let modal = bootstrap.Modal.getInstance(document.getElementById('expenseModal'));
            if (modal) {
                modal.hide();
            }
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, bórralo!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', id);
                Swal.fire(
                    'Eliminado!',
                    'Gasto ha sido eliminada.',
                    'success'
                );
            }
        });
    }
</script>
