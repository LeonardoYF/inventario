@extends('layouts.admin')
@section('contenido')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 style="font-size: 25px;">REPORTE DE VENTAS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Reporte</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.contenido respuesta -->
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> {{ Session::get('success') }}
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>ERROR!</strong> {{ Session::get('error') }}
</div>
@endif
<!-- Hoverable rows start -->
<section class="section">
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-xl-12 ">
                        <form action="{{route('reportes.index')}}" method="get">

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="input-group mb-6">
                                        <label style="margin-top: 2%;" for="id_cliente">Cliente</label>
                                        <div style="margin-left: 2%; width: 80%;" >
                                            <select id="id_clienteVenta" name="cliente"  class="form-control">
                                                @foreach($personas as $persona)
                                                <option value="{{$persona->nombre}}">{{$persona->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="input-group mb-6">
                                        <label style="margin-top: 2%;" for="fecha">Buscar Dia</label>
                                        <input style="margin-left: 2%;" value="{{$fecha}}" type="date" class="form-control" name="fecha" id="fecha">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="input-group mb-6">
                                        <label forordenar style="margin-top: 2%;" for="fecha">Ordenar</label>
                                        <select id="ordenar" name="ordenar" style="margin-left: 2%;" class="form-control">
                                            <option value="asc" {{ $ordenar == 'asc' ? 'selected' : '' }}>Ascendente</option>
                                            <option value="desc" {{ $ordenar == 'desc' ? 'selected' : '' }}>Descendente</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <button class="btn btn-outline-primary" type="submit" id="button-addon2">Buscar</button>
                                </div>
                                <div class="container-total">
                                    <label class="reporte-total">TOTAL GENERAL : </label>
                                    <label class="reporte-total"> {{$totalVentas[0]->total}}</label>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">

                        <!-- table hover -->
                        <div class="table table-bordered table-hover">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Fecha_venta</th>
                                        <th>Id_Venta</th>
                                        <th>Cliente</th>
                                        <th>SubTotal_Venta</th>
                                        <th>Visualizar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->fecha_hora}}</td>
                                        <td>{{ $venta->id_venta}}</td>
                                        <td>{{ $venta->cliente}}</td>
                                        <td>{{ $venta->total_venta}}</td>
                                        <td>
                                            <a href="{{route('reportes.show',$venta->id_venta)}}" class="btn btn-warning btn-sm"><i class="bi bi-box-arrow-in-up-right"></i></a>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            {{$ventas->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->
@push('scripts')
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 4000);
    jQuery(document).ready(function($) {
        $(document).ready(function() {
            $('#id_clienteVenta').select2();
        });
    });
</script>
@endpush
@endSection