@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Detalle de Orden #{{ $orden->numero_orden }}</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('ordenes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            @if($orden->estado == 'pendiente')
            <a href="{{ route('ordenes.edit', $orden->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Información de la Orden -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Información de la Orden</h5>
            <div>
                @if($orden->estado == 'pendiente')
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#changeStatusModal" data-status="completada">
                    <i class="fas fa-check"></i> Marcar como Completada
                </button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#changeStatusModal" data-status="cancelada">
                    <i class="fas fa-times"></i> Cancelar Orden
                </button>
                @elseif($orden->estado == 'cancelada')
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#changeStatusModal" data-status="pendiente">
                    <i class="fas fa-redo"></i> Reactivar Orden
                </button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Número de Orden:</strong> {{ $orden->numero_orden }}</p>
                    <p><strong>Proveedor:</strong> {{ $orden->proveedor->nombre }}</p>
                    <p><strong>Fecha de Orden:</strong> {{ $orden->fecha_orden->format('d/m/Y') }}</p>
                    <p><strong>Fecha de Entrega:</strong> {{ $orden->fecha_entrega->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Estado:</strong> 
                        @if($orden->estado == 'pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                        @elseif($orden->estado == 'completada')
                            <span class="badge bg-success">Completada</span>
                        @elseif($orden->estado == 'cancelada')
                            <span class="badge bg-danger">Cancelada</span>
                        @endif
                    </p>
                    <p><strong>Total:</strong> ${{ number_format($orden->total, 2) }}</p>
                    <p><strong>Creado por:</strong> {{ $orden->usuario->name }}</p>
                    <p><strong>Observaciones:</strong> {{ $orden->observaciones ?: 'Ninguna' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalle de Productos -->
    <div class="card">
        <div class="card-header">
            <h5>Productos en esta Orden</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Código</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orden->detalles as $index => $detalle)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detalle->producto->nombre }}</td>
                                <td>{{ $detalle->producto->codigo }}</td>
                                <td>{{ $detalle->cantidad }}</td>
                                <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                                <td>${{ number_format($detalle->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Total:</strong></td>
                            <td><strong>${{ number_format($orden->total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Estado -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeStatusModalLabel">Cambiar Estado de la Orden</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('ordenes.cambiar-estado', $orden->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="estado" id="statusInput" value="">
                        <p id="statusConfirmText">¿Está seguro que desea cambiar el estado de esta orden?</p>
                        
                        <div id="completedWarning" class="alert alert-info" style="display: none;">
                            <strong>Nota:</strong> Al marcar como completada, se actualizará el stock de los productos.
                        </div>
                        
                        <div id="cancelWarning" class="alert alert-warning" style="display: none;">
                            <strong>Atención:</strong> Al cancelar esta orden, no se recibirán los productos.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('changeStatusModal');
        const statusInput = document.getElementById('statusInput');
        const statusConfirmText = document.getElementById('statusConfirmText');
        const completedWarning = document.getElementById('completedWarning');
        const cancelWarning = document.getElementById('cancelWarning');
        
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const status = button.getAttribute('data-status');
            
            statusInput.value = status;
            
            // Actualizar texto según el estado
            if (status === 'completada') {
                statusConfirmText.textContent = '¿Está seguro que desea marcar esta orden como completada?';
                completedWarning.style.display = 'block';
                cancelWarning.style.display = 'none';
            } else if (status === 'cancelada') {
                statusConfirmText.textContent = '¿Está seguro que desea cancelar esta orden?';
                completedWarning.style.display = 'none';
                cancelWarning.style.display = 'block';
            } else if (status === 'pendiente') {
                statusConfirmText.textContent = '¿Está seguro que desea reactivar esta orden?';
                completedWarning.style.display = 'none';
                cancelWarning.style.display = 'none';
            }
        });
    });
</script>
@endpush 