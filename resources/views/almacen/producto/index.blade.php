@extends('layouts.admin')
@section('contenido')
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">LISTADO DE PRODUCTOS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Productos</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
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
                    <div class="col-xl-12">
                        <form action="{{ route('producto.index')}}" method="get">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <input type="text" class="form-control" name="texto" placeholder="Buscar Productos" value='{{$texto}}'  aria-label="Recipient's username" aria-describedby="button-addon"/>
                                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">Buscar</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <a href="{{ route('producto.create') }}" class="btn btn-success">Nuevo</a>
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
                        <table class="table table-bordered" >
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Stock</th>
                                    <th>Precio_Venta</th>
                                    <th>Descripcion</th>
                                    <th>Imagen</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $prod)
                                <tr>
                                    <td>{{ $prod->codigo}}</td>
                                    <td>{{ $prod->nombre}}</td>
                                    <td>{{ $prod->categoria}}</td>
                                    <td>{{ $prod->stock}}</td>
                                    <td>{{ $prod->precio_venta}}</td>
                                    <td>{{ $prod->descripcion}}</td>
                                    <td><img src="{{asset('imagenes/productos/'.$prod->imagen)}}" alt="{{ $prod->nombre }}" height="50px" width="50px" class="img-thumbnail"/></td>
                                    <td>{{ $prod->status}}</td>                                    
                                    <td>
                                        <a href="{{route('producto.edit',$prod->id_producto)}}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        <!-- Button trigger for danger theme modal -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$prod->id_producto}}"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                @include('almacen.producto.modal')
                                @endforeach
                            </tbody>
                        </table>
                        {{$productos->links()}}
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
</script>
@endpush
@endSection