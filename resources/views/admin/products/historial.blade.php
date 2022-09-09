@extends('layouts.app')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                        <div class="card-header align-items-center  border-bottom-dark px-0">
                            <div class="card-title mb-0">
                                <h4 class="card-label mb-0 font-weight-bold text-body">
                                    Historial del producto
                                    <a href="{{route('update.stock',['code' => $producto->cod_fenovo])}}"> {{$producto->cod_fenovo }}</a> - {{ $producto->name }} - Unidad
                                    <span class=" text-danger">{{ $producto->unit_type }} </span>
                                </h4>
                                @if (\Auth::user()->rol() == 'contable')
                                    <br>
                                    @foreach ($producto->productos_store as $ps)
                                        <strong>{{ $ps->deposito->razon_social }}:</strong>
                                        {{ $ps->stock_f + $ps->stock_r + $ps->stock_cyo }} &nbsp;&nbsp;&nbsp;
                                    @endforeach
                                @endif
                            </div>
                            <div class="icons d-flex">
                                <a href="{{ route('product.printHistorial', ['id' => $producto->id]) }}" class="mt-1 mr-3">
                                    <i class=" fa fa-file-excel"></i> Exportar
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-custom gutter-b bg-white border-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="yajra-datatable" class=" table-hover table-condensed">
                                    <thead class="text-body">
                                        <tr class="bg-dark text-white">
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Orden</th>
                                            <th>Tipo</th>
                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th>Observacion</th>
                                            <th>Pres.</th>
                                            <th>Bultos</th>
                                            <th>Circ.</th>
                                            <th>In</th>
                                            <th>Out</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody class="kt-table-tbody text-dark">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        var table = jQuery('#yajra-datatable').DataTable({
            lengthMenu: [
                [10, 25, 50, 500],
                [10, 25, 50, 500]
            ],
            stateSave: true,
            processing: true,
            serverSide: true,
            ordering: false,
            autoWidth: true,
            dom: '<lfrtip>',
            autoWidth: false,
            ajax: '{{ route('product.getHistorial', ['id' => $producto->id]) }}',
            columns: [{
                    data: 'id',
                    'class': 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'fecha',
                    'class': 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'orden',
                    'class': 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'type',
                    'class': 'text-left',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'from',
                    'class': 'text-left',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'to',
                    'class': 'text-left',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'observacion',
                    'class': 'text-left',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'unit_package',
                    'class': 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'bultos',
                    'class': 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'circuito',
                    'class': 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'entry',
                    'class': 'text-center text-success',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'egress',
                    'class': 'text-center text-danger',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'balance',
                    'class': 'text-center',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    </script>
@endsection
