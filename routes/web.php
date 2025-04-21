<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\OrdenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas para Productos
    Route::resource('productos', ProductoController::class);
    
    // Rutas para Categorías
    Route::resource('categorias', CategoriaController::class);
    
    // Rutas para Proveedores
    Route::resource('proveedores', ProveedorController::class);
    
    // Rutas para Órdenes
    Route::resource('ordenes', OrdenController::class);
    
    // Ruta para generar PDF de una orden
    Route::get('ordenes/{orden}/pdf', [OrdenController::class, 'generarPdf'])->name('ordenes.pdf');
    
    // Ruta para buscar productos (para AJAX)
    Route::get('api/productos/buscar', [ProductoController::class, 'buscar'])->name('api.productos.buscar');
    
    // Ruta para cambiar el estado de una orden
    Route::put('/ordenes/{id}/cambiar-estado', [App\Http\Controllers\OrdenController::class, 'cambiarEstado'])->name('ordenes.cambiar-estado');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
