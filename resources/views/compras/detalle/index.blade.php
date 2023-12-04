@section('detalle')


<!-- Hoverable rows start -->
<section class="col-md-12 col-12">
    <div class="row">
        <div class="col-md-12 col-12">
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

                            </tr>
                        </thead>
                        <tfoot>
                            <th>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <a href="" data-toggle="modal" data-target="#modal-create" data-idingreso="{{$ingreso->id_ingreso}}" data-productos="{{$productos}}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a>
                                    </div>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total :</th>
                            <th>
                                <h4 id="total">${{number_format($totalGeneral,2)}}</h4>
                            </th>
                        </tfoot>
                        <tbody>
                            @foreach($detalles as $det)
                            <tr>
                                <td>
                            
                                        <a href="{{route('detalles.edit',$det->id_detalle_ingreso)}}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        <!-- Button trigger for danger theme modal -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$det->id_detalle_ingreso,$det->id_ingreso}}"><i class="fas fa-trash-alt"></i></button>
                                      
                                    
                                </td>
                                <td>{{$det->articulo}}</td>
                                <td>{{$det->cantidad}}</td>
                                <td>{{$det->precio_compra}}</td>
                                <td>{{$det->precio_venta}}</td> <!-- Corregido el paréntesis de cierre -->
                                <td>{{number_format($det->cantidad * $det->precio_compra, 2)}}</td>
                            </tr>

                            
                            @include('compras.detalle.modal')
                            @include('compras.detalle.modal.create')
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <input type="hidden" name="_token" value="{{ csrf_token()}}">
        <div class="card-footer">
            <button  name="guardar" id="guardar" class="btn btn-success me-1 mb-1">Guardar</button>
            <a href="{{route('ingresos.index')}}" name="regresar" id="regresar" class="btn btn-dark me-1 mb-1">Regresar</a>
        </div>
    </div>
</section>

<!-- Hoverable rows end -->

@endSection
