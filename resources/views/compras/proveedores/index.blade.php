@extends('layouts.admin')
@section('contenido')
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">LISTADO DE PROVEEDORES</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Proveedores</li>
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
                        <form action="{{ route('proveedores.index')}}" method="get">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <input type="text" class="form-control" name="texto" placeholder="Buscar Proveedores" value='{{$texto}}'  aria-label="Recipient's username" aria-describedby="button-addon"/>
                                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">Buscar</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <a href="{{ route('proveedores.create') }}" class="btn btn-success">Nuevo</a>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    
                    <!-- table hover -->
                    <div class="table-responsive" >
                        <table class="table table-bordered table-hover" >
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Numero Documento</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proveedores as $prov)
                                <tr>
                                    <td>{{ $prov->id_persona}}</td>
                                    <td>{{ $prov->nombre}}</td>
                                    <td>{{ $prov->tipo_documento}}</td>
                                    <td>{{ $prov->num_documento}}</td>
                                    <td>{{ $prov->direccion}}</td>
                                    <td>{{ $prov->telefono}}</td>
                                    <td>{{ $prov->email}}</td>                                      
                                    <td>
                                        <a href="{{route('proveedores.edit',$prov->id_persona)}}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        <!-- Button trigger for danger theme modal -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$prov->id_persona}}"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                @include('compras.proveedores.modal')
                                @endforeach
                            </tbody>
                        </table>
                        {{$proveedores->links()}}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->
@endSection