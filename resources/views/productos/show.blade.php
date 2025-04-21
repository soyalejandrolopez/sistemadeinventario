@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Detalle del Producto</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    @if ($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <div class="bg-light p-5 rounded">
                            <i class="fas fa-image fa-5x text-secondary"></i>
                            <p class="mt-3 text-muted">Sin imagen</p>
                        </div>
                    @endif
                </div>
                
                <div class="col-md-8">
                    <h3 class="card-title">{{ $producto->nombre }}</h3>
                    <p class="text-muted">Código: {{ $producto->codigo }}</p>
                    
                    <div class="mb-3">
                        <h5>Detalles</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th class="table-light" width="30%">Categoría</th>
                                <td>{{ $producto->categoria->nombre }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">Proveedor</th>
                                <td>{{ $producto->proveedor->nombre }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">Precio de Compra</th>
                                <td>${{ number_format($producto->precio_compra, 2) }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">Precio de Venta</th>
                                <td>${{ number_format($producto->precio_venta, 2) }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">Stock Actual</th>
                                <td>
                                    @if ($producto->stock <= $producto->stock_minimo)
                                        <span class="badge bg-danger">{{ $producto->stock }}</span>
                                        <small class="text-danger ms-2">Stock por debajo del mínimo</small>
                                    @else
                                        <span class="badge bg-success">{{ $producto->stock }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light">Stock Mínimo</th>
                                <td>{{ $producto->stock_minimo }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">Estado</th>
                                <td>
                                    @if ($producto->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light">Fecha de Creación</th>
                                <td>{{ $producto->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">Última Actualización</th>
                                <td>{{ $producto->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    @if ($producto->descripcion)
                        <div class="mb-3">
                            <h5>Descripción</h5>
                            <p class="card-text">{{ $producto->descripcion }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 