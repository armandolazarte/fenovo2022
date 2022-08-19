@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                <div class="card-header align-items-center  border-bottom-dark px-0">
                    <div class="card-title mb-0">
                        <h4 class="card-label mb-0 font-weight-bold text-body">
                            Salidas cerrradas
                        </h4>
                    </div>
                    <div class="icons d-flex">
                        <a href="{{ route('index.ordenConsolidada') }}" class="mt-1 mr-3">
                            Salidas consolidadas
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

                    <div class="table-datapos">
                        <div class="table-responsive">
                            <table class="display table-hover yajra-datatable">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        <td>#</th>
                                        <td>Fecha</td>
                                        <td>Destino</td>
                                        <td>Tipo</td>
                                        <td>Item</td>
                                        <td>Factura</td>
                                        <td>Remito</td>
                                        <td>Orden</td>
                                        <th>Paper</th>
                                        <th>Flete</th>
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
    @include('admin.movimientos.salidas.partials.modal-open-remito')
@endsection

@section('js')
    <script>
        var table = jQuery('.yajra-datatable').DataTable({
            @include('partials.table.setting'),
            ajax: "{{ route('salidas.getSalidas') }}",
            columns: [
                { data: 'id', 'class': 'text-center', orderable: false, searchable: false },
                { data: 'date' },
                { data: 'destino' },
                { data: 'type' },
                { data: 'items' },
                { data: 'factura' },
                { data: 'remito' },
                { data: 'orden' },
                { data: 'paper' },
                { data: 'flete' },                
            ]
        });

        function createRemito(id) {
            var url = "{{ route('get.total.movement') }}"
            jQuery.ajax({
                url: url,
                type: 'GET',
                data: {
                    movement_id: id
                },
                beforeSend: function() {
                    jQuery('#loader').removeClass('hidden')
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        jQuery("#movement_id_in_modal").val(id)
                        jQuery("#total_in_span").html(data['total'])
                        let neto = data['total'].replace(/\./g, '').replace(/\,/g, '.')
                        jQuery("#neto").val(neto).select()
                        jQuery('#createRemito').addClass('offcanvas-on')
                    } else {
                        toastr.error(data['msj'], 'Verifique')
                    }
                    jQuery('#loader').addClass('hidden')
                },
                error: function(data) {},
                complete: function() {
                    jQuery('#loader').addClass('hidden')
                }
            });
        };

        jQuery('#close_modal_salida').on('click', function() {
            jQuery('#createRemito').removeClass('offcanvas-on')
        });

    </script>
@endsection
