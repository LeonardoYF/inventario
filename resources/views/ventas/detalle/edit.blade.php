@extends('layouts.admin')
@section('contenido')
<!-- left column -->
<div class="col-md-12">

    <div class="card card-primary">
        <!--/.card-header -->
        <div class="card-header">
            <h3 class="card-title">Modificar Detalle Venta</h3>
        </div>

        <!-- form start -->
        <form action="{{ route('detallesVentas.update',$detalle->id_detalle_venta)}}" method="POST" class="form">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-6">
                        <div class="form-group">
                            <label for="id_producto">Productos</label>
                            <select style="width: 100%;" name="id_producto" class="js-example-basic-single" id="id_productomm">
                                @foreach($productos as $producto)
                                <option {{ $producto->id_producto == $detalle->id_producto ? 'selected' : '' }} value="{{ $producto->id_producto }}">{{ $producto->Articulo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input value="{{$detalle->cantidad}}" type="number" class="form-control" min="0" name="cantidad" id="cantidad" placeholder="Cantidad">
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <label for="descuento">Descuento</label>
                            <input value="{{$detalle->descuento}}" type="number" class="form-control" step="1" min="0" name="descuento" id="descuento" placeholder="Descuento">
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <label for="pprecio_venta">P_Venta</label>
                            <input readonly value="{{$detalle->precio_venta}}" type="number" class="form-control" step="0.01" min="0" name="precio_venta" id="precio_venta" placeholder="Precio_compra">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
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
    jQuery(document).ready(function($) {
        $(document).ready(function() {
            $('#id_productomm').select2();

        });
    });
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 4000);
</script>
@endpush
@endSection