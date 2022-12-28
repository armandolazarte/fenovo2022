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
                                        Excepciones vigentes
                                    </h4>
                                </div>
                                <div class="icons d-flex">

                                    <a href="{{ route('oferta.excepciones.exportCSV') }}" class="mr-2">
                                        <i class=" fa fa-file-csv"></i> Exportar
                                    </a>                                    
                                    <a href="{{ route('oferta.index') }}" class="mr-2">
                                        Ofertas
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
                                <table class="display table-hover yajra-datatable text-center">
                                    <thead>
                                        <tr class="bg-dark text-white">
                                            <th>CodFenovo</th>
                                            <th>Nombre del producto</th>
                                            <th>P1_Tienda</th>
                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th>Vincular</th>
                                            <th>Tiendas asociadas</th>
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

@include('admin.ofertas.modal')

@endsection

@section('js')

<script>
    jQuery("#product_id").select2({
        placeholder: "Seleccione producto ... "
    });

    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('oferta.excepciones') }}",
        columns: [
            {data: 'cod_fenovo', orderable: false, searchable: false},
            {data: 'producto', 'class':'text-left'},
            {data: 'p1tienda', orderable: false, searchable: false},
            {data: 'fechadesde'},
            {data: 'fechahasta'},
            {data: 'vincular', orderable: false, searchable: false},
            {data: 'tiendas', 'class':'text-left', orderable: false, searchable: false},
            {data: 'edit', orderable: false, searchable: false},
            {data: 'destroy', orderable: false, searchable: false},
        ]
    });
</script>

@endsection