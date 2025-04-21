@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Crear Nueva Orden</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('ordenes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('ordenes.store') }}" method="POST" id="ordenForm">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="proveedor_id" class="form-label">Proveedor</label>
                            <select class="form-select @error('proveedor_id') is-invalid @enderror" id="proveedor_id" name="proveedor_id" required>
                                <option value="">Seleccione un proveedor</option>
                                @foreach($proveedores as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('proveedor_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                            @error('proveedor_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="fecha_orden" class="form-label">Fecha de Orden</label>
                            <input type="date" class="form-control @error('fecha_orden') is-invalid @enderror" id="fecha_orden" name="fecha_orden" value="{{ old('fecha_orden', date('Y-m-d')) }}" required>
                            @error('fecha_orden')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                            <input type="date" class="form-control @error('fecha_entrega') is-invalid @enderror" id="fecha_entrega" name="fecha_entrega" value="{{ old('fecha_entrega', date('Y-m-d', strtotime('+7 days'))) }}" required>
                            @error('fecha_entrega')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="2">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <h4 class="mt-4 mb-3">Productos</h4>

                @if($productos->isEmpty())
                <div class="alert alert-warning">
                    No hay productos disponibles para agregar a la orden.
                </div>
                @else
                <div class="row mb-3">
                    <div class="col-md-6">
                        <select class="form-select" id="producto_selector">
                            <option value="">Seleccione un producto para agregar</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}" 
                                        data-nombre="{{ $producto->nombre }}" 
                                        data-codigo="{{ $producto->codigo }}" 
                                        data-precio="{{ $producto->precio_compra }}">
                                    {{ $producto->nombre }} ({{ $producto->codigo }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="cantidad_selector" placeholder="Cantidad" min="1" value="1">
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="precio_selector" placeholder="Precio" step="0.01" min="0.01">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary w-100" id="btn_agregar_producto">
                            <i class="fas fa-plus"></i> Agregar
                        </button>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-striped" id="productos_tabla">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Código</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Filas de productos se agregarán dinámicamente -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td><strong id="total_orden">$0.00</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div id="productos_container">
                    <!-- Inputs dinámicos para productos -->
                </div>
                @endif

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="btn_guardar">Guardar Orden</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productoSelector = document.getElementById('producto_selector');
        const cantidadSelector = document.getElementById('cantidad_selector');
        const precioSelector = document.getElementById('precio_selector');
        const btnAgregarProducto = document.getElementById('btn_agregar_producto');
        const productosTabla = document.getElementById('productos_tabla').getElementsByTagName('tbody')[0];
        const productosContainer = document.getElementById('productos_container');
        const btnGuardar = document.getElementById('btn_guardar');
        const totalOrden = document.getElementById('total_orden');
        
        let productos = [];
        let productoCount = 0;
        let total = 0;
        
        // Evento al seleccionar un producto
        productoSelector.addEventListener('change', function() {
            if (this.value) {
                const selectedOption = this.options[this.selectedIndex];
                const precio = selectedOption.getAttribute('data-precio');
                precioSelector.value = precio;
            } else {
                precioSelector.value = '';
            }
        });
        
        // Agregar producto a la tabla
        btnAgregarProducto.addEventListener('click', function() {
            const productoId = productoSelector.value;
            
            if (!productoId) {
                alert('Por favor seleccione un producto.');
                return;
            }
            
            const cantidad = parseInt(cantidadSelector.value);
            if (!cantidad || cantidad <= 0) {
                alert('La cantidad debe ser mayor a 0.');
                return;
            }
            
            const precio = parseFloat(precioSelector.value);
            if (!precio || precio <= 0) {
                alert('El precio debe ser mayor a 0.');
                return;
            }
            
            const selectedOption = productoSelector.options[productoSelector.selectedIndex];
            const productoNombre = selectedOption.getAttribute('data-nombre');
            const productoCodigo = selectedOption.getAttribute('data-codigo');
            
            // Verificar si el producto ya está en la tabla
            const existe = productos.some(p => p.id === productoId);
            if (existe) {
                alert('Este producto ya está agregado a la orden.');
                return;
            }
            
            const subtotal = cantidad * precio;
            
            // Agregar a la lista de productos
            productos.push({
                id: productoId,
                nombre: productoNombre,
                codigo: productoCodigo,
                cantidad: cantidad,
                precio_unitario: precio,
                subtotal: subtotal
            });
            
            // Crear fila en la tabla
            const newRow = productosTabla.insertRow();
            newRow.setAttribute('data-id', productoId);
            
            const cellNombre = newRow.insertCell(0);
            const cellCodigo = newRow.insertCell(1);
            const cellCantidad = newRow.insertCell(2);
            const cellPrecio = newRow.insertCell(3);
            const cellSubtotal = newRow.insertCell(4);
            const cellAcciones = newRow.insertCell(5);
            
            cellNombre.textContent = productoNombre;
            cellCodigo.textContent = productoCodigo;
            cellCantidad.textContent = cantidad;
            cellPrecio.textContent = '$' + precio.toFixed(2);
            cellSubtotal.textContent = '$' + subtotal.toFixed(2);
            cellSubtotal.setAttribute('data-subtotal', subtotal);
            
            const btnEliminar = document.createElement('button');
            btnEliminar.className = 'btn btn-danger btn-sm';
            btnEliminar.innerHTML = '<i class="fas fa-trash"></i>';
            btnEliminar.onclick = function() { eliminarProducto(productoId); };
            cellAcciones.appendChild(btnEliminar);
            
            // Agregar inputs ocultos para el formulario
            agregarInputsProducto(productoCount, productoId, cantidad, precio);
            
            // Actualizar contador y total
            productoCount++;
            actualizarTotal();
            
            // Limpiar selectores
            productoSelector.value = '';
            cantidadSelector.value = '1';
            precioSelector.value = '';
        });
        
        // Función para eliminar un producto
        function eliminarProducto(productoId) {
            // Eliminar de la tabla
            const rows = productosTabla.getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {
                if (rows[i].getAttribute('data-id') === productoId) {
                    productosTabla.removeChild(rows[i]);
                    break;
                }
            }
            
            // Eliminar de la lista
            productos = productos.filter(p => p.id !== productoId);
            
            // Eliminar inputs
            const inputsContainer = document.getElementById('productos_container');
            const inputGroup = document.getElementById('producto_group_' + productoId);
            if (inputGroup) {
                inputsContainer.removeChild(inputGroup);
            }
            
            // Actualizar total
            actualizarTotal();
        }
        
        // Función para agregar inputs ocultos
        function agregarInputsProducto(index, productoId, cantidad, precio) {
            const div = document.createElement('div');
            div.id = 'producto_group_' + productoId;
            
            div.innerHTML = `
                <input type="hidden" name="productos[${index}][id]" value="${productoId}">
                <input type="hidden" name="productos[${index}][cantidad]" value="${cantidad}">
                <input type="hidden" name="productos[${index}][precio_unitario]" value="${precio}">
            `;
            
            productosContainer.appendChild(div);
        }
        
        // Función para actualizar el total
        function actualizarTotal() {
            total = 0;
            const subtotales = document.querySelectorAll('[data-subtotal]');
            subtotales.forEach(cell => {
                total += parseFloat(cell.getAttribute('data-subtotal'));
            });
            
            totalOrden.textContent = '$' + total.toFixed(2);
        }
        
        // Validación del formulario
        document.getElementById('ordenForm').addEventListener('submit', function(e) {
            if (productos.length === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un producto a la orden.');
            }
        });
    });
</script>
@endpush 