<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Constructor que aplica middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra un listado de proveedores.
     */
    public function index()
    {
        $proveedores = Proveedor::orderBy('nombre')->paginate(10);
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Almacena un nuevo proveedor en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'nit' => 'required|string|max:20|unique:proveedores',
            'direccion' => 'nullable|string|max:200',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'persona_contacto' => 'nullable|string|max:100',
            'activo' => 'boolean',
        ]);
        
        // Crear el proveedor
        Proveedor::create($request->all());
        
        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    /**
     * Muestra un proveedor específico.
     */
    public function show(string $id)
    {
        $proveedor = Proveedor::with('productos')->findOrFail($id);
        return view('proveedores.show', compact('proveedor'));
    }

    /**
     * Muestra el formulario para editar un proveedor.
     */
    public function edit(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Actualiza un proveedor en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'nit' => 'required|string|max:20|unique:proveedores,nit,' . $id,
            'direccion' => 'nullable|string|max:200',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'persona_contacto' => 'nullable|string|max:100',
            'activo' => 'boolean',
        ]);
        
        // Actualizar el proveedor
        $proveedor->update($request->all());
        
        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Elimina un proveedor de la base de datos.
     */
    public function destroy(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        
        // Verificar si tiene productos o órdenes asociadas
        if ($proveedor->productos()->count() > 0) {
            return redirect()->route('proveedores.index')
                ->with('error', 'No se puede eliminar el proveedor porque tiene productos asociados.');
        }
        
        if ($proveedor->ordenes()->count() > 0) {
            return redirect()->route('proveedores.index')
                ->with('error', 'No se puede eliminar el proveedor porque tiene órdenes asociadas.');
        }
        
        $proveedor->delete();
        
        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
