@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-tags me-2"></i>Categorías
            </h2>
            <p class="text-muted">Gestión de categorías de productos</p>
        </div>
        <a href="{{ route('categorias.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Nueva Categoría
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0" 
                            placeholder="Buscar categoría...">
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="fas fa-filter me-1"></i> Todas
                        </button>
                        <button type="button" class="btn btn-outline-success">
                            <i class="fas fa-check-circle me-1"></i> Activas
                        </button>
                        <button type="button" class="btn btn-outline-danger">
                            <i class="fas fa-times-circle me-1"></i> Inactivas
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Descripción</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr>
                                <td class="px-4 py-3 align-middle">{{ $categoria->id }}</td>
                                <td class="px-4 py-3 align-middle fw-medium">{{ $categoria->nombre }}</td>
                                <td class="px-4 py-3 align-middle">{{ Str::limit($categoria->descripcion, 50) }}</td>
                                <td class="px-4 py-3 align-middle">
                                    @if($categoria->activo)
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
                                        <a href="{{ route('categorias.show', $categoria->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $categoria->id }}" data-bs-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de confirmación de eliminación -->
                                    <div class="modal fade" id="deleteModal{{ $categoria->id }}" tabindex="-1" aria-hidden="true">
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
                                                    <p>¿Está seguro que desea eliminar la categoría <strong>{{ $categoria->nombre }}</strong>?</p>
                                                    <p class="mb-0 text-muted small">Esta acción no se puede deshacer.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>Cancelar
                                                    </button>
                                                    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display: inline-block;">
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
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-2">
                                        <i class="fas fa-tag fa-3x"></i>
                                    </div>
                                    <h5 class="fw-bold">No hay categorías registradas</h5>
                                    <p class="mb-0 text-muted">Comienza agregando una nueva categoría.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            {{ $categorias->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Búsqueda en tiempo real
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var searchText = this.value.toLowerCase();
        var rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(function(row) {
            var text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });
});
</script>
@endsection 