<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" wire:model.live="searchTerm" class="form-control" placeholder="Buscar...">
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#propertyModal"
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
                <th>Ciudad</th>
                <th>Dirección</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @if ($properties->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">No se encontraron propiedades.</td>
                </tr>
            @else
                @foreach ($properties as $property)
                    <tr>
                        <td>{{ $property->name }}</td>
                        <td>{{ $property->city }}</td>
                        <td>{{ $property->address }}</td>
                        <td>
                            <button wire:click="edit({{ $property->id }})" class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#propertyModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $property->id }})">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>

    {{ $properties->links() }}

    <!-- Property Modal -->
    <div wire:ignore.self class="modal fade" id="propertyModal" tabindex="-1" aria-labelledby="propertyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="propertyModalLabel">
                        {{ $isEditMode ? 'Editar propiedad' : 'Crear propiedad' }}</h5>
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
                            <label for="city">Ciudad</label>
                            <input type="text" class="form-control" placeholder="Ciudad" id="city"
                                wire:model="city">
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" id="address" placeholder="Dirección"
                                wire:model="address">
                            @error('address')
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
        Livewire.on('propertyStoreOrUpdate', function() {
            let modal = bootstrap.Modal.getInstance(document.getElementById('propertyModal'));
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
                    'La propiedad ha sido eliminada.',
                    'success'
                );
            }
        });
    }
</script>
