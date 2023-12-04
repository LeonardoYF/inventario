<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetalleIngresoFormRequest;
use App\Http\Requests\IngresoFormRequest;
use App\Models\DetalleIngreso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleIngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $detalles = DB::table('detalle_ingreso as di')
            ->join('producto as p', 'di.id_producto', '=', 'p.id_producto')
            ->select('di.id_detalle_ingreso', 'p.nombre as articulo', 'di.cantidad', 'di.precio_compra', 'di.precio_venta')
            ->orderBy('di.id_detalle_ingreso', 'asc')
            ->paginate(5);

        return view('compras.detalle.index', ["detalles" => $detalles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $id_ingreso = $request->get('id_ingreso');
        $productos = DB::table('producto as p')
            ->select(DB::raw('CONCAT(p.codigo, " ", p.nombre) AS Articulo'), 'p.id_producto', 'p.stock')
            ->where('p.status', '=', 'Activo')
            ->get();
        return view("compras.detalle.modal.create", ["productos" => $productos, "id_ingreso" => $id_ingreso]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(DetalleIngresoFormRequest $request)
    {
        $detalle = new DetalleIngreso();
        $detalle->id_ingreso = $request->get('idingreso');
        $detalle->cantidad = $request->get('cantidad');
        $detalle->id_producto = $request->get('id_producto');
        $detalle->precio_compra = $request->get('precio_compra');
        $detalle->precio_venta = $request->get('precio_venta');
        $detalle->save();
        return redirect()->route('ingresos.show', ['ingreso' => $request->get('idingreso')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $detalles = DB::table('detalle_ingreso as di')
            ->join('producto as p', 'di.id_producto', '=', 'p.id_producto')
            ->select('di.id_producto','di.id_detalle_ingreso', 'di.id_ingreso', 'p.nombre as articulo', 'di.cantidad', 'di.precio_compra', 'di.precio_venta')
            ->where('di.id_detalle_ingreso', '=', $id)
            ->first();
        $productos = DB::table('producto as p')
            ->select(DB::raw('CONCAT(p.codigo, " ", p.nombre) AS Articulo'), 'p.id_producto', 'p.stock')
            ->where('p.status', '=', 'Activo')
            ->get();
            return view('compras.detalle.edit', [ 'detalle' => $detalles,'productos'=>$productos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        try {
            // Obtener el detalle que se va a actualizar
            $detalle = DetalleIngreso::findOrFail($id);

            // Actualizar los campos del detalle
            $detalle->cantidad = $request->input('cantidad');
            $detalle->id_producto = $request->input('id_producto');
            $detalle->precio_compra = $request->input('precio_compra');
            $detalle->precio_venta = $request->input('precio_venta');

            // Guardar los cambios en la base de datos
            $detalle->update();

           
        } catch (Exception $e) {
            // Manejar errores y posiblemente realizar un rollback

            return back()->with('error', 'Error al actualizar el detalle.');
        }


        return redirect()->route('ingresos.show', ['ingreso' => $detalle->id_ingreso]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        
        try {
            DB::beginTransaction();
            // Obtener el ingreso que se va a cancelar
            $detalle = DetalleIngreso::findOrFail($id);
            $idingreso = $detalle->id_ingreso;
            // Actualizar el estado a 'C' (cancelado)
            $detalle->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return redirect()->route('ingresos.show', ['ingreso' => $idingreso]);
    }
}
