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
                </div>
                <div class="card-content">
                    <div class="card-body">

                        <!-- table hover -->
                        <div class="table-responsive">
                            <table id="detalles" class="table table-bordered table-hover">
                                <thead style="background-color:#A9D0F5">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>P_Venta</th>
                                        <th>Descuento(%)</th>
                                        <th>Sub Total</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total :</th>
                                    <th>
                                        <h4 id="total">${{number_format($ventas->total_venta,2)}}</h4>
                                    </th>
                                </tfoot>
                                <tbody>
                                    @foreach($detalles as $det)
                                    <tr>

                                        <td>{{$det->articulo}}</td>
                                        <td>{{$det->cantidad}}</td>

                                        <td>{{$det->precio_venta}}</td>
                                        <td>{{$det->descuento}}</td>
                                        <!-- Corregido el paréntesis de cierre -->
                                        <td>{{number_format(($det->cantidad * $det->precio_venta)-(($det->cantidad * $det->precio_venta)* ($det->descuento)/100), 2)}}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="card-footer">
                       
                        <a href="{{route('reportes.index')}}" name="regresar" id="regresar" class="btn btn-dark me-1 mb-1">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->
@endSection