<div class="modal fade" id="modal-eliminar-{{$det->id_detalle_venta}}" tabindex="-1" role="dialog" aria-labelledby="modal-eliminar-label" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('detallesVentas.destroy',$det->id_detalle_venta)}}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Detalle de Venta</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseas eliminar el detalle cuyo id es {{ $det->id_detalle_venta }}
                     
                    </p>
                </div>
                <input type="hidden" name="id_detalle_venta" value="{{$det->id_detalle_venta}}">
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Eliminar</button>
                </div>
            </div>
        </form>
    </div>
    <!--/.modal-dialog -->
</div>
<!--/.modal -->