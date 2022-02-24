@extends('layouts.app')

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">
                    Salidas Cerradas
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row mt-5">
                    <div class="col-lg-12 col-xl-6">
                        <h3 class="card-label mb-0 font-weight-bold text-body">
                            Listado
                        </h3>
                    </div>
                    <div class="col-lg-12 col-xl-6  text-right">
                        <a href="{{ route('salidas.menu.print') }}"> <i class=" fa fa-print"></i> Opciones de Impresion</a>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-lg-12 col-xl-12">
                        &nbsp;
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">
                                <table class="display table-hover yajra-datatable">
                                    <thead>
                                        <tr class="bg-dark text-white">
                                            <th>No</th>
                                            <th>Fecha</th>
                                            <th>Destino</th>
                                            <th>Tipo</th>
                                            <th>Comprobante Nro</th>
                                            <th>Registro</th>
                                            <th>Detalle</th>
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
    </div>

</div>

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({

        ajax: "{{ route('salidas.index') }}",
        columns: [
            {data: 'DT_RowIndex', 'class':'text-center', searchable: false},
            {data: 'date'},
            {data: 'destino'},
            {data: 'type'},
            {data: 'voucher_number',  'class':'text-center'},
            {data: 'updated_at'},
            {data: 'acciones','class':'flex'},
        ]
    });
</script>

@endsection