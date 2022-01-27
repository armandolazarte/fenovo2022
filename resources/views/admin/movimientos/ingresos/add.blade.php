@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Ingreso de mercadería</li>
            </ol>
        </nav>
    </div>
</div>
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card card-custom gutter-b bg-white border-0">
                    <div class="card-body">
                        {{ Form::open(['route' => 'ingresos.store']) }}
                        <div class="form-group d-none">
                            <input type="hidden" name="type" id="type" value="COMPRA" />
                            <input type="hidden" name="to" id="to" value="1" />
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="text-body">Fecha</label>
                                <input type="date" name="date" value="{{ date('Y-m-d', strtotime(now())) }}" class="form-control datepicker mb-3" autofocus>
                            </div>
                            <div class="col-md-4">
                                <label class="text-body">Proveedor</label>
                                <fieldset class="form-group mb-3">
                                    {{ Form::select('from', $proveedores, null, ['class' => 'js-example-basic-single form-control bg-transparent proveedor', 'placeholder'=>'seleccione ...', 'required' => 'true']) }}
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <label class="text-dark">Nro Comprobante</label>
                                <input type="text" id="voucher_number" name="voucher_number" value="" class="form-control" required="true">
                            </div>
                            <div class="col-md-2 text-center">
                                <label class="text-dark">&nbsp;</label>
                                <fieldset class="form-group mb-3">
                                    <button type="submit" class="btn btn-primary btn-guardar-ingreso text-white"><i class="fa fa-save"></i> </button>
                                </fieldset>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>

                </div>
            </div>
            <div class="col-lg-12 col-xl-12">
                <div class="card card-custom gutter-b bg-white border-0">
                    <div class="card-body">
                        <div id="data" class="row d-none">
                            <div class="col-12"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endsection

    @section('js')
    <script>
        jQuery(".proveedor").on('change',function(){
            const id = this.value;
            jQuery.ajax({
                url: '{{ route('products.getProductByProveedor') }}',
                type: 'GET',
                data: { id },
                success: function (data) {                    
                    if (data['type'] == 'success') {
                        jQuery("#data").html(data['html']);
                        jQuery("#product_id").select2({});
                    }
                }
            });
        })

    </script>
    @endsection