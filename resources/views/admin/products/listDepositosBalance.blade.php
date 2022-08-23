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
                    <div class="col-3">
                        <fieldset class="form-group">
                            <input type="week" id="semana" name="semana" class=" form-control">
                        </fieldset>
                    </div>
                    <div class="col-2">
                        <button class=" btn btn-sm btn-outline-primary" id="btnBalance" >Ver balance</button>
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

        jQuery('#btnBalance').on('click', function() {
            let fecha = jQuery("#semana").val().split('-');
            if(jQuery("#semana").val() == '' || jQuery("#semana").val() == 'undefined') return;                

            let anio = fecha[0];
            let semana = fecha[1].slice(1);
            
            let route = '{{ route('depositos.balance.detalle') }}';

            jQuery.ajax({
                url: route,
                type: 'GET',
                data: {anio, semana},
                success: function(data) {
                    if (data['type'] == 'success') {
                        jQuery(".detalle").html(data['html']);
                    }
                }
            });


        });


    </script>
@endsection
