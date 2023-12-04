@extends('layouts.admin')
@section('detalle')
<!-- Hoverable rows start -->
<section class="col-md-12 col-12">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card-body">
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


                <!-- table hover -->
                <div class="table-responsive">
                    <table id="detalles" class="table table-bordered table-hover">
                        <thead style="background-color:#A9D0F5">
                            <tr>
                                <th>Opciones</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>P_Venta</th>
                                <th>Descuento(%)</th>
                                <th>Sub Total</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <th>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <a href="" data-toggle="modal" data-target="#modal-create-venta" data-idventa="{{$ventas->id_venta}}" data-productos="{{$productos}}"  class="btn btn-success"><i class="bi bi-plus-lg"></i></a>
                                    </div>
                                </div>
                            </th>
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
                                <td>
                                    <a href="{{route('detallesVentas.edit',$det->id_detalle_venta)}}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>

                                    <a class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-eliminar-{{$det->id_detalle_venta}}"><i class="fas fa-trash-alt"></i></a>

                                </td>
                                <td>{{$det->articulo}}</td>
                                <td>{{$det->cantidad}}</td>

                                <td>{{$det->precio_venta}}</td>
                                <td>{{$det->descuento}}</td>
                                <!-- Corregido el paréntesis de cierre -->
                                <td>{{number_format(($det->cantidad * $det->precio_venta)-(($det->cantidad * $det->precio_venta)* ($det->descuento)/100), 2)}}</td>
                            </tr>


                            @include('ventas.detalle.modal')

                            @endforeach
                            @include('ventas.detalle.modal.create')
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <div class="row">

        <div class="card-footer">
            <button name="guardar" id="guardar" class="btn btn-success me-1 mb-1">Guardar</button>
            <a href="{{route('ingresos.index')}}" name="regresar" id="regresar" class="btn btn-dark me-1 mb-1">Regresar</a>
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