<div class="modal fade" id="modal-delete-{{$prov->id_persona}}" role="dialog" aria-labelledby="modal-delete-label" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('proveedores.destroy', $prov->id_persona) }}" method="POST"> 
            @csrf
            @method('DELETE')
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Persona</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseas eliminar el producto {{$prov->nombre}}</p>
                </div>
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