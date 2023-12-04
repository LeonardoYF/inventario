@extends('layouts.admin')
@section('contenido')
<!-- left column -->
<div class="col-md-12">

    <div class="card card-primary">
        <!--/.card-header -->
        <div class="card-header">
            <h3 class="card-title">Nuevo Ingreso</h3>
        </div>

        <!-- form start -->
        <form action="{{ route('ingresos.store') }}" method="POST" class="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label for="id_proveedor">Proveedor</label>
                            <select name="id_proveedor" class="form-control" id="id_proveedor">
                                @foreach($personas as $persona)
                                <option value="{{$persona->id_persona}}">{{$persona->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label for="tipo_comprobante">Tipo Comprobante</label>
                            <select name="tipo_comprobante" class="form-control" id="tipo_comprobante">
                                <option>Ruc</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label for="num_comprobante">N° Documento</label>
                            <input type="numero" class="form-control" name="num_comprobante" id="num_comprobante" placeholder="Ingresa el N° de documento">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <label for="pid_producto">Productos</label>
                            <select name="pid_producto" class="form-control selectpicker" id="pid_producto" data-live-search="true">
                                @foreach($productos as $producto)
                                <option value="{{ $producto->id_producto }}">{{ $producto->Articulo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label for="pcantidad">Cantidad</label>
                            <input type="number" class="form-control" min="0" name="pcantidad" id="pcantidad" placeholder="Cantidad">
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label for="pprecio_compra">P_Compra</label>
                            <input type="number" class="form-control" step="0.01" min="0" name="pprecio_compra" id="pprecio_compra" placeholder="Precio_compra">
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label for="pprecio_venta">P_Venta</label>
                            <input type="number" class="form-control" step="0.01" min="0" name="pprecio_venta" id="pprecio_venta" placeholder="Precio_compra">
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <button style="margin-left: 15%;margin-top: 12%;width: 50%;" type="button" id="bt_add" class="btn btn-success me-1 mb-1 "><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-6">
                        <div class="card-body">

                            <!-- table hover -->
                            <div class="table-responsive">
                                <table id="detalles" class="table table-bordered table-hover">
                                    <thead style="background-color:#A9D0F5">
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>P_Compra</th>
                                            <th>P_Venta</th>
                                            <th>Sub Total</th>
                                            <th>Estado</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <h4 id="total">$ 0.00</h4>
                                        </th>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                    
                    <div class="card-footer">
                        <button type="submit" name="guardar" id="guardar" class="btn btn-success me-1 mb-1">Guardar</button>
                        <button type="reset" class="btn btn-danger me-1 mb-1">cancelar</button>
                    </div>
                </div>
            </div>
            <!--/.card-body -->

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
    $(document).ready(function() {
        $('#bt_add').click(function() {
            agregar();
        })
    })
    var cont = 0;
    var subTotal = [];
    total = 0;

    $("#guardar").hide();
    $("#pid_producto").change(mostrarvalores);


    function mostrarvalores() {
        datosArticulo = document.getElementById("pid_producto").value.split('_');
        $("#pcantidad").val(1); // Esto se puede ajustar según tus necesidades
        $("#unidad").html(datosArticulo[2]);
    }

    function agregar() {
        var datosArticulo = document.getElementById("pid_producto").value.split('_');
        id_producto = datosArticulo[0];
        Articulo = $("#pid_producto option:selected").text(); // Corregido el uso de option:selected
        cantidad = $("#pcantidad").val();
        precio_compra = $("#pprecio_compra").val();
        precio_venta = $("#pprecio_venta").val();
        if (id_producto != "" && Articulo != "" && cantidad > 0 && precio_compra != "" && precio_venta != "") {
            subTotal[cont] = cantidad * precio_compra ;
            total += subTotal[cont];
            var fila = '<tr class="selected" id="fila' + cont + '"><td><button type="button" class="btn btn-warning" onclick="eliminar(' + cont + ');">X</button></td><td><input type="hidden" name="id_producto[]" value="' + id_producto + '">' + id_producto + '</td><td><input type="number" style="width: 20%;" name="cantidad[]" value="' + cantidad + '"></td><td><input type="number" name="precio_compra[]" style="width: 20%;" value="' + precio_compra + '"></td><td><input type="number" name="precio_venta[]" style="width: 20%;" value="' + precio_venta + '"></td><td>' + subTotal[cont] + '</td></tr>';
            cont++;
            limpiar();
            $("#total").html("$" + total); // Corregido el formato de concatenación
            evaluar();
            $('#detalles').append(fila);
        } else {
            alert("Error al ingresar el detalle del ingreso, revise los datos del articulo")
        }
    }

    function limpiar() {
        $('#pcantidad').val("");
        $('#pprecio_compra').val("");
        $('#pprecio_venta').val("");
    }

    function evaluar() {
        if (total > 0) {
            $('#guardar').show();
        } else {
            $('#guardar').hide()
        }
    }

    function eliminar(index) {
        total -= subTotal[index]; // Corregida la resta del subtotal
        $("#total").html("s/." + total); // Corregido el formato de concatenación
        $("#fila" + index).remove();
        evaluar();
    }
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 4000);
</script>
@endpush
@endSection