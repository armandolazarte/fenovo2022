@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">Ingreso de mercadería</li>
            </ol>
        </nav>
    </div>
</div>
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card gutter-b bg-white border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="text-body">Fecha</label>
                        <fieldset class="form-group mb-3">
                            <strong>{{ date('d-m-Y',strtotime($movement->date)) }}</strong>
                        </fieldset>
                    </div>
                    <div class="col-md-3">
                        <label class="text-body">Operación</label>
                        <fieldset class="form-group mb-3">
                            <strong>{{ $movement->type }}</strong>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        <label class="text-body">Origen</label>
                        <fieldset class="form-group mb-3">
                            <strong>{{ $movement->origenData($movement->type) }}</strong>
                        </fieldset>
                    </div>
                    <div class="col-md-2 text-center">
                        <label class="text-dark">Nro Comprobante</label>
                        <fieldset class="form-group mb-3">
                            <strong>{{ $movement->voucher_number }}</strong>
                        </fieldset>
                    </div>
                    <div class="col-md-1 text-center">

                    </div>
                    <div class="col-md-1 text-center">

                    </div>
                </div>
            </div>

            <div class="card gutter-b bg-white border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            @isset($movimientos)
                            <div class="table-datapos">
                                <div class="table-responsive">
                                    <table class=" table table-hover table-sm text-center">
                                        <tr class=" bg-dark text-white">
                                            <th class="text-center">#</th>
                                            <th>Cod fenovo</th>
                                            <th>Producto</th>
                                            <th>Unidad</th>
                                            <th>Presentación</th>
                                            <th>$_Costo </th>
                                            <th>Bultos</th>
                                            <th>$_Total</th>
                                            <th>Cantidad</th>
                                        </tr>

                                        @php
                                        $total = 0;
                                        @endphp

                                        @foreach ($movimientos as $movimiento)

                                        @php
                                        $total += $movimiento->cost_fenovo*$movimiento->unit_package*$movimiento->bultos;
                                        @endphp
                                        <tr>
                                            <td class=" text-center"> {{ $loop->iteration }}</td>
                                            <td> {{ $movimiento->product->cod_fenovo }} </td>
                                            <td class=" text-left"> {{ $movimiento->product->name }}</td>
                                            <td> {{ $movimiento->unit_type }} </td>
                                            <td> {{ $movimiento->unit_package }} </td>
                                            <td> {{ $movimiento->cost_fenovo }}</td>
                                            <td> {{ $movimiento->bultos }}</td>
                                            <td> {{ number_format($movimiento->cost_fenovo*$movimiento->unit_package*$movimiento->bultos,2, ',', '.') }} </td>
                                            <td> {{ number_format($movimiento->unit_package * $movimiento->bultos,0,'','') }} </td>
                                        </tr>
                                        @endforeach
                                        <tr class=" bg-black">
                                            <th colspan="9">
                                                &nbsp;
                                            </th>
                                        </tr>
                                        <tr class=" bg-dark text-white">
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Totales</th>
                                            <th> {{ $movimientos->sum('bultos')}} </th>
                                            <th> {{ number_format($total, 2,',', '.')}} </th>
                                            <th></th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endsection

    @section('js')

    @endsection