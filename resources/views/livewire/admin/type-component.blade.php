<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" wire:model.live="searchTerm" class="form-control" placeholder="Buscar...">
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#typeModal"
                wire:click="resetInputFields"><i class="fas fa-plus-circle"></i></button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @if ($types->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">No se encontraron tipos.</td>
                </tr>
            @else
                @foreach ($types as $type)
                    <tr>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->description }}</td>
                        <td>
                            <button wire:click="edit({{ $type->id }})" class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#typeModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $type->id }})">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>

    {{ $types->links() }}

    <!-- Property Modal -->
    <div wire:ignore.self class="modal fade" id="typeModal" tabindex="-1" aria-labelledby="typeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="typeModalLabel">
                        {{ $isEditMode ? 'Editar tipo' : 'Crear tipo' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" placeholder="Nombre" id="name"
                                wire:model="name">
                            @error('name')
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" wire:click.prevent="storeOrUpdate()"
                        class="btn btn-sm btn-primary">{{ $isEditMode ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', function() {
        Livewire.on('typeStoreOrUpdate', function() {
            let modal = bootstrap.Modal.getInstance(document.getElementById('typeModal'));
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
                    'Tipo ha sido eliminada.',
                    'success'
                );
            }
        });
    }
</script>