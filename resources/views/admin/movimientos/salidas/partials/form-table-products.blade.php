<div class="table-responsive">
    <table class="table table-striped table-borderless table-condensed table-hover text-center yajra-datatable">
        <thead>
            <tr class="bg-dark text-white">
                <td>Codigo</td>
                <td>Nombre del producto</td>
                <td>Presentación</td>
                <td>Bultos</td>
                <td>Cantidad</td>
                <td>Precio</th>
                <td>Iva</td>
                <td class="text-right">Subtotal</td>
                <td>NroPalet</td>
                <td>Editar</td>
                <td>
                    @if (in_array(Auth::user()->rol(), ['superadmin', 'admin', 'contable']))
                    <a href="javascript:void(0)" onclick="deleteItemSession()" title="Eliminar productos seleccionados " class=" text-white">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    @endif
                </td>
            </tr>
        </thead>
        <tbody>
            @if (isset($session_products))
                @php
                    $subtotal_product = 0;
                    $total_kgrs = 0;
                    $total_unidades = 0;
                    $total_bultos = 0;
                    $total_iva = 0;
                    $subtotal = 0;
                @endphp
                @foreach ($session_products as $session_product)
                    @php
                        $unit_price = $session_product->invoice ? $session_product->unit_price : $session_product->neto;
                        $subtotal_product = $unit_price * $session_product->unit_package * $session_product->quantity;
                        $subtotal_product_format = number_format($subtotal_product, 2, ',', '');
                        $total_bultos += $session_product->quantity;
                        $total_kgrs += $session_product->producto->unit_weight * $session_product->unit_package * $session_product->quantity;
                        $total_iva += $session_product->invoice ? $subtotal_product * ($session_product->producto->product_price->tasiva / 100) : 0;
                        $subtotal += $subtotal_product;
                    @endphp

                    <tr>
                        <td>{{ $session_product->producto->cod_fenovo }}</td>
                        <td class="text-left">
                            @if ($session_product->circuito == 'CyO')
                                <span style="font-size: 24px;vertical-align: -webkit-baseline-middle;"> * </span>
                            @endif
                            {{ $session_product->producto->name }}
                        </td>
                        <td>{{ number_format($session_product->unit_package, 2) }}</td>
                        <td>{{ $session_product->quantity }}</td>
                        <td>
                            @if ($session_product->unit_type == 'K')
                                {{ $session_product->producto->unit_weight * $session_product->unit_package * $session_product->quantity }}
                            @else
                                {{ $session_product->unit_package * $session_product->quantity }}
                            @endif
                        </td>
                        <td> {{ number_format($unit_price, 2, ',', '') }}</td>
                        <td> {{ $session_product->invoice ? number_format($session_product->producto->product_price->tasiva, 2) : 0 }}
                            % </td>
                        <td class=" text-right"> {{ $subtotal_product_format }}</td>
                        <td>
                            <select name="palet" id="palet" onchange="cambioPalet('{{ $session_product->id }}', this.value)">
                                <option value="">...</option>
                                @for ($i = 1; $i < 11; $i++)
                                    <option value="{{ $i }}" @if (isset($session_product->palet) && $session_product->palet == $i) selected @endif>{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <a href="javascript:void(0)"
                                onclick="editarMovimiento('{{ $session_product->id }}', '{{ $session_product->quantity }}', '{{ $session_product->producto->cod_fenovo }}')"
                                title="modificar">
                                <i class=" fa fa-pencil-alt"></i>
                            </a>
                        </td>
                        <td>

                            @if (in_array(Auth::user()->rol(), ['superadmin', 'admin', 'contable']))
                                <input type="checkbox" class="deleteItem" value="{{ $session_product->id }}">                                
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <input type="hidden" name="subTotal" id="subTotal" value="{{ $subtotal + $total_iva }}">
    <input type="hidden" name="total_from_session" id="total_from_session" value="{{ $subtotal }}">
</div>

<div class="row mt-5 mb-2">
    <div class="col-5 text-right">ITEM</div>
    <div class="col-1 text-center font-weight-bolder"> {{ $session_products->count('quantity') }} </div>
    <div class="col-3 text-right">SUBTOTAL $</div>
    <div class="col-1 text-right font-weight-bolder"> {{ number_format($subtotal, 2, ',', '') }} </div>
    <div class="col-1"></div>
</div>

<div class="row mb-2">
    <div class="col-5 text-right">BULTOS</div>
    <div class="col-1 text-center font-weight-bolder"> {{ $session_products->sum('quantity') }} </div>
    <div class="col-3 text-right">IVA $</div>
    <div class="col-1 text-right font-weight-bolder"> {{ number_format($total_iva, 2, ',', '') }} </div>
    <div class="col-1"></div>
</div>

<div class="row mb-2">
    <div class="col-9 text-right">
        TOTAL $
    </div>
    <div class="col-1 text-right font-weight-bolder">
        {{ number_format($subtotal + $total_iva, 2, ',', '') }}
    </div>
    <div class="col-1"></div>
</div>


<script>
    jQuery('#product_search').select2('open');

    var dataTable = jQuery(".yajra-datatable").DataTable({
        scrollY: 300,
        info: false,
        paging: false,
        ordering: true,
        columnDefs: [{
                orderable: true,
                targets: 0
            },
            {
                orderable: false,
                targets: 1
            },
            {
                orderable: false,
                targets: 2
            },
            {
                orderable: false,
                targets: 3
            },
            {
                orderable: false,
                targets: 4
            },
            {
                orderable: false,
                targets: 5
            },
            {
                orderable: false,
                targets: 6
            },
            {
                orderable: false,
                targets: 7
            },
            {
                orderable: false,
                targets: 8
            },
            {
                orderable: false,
                targets: 9
            },
            {
                orderable: false,
                targets: 10
            },
        ],
        order: [
            [0, 'asc']
        ],
        iDisplayLength: -1,
    });

</script>
