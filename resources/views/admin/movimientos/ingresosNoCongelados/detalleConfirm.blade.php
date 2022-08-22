@isset($movimientos)

    <div class="table-responsive">
        <table class=" table table-hover table-striped table-sm text-center yajra-datatable" id="show-entrada"">
            <thead>
                <tr class=" bg-dark text-black-50">
                    <th>Cod fenovo</th>
                    <th class="w-25 text-left">Nombre del producto</th>
                    <th>Unidad</th>
                    <th>Presentación</th>
                    <th>Bultos</th>
                    <th>Unidades</th>
                    <th>Iva</th>
                    <th>Costo</th>
                    <th>Neto</th>
                    <th>Iva</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $totalIva = 0;
                    
                    $totalNeto10 = 0;
                    $totalNeto21 = 0;
                    $totalNeto27 = 0;
                    $totalNetoNoGravado = 0;
                    
                    $totalIva10 = 0;
                    $totalIva21 = 0;
                    $totalIva27 = 0;
                    
                @endphp

                @foreach ($movimientos as $movimiento)
                    @php
                        
                        switch ($movimiento->tasiva) {
                            case '10.5':
                            $totalNeto10 += $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                            $totalIva10 += ($movimiento->tasiva / 100) * $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                            break;
                            case '21.0':
                            $totalNeto21 += $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                            $totalIva21 += ($movimiento->tasiva / 100) * $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                            break;
                            case '27.0':
                            $totalNeto27 += $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                            $totalIva27 += ($movimiento->tasiva / 100) * $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                            break;
                            
                            case '0':
                            $totalNetoNoGravado += $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                            break;
                        }

                        $total += ($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos) + $totalNetoNoGravado;
                        $totalIva += ($movimiento->tasiva / 100) * $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                        
                    @endphp

                    <tr>
                        <td> {{ $movimiento->product->cod_fenovo }} </td>
                        <td class="text-left">{{ $movimiento->product->name }}</td>
                        <td> {{ $movimiento->unit_type }}</td>
                        <td> {{ number_format($movimiento->unit_package, 2) }} </td>
                        <td> {{ $movimiento->bultos }}</td>
                        <td> {{ $movimiento->entry }} </td>
                        <td> {{ $movimiento->tasiva }}% </td>
                        <td> {{ $movimiento->cost_fenovo }}</td>                        
                        <td>
                            {{ number_format($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos, 2, ',', '.') }}
                        </td>
                        <td> 
                            {{ number_format(($movimiento->tasiva / 100) * $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos, 2, ',', '.') }}
                        </td>
                        <td>
                            {{ number_format($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos * (1 + $movimiento->tasiva / 100), 2, ',', '.') }}
                        </td>
                        <td>
                            <a href="#"
                                onclick="borrarDetalle('{{ $movimiento->movement_id }}', '{{ $movimiento->product_id }}')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tr>
                <th colspan="12">
                    </hr>
                </th>
            </tr>
            <tr>
                <th>Totales </th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ $movimientos->sum('bultos') }}</th>
                <th>{{ number_format($movimientos->sum('entry'), 2, ',', '.') }}</th>
                <th></th>
                <th></th>
                <th>{{ number_format($total, 2, ',', '.') }}</th>
                <th>{{ number_format($totalIva, 2, ',', '.') }}</th>
                <th>{{ number_format($totalIva + $total, 2, ',', '.') }}</th>
                <th></th>
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col-7">
            <table class="table table-bordered text-left">
                <tr>
                    <td>Ley25413</td>
                    <th><input type="text" min="0" step="0.1" value="0" name="l25413" id="l25413" onkeyup="totalizar()"
                            class=" form-control text-center border-info calculateCompra"></th>
                    <td>Ret.ATER</td>
                    <th><input type="text" min="0" step="0.1" value="0" name="retater" id="retater" onkeyup="totalizar()"
                            class=" form-control text-center border-info calculateCompra"></th>
                    <td>Ret.IVA</td>
                    <th><input type="text" min="0" step="0.1" value="0" name="retiva" id="retiva" onkeyup="totalizar()"
                            class=" form-control text-center border-info calculateCompra"></th>
                    <td>Ret.GAN</td>
                    <th><input type="text" min="0" step="0.1" value="0" name="retgan" id="retgan" onkeyup="totalizar()"
                            class=" form-control text-center border-info calculateCompra"></th>
                </tr>
                <tr>
                    <td>No Grav.</td>
                    <th><input type="text" min="0" step="0.1" value="0" name="nograv" id="nograv" onkeyup="totalizar()"
                            class=" form-control text-center border-info calculateCompra"></th>
                    <td>Perc.ATER</td>
                    <th><input type="text" min="0" step="0.1" value="0" name="percater" id="percater" onkeyup="totalizar()"
                            class=" form-control text-center border-info calculateCompra"></th>
                    <td>Perc.IVA</td>
                    <th><input type="text" min="0" step="0.1" value="0" name="perciva" id="perciva" onkeyup="totalizar()"
                            class=" form-control text-center border-info calculateCompra"></th>
                    <td>Exento</td>
                    <th><input type="text" min="0" step="0.1" value="{{ round($totalNetoNoGravado,2) }}" name="exento" id="exento" onkeyup="totalizar()"
                            class=" form-control text-center border-info calculateCompra"></th>
                </tr>
            </table>

        </div>
        <div class="col-5">
            <table class="table table-bordered text-center">
                <tr>
                    <td>Neto 10,5%</td>
                    <th>
                        <input type="number" readonly id="totalNeto10" name="totalNeto10"
                        value="{{ round($totalNeto10, 2) }}" class=" form-control text-center border-info calculateCompra">
                    </th>
                    <td>Iva 10,5%</td>
                    <th>
                        <input type="number" readonly id="totalIva10" name="totalIva10"
                            value="{{ round($totalIva10, 2) }}" class=" form-control text-center border-info calculateCompra">
                    </th>
                </tr>
                <tr>
                    <td>Neto 21,0%</td>
                    <th>
                        <input type="number" readonly id="totalNeto21" name="totalNeto21"
                        value="{{ round($totalNeto21, 2) }}" class=" form-control text-center border-info calculateCompra">
                    </th>
                    <td>Iva 21,0%</td>
                    <th>
                        <input type="number" readonly id="totalIva21" name="totalIva21"
                            value="{{ round($totalIva21, 2) }}" class=" form-control text-center border-info calculateCompra">
                    </th>
                </tr>
                <tr>
                    <td>Neto 27,0%</td>
                    <th>
                        <input type="number" readonly id="totalNeto27" name="totalNeto27"
                        value="{{ round($totalNeto27, 2) }}" class=" form-control text-center border-info calculateCompra">
                        <td>Iva 27,0%</td>
                        <th>
                            <input type="number" readonly id="totalIva27" name="totalIva27"
                                value="{{ round($totalIva27, 2) }}" class=" form-control text-center border-info calculateCompra">
                        </th>
                    </th>
                </tr>
                <tr>
                    <td></td>
                    <th colspan="2">
                        <span class=" form-control border-info">
                            TOTAL DE LA FACTURA $
                        </span>
                    </th>
                    <th>
                        <span class=" form-control border-danger text-center font-weight-bolder totalCompra">
                            {{ round($totalIva + $total, 2) }}
                        </span>

                        <input type="hidden" id="totalCompra" name="totalCompra" value="{{ round($totalIva + $total, 2) }}">
                    </th>
                </tr>

            </table>
        </div>
    </div>
@endisset

@section('js')
    @parent

    <script>
        const totalizar = () => {

            let total = 0;

            jQuery('.calculateCompra').each(function() {
                if (isNaN(parseFloat(jQuery(this).val()))) {
                    jQuery(this).val(0)
                }
            });

            jQuery('.calculateCompra').each(function() {
                let valor = parseFloat(jQuery(this).val());
                total = total + (valor);
            });

            jQuery('.totalCompra').html(total.toFixed(2))    
            jQuery('#totalCompra').val(total.toFixed(2))            
        }
    </script>
@endsection
