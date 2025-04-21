@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Crear Nuevo Producto</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo') }}" required>
                            @error('codigo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría <span class="text-danger">*</span></label>
                            <select class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id" name="categoria_id" required>
                                <option value="">Seleccione una categoría</option>
                                @foreach ($categorias as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('categoria_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="proveedor_id" class="form-label">Proveedor <span class="text-danger">*</span></label>
                            <select class="form-select @error('proveedor_id') is-invalid @enderror" id="proveedor_id" name="proveedor_id" required>
                                <option value="">Seleccione un proveedor</option>
                                @foreach ($proveedores as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('proveedor_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                            @error('proveedor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="precio_compra" class="form-label">Precio de Compra <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control @error('precio_compra') is-invalid @enderror" id="precio_compra" name="precio_compra" value="{{ old('precio_compra') }}" step="0.01" min="0" required>
                                @error('precio_compra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="precio_venta" class="form-label">Precio de Venta <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control @error('precio_venta') is-invalid @enderror" id="precio_venta" name="precio_venta" value="{{ old('precio_venta') }}" step="0.01" min="0" required>
                                @error('precio_venta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock_minimo') is-invalid @enderror" id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo', 5) }}" min="0" required>
                            @error('stock_minimo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control @error('imagen') is-invalid @enderror" id="imagen" name="imagen">
                    <small class="text-muted">Formatos: JPG, PNG. Máximo 2MB</small>
                    @error('imagen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" {{ old('activo', '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">Producto Activo</label>
                    </div>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 