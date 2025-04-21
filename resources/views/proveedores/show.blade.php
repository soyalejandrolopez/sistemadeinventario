@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Detalles del Proveedor</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Información General</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nombre:</strong> {{ $proveedor->nombre }}</p>
                    <p><strong>NIT:</strong> {{ $proveedor->nit }}</p>
                    <p><strong>Dirección:</strong> {{ $proveedor->direccion ?: 'No especificado' }}</p>
                    <p><strong>Teléfono:</strong> {{ $proveedor->telefono ?: 'No especificado' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $proveedor->email ?: 'No especificado' }}</p>
                    <p><strong>Persona de Contacto:</strong> {{ $proveedor->persona_contacto ?: 'No especificado' }}</p>
                    <p>
                        <strong>Estado:</strong> 
                        @if($proveedor->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Productos Asociados</h5>
        </div>
        <div class="card-body">
            @if($proveedor->productos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proveedor->productos as $producto)
                                <tr>
                                    <td>{{ $producto->id }}</td>
                                    <td>{{ $producto->codigo }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>${{ number_format($producto->precio_compra, 2) }}</td>
                                    <td>${{ number_format($producto->precio_venta, 2) }}</td>
                                    <td>{{ $producto->stock }}</td>
                                    <td>
                                        <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">No hay productos asociados a este proveedor.</p>
            @endif
        </div>
    </div>
</div>
@endsection 