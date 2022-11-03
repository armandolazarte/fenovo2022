<div class="card gutter-b bg-white border-0">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                @isset($movimientos)
                    <div class="table-datapos">
                        <div class="table-responsive">
                            <table class=" table table-hover table-sm text-center">
                                <tr class=" bg-dark text-white">
                                    <th>Codigo</th>
                                    <th>Producto</th>
                                    <th>Medida</th>
                                    <th>Kgrs</th>
                                    <th>Presentación</th>
                                    <th>$_Costo </th>
                                    <th>Bultos</th>
                                    <th>$_Total</th>
                                    <th>Unidades</th>
                                    <th>#</th>
                                    <th>Historial</th>
                                    <th>
                                        <a href="javascript:void(0)" onclick="deleteItemSession()" title="Eliminar productos seleccionados " class=" text-white">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </th>
                                </tr>

                                @php
                                    $total = 0;
                                @endphp

                                @foreach ($movimientos as $movimiento)

                                    @if ($loop->first)
                                       <input type="hidden" name="circuito" id="circuito" value="{{ $movimiento->circuito }}">
                                    @endif


                                    @php
                                        $total += $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                                    @endphp
                                    <tr>
                                        <td> {{ $movimiento->product->cod_fenovo }} </td>
                                        <td class=" text-left"> {{ $movimiento->product->name }}</td>
                                        <td> {{ $movimiento->unit_type }} </td>
                                        <td> {{ number_format($movimiento->product->unit_weight * $movimiento->unit_package * $movimiento->bultos, 2, ',', '.') }}
                                        </td>
                                        <td> {{ $movimiento->unit_package }} </td>
                                        <td> {{ $movimiento->cost_fenovo }}</td>
                                        <td> {{ $movimiento->bultos }}</td>
                                        <td> {{ number_format($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos, 2, ',', '.') }}
                                        </td>
                                        <td> {{ number_format($movimiento->unit_package * $movimiento->bultos, 0, '', '') }}
                                        </td>
                                        <td>
                                            @if ($movement->status == 'FINISHED')
                                                <a href="javascript:void(0)"
                                                    onclick="editarMovimiento(
                                                            '{{ $movimiento->id }}', 
                                                            '{{ $movimiento->bultos }}', 
                                                            '{{ $movimiento->product->id }}',
                                                            '{{ $movimiento->product->cod_fenovo }}',
                                                            '{{ $movimiento->product->name }}',
                                                            '{{ $movimiento->unit_package }}'
                                                        )">
                                                    <i class=" fa fa-pencil-alt"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('product.historial', ['id' => $movimiento->product_id]) }}">
                                                <i class="fa fa-list" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if ($movement->status == 'FINISHED')
                                            <input type="checkbox" class="deleteItem" value="{{ $movimiento->id }}">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                <tr class=" bg-dark text-black-50">
                                    <th>Totales</th>
                                    <th></th>
                                    <th></th>
                                    <th>{{ number_format($movement->totalKgrs(), 2, ',', '.') }}</th>
                                    <th></th>
                                    <th></th>
                                    <th> {{ $movimientos->sum('bultos') }} </th>
                                    <th> {{ number_format($total, 2, ',', '.') }} </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endisset
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-10">

            </div>
            <div class="col-2 text-center">

                @if ($movement->status == 'FINISHED')
                    <button onclick="check_compra('{{ $movement->id }}')" class="btn btn btn-primary">
                        <i class="f "></i> Chequeada
                    </button>
                @endif
            </div>
        </div>

    </div>
</div>