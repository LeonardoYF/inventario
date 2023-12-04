@extends('layouts.admin')
@section('contenido')
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">LISTADO DE VENTAS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Ventas</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Hoverable rows start -->
<section class="section">
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-xl-12">
                        <form action="{{ route('ventas.index') }}" method="get">

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        
                                        <input type="text" class="form-control" name="texto" placeholder="Buscar Ventas" value='{{$texto}}'  aria-label="Recipient's username" aria-describedby="button-addon"/>
                                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">Buscar</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <a href="{{ route('ventas.create') }}"  class="btn btn-success">Nueva</a>
                                       
                                    </div>
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
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Comprobante</th>
                                    <th>Impuesto</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                          
                            <tbody>
                                @foreach ($ventas as $venta)
                                <tr>
                                    <td>{{ $venta->fecha_hora}}</td>
                                    <td>{{ $venta->nombre}}</td>
                                    <td>{{ $venta->tipo_comprobante.':'.$venta->num_comprobante}}</td>
                                    <td>{{ $venta->impuesto}}</td>
                                    <td>{{ $venta->total_venta}}</td>
                                    <td>{{ $venta->estatus}}</td>
                                    <td>
                                        <a href="{{route('ventas.show',$venta->id_venta)}}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        <!-- Button trigger for danger theme modal -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$venta->id_venta}}"><i class="fas fa-trash-alt"></i></button>
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
@endSection