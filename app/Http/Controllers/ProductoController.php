<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Constructor que aplica middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra un listado de productos.
     */
    public function index()
    {
        $productos = Producto::with(['categoria', 'proveedor'])
            ->orderBy('nombre')
            ->paginate(10);
            
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->pluck('nombre', 'id');
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->pluck('nombre', 'id');
        
        return view('productos.create', compact('categorias', 'proveedores'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'codigo' => 'required|string|max:50|unique:productos',
            'nombre' => 'required|string|max:100',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'imagen' => 'nullable|image|max:2048', // Máximo 2MB
        ]);
        
        // Crear el producto
        $producto = new Producto($request->all());
        
        // Manejar la carga de imágenes
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->imagen = $path;
        }
        
        $producto->save();
        
        return redirect()->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Muestra un producto específico.
     */
    public function show(string $id)
    {
        $producto = Producto::with(['categoria', 'proveedor'])->findOrFail($id);
        
        return view('productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario para editar un producto.
     */
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->pluck('nombre', 'id');
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->pluck('nombre', 'id');
        
        return view('productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    /**
     * Actualiza un producto en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);
        
        // Validación de datos
        $request->validate([
            'codigo' => 'required|string|max:50|unique:productos,codigo,' . $id,
            'nombre' => 'required|string|max:100',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'imagen' => 'nullable|image|max:2048', // Máximo 2MB
        ]);
        
        // Actualizar el producto
        $producto->fill($request->except('imagen'));
        
        // Manejar la carga de imágenes
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->imagen = $path;
        }
        
        $producto->save();
        
        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        
        // Eliminar imagen si existe
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        
        $producto->delete();
        
        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
    
    /**
     * Busca productos para AJAX.
     */
    public function buscar(Request $request)
    {
        $term = $request->input('term');
        
        $productos = Producto::where('nombre', 'LIKE', "%$term%")
            ->orWhere('codigo', 'LIKE', "%$term%")
            ->where('activo', true)
            ->get(['id', 'nombre', 'codigo', 'precio_venta', 'stock']);
            
        return response()->json($productos);
    }
}
