@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-3">Dashboard</h1>
            <p class="text-muted">Bienvenido al Sistema de Inventario, aquí puede visualizar un resumen de su negocio.</p>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Tarjeta de Productos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Productos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Producto::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="{{ route('productos.index') }}" class="btn btn-sm btn-primary">
                        Ver todos <i class="fas fa-arrow-right mr-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Categorías -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Categorías</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Categoria::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="{{ route('categorias.index') }}" class="btn btn-sm btn-success">
                        Ver todas <i class="fas fa-arrow-right mr-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Proveedores -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Proveedores</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Proveedor::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="{{ route('proveedores.index') }}" class="btn btn-sm btn-info">
                        Ver todos <i class="fas fa-arrow-right mr-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Órdenes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Órdenes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Orden::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="{{ route('ordenes.index') }}" class="btn btn-sm btn-warning">
                        Ver todas <i class="fas fa-arrow-right mr-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Productos con bajo stock -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">Productos con bajo stock</h6>
                </div>
                <div class="card-body">
                    @php
                        $productosConBajoStock = App\Models\Producto::where('stock', '<=', 10)->limit(5)->get();
                    @endphp
                    
                    @if($productosConBajoStock->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Código</th>
                                        <th>Stock</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productosConBajoStock as $producto)
                                    <tr>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->codigo }}</td>
                                        <td>
                                            <span class="badge {{ $producto->stock <= 5 ? 'badge-danger' : 'badge-warning' }}">
                                                {{ $producto->stock }}
                                            </span>
                                        </td>
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
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="mb-0">Todos los productos tienen stock suficiente.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Últimas órdenes creadas -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">Últimas órdenes</h6>
                </div>
                <div class="card-body">
                    @php
                        $ultimasOrdenes = App\Models\Orden::orderBy('created_at', 'desc')->limit(5)->get();
                    @endphp
                    
                    @if($ultimasOrdenes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Proveedor</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimasOrdenes as $orden)
                                    <tr>
                                        <td>{{ $orden->id }}</td>
                                        <td>{{ $orden->proveedor->nombre }}</td>
                                        <td>{{ \Carbon\Carbon::parse($orden->fecha_orden)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($orden->estado == 'pendiente')
                                                <span class="badge badge-warning">Pendiente</span>
                                            @elseif($orden->estado == 'completada')
                                                <span class="badge badge-success">Completada</span>
                                            @else
                                                <span class="badge badge-danger">Cancelada</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <p class="mb-0">No hay órdenes registradas aún.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos (opcional, se utilizarán gráficos basados en Chart.js) -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">Estadísticas del Sistema</h6>
                </div>
                <div class="card-body">
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar fa-4x text-primary mb-3 opacity-50"></i>
                        <h5>Módulo de estadísticas en desarrollo</h5>
                        <p class="text-muted">Próximamente se mostrarán aquí gráficos con estadísticas de productos, ventas y más.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .border-left-primary {
        border-left: 4px solid var(--primary);
    }
    .border-left-success {
        border-left: 4px solid var(--secondary);
    }
    .border-left-info {
        border-left: 4px solid #36b9cc;
    }
    .border-left-warning {
        border-left: 4px solid #f6c23e;
    }
    .text-primary {
        color: var(--primary) !important;
    }
    .text-success {
        color: var(--secondary) !important;
    }
    .text-info {
        color: #36b9cc !important;
    }
    .text-warning {
        color: #f6c23e !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .card-body {
        padding: 1.25rem;
    }
    .badge {
        font-weight: 600;
        padding: 0.35em 0.65em;
        border-radius: 0.25rem;
    }
    .badge-success {
        background-color: rgba(56, 193, 114, 0.2);
        color: var(--secondary-dark);
    }
    .badge-danger {
        background-color: rgba(227, 52, 47, 0.2);
        color: #e53e3e;
    }
    .badge-warning {
        background-color: rgba(246, 194, 62, 0.2);
        color: #cb8a05;
    }
    .opacity-50 {
        opacity: 0.5;
    }
    h1 {
        font-weight: 700;
        color: var(--dark);
    }
</style>
@endsection
