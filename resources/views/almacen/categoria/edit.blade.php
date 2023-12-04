@extends('layouts.admin')
@section('contenido')
<!-- left column -->
<div class="col-md-6">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Editar Categoría</h3>
        </div>
        <!--/.card-header -->
        <!-- form start -->
        <form action="{{ route('categoria.update',$categoria->id_categoria) }}" method="POST" class="form">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="categoria">Nombre</label>
                    <input value="{{$categoria->categoria}}" type="text" class="form-control" name="categoria" id="categoria" placeholder="Ingresa el nombre de la categoría">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input value="{{$categoria->descripcion}}" type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Ingresa la descripción">
                    <!--/.card-body -->

                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="estatus">Estatus</label>
                        <select name="estatus" class="form-control" id="estatus">
                            <option value="1" {{ $categoria->estatus == '1' ? 'selected' : '' }}>1</option>
                            <option value="0" {{ $categoria->estatus == '0' ? 'selected' : '' }}>0</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success ne-1 mb-1">Guardar</button>
                    <button type="reset" class="btn btn-danger ne-1 mb-1">cancelar</button>
                </div>
            </div>
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