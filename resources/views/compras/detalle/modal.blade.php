<div class="modal fade" id="modal-delete-{{$det->id_detalle_ingreso,$det->id_ingreso}}" role="dialog" aria-labelledby="modal-delete-label" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('detalles.destroy',$det->id_detalle_ingreso)}}" method="POST"> 
            @csrf
            @method('DELETE')
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Detalle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseas eliminar el detalle que incluye al producto {{ $det->articulo }}<br>
                    </p>
                </div>
                <input type="hidden" value="{{$det->id_ingreso}}" name="idingreso">
                <input type="hidden" value="{{$det->id_detalle_ingreso}}" name="id">                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button> 
                    <button type="submit" class="btn btn-outline-light">Eliminar</button>
                </div>
            </div>
        </form>
    </div>
    <!--/.modal-dialog -->
</div>
<!--/.modal -->