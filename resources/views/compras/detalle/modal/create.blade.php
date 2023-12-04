<div class="modal fade" id="modal-create" role="dialog" aria-labelledby="modal-delete-label" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('detalles.store')}}" method="POST">
            @csrf
            <div class="modal-content bg-warning">
                <div class="modal-header">
                    <h4 class="modal-title">Crear Detalle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-6">
                            <div class="form-group">
                                <label for="id_producto">Productos</label>
                                <select style="width: 100%;" name="id_producto" class="js-example-basic-single " id="pid_producto">
                                    @foreach($productos as $producto)
                                    <option value="{{$producto->id_producto}}">{{ $producto->Articulo }}</option>
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
                                <label for="precio_compra">P_Compra</label>
                                <input type="number" class="form-control" step="0.01" min="0" name="precio_compra" id="precio_compra" placeholder="Precio_compra">
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                <label for="precio_venta">P_Venta</label>
                                <input type="number" class="form-control" step="0.01" min="0" name="precio_venta" id="precio_venta" placeholder="Precio_Venta">
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" value="{{$ingreso->id_ingreso}}" name="idingreso">

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="bt_add" class="btn btn-outline-light">Guardar</button>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
            </div>
        </form>
    </div>
    <!--/.modal-dialog -->
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
<!--/.modal -->
@push('scripts')
<script>
    jQuery(document).ready(function($) {
        $(document).ready(function() {
            $('#pid_producto').select2();
        });
    });
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 4000);
</script>

@endpush