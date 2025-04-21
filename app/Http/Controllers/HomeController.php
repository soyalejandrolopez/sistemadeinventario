<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener estadísticas del inventario
        $totalProductos = Producto::count();
        $totalCategorias = Categoria::count();
        $totalProveedores = Proveedor::count();
        $totalOrdenes = Orden::count();
        
        // Productos con stock bajo
        $productosBajoStock = Producto::whereRaw('stock <= stock_minimo')
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();
            
        // Valor total del inventario
        $valorInventario = Producto::sum(DB::raw('stock * precio_compra'));
        
        // Top 5 productos más caros
        $productosMasCaros = Producto::orderBy('precio_venta', 'desc')
            ->limit(5)
            ->get();
            
        // Cantidad de productos por categoría
        $productosPorCategoria = Categoria::withCount('productos')
            ->orderBy('productos_count', 'desc')
            ->limit(5)
            ->get();
            
        return view('home', compact(
            'totalProductos', 
            'totalCategorias', 
            'totalProveedores', 
            'totalOrdenes',
            'productosBajoStock',
            'valorInventario',
            'productosMasCaros',
            'productosPorCategoria'
        ));
    }
}
