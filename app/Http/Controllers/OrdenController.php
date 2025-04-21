<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\DetalleOrden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrdenController extends Controller
{
    /**
     * Constructor que aplica middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra un listado de órdenes.
     */
    public function index()
    {
        $ordenes = Orden::with('proveedor', 'usuario')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('ordenes.index', compact('ordenes'));
    }

    /**
     * Muestra el formulario para crear una nueva orden.
     */
    public function create()
    {
        $proveedores = Proveedor::where('activo', true)
            ->orderBy('nombre')
            ->pluck('nombre', 'id');
            
        $productos = Producto::where('activo', true)
            ->where('stock', '>', 0)
            ->orderBy('nombre')
            ->get();
            
        return view('ordenes.create', compact('proveedores', 'productos'));
    }

    /**
     * Almacena una nueva orden en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos básicos
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_orden' => 'required|date',
            'fecha_entrega' => 'required|date|after_or_equal:fecha_orden',
            'observaciones' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);
        
        // Iniciar transacción
        DB::beginTransaction();
        
        try {
            // Crear la orden
            $orden = new Orden();
            $orden->fill([
                'proveedor_id' => $request->proveedor_id,
                'fecha_orden' => $request->fecha_orden,
                'fecha_entrega' => $request->fecha_entrega,
                'observaciones' => $request->observaciones,
                'estado' => 'pendiente',
                'user_id' => Auth::id(),
            ]);
            
            // Generar número de orden (formato: OC-YYYYMMDD-XXX)
            $fecha = date('Ymd');
            $ultimaOrden = Orden::whereDate('created_at', today())
                ->orderBy('id', 'desc')
                ->first();
                
            $secuencia = $ultimaOrden ? intval(substr($ultimaOrden->numero_orden, -3)) + 1 : 1;
            $orden->numero_orden = 'OC-' . $fecha . '-' . str_pad($secuencia, 3, '0', STR_PAD_LEFT);
            
            // Calcular total
            $total = 0;
            foreach ($request->productos as $producto) {
                $subtotal = $producto['cantidad'] * $producto['precio_unitario'];
                $total += $subtotal;
            }
            $orden->total = $total;
            
            $orden->save();
            
            // Crear detalles de la orden
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);
                $subtotal = $item['cantidad'] * $item['precio_unitario'];
                
                DetalleOrden::create([
                    'orden_id' => $orden->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $subtotal
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('ordenes.index')
                ->with('success', 'Orden creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear la orden: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Muestra una orden específica.
     */
    public function show(string $id)
    {
        $orden = Orden::with(['proveedor', 'usuario', 'detalles.producto'])
            ->findOrFail($id);
            
        return view('ordenes.show', compact('orden'));
    }

    /**
     * Muestra el formulario para editar una orden.
     */
    public function edit(string $id)
    {
        $orden = Orden::with('detalles.producto')->findOrFail($id);
        
        // Solo permitir editar órdenes en estado pendiente
        if ($orden->estado !== 'pendiente') {
            return redirect()->route('ordenes.show', $orden->id)
                ->with('error', 'Solo se pueden editar órdenes en estado pendiente.');
        }
        
        $proveedores = Proveedor::where('activo', true)
            ->orderBy('nombre')
            ->pluck('nombre', 'id');
            
        $productos = Producto::where('activo', true)
            ->orderBy('nombre')
            ->get();
            
        return view('ordenes.edit', compact('orden', 'proveedores', 'productos'));
    }

    /**
     * Actualiza una orden en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $orden = Orden::findOrFail($id);
        
        // Solo permitir actualizar órdenes en estado pendiente
        if ($orden->estado !== 'pendiente') {
            return redirect()->route('ordenes.show', $orden->id)
                ->with('error', 'Solo se pueden actualizar órdenes en estado pendiente.');
        }
        
        // Validación de datos
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_orden' => 'required|date',
            'fecha_entrega' => 'required|date|after_or_equal:fecha_orden',
            'observaciones' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);
        
        // Iniciar transacción
        DB::beginTransaction();
        
        try {
            // Actualizar datos básicos de la orden
            $orden->update([
                'proveedor_id' => $request->proveedor_id,
                'fecha_orden' => $request->fecha_orden,
                'fecha_entrega' => $request->fecha_entrega,
                'observaciones' => $request->observaciones,
            ]);
            
            // Eliminar detalles anteriores
            $orden->detalles()->delete();
            
            // Crear nuevos detalles y calcular total
            $total = 0;
            foreach ($request->productos as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario'];
                $total += $subtotal;
                
                DetalleOrden::create([
                    'orden_id' => $orden->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $subtotal
                ]);
            }
            
            // Actualizar total
            $orden->total = $total;
            $orden->save();
            
            DB::commit();
            
            return redirect()->route('ordenes.show', $orden->id)
                ->with('success', 'Orden actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar la orden: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Cambia el estado de una orden.
     */
    public function cambiarEstado(Request $request, string $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,completada,cancelada',
        ]);
        
        $orden = Orden::findOrFail($id);
        $estadoAnterior = $orden->estado;
        
        // Actualizar estado
        $orden->estado = $request->estado;
        $orden->save();
        
        // Si la orden cambia a completada, actualizar stock de productos
        if ($request->estado == 'completada' && $estadoAnterior != 'completada') {
            foreach ($orden->detalles as $detalle) {
                $producto = $detalle->producto;
                $producto->stock += $detalle->cantidad;
                $producto->save();
            }
        }
        
        // Si la orden cambia de completada a otro estado, revertir stock
        if ($estadoAnterior == 'completada' && $request->estado != 'completada') {
            foreach ($orden->detalles as $detalle) {
                $producto = $detalle->producto;
                $producto->stock -= $detalle->cantidad;
                $producto->save();
            }
        }
        
        return redirect()->route('ordenes.show', $orden->id)
            ->with('success', 'Estado de la orden actualizado correctamente.');
    }

    /**
     * Elimina una orden de la base de datos.
     */
    public function destroy(string $id)
    {
        $orden = Orden::findOrFail($id);
        
        // Solo permitir eliminar órdenes en estado pendiente o cancelada
        if ($orden->estado == 'completada') {
            return redirect()->route('ordenes.index')
                ->with('error', 'No se pueden eliminar órdenes completadas.');
        }
        
        // Iniciar transacción
        DB::beginTransaction();
        
        try {
            // Eliminar detalles
            $orden->detalles()->delete();
            
            // Eliminar orden
            $orden->delete();
            
            DB::commit();
            
            return redirect()->route('ordenes.index')
                ->with('success', 'Orden eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar la orden: ' . $e->getMessage());
        }
    }
}
