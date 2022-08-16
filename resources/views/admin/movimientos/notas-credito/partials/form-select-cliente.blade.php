<div class="col-lg-12 col-xl-12">
    <div class="card card-custom gutter-b bg-white border-0">
        <div class="card-body mb-5">

            <div class="row">
                <div class="col-md-4">
                    <label class="text-body">Movimiento</label>
                    <fieldset class="form-group mb-3">
                        <select class="js-example-basic-single js-states form-control bg-transparent" name="to_type"
                            id="to_type">
                            <option value="DEVOLUCION" @if (isset($tipo) && $tipo == 'DEVOLUCION') selected @endif>Devolución
                            </option>
                            <option value="DEVOLUCIONCLIENTE" @if (isset($tipo) && $tipo == 'DEVOLUCIONCLIENTE') selected @endif>
                                Devolución cliente</option>
                        </select>
                    </fieldset>
                </div>
                <div class="col-md-3">
                    <label class="text-body">Cliente/Tienda</label>
                    <fieldset class="form-group mb-3">
                        <select class="js-example-basic-single js-states form-control bg-transparent" name="to"
                            id="to">
                            @if (isset($destino))
                                <option value="{{ $destino->id }}">{{ $destinoName }}</option>
                            @endif
                        </select>
                    </fieldset>
                </div>
                <div class="col-md-3">
                    <label class="text-body">Seleccionar producto</label>
                    <fieldset class="form-group mb-3 d-flex">
                        <select class="js-example-basic-single js-states form-control bg-transparent"
                            name="product_search" id="product_search"> </select>
                    </fieldset>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" id="btnOpenCerrarNC" disabled
                        style="float: right;margin-top: 30px;height: 20px;padding: 2px 15px 22px 15px;">
                        <i class="fa fa-times"></i> Cerrar Nota de crédito</button>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-2 col-lg-2">
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="checkTiendas" onclick="verDiv()">Desde otro lugar
                    </div>
                </div>
            
                <div class="col-xs-12 col-md-2 col-lg-2">
                    <div id="divStore" style="display:none">
                        <select id="tienda_destino" name="tienda_destino" class="js-example-responsive" style="width: 100%">
                            <option value="0">Dónde ingresa la mercadería ...</option>
                            @foreach ($storesNaves as $store)
                                <option value="{{ $store->id }}">
                                    {{ str_pad($store->cod_fenovo, 3, '0', STR_PAD_LEFT) }} - {{ $store->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
