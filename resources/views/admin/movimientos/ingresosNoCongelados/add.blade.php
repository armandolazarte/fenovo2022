@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-solid">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white mb-0 px-2 py-2">
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
                            {{ Form::open(['route' => 'ingresos.storeNocongelados']) }}

                            <div class="form-group d-none">
                                <input type="hidden" name="type" id="type" value="COMPRA" />
                                <input type="hidden" name="to" id="to" value="1" />
                                <input type="hidden" name="voucher_number" id="voucher_number" value="0" />
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="text-body">Proveedor</label>
                                    <fieldset class="form-group mb-3">
                                        {{ Form::select('from', $proveedores, null, ['id' => 'from', 'class' => 'js-example-basic-single form-control bg-transparent proveedor', 'placeholder' => 'seleccione ...', 'required' => 'true']) }}
                                    </fieldset>
                                </div>
                                <div class="col-1">
                                    <label class="text-body">Tipo compra</label>
                                    <select class="form-control" name="subtype" id="subtype">
                                        <option value="FA" selected>FACTURA - A</option>
                                        <option value="FB">FACTURA - B</option>
                                        <option value="FC">FACTURA - C</option>
                                        <option value="FM">FACTURA - M</option>
                                        <option value="CYO">CYO</option>
                                        <option value="REMITO">R</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label class="text-dark">Punto Vta</label>
                                    <input type="number" id="puntoVenta" name="puntoVenta" value=""
                                        onkeyup="numerico(5, this)" class="form-control text-center" required="true">
                                </div>
                                <div class="col-2">
                                    <label class="text-dark">Comprobante</label>
                                    <input type="number" id="comprobanteNro" name="comprobanteNro" value=""
                                        onkeyup="numerico(8, this)" class="form-control text-center" required="true"
                                        onblur="checkComprobante()">
                                </div>
                                <div class="col-md-1 text-center">
                                    <label class="text-dark">Guardar</label>
                                    <fieldset class="form-group">
                                        <button type="submit" class="btn btn-dark">
                                            <i class="fa fa-save text-black-50"></i>
                                        </button>
                                    </fieldset>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label class="text-body">Fecha</label>
                                    <input type="date" name="date" id="date"
                                        value="{{ date('Y-m-d', strtotime(now())) }}" class="form-control datepicker mb-3">
                                </div>
                                <div class="col-md-4">
                                    <label class="text-body">Depósito final</label>
                                    <select class="form-control bg-transparent" name="deposito" id="deposito">
                                        @foreach ($depositos as $deposito)
                                            <option value="{{ $deposito->id }}">{{ $deposito->razon_social }} -
                                                {{ $deposito->description }}</option>
                                        @endforeach
                                    </select>
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
            jQuery(document).ready(function() {

            });

            const numerico = (longitud, objeto) => {
                if (objeto.value.length > longitud) {
                    objeto.value = objeto.value.substring(0, objeto.value.length - 1);
                    return
                };
            }

            const checkComprobante = () => {

                let puntoVenta = jQuery("#puntoVenta").val().padStart(5, "0");
                jQuery("#puntoVenta").val(puntoVenta);
                let comprobanteNro = jQuery("#comprobanteNro").val().padStart(8, "0");
                jQuery("#comprobanteNro").val(comprobanteNro);
                jQuery("#voucher_number").val(jQuery("#puntoVenta").val() + jQuery("#comprobanteNro").val());
                
                let voucher = jQuery("#voucher_number").val();
                let proveedorId = jQuery("#from").val();
                let subtype = jQuery("#subtype").val();

                jQuery.ajax({
                    url: '{{ route('ingresos.checkVoucher') }}',
                    type: 'POST',
                    data: {
                        voucher,
                        proveedorId,
                        subtype
                    },
                    success: function(data) {
                        if (data['type'] == 'success') {
                            jQuery("#puntoVenta").select()
                            toastr.error(data['msj'], 'Verifique');
                        }
                    }
                });
            }

        </script>
    @endsection
