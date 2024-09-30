<div class="container">
    <div class="form-group">
        <label for="nota">Nota</label>
        <textarea id="nota" class="form-control" wire:model="note" rows="3" placeholder="Nota"></textarea>
        @error('note')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="btn-group" role="group" aria-label="Button group">
        <button class="btn btn-info btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalClient"><i
                class="fas fa-plus-circle"></i> Nuevo Cliente</button>
        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalClients"><i
                class="fas fa-search"></i> Seleccionar Cliente</button>
    </div>

    <div>
        @error('client_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="text-end">
        <a class="btn btn-primary" href="#" wire:click.prevent="rent()" role="button">Alquilar</a>
    </div>

    <div wire:ignore.self class="modal fade" id="modalClients" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Clientes
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" wire:model.live="searchTerm" class="form-control" placeholder="Buscar...">
                    <div class="table-responsive">
                        <table class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($clients->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">No se encontraron clientes.</td>
                                    </tr>
                                @else
                                    @foreach ($clients as $client)
                                        <tr>
                                            <td>
                                                <button wire:click="addClient({{ $client->id }})"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-plus-circle"></i>
                                                </button>
                                            </td>
                                            <td>{{ $client->full_name }}</td>
                                            <td>{{ $client->phone }}</td>
                                            <td>{{ $client->address }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $clients->links() }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondangerdary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalClient" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Nuevo Cliente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row">
                        <div class="form-group col-md-12">
                            <label for="full_name">Nombre Completo</label>
                            <input type="text" class="form-control" placeholder="Nombre Completo" id="full_name"
                                wire:model="full_name">
                            @error('full_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date_of_birth">Fecha de Nacimiento</label>
                            <input type="date" class="form-control form-control-lg" id="date_of_birth"
                                wire:model="date_of_birth">
                            @error('date_of_birth')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gender">Género</label>
                            <select class="form-control form-control-lg" id="gender" wire:model="gender">
                                <option value="">Seleccionar género</option>
                                <option value="Male" {{ $gender === 'Male' ? 'selected' : '' }}>Masculino</option>
                                <option value="Female" {{ $gender === 'Female' ? 'selected' : '' }}>Femenino</option>
                                <option value="Not specified" {{ $gender === 'Not specified' ? 'selected' : '' }}>No
                                    desea decirlo</option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">Teléfono</label>
                            <input type="number" class="form-control" id="phone" placeholder="Teléfono"
                                wire:model="phone">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email"
                                placeholder="Correo Electrónico" wire:model="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" id="address" placeholder="Dirección"
                                wire:model="address">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city">Ciudad</label>
                            <input type="text" class="form-control" id="city" placeholder="Ciudad"
                                wire:model="city">
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state">Estado</label>
                            <input type="text" class="form-control" id="state" placeholder="Estado"
                                wire:model="state">
                            @error('state')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="postal_code">Código Postal</label>
                            <input type="number" class="form-control" id="postal_code" placeholder="Código Postal"
                                wire:model="postal_code">
                            @error('postal_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country">País</label>
                            <input type="text" class="form-control" id="country" placeholder="País"
                                wire:model="country">
                            @error('country')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="identification_number">Número de Identificación</label>
                            <input type="number" class="form-control" id="identification_number"
                                placeholder="Número de Identificación" wire:model="identification_number">
                            @error('identification_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="identification_type">Tipo de Identificación</label>
                            <input type="text" class="form-control" id="identification_type"
                                placeholder="Tipo de Identificación" wire:model="identification_type">
                            @error('identification_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="store()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

</div>
