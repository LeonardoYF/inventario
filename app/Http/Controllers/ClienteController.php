<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteFormRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $clientes = DB::table('persona')
            ->where('status', '=', '1')
            ->where('tipo_persona', 'like', 'Cliente')
            ->where(function ($query) use ($texto) {
                $query  ->where('nombre', 'LIKE', '%' . $texto . '%')
                        ->orWhere('num_documento', 'LIKE', '%' . $texto . '%')
                        ->orWhere('email', 'LIKE', '%' . $texto . '%')
                        ->orWhere('tipo_documento', 'LIKE', '%' . $texto . '%');
            })
            ->orderBy('id_persona', 'asc')
            ->paginate(10);
        return view('ventas.cliente.index', compact('clientes', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("ventas.cliente.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClienteFormRequest $request)
    {
        $cliente = new Cliente;
        $cliente->tipo_persona = 'Cliente';
        $cliente->nombre = $request->get("nombre");
        $cliente->tipo_documento = $request->get("tipo_documento");
        $cliente->num_documento = $request->get("num_documento");
        $cliente->direccion = $request->get("direccion");
        $cliente->telefono = $request->get("telefono");
        $cliente->email = $request->get("email");
        $cliente->status = '1';
        $cliente->save();
        return Redirect::to('ventas/cliente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return  view("ventas.cliente.show", ["cliente" => Cliente::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return  view("ventas.cliente.edit", ["cli" => Cliente::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->tipo_persona = 'Cliente';
        $cliente->nombre = $request->get("nombre");
        $cliente->tipo_documento = $request->get("tipo_documento");
        $cliente->num_documento = $request->get("num_documento");
        $cliente->direccion = $request->get("direccion");
        $cliente->telefono = $request->get("telefono");
        $cliente->email = $request->get("email");
        $cliente->update();
        return Redirect::to('ventas/cliente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->status = '0';
        $cliente->update();
        return Redirect()->route('cliente.index')
            ->with('success', 'Cliente Eliminado Correctamente');
    }
}
