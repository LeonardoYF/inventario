<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;
use App\Http\Requests\IngresoFormRequest;
use App\Models\Ingreso;
use App\Models\DetalleIngreso;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;
use Symfony\Component\HttpFoundation\Response;

class IngresoController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request) {
            $texto = trim($request->get('texto'));
            $ingresos = DB::table('ingreso as i')
                ->join('persona as p', 'i.id_proveedor', '=', 'p.id_persona')
                ->join('detalle_ingreso as det', 'i.id_ingreso', '=', 'det.id_ingreso')
                ->select('i.id_ingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado', DB::raw('SUM(det.cantidad * det.precio_compra) as total'))
                ->where('i.num_comprobante', 'LIKE', '%' . $texto . '%')
                ->groupBy('i.id_ingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado')
                ->orderBy('i.id_ingreso', 'desc')
                ->paginate(8);

            return view('compras/ingreso.index', ['ingresos' => $ingresos, 'texto' => $texto]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $personas = DB::table('persona')
            ->where('tipo_persona', '=', 'Proveedor')
            ->where('status', 'LIKE', '1')
            ->get();
        $ingreso = Ingreso::all();
        $productos = DB::table('producto as p')
            ->select(DB::raw('CONCAT(p.codigo, " ", p.nombre) AS Articulo'), 'p.id_producto', 'p.stock')
            ->where('p.status', '=', 'Activo')
            ->get();
        return view("compras.ingreso.create", ["personas" => $personas, "productos" => $productos, "ingreso" => $ingreso]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $ingreso = new Ingreso;
            $ingreso->id_proveedor = $request->get("id_proveedor");
            $ingreso->tipo_comprobante = $request->get("tipo_comprobante");
            $ingreso->num_comprobante = $request->get("num_comprobante"); // Corregido el signo = en lugar de -
            $mytime = Carbon::now("America/Lima");
            $ingreso->fecha_hora = $mytime->toDateTimeString(); // Corregido el signo - en lugar de ->
            $ingreso->impuesto = '18';
            $ingreso->estado = 'A';
            $ingreso->save();

            $id_producto = $request->get('id_producto');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');
            $cont = 0;

            while ($cont < count($id_producto)) {
                $detalle = new DetalleIngreso();
                $detalle->id_ingreso = $ingreso->id_ingreso;
                $detalle->id_producto = $id_producto[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_compra = $precio_compra[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont = $cont + 1;
            }

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            dd($e);
        }
        return Redirect::to('compras/ingresos');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $productos = DB::table('producto as p')
            ->select(DB::raw('CONCAT(p.codigo, " ", p.nombre) AS Articulo'), 'p.id_producto', 'p.stock')
            ->where('p.status', '=', 'Activo')
            ->get();
        $ingreso = DB::table('ingreso as i')
            ->join('persona as p', 'i.id_proveedor', '=', 'p.id_persona')
            ->join('detalle_ingreso as di', 'i.id_ingreso', '=', 'di.id_ingreso')
            ->select('i.id_ingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado')
            ->where('i.id_ingreso', '=', $id)
            ->first();

        $detalles = DB::table('detalle_ingreso as di')
            ->join('producto as p', 'di.id_producto', '=', 'p.id_producto')
            ->select('di.id_detalle_ingreso','di.id_ingreso','p.nombre as articulo', 'di.cantidad', 'di.precio_compra', 'di.precio_venta')
            ->where('di.id_ingreso', '=', $id)
            ->get();

        $totalGeneral = DB::table('detalle_ingreso')
            ->where('id_ingreso', '=', $id)
            ->sum(DB::raw('cantidad * precio_compra'));

        return view('compras.ingreso.show', ['ingreso' => $ingreso, 'detalles' => $detalles, 'totalGeneral' => $totalGeneral,'productos'=>$productos]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Obtener los datos del ingreso que se va a editar
        $ingreso = Ingreso::findOrFail($id);

        // Obtener los detalles relacionados con este ingreso
        $detalles = DB::table('detalle_ingreso as di')
            ->join('producto as p', 'di.id_producto', '=', 'p.id_producto')
            ->select('p.nombre as articulo', 'di.cantidad', 'di.precio_compra', 'di.precio_venta')
            ->where('di.id_ingreso', '=', $id)
            ->get();

        // Obtener otras variables necesarias para el formulario (si es necesario)
        $personas = DB::table('persona')->where('tipo_persona', '=', 'Proveedor')->get();
        $productos = DB::table('producto as p')
            ->select(DB::raw('CONCAT(p.codigo, " ", p.nombre) AS Productos'), 'p.id_producto', 'p.stock')
            ->where('p.status', '=', 'Activo')
            ->get();

        // Pasar los datos a la vista de edición
        return view('compras.ingreso.edit', ['ingreso' => $ingreso, 'detalles' => $detalles, 'personas' => $personas, 'productos' => $productos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            // Obtener el ingreso que se va a actualizar
            $ingreso = Ingreso::findOrFail($id);

            // Actualizar los campos del ingreso con los valores del formulario
            $ingreso->id_proveedor = $request->get('idproveedor');
            $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
            $ingreso->num_comprobante = $request->get('num_comprobante');
            // ... Actualizar otros campos si es necesario ...
            $ingreso->save();

            // Actualizar los detalles de ingreso relacionados (si es necesario)
            $id_producto = $request->get('id_producto');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');

            // Eliminar detalles existentes (opcional)
            DetalleIngreso::where('id_ingreso', $id)->delete();

            // Insertar nuevos detalles
            for ($cont = 0; $cont < count($id_producto); $cont++) {
                $detalle = new DetalleIngreso();
                $detalle->id_ingreso = $ingreso->id_ingreso;
                $detalle->id_producto = $id_producto[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_compra = $precio_compra[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return Redirect::to('compras/ingreso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Obtener el ingreso que se va a cancelar
            $ingreso = Ingreso::findOrFail($id);

            // Actualizar el estado a 'C' (cancelado)
            $ingreso->estado = 'C';
            $ingreso->update();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return Redirect()->route('ingresos.index')
            ->with('success', 'Ingreso Eliminado Correctamente');
    }
}
