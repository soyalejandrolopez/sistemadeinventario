@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-boxes me-2"></i>Productos
            </h2>
            <p class="text-muted">Gestión de inventario de productos</p>
        </div>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Nuevo Producto
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('productos.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="buscar" class="form-control border-start-0" 
                                placeholder="Buscar producto..." value="{{ request('buscar') }}">
                            <button type="submit" class="btn btn-primary">
                                Buscar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i> Filtrar
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Por Categoría</a></li>
                            <li><a class="dropdown-item" href="#">Stock Bajo</a></li>
                            <li><a class="dropdown-item" href="#">Más Vendidos</a></li>
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
                            <th class="px-4 py-3">Código</th>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Categoría</th>
                            <th class="px-4 py-3">Precio Compra</th>
                            <th class="px-4 py-3">Precio Venta</th>
                            <th class="px-4 py-3">Stock</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                            <tr>
                                <td class="px-4 py-3 align-middle">
                                    <span class="badge bg-secondary">{{ $producto->codigo }}</span>
                                </td>
                                <td class="px-4 py-3 align-middle fw-medium">{{ $producto->nombre }}</td>
                                <td class="px-4 py-3 align-middle">
                                    <span class="badge rounded-pill bg-light text-dark border">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $producto->categoria->nombre }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 align-middle">${{ number_format($producto->precio_compra, 2) }}</td>
                                <td class="px-4 py-3 align-middle">${{ number_format($producto->precio_venta, 2) }}</td>
                                <td class="px-4 py-3 align-middle">
                                    @if ($producto->stock <= $producto->stock_minimo)
                                        <span class="badge rounded-pill bg-danger">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $producto->stock }}
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            {{ $producto->stock }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $producto->id }}" data-bs-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de confirmación de eliminación -->
                                    <div class="modal fade" id="deleteModal{{ $producto->id }}" tabindex="-1" aria-hidden="true">
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
                                                    <p>¿Está seguro que desea eliminar el producto <strong>{{ $producto->nombre }}</strong>?</p>
                                                    <p class="mb-0 text-muted small">Esta acción no se puede deshacer.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>Cancelar
                                                    </button>
                                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline">
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
                                        <i class="fas fa-box-open fa-3x"></i>
                                    </div>
                                    <h5 class="fw-bold">No hay productos registrados</h5>
                                    <p class="mb-0 text-muted">Comienza agregando un nuevo producto.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            {{ $productos->links() }}
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