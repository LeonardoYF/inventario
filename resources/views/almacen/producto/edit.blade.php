@extends('layouts.admin')
@section('contenido')
<!-- left column -->
<div class="col-md-12">

    <div class="card card-primary">
        <!--/.card-header -->
        <div class="card-header">
            <h3 class="card-title">Modificar Producto</h3>
        </div>

        <!-- form start -->
        <form action="{{ route('producto.update', $prod->id_producto) }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input value="{{$prod->nombre}}" type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre del producto">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>categoría</label>
                            <select name="id_categoria" class="form-control" id="id_categoria">
                                @foreach ($categorias as $cat)
                                <option value="{{ $cat->id_categoria }}" {{ $cat->id_categoria == $prod->id_categoria ? 'selected' : '' }}>
                                    {{ $cat->categoria }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="codigo">Codigo</label>
                            <input value="{{$prod->codigo}}" type="text" class="form-control" name="codigo" id="codigo" placeholder="Ingresa el código del producto">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input value="{{$prod->stock}}" type="text" class="form-control" name="stock" id="stock" placeholder="Ingresa el stock del producto">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="unidad">Unidad</label>
                            <select name="unidad" class="form-control" id="unidad">
                                <option>Piezas</option>
                                <option>Kilos</option>
                                <option>cajas</option>
                                <option>Paquetes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input value="{{$prod->descripcion}}" type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Ingresa la descripción del producto" />
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="precio_venta">Precio_Venta</label>
                            <input value="{{$prod->precio_venta}}" type="text" class="form-control" name="precio_venta" id="precio_venta" placeholder="Ingresa el Precio de Venta del producto">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="imagen">Imagen</label>
                            <input value="{{$prod->imagen}}" type="file" class="form-control" id="imagen" name="imagen">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="status">Estado</label>
                            <select name="status" class="form-control" id="status">
                                <option value="Activo" {{ $prod->status == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="No activo" {{ $prod->status == 'No activo' ? 'selected' : '' }}>No activo</option>
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
            <!--/.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-success me-1 mb-1">Guardar</button>
                <button type="reset" class="btn btn-danger me-1 mb-1">cancelar</button>
            </div>
        </form>
    </div>
</div>
@if($errors->any())
<div class="alert alert" id="alerta">
    <ul>
        @foreach($errors->all() as $error)
        <li> <i class="bi bi-x-circle-fill"></i>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@push('scripts')
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 4000);
</script>
@endpush
@endSection