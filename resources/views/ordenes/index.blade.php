@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-file-invoice-dollar me-2"></i>Órdenes de Compra
            </h2>
            <p class="text-muted">Gestión de órdenes de compra a proveedores</p>
        </div>
        <a href="{{ route('ordenes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Nueva Orden
        </a>
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

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-white py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <form action="{{ route('ordenes.index') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="buscar" class="form-control border-start-0" 
                                placeholder="Buscar número de orden..." value="{{ request('buscar') }}">
                            <button type="submit" class="btn btn-primary">
                                Buscar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end gap-2">
                        <div class="btn-group" role="group">
                            <a href="{{ route('ordenes.index') }}" class="btn btn-outline-secondary {{ !request('estado') ? 'active' : '' }}">
                                <i class="fas fa-list me-1"></i> Todas
                            </a>
                            <a href="{{ route('ordenes.index', ['estado' => 'pendiente']) }}" class="btn btn-outline-warning {{ request('estado') == 'pendiente' ? 'active' : '' }}">
                                <i class="fas fa-clock me-1"></i> Pendientes
                            </a>
                            <a href="{{ route('ordenes.index', ['estado' => 'completada']) }}" class="btn btn-outline-success {{ request('estado') == 'completada' ? 'active' : '' }}">
                                <i class="fas fa-check-circle me-1"></i> Completadas
                            </a>
                        </div>
                        
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-calendar-alt me-1"></i> Fechas
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-3" style="width: 250px;">
                                <form action="{{ route('ordenes.index') }}" method="GET">
                                    <div class="mb-3">
                                        <label class="form-label small">Desde:</label>
                                        <input type="date" name="fecha_desde" class="form-control form-control-sm" value="{{ request('fecha_desde') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Hasta:</label>
                                        <input type="date" name="fecha_hasta" class="form-control form-control-sm" value="{{ request('fecha_hasta') }}">
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary w-100">Aplicar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Número</th>
                            <th class="px-4 py-3">Proveedor</th>
                            <th class="px-4 py-3">Fecha Orden</th>
                            <th class="px-4 py-3">Fecha Entrega</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ordenes as $orden)
                            <tr>
                                <td class="px-4 py-3 align-middle">
                                    <span class="fw-medium">{{ $orden->numero_orden }}</span>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar-circle bg-primary text-white me-2">
                                            {{ substr($orden->proveedor->nombre, 0, 1) }}
                                        </span>
                                        {{ $orden->proveedor->nombre }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <i class="far fa-calendar-alt text-muted me-1"></i>{{ $orden->fecha_orden->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <i class="far fa-calendar-check text-muted me-1"></i>{{ $orden->fecha_entrega->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 align-middle fw-bold">
                                    ${{ number_format($orden->total, 2) }}
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    @if($orden->estado == 'pendiente')
                                        <span class="badge rounded-pill bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i>Pendiente
                                        </span>
                                    @elseif($orden->estado == 'completada')
                                        <span class="badge rounded-pill bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Completada
                                        </span>
                                    @elseif($orden->estado == 'cancelada')
                                        <span class="badge rounded-pill bg-danger">
                                            <i class="fas fa-times-circle me-1"></i>Cancelada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('ordenes.show', $orden->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($orden->estado == 'pendiente')
                                        <a href="{{ route('ordenes.edit', $orden->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $orden->id }}" data-bs-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de confirmación de eliminación -->
                                    <div class="modal fade" id="deleteModal{{ $orden->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        Confirmar eliminación
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Está seguro que desea eliminar la orden <strong>{{ $orden->numero_orden }}</strong>?</p>
                                                    @if($orden->estado == 'completada')
                                                    <div class="alert alert-warning">
                                                        <i class="fas fa-exclamation-circle me-2"></i>
                                                        <strong>Advertencia:</strong> No se pueden eliminar órdenes completadas.
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>Cancelar
                                                    </button>
                                                    @if($orden->estado != 'completada')
                                                    <form action="{{ route('ordenes.destroy', $orden->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash me-1"></i>Eliminar
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted mb-2">
                                        <i class="fas fa-file-invoice-dollar fa-3x"></i>
                                    </div>
                                    <h5 class="fw-bold">No hay órdenes registradas</h5>
                                    <p class="mb-0 text-muted">Comienza agregando una nueva orden de compra.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            {{ $ordenes->links() }}
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection 