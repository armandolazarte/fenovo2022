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

    <div class="row mb-2">
        <div class="col-10 text-right">
            Buscar texto        
            <select id="tipo" class="filtro">
                <option value="TODOS" selected>Todas las salidas</option>
                <option value="TIENDAS">Sólo en tiendas</option>
                <option value="CLIENTES">Sólo en clientes</option>
            </select>
        </div>
        <div class="col-2 text-right">
            <input type="search" id="search" name="search" class=" form-control" autofocus>
        </div>
    </div>

    <div class="row">
        <div class="col-12 ">
            <div class="table-responsive">
                <table class="table table-condensed table-hover yajra-datatable text-center">
                    <thead>
                        <tr class="bg-dark text-white">
                            <td>#</td>
                            <td>Fecha</td>
                            <td>Destino</td>
                            <td>Tipo  </td>
                            <td>Item</td>
                            <td>Factura</td>
                            <td>Rto</td>
                            <td>Orden</td>
                            <td>Paper</td>
                            <td>Flete</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.movimientos.salidas.partials.modal-open-remito')
@endsection

@section('js')
    <script>


    jQuery(document).ready(function() {
        cargarDatos(jQuery("#tipo").val());
    })

    jQuery(".filtro").on("change", function() {
        jQuery('.yajra-datatable').DataTable().destroy();
        cargarDatos(jQuery("#tipo").val());
    })

    jQuery("#search").on("keypress keyup", function() {
        jQuery('.yajra-datatable').DataTable().destroy();
        cargarDatos(jQuery("#tipo").val());
    })

    
    const cargarDatos = (tipo)=>{

        var table = jQuery('.yajra-datatable').DataTable({
            lengthMenu : [[10, 25, 50, 500], [10, 25, 50, 500]],
            stateSave:true,
            processing: true,
            serverSide: true,
            ordering:false,
            autoWidth: true,
            dom: '<lrtip>',
            ajax: {
                url: "{{ route('salidas.getSalidas') }}",
                type: "get",
                data: {
                    tipo,
                    "search": jQuery("#search").val(),
                },
            },
            columns: [
                { data: 'id' },
                { data: 'date' },
                { data: 'destino', 'class': 'text-left', },
                { data: 'type', 'class': 'text-left',  },
                { data: 'items' },
                { data: 'factura' },
                { data: 'remito' },
                { data: 'orden' },
                { data: 'paper' },
                { data: 'flete' },                
            ]
        }); 

    }
    


    jQuery('.yajra-datatable').on('draw.dt', function() {
        jQuery('[data-toggle="tooltip" ]').tooltip();
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
