<div>
    @php
        use Carbon\Carbon;
    @endphp
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" wire:model.live="searchTerm" class="form-control" placeholder="Buscar...">
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal"
                wire:click="resetInputFields">
                <i class="fas fa-plus-circle"></i>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @php
        // Suma total de los abonos
        $totalAbonos = $payments->sum('amount');

        $contador = $totalAbonos / $total;

        $meses = $contador;

        $fechaInicio = Carbon::parse($rent->created_at);

        // Fecha final basada en el número de meses
        $fechaFinal = $fechaInicio->copy()->addMonths($meses);
    @endphp

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @if ($payments->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">No se encontraron pagos.</td>
                    </tr>
                @else
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ Carbon::parse($payment['created_at'])->format('d') }} de
                                {{ Carbon::parse($payment['created_at'])->translatedFormat('F') }} de
                                {{ Carbon::parse($payment['created_at'])->format('Y') }} a las
                                {{ Carbon::parse($payment['created_at'])->format('H:i') }}</td>
                            <td>{{ $payment['amount'] }}</td>
                            <td>
                                <a target="_blank" href="{{ route('payment.pdf', Crypt::encrypt($payment->id)) }}"
                                    class="btn btn-danger btn-sm"><i class="fas fa-print"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><b>Total Abonos:</b></td>
                        <td colspan="2">
                            <h4>{{ $totalAbonos }}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Meses:</b></td>
                        <td colspan="2">
                            <h4>{{ number_format($contador, 2) }}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Fecha Final:</b></td>
                        <td colspan="2">
                            <h4>{{ $fechaFinal->format('d') }} de {{ $fechaFinal->translatedFormat('F') }} de
                                {{ $fechaFinal->format('Y') }}</h4>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-2">
        {{ $payments->links() }}
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Agregar Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    <form>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Monto</label>
                            <input type="number" class="form-control" id="amount" wire:model="amount">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="storePayment">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', function() {
        Livewire.on('paymentStored', (data) => {
            let modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
            modal.hide();
            console.log(data);
            setTimeout(() => {
                window.open(data[0].pdfPath, '_blank');
            }, 1000);

        });
    });
</script>
