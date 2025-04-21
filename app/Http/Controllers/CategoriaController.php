<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Constructor que aplica middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra un listado de categorías.
     */
    public function index()
    {
        $categorias = Categoria::orderBy('nombre')->paginate(10);
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Almacena una nueva categoría en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);
        
        // Crear la categoría
        Categoria::create($request->all());
        
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Muestra una categoría específica.
     */
    public function show(string $id)
    {
        $categoria = Categoria::with('productos')->findOrFail($id);
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Muestra el formulario para editar una categoría.
     */
    public function edit(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualiza una categoría en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $categoria = Categoria::findOrFail($id);
        
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $id,
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);
        
        // Actualizar la categoría
        $categoria->update($request->all());
        
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Elimina una categoría de la base de datos.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        
        // Verificar si tiene productos asociados
        if ($categoria->productos()->count() > 0) {
            return redirect()->route('categorias.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        }
        
        $categoria->delete();
        
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
