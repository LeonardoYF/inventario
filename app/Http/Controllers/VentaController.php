<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaFormRequest;
use App\Models\Detalleventa;
use App\Models\Producto;
use App\Models\venta;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request) {
            $texto = trim($request->get('texto'));
            $ventas = DB::table('venta as v')
                ->join('persona as p', 'v.id_cliente', '=', 'p.id_persona')
                ->select('v.id_venta', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estatus', 'v.total_venta')
                ->where('v.num_comprobante', 'LIKE', '%' . $texto . '%')
                ->groupBy('v.id_venta', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estatus', 'v.total_venta')
                ->orderBy('v.id_venta', 'desc')
                ->paginate(8);

            return view('ventas/ventas.index', ['ventas' => $ventas, 'texto' => $texto]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $personas = DB::table('persona')
            ->where('tipo_persona', '=', 'Cliente')
            ->where('status', 'LIKE', '1')
            ->get();
        $ingreso = venta::all();
        $productos = DB::table('producto as p')
            ->select(DB::raw('CONCAT(p.codigo, " ", p.nombre) AS Articulo'), 'p.id_producto', 'p.precio_venta', 'p.stock')
            ->where('p.status', '=', 'Activo')
            ->get();
        return view("ventas.ventas.create", ["personas" => $personas, "productos" => $productos, "ingreso" => $ingreso]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VentaFormRequest $request)
    {

        try {

            DB::beginTransaction();
            $venta = new Venta();

            $venta->id_cliente = $request->get("id_cliente");

            $venta->tipo_comprobante = $request->get("tipo_comprobante");
            $venta->num_comprobante = $request->get("num_comprobante");
            $mytime = Carbon::now("America/Lima");
            $venta->fecha_hora = $mytime->toDateTimeString();
            $venta->estatus = 'A';
            $venta->total_venta = '0';
            $venta->impuesto = '18';
            $venta->save();

            $id_producto = $request->get('id_producto');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precio_venta = $request->get('precio_venta');
            $cont = 0;

            while ($cont < count($id_producto)) {
                $detalle = new Detalleventa();
                $detalle->id_venta = $venta->id_venta;
                $detalle->id_producto = $id_producto[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->descuento = $descuento[$cont];

                $producto = Producto::find($detalle->id_producto);

                if ($producto) {
                    // Verificar si hay suficiente stock disponible
                    if ($detalle->cantidad > $producto->stock) {
                        $stockErrorMessage = 'No hay suficiente stock disponible para el producto ' . $producto->nombre . '.';
                        Session::flash('stock_error', $stockErrorMessage);
                        if(count($id_producto)==1)$venta->delete();
                    } else {
                        // Actualizar el stock del producto

                        // Guardar el detalle de venta
                        $detalle->save();
                        $producto->stock -= $detalle->cantidad;
                        $producto->update();
                        $venta = venta::find($detalle->id_venta);
                        $venta->total_venta += ($detalle->cantidad * $detalle->precio_venta) - (($detalle->cantidad * $detalle->precio_venta) * $detalle->descuento / 100);
                        $venta->update();
                    }
                }

                $cont = $cont + 1;
            }

            // Si no hubo errores de stock, mostrar el mensaje de éxito
            if (!Session::has('stock_error')) {
                Session::flash('success', 'Venta y detalles creados exitosamente.');
                return redirect()->route('ventas.index');
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }

        return redirect()->route('ventas.show', ['venta' => $venta->id_venta]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productos = DB::table('producto as p')
            ->select(DB::raw('CONCAT(p.codigo, " ", p.nombre) AS Articulo'), 'p.precio_venta', 'p.id_producto', 'p.stock')
            ->where('p.status', '=', 'Activo')
            ->get();
        $ventas = DB::table('venta as v')
            ->join('persona as p', 'v.id_cliente', '=', 'p.id_persona')
            ->select('v.id_venta', 'v.total_venta', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estatus')
            ->where('v.id_venta', '=', $id)
            ->first();

        $detalles = DB::table('detalle_venta as dv')
            ->join('producto as p', 'dv.id_producto', '=', 'p.id_producto')
            ->select('dv.id_detalle_venta', 'dv.id_venta', 'p.nombre as articulo', 'dv.cantidad', 'dv.descuento', 'dv.precio_venta')
            ->where('dv.id_venta', '=', $id)
            ->get();

        return view('ventas.ventas.show', ['ventas' => $ventas, 'detalles' => $detalles, 'productos' => $productos]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
