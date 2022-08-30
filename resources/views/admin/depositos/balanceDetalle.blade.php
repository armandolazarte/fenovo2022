<table class="table table-borderless mt-5 w-50 fenovo-celeste text-white">
    <tr>
        <td>
            #{{ $store->id }} - <strong> ( {{ $store->cod_fenovo }}) {{ $store->description }} </strong>
        </td>
        <td>Desde</td>
        <th>{{ date('d-m-Y', strtotime($fecha_desde)) }}</th>
        <td>Hasta</td>
        <th>{{ date('d-m-Y', strtotime($fecha_hasta)) }}</th>
    </tr>
</table>


<ul class="nav nav-pills" id="pills-tab1" role="tablist">
    <li class="nav-item mr-2">
        <a class="nav-link fenovo-celeste text-white-50" id="valuados-tab-basic" data-toggle="pill" href="#valuados"
            role="tab" aria-controls="valuados" aria-selected="true">
            Stocks valuados
        </a>
    </li>
    <li class="nav-item mr-2" id="nav-item-precios">
        <a class="nav-link fenovo-celeste text-white-50" id="sin-valuar-tab-basic" data-toggle="pill" href="#sin-valuar"
            role="tab" aria-controls="sin-valuar" aria-selected="false">
            Stocks
        </a>
    </li>
    <li class="nav-item mr-2 mt-2" id="nav-item-precios">
        <a class="fenovo-celeste text-white-50" role="tab" aria-selected="false">
            <a href="javascript:void(0)" onclick="exportar('{{ $store->id }}', '{{ $week }}', '{{ $year }}')">
                <i class=" fa fa-file-csv"></i> Exportar balance
            </a>
        </a>
    </li>
</ul>

<div class="tab-content" id="v-pills-tabContent1">
    <div class="tab-pane fade show active" id="valuados" role="tabpanel" aria-labelledby="home-tab-basic">
        <div class="table-responsive">
            <table class=" table table-hover dataTable table-condensed yajra-datatable text-center" role="grid"
                id="tabla-valores">
                <thead>
                    <tr class="bg-dark text-black-50">
                        <td>Codigo</td>
                        <td>Producto</td>
                        <td>Inicial</td>
                        <td>Entradas</td>
                        <td>Salidas</td>
                        <td>Resultado</td>
                        <td>Actual</td>
                        <td>Dif</td>
                        <td>Accion</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto['cod_fenovo'] }}</td>
                            <td class=" text-left">{{ $producto['name'] }}</td>
                            <td>{{ $producto['inicialValorizada'] }}</td>
                            <td>{{ $producto['entradasValorizada'] }}</td>
                            <td>{{ $producto['salidasValorizada'] }}</td>
                            <th class=" text-danger">{{ $producto['resultadoValorizada'] }}</th>
                            <th class=" text-success">{{ $producto['actualValorizada'] }}</th>
                            <td>
                                @if ($producto['resultadoValorizada'] != 0 && $producto['actualValorizada'] != 0)
                                    {{ number_format(($producto['resultadoValorizada'] / $producto['actualValorizada'] - 1) * 100, 2) }} %
                                @else

                                    @if($producto['resultadoValorizada'] > $producto['actualValorizada'])
                                        {{ $producto['resultadoValorizada'] }}
                                    @else
                                        {{ $producto['actualValorizada']}}
                                    @endif    
                                    
                                @endif
                                
                            </td>
                            <td>
                                @if ($producto['resultadoValorizada'] - $producto['actualValorizada'] > 1)
                                    <a
                                        href="{{ route('product.historial.tienda', ['product_id' => $producto['id'], 'store_id' => $store->id]) }}">
                                        <i class="fa fa-list" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="sin-valuar" role="tabpanel" aria-labelledby="service-tab-basic">
        <div class="table-responsive">
            <table class=" table table-hover dataTable table-condensed yajra-datatable text-center" role="grid"
                id="tabla-sin-valuar">
                <thead>
                    <tr class="bg-dark text-black-50">
                        <td>Codigo</td>
                        <td>Producto</td>
                        <td>Inicial</td>
                        <td>Entradas</td>
                        <td>Salidas</td>
                        <td>Resultado</td>
                        <td>Actual</td>
                        <td>Revisar</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto['cod_fenovo'] }}</td>
                            <td class=" text-left">{{ $producto['name'] }}</td>
                            <td>{{ $producto['inicial'] }}</td>
                            <td>{{ $producto['entradas'] }}</td>
                            <td>{{ $producto['salidas'] }} </td>
                            <th class=" text-danger">{{ $producto['resultado'] }}</th>
                            <th class=" text-success">{{ $producto['actual'] }}</th>
                            <td>
                                @if ($producto['resultado'] != $producto['actual'])
                                    <a
                                        href="{{ route('product.historial.tienda', ['product_id' => $producto['id'], 'store_id' => $store->id]) }}">
                                        <i class="fa fa-list" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    var dataTable = jQuery("#tabla-valores").DataTable({
        scrollY: 300,
        paging: false,
        ordering: false,
        iDisplayLength: -1,
    });

    var dataTable = jQuery("#tabla-sin-valuar").DataTable({
        scrollY: 300,
        paging: false,
        ordering: false,
        iDisplayLength: -1,
    });
</script>
