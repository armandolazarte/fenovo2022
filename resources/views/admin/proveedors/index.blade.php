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
                                        Proveedores
                                    </h4>
                                </div>
                                <div class="icons d-flex">
                                    <a href="{{ route('proveedors.add') }}" class="ml-2">
                                        <i class="fa fa-2x fa-plus-circle text-primary"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
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
                                            <th>Razon social</th>
                                            <th>Cuit</th>
                                            <th>Pto Venta</th>
                                            <th>Email</th>
                                            <th></th>
                                            <th></th>
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
        @include('partials.table.setting'),
        ajax: "{{ route('proveedors.index') }}",
        columns: [
            {data: 'id', 'class':'text-center', orderable: false, searchable: false},
            {data: 'name'},
            {data: 'cuit'},
            {data: 'punto_venta', 'class':'text-center'},
            {data: 'email'},
            {data: 'edit', name: 'Editar', 'class':'text-center', orderable: false, searchable: false},
            {data: 'destroy', name: 'Borrar', 'class':'text-center', orderable: false, searchable: false},
        ]
    });
</script>

@endsection