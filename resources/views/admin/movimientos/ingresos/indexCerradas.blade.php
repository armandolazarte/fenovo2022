@extends('layouts.app')

@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                            <div class="card-header align-items-center  border-bottom-dark px-0">
                                <div class="card-title mb-0">
                                    <h4 class="card-label mb-0 font-weight-bold text-body">
                                        Compras cerradas
                                    </h4>
                                </div>
                                <div class="icons d-flex">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">
                                <div class="table-datapos">
                                    <div class="table-responsive">
                                        <table class="display table-hover yajra-datatable text-center">
                                            <thead>
                                                <tr class="bg-dark text-white">
                                                    <th>#</th>
                                                    <th>Fecha</th>
                                                    @if (\Auth::user()->rol() == 'base')
                                                    <th>Origen</th>
                                                    @else
                                                    <th>Proveedor</th>
                                                    @endif
                                                    <th>Tipo</th>
                                                    <th>Items</th>
                                                    <th>Nro compra</th>
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
    </div>
</div>

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('ingresos.getCompras') }}",
        ordering: false,
        columns: [
            {data: 'id'},
            {data: 'date'},
            {data: 'origen', class: 'text-left'},
            {data: 'subtype'},
            {data: 'items'},
            {data: 'voucher'},
            {data: 'show'},
        ],
        });
</script>

@endsection