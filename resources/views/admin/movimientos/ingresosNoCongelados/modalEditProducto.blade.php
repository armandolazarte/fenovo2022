<div id="editProducto" class="editProducto offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formDataEdit">
        @csrf
        <div class="row">
            <div class="col-12" id="insertByAjax"></div>
        </div>
        <div class="row">
            <div class="col-6">
                <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="cerrar_modal()">
                    <i class="fa fa-times"></i> Cancelar
                </a>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-primary btn-actualizar" onclick="actualizarProductoNoCongelado()">
                    <i class="fa fa-save"></i> Actualizar
                </button>
            </div>
        </div>
    </form>
</div>
