<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetalleVentaFormRequest;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\venta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DetalleVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detalles = DB::table('detalle_venta as dv')
            ->join('producto as p', 'dv.id_producto', '=', 'p.id_producto')
            ->select('dv.id_detalle_venta', 'p.nombre as articulo', 'dv.cantidad', 'dv.descuento', 'di.precio_venta')
            ->orderBy('di.id_detalle_venta', 'asc')
            ->paginate(5);

        return view('ventas.detalle.index', ["detalles" => $detalles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $id_venta = $request->get('id_venta');
        $productos = DB::table('producto as p')
            ->select(DB::raw('CONCAT(p.codigo, " ", p.nombre) AS Articulo'),'p.precio_venta' ,'p.id_producto', 'p.stock')
            ->where('p.status', '=', 'Activo')
            ->get();


        return view("ventas.detalle.modal.create", ["productos" => $productos, "id_venta" => $id_venta]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetalleVentaFormRequest $request)
    {

        $stockErrorMessage = null; // Variable para almacenar el mensaje de falta de stock

        try {
            $detalle = new DetalleVenta();
            $detalle->id_venta = $request->get('idventa');
            $detalle->cantidad = $request->get('cantidad');
            $detalle->id_producto = $request->get('id_producto');
            $detalle->descuento = $request->get('descuento');
            $detalle->precio_venta = $request->get('precio_venta');

            // Obtener información del producto para verificar el stock
            $producto = Producto::find($detalle->id_producto);

            if ($producto) {
                // Verificar si hay suficiente stock disponible
                if ($detalle->cantidad > $producto->stock) {
                    $stockErrorMessage = 'No hay suficiente stock disponible para el producto ' . $producto->nombre . '.';
                } else {
                    // Actualizar el stock del producto
                    $producto->stock -= $detalle->cantidad;
                    $producto->save();

                    // Guardar el detalle de venta
                    $detalle->save();
                    $venta = venta::find($detalle->id_venta);
                    $venta->total_venta += ($detalle->cantidad * $detalle->precio_venta) - (($detalle->cantidad * $detalle->precio_venta) * $detalle->descuento / 100);
                    $venta->update();
                    Session::flash('success', 'Detalle de venta creado exitosamente.');
                }
            } else {
                $stockErrorMessage = 'El producto no existe.';
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Error al crear el detalle de venta: ' . $e->getMessage());
        }

        // Si hay un mensaje de falta de stock, almacenarlo en la sesión para mostrarlo después
        if ($stockErrorMessage) {
            Session::flash('stock_error', $stockErrorMessage);
        }

        return redirect()->route('ventas.show', ['venta' => $request->get('idventa')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $detalle = DB::table('detalle_venta as dv')
            ->join('producto as p', 'dv.id_producto', '=', 'p.id_producto')
            ->select('dv.id_producto', 'dv.id_detalle_venta', 'dv.id_venta', 'p.nombre as articulo', 'dv.cantidad', 'dv.descuento', 'dv.precio_venta')
            ->where('dv.id_detalle_venta', '=', $id)
            ->first();
        $productos = DB::table('producto as p')
            ->select(DB::raw('CONCAT(p.codigo, " ", p.nombre) AS Articulo'), 'p.id_producto', 'p.stock')
            ->where('p.status', '=', 'Activo')
            ->get();
        return view('ventas.detalle.edit', ['detalle' => $detalle, 'productos' => $productos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DetalleVentaFormRequest $request, $id)
    {
        $stockErrorMessage = "";
        try {
            // Obtener el detalle que se va a actualizar
            $detalle = DetalleVenta::findOrFail($id);
            $producto = Producto::find($detalle->id_producto);
            $producto->stock += $detalle->cantidad;
            $producto->save();
            // Actualizar los campos del detalle
            $detalle->cantidad = $request->input('cantidad');
            $detalle->id_producto = $request->input('id_producto');
            $detalle->descuento = $request->input('descuento');
            $detalle->precio_venta = $request->input('precio_venta');

            $producto = Producto::find($detalle->id_producto);

            if ($producto) {
                // Verificar si hay suficiente stock disponible
                if ($detalle->cantidad > $producto->stock) {
                    $stockErrorMessage = 'No hay suficiente stock disponible para el producto ' . $producto->nombre . '.';
                } else {
                    // Actualizar el stock del producto
                    $producto->stock -= $detalle->cantidad;
                    $producto->save();

                    // Guardar el detalle de venta
                    $detalle->update();

                    Session::flash('success', 'Detalle de venta modificado exitosamente.');
                }
            } else {
                $stockErrorMessage = 'El producto no existe.';
            }
            // Guardar los cambios en la base de datos
            if ($stockErrorMessage) {
                Session::flash('stock_error', $stockErrorMessage);
            }
        } catch (\Exception $e) {
            // Manejar errores y posiblemente realizar un rollback
            Session::flash('error', 'Error al actualizar el detalle: ' . $e->getMessage());
        }


        return redirect()->route('ventas.show', ['venta' => $detalle->id_venta]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            // Obtener el detalle que se va a eliminar
            $detalle = DetalleVenta::findOrFail($id);
            $idventa = $detalle->id_venta;
            $producto = Producto::findOrFail($detalle->id_producto);
            $producto->stock += $detalle->cantidad;
            $producto->update();
            // Realizar la eliminación del detalle
            $detalle->delete();

            DB::commit();

            Session::flash('success', 'Detalle de venta eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();

            Session::flash('error', 'Error al eliminar el detalle de venta: ' . $e->getMessage());
        }
        return redirect()->route('ventas.show', ['venta' => $idventa]);
    }
}
