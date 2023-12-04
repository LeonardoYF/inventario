<div class="modal fade" id="modal-create-venta" role="dialog" aria-labelledby="modal-delete-label" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('detallesVentas.store')}}" method="POST">
            @csrf
            <div class="modal-content bg-warning">
                <div class="modal-header">
                    <h4 class="modal-title">Crear Detalle Venta</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-6">
                            <div class="form-group">
                                <label for="id_producto">Productos</label>
                                <select name="id_producto" style="width: 100%;" class="js-example-basic-single " id="id_producto" data-live-search="true">
                                    @foreach($productos as $producto)
                                    <option value="{{ $producto->id_producto }}" data-precio="{{ $producto->precio_venta }}">{{ $producto->Articulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" class="form-control" min="0" name="cantidad" id="cantidad" placeholder="Cantidad">
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label for="descuento">Descuento</label>
                                <input type="number" class="form-control" step="1" min="0" name="descuento" id="descuento" placeholder="Descuento">
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label for="pprecio_venta">P_Venta</label>
                                <input readonly type="number" class="form-control" step="0.01" min="0" name="precio_venta" id="precio_venta" placeholder="Precio_Venta">
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" value="{{$ventas->id_venta}}" name="idventa">
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="bt_add" class="btn btn-outline-primary">Guardar</button>
                </div>

            </div>
        </form>
    </div>
    <!--/.modal-dialog -->
</div>
@if(Session::has('stock_error'))
<div class="alert alert-danger">
    {{ Session::get('stock_error') }}
</div>
@endif
@if($errors->any())
<div class="alert alert" id="alerta">
    <ul>
        @foreach($errors->all() as $error)
        <li> <i class="bi bi-x-circle-fill"></i>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!--/.modal -->
@push('scripts')
<script>
    jQuery(document).ready(function($) {
        $(document).ready(function() {
            $('#id_producto').select2();
        });
    });
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 4000);
    $(document).ready(function() {
        $('#id_producto').change(function() {
            var selectedOption = $(this).find('option:selected');
            var precioVenta = selectedOption.data('precio');

            if (precioVenta !== undefined) {
                $('#precio_venta').val(precioVenta);
            } else {
                $('#precio_venta').val('');
            }
        });
    });
</script>

@endpush