@extends('layouts.admin')
@section('contenido')
<!-- left column -->
<div class="col-md-12">

    <div class="card card-primary">
        <!--/.card-header -->
        <div class="card-header">
            <h3 class="card-title">Detalle Ingreso</h3>
        </div>

        <!-- form start -->
        <form action="{{ route('ingresos.index') }}" method="GET" class="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label for="id_proveedor">Proveedor</label>
                            <p>{{$ingreso->nombre}}</p>
                        </div>
                    </div>


                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label for="tipo_comprobante">Tipo Comprobante</label>
                            <p>{{$ingreso->tipo_comprobante}}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label for="num_comprobante">N° Documento</label>
                            <p>{{$ingreso->num_comprobante}}</p>
                        </div>
                    </div>
                </div>
        </form>
        <div class="row">
            @section('detalle')
            @include('compras.detalle.index')
            @show
        </div>
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token()}}">

        </div>
    </div>
    <!--/.card-body -->


</div>
</div>

@endSection