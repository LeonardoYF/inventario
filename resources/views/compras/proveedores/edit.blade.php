@extends('layouts.admin')
@section('contenido')
<!-- left column -->
<div class="col-md-12">

    <div class="card card-primary">
        <!--/.card-header -->
        <div class="card-header">
            <h3 class="card-title">Modificar Proveedor</h3>
        </div>

        <!-- form start -->
        <form action="{{ route('proveedores.update',$prov->id_persona)}}" method="POST" class="form">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input value="{{$prov->nombre}}" type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre del producto">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="tipo_documento">Tipo Documento</label>
                            <select name="tipo_documento" class="form-control" id="tipo_documento">
                                <option value="Dni" {{ $prov->tipo_documento == 'Dni' ? 'selected' : '' }}>Dni</option>
                                <option value="Carnet Extranjeria" {{ $prov->tipo_documento == 'Carnet Extranjeria' ? 'selected' : '' }}>Carnet Extranjeria</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="num_documento">N° Documento</label>
                            <input value="{{$prov->num_documento}}" type="text" class="form-control" name="num_documento" id="num_documento" placeholder="Ingresa el N° de documento">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="direccion">Direccion</label>
                            <input value="{{$prov->direccion}}" type="text" class="form-control" name="direccion" id="direccion" placeholder="Ingresa la direccion del cliente" />
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input value="{{$prov->telefono}}" type="text" class="form-control" name="telefono" id="telefono" placeholder="Ingresa el telefono del cliente" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input value="{{$prov->email}}" type="email" class="form-control" id="email" name="email">
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