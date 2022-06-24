<form method="POST" id="ajuste-stock">
    <div class="row mb-3">
        <div class="col-6">
            <h4 class=" card-title mb-0">
                {{ $product->cod_fenovo }} <span class="text-primary"> {{ $product->name }} </span>
            </h4>
        </div>
        <div class="col-2">
            <input type="hidden" name="stockActual" id="stockActual" value="{{ $stock }}">
            <h4 class=" card-title mb-0">Stock actual <span class=" text-primary"> {{ $stock }} </span> </h4>
        </div>
        <div class="col-2 text-center">
            <h4 class=" card-title mb-0">Peso <span class=" text-primary"> {{ $product->unit_weight }} </span> Kgrs
            </h4>
        </div>
        <div class="col-2 text-center">
            <h4 class=" card-title mb-0">Unidad medida <span class=" text-primary"> {{ $product->unit_type }} </span>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <table class="table">
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <tr class=" bg-dark text-white">
                    <th class="w-50">TIPO</th>
                    <th class="w-50 text-center">STOCK ACTUAL</th>
                </tr>
                <tr>
                    <td>FACTURADO</td>
                    <th class="text-center">{{ $product->stock_f }}</th>
                </tr>
                <tr>
                    <td>REMITO</td>
                    <th class="text-center">{{ $product->stock_r }}</th>
                </tr>
                <tr>
                    <td>CTA y ORDEN</td>
                    <th class="text-center">{{ $product->stock_cyo }}</th>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>#Id interno <span class=" font-weight-bold"> {{ $product->id }} </span> </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div class="col-xs-12 col-md-6">

            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
            <input type="hidden" name="unit_type" id="unit_type" value="{{ $product->unit_type }}">
            <input type="hidden" name="unit_weight" id="unit_weight" value="{{ $product->unit_weight }}">
            <input type="hidden" name="bultos" id="bultos">

            <table class="table">
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <tr class=" bg-dark text-white">
                    <th class="w-50">PRESENTACIONES</th>
                    <th class="w-50 text-center">BULTOS</th>
                </tr>
                @for ($i = 0; $i < count($stock_presentaciones); $i++)
                    @if ($i == 0)
                        <input type="hidden" name="presentacion" id="presentacion" value="{{ $stock_presentaciones[$i]['presentacion'] }}">
                    @endif

                    <tr>
                        <th class="text-center">
                            {{ $stock_presentaciones[$i]['presentacion'] }}
                        </th>
                        <td class="text-center">
                            <input type="text" name="unidades_{{ $stock_presentaciones[$i]['presentacion'] }}"
                                id="unidades_{{ $stock_presentaciones[$i]['presentacion'] }}"
                                class="form-control calculate text-center bg-white border-primary font-weight-bolder" value="0"
                                onkeyup="sumar(this)">
                        </td>
                    </tr>
                @endfor

                <tr>
                    <td>Observaciones / comentarios del ajuste</td>
                    <th>
                        <input type="text" name="observacion" id="observacion" class="form-control bg-white border-primary">
                    </th>
                </tr>

                <tr>
                    <td>Tipo ajuste</td>
                    <th>
                        @foreach ($ajustes as $ajuste)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radioAjuste{{ $ajuste['type'] }}" name="ajuste" class="custom-control-input" onclick="VerAjuste(this.value)" value="{{ $ajuste['type'] }}" @if( $loop->first) checked @endif>
                            <label class="custom-control-label" for="radioAjuste{{ $ajuste['type'] }}"> {{ $ajuste['type'] }}</label>
                        </div>
                        @endforeach
                    </th>
                </tr>
                <tr>
                    <td>Operación </td>
                    <th>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radioOperacion1" name="operacion" class="custom-control-input" onclick="VerOperacion(this.value)" value="suma" checked>
                            <label class="custom-control-label" for="radioOperacion1">SUMAR</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radioOperacion2" name="operacion" class="custom-control-input" onclick="VerOperacion(this.value)" value="resta">
                            <label class="custom-control-label" for="radioOperacion2">RESTAR</label>
                        </div>
                    </th>
                </tr>
                <tr>
                    <td>Tipo de stock a ajustar</td>
                    <th>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radioTipo1" name="tipo" class="custom-control-input" onclick="VerTipo(this.value)" value="F" checked>
                            <label class="custom-control-label" for="radioTipo1">FACTURADO</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radioTipo2" name="tipo" class="custom-control-input" onclick="VerTipo(this.value)" value="R">
                            <label class="custom-control-label" for="radioTipo2">REMITO</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radioTipo3" name="tipo" class="custom-control-input" onclick="VerTipo(this.value)" value="CyO">
                            <label class="custom-control-label" for="radioTipo3">CTA y ORDEN</label>
                        </div>                        
                    </th>
                </tr>
                <tr>
                    <th>
                        <input type="hidden" name="cantidad" id="cantidad" value="0">
                    </th>
                    <th class=" text-center">
                        <a href="javascript:ajustar()" id="btnAplicar" class="btn btn-block btn-dark" title="Ajustar stock "> Ajustar </a>
                    </th>
                </tr>
            </table>
        </div>

        <div class="col-xs-12 col-md-6">            
        </div>

        <div class="col-xs-12 col-md-3">
            <h4>Stock ajustado <span id="txtAjustado" class=" text-danger">  </span> </h4>
        </div>          
        
        <div class="col-xs-12 col-md-3">
            <h4>Cantidad a ajustar <span id="txtCantidad" class= "text-primary font-weight-bold"> 0 </span> </h4> 
        </div>

    </div>
</form>
