<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorFormRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $proveedores = DB::table('persona')
            ->where('status', '=', '1')
            ->where('tipo_persona', 'like', 'Proveedor')
            ->where(function ($query) use ($texto) {
                $query  ->where('nombre', 'LIKE', '%' . $texto . '%')
                        ->orWhere('num_documento', 'LIKE', '%' . $texto . '%')
                        ->orWhere('email', 'LIKE', '%' . $texto . '%')
                        ->orWhere('tipo_documento', 'LIKE', '%' . $texto . '%');
            })
            ->orderBy('id_persona', 'asc')
            ->paginate(10);
        return view('compras.proveedores.index', compact('proveedores', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("compras.proveedores.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProveedorFormRequest $request)
    {
        $proveedor = new Proveedor();
        $proveedor->tipo_persona = 'Proveedor';
        $proveedor->nombre = $request->get("nombre");
        $proveedor->tipo_documento = $request->get("tipo_documento");
        $proveedor->num_documento = $request->get("num_documento");
        $proveedor->direccion = $request->get("direccion");
        $proveedor->telefono = $request->get("telefono");
        $proveedor->email = $request->get("email");
        $proveedor->status = '1';
        $proveedor->save();
        return Redirect::to('compras/proveedores');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return  view("compras.proveedores.show", ["proveedores" => Proveedor::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return  view("compras.proveedores.edit", ["prov" => Proveedor::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->nombre = $request->get("nombre");
        $proveedor->tipo_documento = $request->get("tipo_documento");
        $proveedor->num_documento = $request->get("num_documento");
        $proveedor->direccion = $request->get("direccion");
        $proveedor->telefono = $request->get("telefono");
        $proveedor->email = $request->get("email");
        $proveedor->update();
        return Redirect::to('compras/proveedores');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->status = '0';
        $proveedor->update();
        return Redirect()->route('proveedores.index')
            ->with('success', 'Cliente Eliminado Correctamente');
    }
}
