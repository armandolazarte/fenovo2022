@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                <div class="row mt-5 mb-3">
                    <div class="col-6">
                        <h4>
                            Balance de depósitos
                        </h4>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <select class="form-control" name="storeId" id="storeId">
                            <option value="">... </option>
                            @foreach ($stores as $store)
                                <option value="{{ $store->id }}">
                                    {{ str_pad($store->cod_fenovo, 3, '0', STR_PAD_LEFT) }} - {{ $store->description }}
                                </option>
                            @endforeach
                        </select>                        
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <fieldset class="input-group form-group mb-3">
                            <input type="week" id="semana" name="semana" class="form-control input-lg">
                            <div class="input-group-prepend bg-transparent">
                                <span class="input-group-text">
                                    <a href="javscript:void(0)" id="btnBalance" class=" badge badge-primary rounded p-1" >
                                        CONSULTAR
                                    </a>
                                </span>
                            </div>
                        </fieldset>                        
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="detalle">

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>

        jQuery(document).ready(function() {

            jQuery('#storeId').select2({
                placeholder: 'Seleccione una frioteka / deposito ...',
            })
        });

        jQuery('#btnBalance').on('click', function() {
            let fecha = jQuery("#semana").val().split('-');

            if(jQuery("#storeId").val() == '' || jQuery("#storeId").val() == 'undefined') return;                
            if(jQuery("#semana").val() == '' || jQuery("#semana").val() == 'undefined') return;                

            let store_id= jQuery("#storeId").val();
            let anio    = fecha[0];
            let semana  = fecha[1].slice(1);
            
            let route = '{{ route('depositos.balance.detalle') }}';

            jQuery.ajax({
                url: route,
                type: 'GET',
                data: {store_id, anio, semana},
                beforeSend: function() {
                    jQuery('#loader').removeClass('hidden');
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        jQuery(".detalle").html(data['html']);
                    }
                },
                complete: function() {
                    jQuery('#loader').addClass('hidden');
                }
            });
        });


    </script>
@endsection
