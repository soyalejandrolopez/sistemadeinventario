@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-truck me-2"></i>Proveedores
            </h2>
            <p class="text-muted">Gestión de proveedores del sistema</p>
        </div>
        <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Nuevo Proveedor
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
            <div class="row align-items-center">
                <div class="col-md-8">
                    <form action="{{ route('proveedores.index') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="buscar" class="form-control border-start-0" 
                                placeholder="Buscar proveedor..." value="{{ request('buscar') }}">
                            <button type="submit" class="btn btn-primary">
                                Buscar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i> Estado
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('proveedores.index') }}">Todos</a></li>
                            <li><a class="dropdown-item" href="{{ route('proveedores.index', ['estado' => 'activo']) }}">Activos</a></li>
                            <li><a class="dropdown-item" href="{{ route('proveedores.index', ['estado' => 'inactivo']) }}">Inactivos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3" width="60">#</th>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">NIT</th>
                            <th class="px-4 py-3">Teléfono</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proveedores as $proveedor)
                            <tr>
                                <td class="px-4 py-3 align-middle">{{ $proveedor->id }}</td>
                                <td class="px-4 py-3 align-middle fw-medium">{{ $proveedor->nombre }}</td>
                                <td class="px-4 py-3 align-middle">
                                    <span class="badge bg-secondary">{{ $proveedor->nit }}</span>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <i class="fas fa-phone text-muted me-1"></i>{{ $proveedor->telefono }}
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <a href="mailto:{{ $proveedor->email }}" class="text-decoration-none">
                                        <i class="fas fa-envelope text-muted me-1"></i>{{ $proveedor->email }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    @if($proveedor->activo)
                                        <span class="badge rounded-pill bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Activo
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger">
                                            <i class="fas fa-times-circle me-1"></i>Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('proveedores.show', $proveedor->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $proveedor->id }}" data-bs-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de confirmación de eliminación -->
                                    <div class="modal fade" id="deleteModal{{ $proveedor->id }}" tabindex="-1" aria-hidden="true">
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
                                                    <p>¿Está seguro que desea eliminar el proveedor <strong>{{ $proveedor->nombre }}</strong>?</p>
                                                    <div class="alert alert-warning">
                                                        <i class="fas fa-exclamation-circle me-2"></i>
                                                        Esta acción también eliminará todos los productos asociados a este proveedor.
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>Cancelar
                                                    </button>
                                                    <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash me-1"></i>Eliminar
                                                        </button>
                                                    </form>
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
                                        <i class="fas fa-truck fa-3x"></i>
                                    </div>
                                    <h5 class="fw-bold">No hay proveedores registrados</h5>
                                    <p class="mb-0 text-muted">Comienza agregando un nuevo proveedor.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            {{ $proveedores->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection 