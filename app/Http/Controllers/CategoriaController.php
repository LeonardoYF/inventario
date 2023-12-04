<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaFormRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CategoriaController extends Controller
{
    public function __construct()
    {
    }
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('texto'));
            $categorias = DB::table('categoria')
                ->where('categoria', 'LIKE', '%' . $query . '%')
                ->orderBy('id_categoria', 'asc')
                ->paginate(5);
            return view('almacen.categoria.index', ["categoria" => $categorias, 'texto' => $query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("almacen.categoria.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaFormRequest $request)
    {
        //
        try {
            $categoria = new Categoria;
            $categoria->categoria = $request->get('categoria');
            $categoria->descripcion = $request->get("descripcion");
            $categoria->estatus = "1";
            $categoria->save();

            Session::flash('success', 'Categoría creada exitosamente.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error al crear la categoría: ' . $e->getMessage());
        }

        return Redirect::to('almacen/categoria');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        return  view("almacen.categoria.show", ["categoria" => Categoria::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        return  view("almacen.categoria.edit", ["categoria" => Categoria::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaFormRequest $request,  $id)
    {
        //
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->categoria = $request->get('categoria');
            $categoria->descripcion = $request->get('descripcion');
            $categoria->estatus = $request->get('estatus');
            $categoria->update();
            Session::flash('success', 'Categoría Modificada exitosamente.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error al crear la categoría: ' . $e->getMessage());
        }
        return Redirect::to('almacen/categoria');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->estatus = '0';
            $categoria->update();
            Session::flash('success', 'Categoría Eliminada exitosamente.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error al crear la categoría: ' . $e->getMessage());
        }
        return Redirect::to('almacen/categoria');
        
            
    }
}
