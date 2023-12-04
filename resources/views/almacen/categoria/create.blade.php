@extends('layouts.admin')
@section('contenido')
<!-- left column -->
<div class="col-md-6">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Nueva Categoría</h3>
        </div>
        <!--/.card-header -->

        <!-- form start -->
        <form action="{{ route('categoria.store') }}" method="POST" class="form">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="categoria">Nombre</label>
                    <input type="text" class="form-control" name="categoria" id="categoria" placeholder="Ingresa el nombre de la categoría">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Ingresa la descripción">
                    <!--/.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success ne-1 mb-1">Guardar</button>
                        <button type="reset" class="btn btn-danger ne-1 mb-1">cancelar</button>
                    </div>
                </div>
            </div>
    </div>
    </form>
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