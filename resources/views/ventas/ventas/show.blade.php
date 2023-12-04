@extends('layouts.admin')

@section('contenido')
<!-- left column -->
<div class="col-md-12">

    <div class="card card-primary">
        <!--/.card-header -->
        <div class="card-header">
            <h3 class="card-title">Detalle Venta</h3>
        </div>

        <!-- form start -->
        <form action="{{ route('ventas.index') }}" method="GET" class="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label for="id_proveedor">Cliente</label>
                            @if ($ventas)
                            <p>{{$ventas->nombre}}</p>
                            @else
                            <p></p>
                            @endif
                        </div>
                    </div>


                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label for="tipo_comprobante">Tipo Comprobante</label>
                            @if ($ventas)
                            <p>{{$ventas->tipo_comprobante}}</p>
                            @else
                            <p></p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label for="num_comprobante">N° Documento</label>
                            @if ($ventas)
                            <p>{{$ventas->num_comprobante}}</p>
                            @else
                            <p></p>
                            @endif
                        </div>
                    </div>
                </div>
        </form>
        
        
        <div class="row">
            @section('detalle')
            @include('ventas.detalle.index')
            @show
        </div>
       
       
       
    </div>
    <!--/.card-body -->


</div>
</div>

@endSection