<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $texto = trim($request->get('cliente'));
        $ordenar = $request->get('ordenar');
        if ($ordenar == null) $ordenar = 'asc';
        
        $ventas = DB::table('venta as v')
            ->join('persona as p', 'v.id_cliente', '=', 'p.id_persona')
            ->select('v.id_venta', 'v.fecha_hora', 'p.nombre as cliente', 'v.total_venta')
            ->orwhere('p.nombre', 'like', '%' . $texto . '%')
            ->whereRaw('DATE(v.fecha_hora) = ?', [$request->get('fecha')])
            ->groupBy('v.id_venta', 'v.fecha_hora', 'p.nombre', 'v.total_venta')
            ->orderBy('v.total_venta', $ordenar)
            ->paginate(20);
        $totalVentas = DB::table('venta as v')
            ->join('persona as p', 'v.id_cliente', '=', 'p.id_persona')
            ->select(DB::raw('sum(total_venta) as total'))
            ->orwhere('p.nombre', 'like', '%' . $texto . '%')
            ->whereRaw('DATE(v.fecha_hora) = ?', [$request->get('fecha')])
            ->get();
        $personas = DB::table('persona')
            ->where('tipo_persona', '=', 'Cliente')
            ->where('status', 'LIKE', '1')
            ->get();

        return view('reportes.index', ['personas'=>$personas,'ordenar' => $ordenar, 'ventas' => $ventas, 'texto' => $texto, 'totalVentas' => $totalVentas, 'fecha' => $request->get('fecha')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productos = DB::table('producto as p')
            ->select(DB::raw('CONCAT(p.codigo, " ", p.nombre) AS Articulo'), 'p.id_producto', 'p.stock')
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

        return view('reportes.mostrar', ['ventas' => $ventas, 'detalles' => $detalles, 'productos' => $productos]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
