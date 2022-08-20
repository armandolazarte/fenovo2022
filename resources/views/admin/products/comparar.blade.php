@extends('layouts.app')

@section('content')


    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                <div class="card-header align-items-center  border-bottom-dark px-0">
                    <div class="card-title mb-0">
                        <h4 class="card-label mb-0 font-weight-bold text-body">
                            Comparar stocks de productos
                        </h4>
                    </div>
                    <div class="icons d-flex">
                        <a href="{{ route('products.printCompararStock') }}" target="_blank">
                            <i class=" fa fa-file-csv "></i> Exportar
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
                    <div class="table-datapos">
                        <div class="table-responsive">
                            <table class=" table table-hover yajra-datatable text-center">
                                <thead class="text-body">
                                    <tr class="bg-light">
                                        <th>Proveedor</th>
                                        <th>Codigo</th>
                                        <th>Producto</th>
                                        <th>Costo</th>
                                        <th>Unidad</th>
                                        <th>Pres</th>
                                        <th>StockIni</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>StockFin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('products.getCompararStocks') }}",
        columns: [
            {data: 'proveedor', 'className': 'text-left'},
            {data: 'cod_fenovo'},
            {data: 'name', 'className': 'text-left'},
            {data: 'costo'},
            {data: 'unit_type'},
            {data: 'unit_package'},
            {data: 'stockInicioSemana'},
            {data: 'ingresoSemana', 'className': 'text-success'},
            {data: 'salidaSemana', 'className': 'text-danger'},
            {data: 'stock', 'className': 'font-weight-bolder'},
        ]
    });
</script>

@endsection