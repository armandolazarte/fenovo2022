@isset($movimientos)

    <div class="table-responsive">
        <table class=" table table-hover table-striped table-sm text-center yajra-datatable" id="show-entrada"">
            <thead>
                <tr class=" bg-dark text-black-50">
                    <th>Cod fenovo</th>
                    <th class="w-25">Producto</th>
                    <th>Unidad</th>
                    <th>Presentación</th>
                    <th>Bultos</th>
                    <th>Unidades</th>
                    <th>Iva</th>
                    <th>Costo</th>
                    <th>Iva</th>
                    <th>Neto</th>
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
                
                $totalIva10 = 0;
                $totalIva21 = 0;
                $totalIva27 = 0;
                
            @endphp

            @foreach ($movimientos as $movimiento)
                @php
                    $total += $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                    $totalIva += ($movimiento->tasiva / 100) * $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                    
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
                    }
                    
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
                        {{ number_format(($movimiento->tasiva / 100) * $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos, 2, ',', '.') }}
                    </td>
                    <td> 
                        {{ number_format($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos, 2, ',', '.') }}
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
                <th>{{ number_format($totalIva, 2, ',', '.') }}</th>
                <th>{{ number_format($total, 2, ',', '.') }}</th>
                <th> {{ number_format($totalIva + $total, 2, ',', '.') }}</th>
                <th></th>
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col-6">

        </div>
        <div class="col-6">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <tr>
                        <td>Neto 10,5%</td>
                        <th>{{ number_format($totalNeto10, 2, ',', '.') }}</th>
                        <td>Iva 10,5%</td>
                        <th>{{ number_format($totalIva10, 2, ',', '.') }}</th>
                        <td>Ley25413</td>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Neto 21,0%</td>
                        <th>{{ number_format($totalNeto21, 2, ',', '.') }}</th>
                        <td>Iva 21,0%</td>
                        <th>{{ number_format($totalIva21, 2, ',', '.') }}</th>
                        <td>Ret.DGR</td>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Neto 27,0%</td>
                        <th>{{ number_format($totalNeto27, 2, ',', '.') }}</th>
                        <td>Iva 27,0%</td>
                        <th>{{ number_format($totalIva27, 2, ',', '.') }}</th>
                        <td>Ret.IVA</td>
                        <th></th>
                    </tr>
                    <tr>
                        <td>No Gravado</td>
                        <th></th>
                        <td>Perc.DGR</td>
                        <th></th>
                        <td>Ret.GAN</td>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Exento</td>
                        <th></th>
                        <td>Perc.IVA</td>
                        <th></th>
                        <td>TOTAL</td>
                        <th></th>
                    </tr>
        
                </table>
            </div>
        </div>
    </div>

@endisset


@section('js')
<script>
    var dataTable = jQuery(".yajra-datatable").DataTable({
        scrollY: 300,
        info: false,
        paging: false,
        ordering: false,
    })
</script>
@endsection
