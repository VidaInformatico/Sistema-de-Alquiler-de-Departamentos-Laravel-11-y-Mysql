<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" wire:model.live="searchTerm" class="form-control" placeholder="Buscar...">
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"
                wire:click="resetInputFields"><i class="fas fa-plus-circle"></i></button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered" style="width: 100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Fecha Registro</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No se encontraron usuarios.</td>
                    </tr>
                @else
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                <button wire:click="edit({{ $user->id }})" class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#userModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $user->id }})">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    {{ $users->links() }}

    <!-- Modal de Usuario -->
    <div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">
                        {{ $isEditMode ? 'Editar Usuario' : 'Crear Usuario' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" placeholder="Nombre Completo" id="name"
                                wire:model="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" placeholder="Correo Electrónico"
                                wire:model="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña"
                                wire:model="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="confirmed_password">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirmed_password"
                                placeholder="Confirmar Contraseña" wire:model="password_confirmation">
                            @error('confirmed_password')
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
        Livewire.on('userStoreOrUpdate', function() {
            let modal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
            if (modal) {
                modal.hide();
            }
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
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
                    '¡Eliminado!',
                    'El usere ha sido eliminado.',
                    'success'
                );
            }
        });
    }
</script>
