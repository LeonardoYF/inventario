<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DetalleIngresoController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Auth;

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
    return view('home/homeVenta');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('almacen/categoria', CategoriaController::class);
    Route::resource('almacen/producto', ProductoController::class);
    Route::resource('ventas/cliente', ClienteController::class);
    Route::resource('ventas/ventas', VentaController::class);
    Route::resource('ventas/detallesVentas', DetalleVentaController::class);
    Route::resource('compras/proveedores', ProveedorController::class);
    Route::resource('compras/ingresos', IngresoController::class);
    Route::resource('compras/detalles', DetalleIngresoController::class);
    Route::resource('reportes/reportes', ReporteController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/homeVenta', [App\Http\Controllers\HomeController::class, 'home'])->name('homeVenta');
