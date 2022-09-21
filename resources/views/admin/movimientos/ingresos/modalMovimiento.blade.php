<div id="movimientoPopup" class="movimientoPopup offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formDataCompra">
        @csrf
        <div class="row">
            <div class="col-12 font-weight-bolder text-center">
                <h3> AJUSTAR INGRESO </h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 font-weight-bolder">
                <span class=" text-danger" id="cod_fenovo"></span> - <span id="nombre"></span>
            </div>
        </div>

        <input type="hidden" id="movimiento_id" name="movimiento_id" value="{{ $movement->id }}" />
        <input type="hidden" id="detalle_id" name="detalle_id" />
        <input type="hidden" id="producto_id" name="producto_id" />
        <input type="hidden" id="bultos_anterior" name="bultos_anterior" />
        <input type="hidden" id="tipo" name="tipo" value="{{ $movement->subtype }}" />
        <input type="hidden" id="unit_package" name="unit_package"/>

        <div class="row mt-5">
            <div class="col-4">
                <label class="text-body">Bultos</label>
            </div>
            <div class="col-8">
                <input type="number" id="bultos_actual" name="bultos_actual" class="form-control text-center" autofocus />                
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-6">
                <button type="reset" class="btn btn-outline-primary" onclick="cerrarModal()">
                    <i class="fa fa-times"></i> Cancelar
                </button>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-dark" onclick="actualizarMovimiento()">
                    <i class="fa fa-save"></i> Ajustar
                </button>
            </div>
        </div>
    </form>
</div>
