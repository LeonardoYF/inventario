<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoFormRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $productos = DB::table('producto as a')
            ->join('categoria as c', 'a.id_categoria', '=', 'c.id_categoria')
            ->select('a.id_producto', 'a.nombre', 'a.codigo', 'a.stock','a.precio_venta' ,'c.categoria', 'a.descripcion', 'a.imagen', 'a.status')
            ->where(function ($query) use ($texto) {
                $query->where('a.nombre', 'LIKE', '%' . $texto . '%')
                    ->orWhere('a.codigo', 'LIKE', '%' . $texto . '%')
                    ->orWhere('c.categoria', 'LIKE', '%' . $texto . '%')
                    ->orWhere('a.status', 'LIKE', '%' . $texto . '%');
            })
            ->orderBy('id_producto', 'asc')
            ->paginate(10);

        return view('almacen.producto.index', compact('productos', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Illuminate\Http\Response;
     */
    public function create()
    {
        $categorias = DB::table('categoria')->where('estatus', '=', '1')->get();
        return view("almacen.producto.create", ['categorias' => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     * @return Illuminate\Http\Resquest $request;
     * @return Illuminate\Http\Response;
     */
    public function store(ProductoFormRequest $request)
    {
        try {
            $producto = new Producto;
            $producto->id_categoria = $request->input('id_categoria');
            $producto->codigo = $request->input('codigo');
            $producto->nombre = $request->input('nombre');
            $producto->stock = $request->input('stock');
            $producto->precio_venta = $request->input('precio_venta');
            $producto->descripcion = $request->input('descripcion');
            $producto->status = 'Activo';
            // script para subir la imagen 
            if ($request->hasFile("imagen")) {
                $imagen = $request->file("imagen");
                $nombreimagen = Str::slug($request->nombre) . "." . $imagen->guessExtension();
                $ruta = public_path("/imagenes/productos/");
                copy($imagen->getRealPath(), $ruta . $nombreimagen);
                $producto->imagen = $nombreimagen;
            }
            $producto->save();
            Session::flash('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error al crear el producto: ' . $e->getMessage());
        }
        return redirect()->route('producto.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return  view("almacen.categoria.show", ["categoria" => Producto::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categorias = DB::table('categoria')->where('estatus', '=', '1')->get();
        $producto = Producto::findOrFail($id);
        return view("almacen.producto.edit", ['categorias' => $categorias, 'prod' => $producto]);
    }

    /**
     * Update the specified resource in storage.
     * @return Illuminate\Http\Resquest $request;
     * @return Illuminate\Http\Response;
     */
    public function update(Request $request, $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->id_categoria = $request->input('id_categoria');
            $producto->codigo = $request->input('codigo');
            $producto->nombre = $request->input('nombre');
            $producto->stock = $request->input('stock');
            $producto->precio_venta = $request->input('precio_venta');
            $producto->descripcion = $request->input('descripcion');
            $producto->status = $request->input('status');
            if ($request->hasFile("imagen")) {
                $imagen = $request->file("imagen");
                $nombreimagen = Str::slug($request->nombre) . "." . $imagen->guessExtension();
                $ruta = public_path("/imagenes/productos/");
                copy($imagen->getRealPath(), $ruta . $nombreimagen);
                $producto->imagen = $nombreimagen;
            }
            $producto->update();
            Session::flash('success', 'Producto modificado exitosamente.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error al modificar el producto: ' . $e->getMessage());
        }
        return Redirect::to('almacen/producto');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->status = 'No activo';
            $producto->update();
            Session::flash('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
        return Redirect()->route('producto.index');
    }
    
}
