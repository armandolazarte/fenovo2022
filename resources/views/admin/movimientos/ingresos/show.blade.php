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
            <div class="card gutter-b bg-white border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Fecha</label>
                        </div>
                        <div class="col-md-3 text-center">
                            <label>Operación</label>
                        </div>
                        <div class="col-md-2 text-center">
                            <label>Tipo</label>
                        </div>
                        <div class="col-md-3 text-center">
                            <label>Origen</label>
                        </div>
                        <div class="col-md-2 text-center">
                            <label>Comprobante</label>
                        </div>
                    </div>

                    <div class="row font-weight-bolder mb-5">

                        <input type="hidden" id="movement_id" name="movement_id" value="{{ $movement->id }}">

                        <div class="col-md-2">
                            {{ date('d-m-Y', strtotime($movement->date)) }}
                        </div>
                        <div class="col-md-3 text-center">
                            {{ $movement->type }}
                        </div>
                        <div class="col-md-2 text-center">
                            {{ $movement->subtype }}
                        </div>
                        <div class="col-md-3 text-center">
                            {{ $movement->origenData($movement->type) }}
                        </div>
                        <div class="col-md-2 text-center">
                            {{ $movement->voucher_number }}
                        </div>
                    </div>

                    <div class="row mt-3 mb-3">
                        <div class="col-xs-12 col-md-4">
                            {{ Form::select('product_id', $productos, null, ['id' => 'product_id', 'class' => 'js-example-basic-single form-control bg-transparent', 'placeholder' => '(+) Agregar productos ...']) }}
                        </div>
                        <div class="col-xs-12 col-md-7">
                            <div id="dataTemp">
                                @include('admin.movimientos.ingresos.detalleTemp')
                            </div>
                        </div>
                    </div>

                </div>

                <div id="detalleCompra">
                    @include('admin.movimientos.ingresos.detalleIngresoShow')
                </div>

            </div>
        </div>

        @include('admin.movimientos.ingresos.modalMovimiento')
    @endsection

    @section('js')
        <script>
            const guardarItem = (product_id, peso_unitario) => {

                jQuery('#loader').removeClass('hidden');

                const movement_id = jQuery("#movement_id").val();
                const unit_type = jQuery("#unit_type").val();
                const circuito = jQuery("#circuito").val();

                const store_id = 1;
                let invoice = 0;
                let cyo = 0;

                let arrMovimientos = [];
                jQuery('.calculate').each(function() {
                    if (isNaN(parseFloat(jQuery(this).val()))) {
                        valido = false;
                    } else {
                        let presentacion_input = jQuery(this).attr("id").split('_');
                        let presentacion = presentacion_input[1];
                        let unit_package = presentacion;
                        let valor = parseFloat(jQuery(this).val());
                        let entry = (unit_type == 'K') ? (valor * presentacion) * peso_unitario : (valor *
                            presentacion);
                        let egress = 0;
                        let balance = 0;
                        let entidad_tipo = 'S';

                        if (entry > 0) {
                            let Movi = new Object();
                            Movi.movement_id = movement_id;
                            Movi.entidad_id = store_id;
                            Movi.entidad_tipo = entidad_tipo;
                            Movi.product_id = product_id;
                            Movi.unit_package = unit_package;
                            Movi.unit_type = unit_type;
                            Movi.invoice = invoice;
                            Movi.circuito = circuito;
                            Movi.cyo = cyo;
                            Movi.bultos = valor;
                            Movi.entry = entry;
                            Movi.balance = 0;
                            Movi.egress = 0;
                            arrMovimientos.push(Movi);
                        }
                    }
                });

                jQuery.ajax({
                    url: '{{ route('detalle-ingresos.store.cerrada') }}',
                    type: 'POST',
                    data: {
                        datos: arrMovimientos
                    },
                    success: function(data) {
                        if (data['type'] == 'success') {
                            jQuery("#dataTemp").html('');
                        }
                        if (data['type'] !== 'success') {
                            toastr.error(data['msj'], 'Verifique');
                        }
                    }
                })

                jQuery('#loader').addClass('hidden');
            }

            const sumar = () => {
                let total = 0;
                let valido = true;

                jQuery('.calculate').each(function() {
                    if (isNaN(parseFloat(jQuery(this).val()))) {
                        valido = false;
                    }
                });

                if (valido) {
                    jQuery('.calculate').each(function() {
                        let valor = parseFloat(jQuery(this).val());
                        let presentacion_input = jQuery(this).attr("id").split('_');
                        let presentacion = presentacion_input[1];

                        total = total + (valor * presentacion);
                    });
                    if (total > 0) {
                        jQuery('#btn-guardar-producto').removeClass("d-none");
                    }
                    jQuery('.total').val(total.toFixed(2))
                } else {
                    jQuery('#btn-guardar-producto').addClass("d-none");
                    jQuery('.total').val(0)
                }
            }

            jQuery("#product_id").on('change', function() {
                const productId = jQuery("#product_id").val();
                jQuery.ajax({
                    url: '{{ route('detalle-ingresos.check') }}',
                    type: 'POST',
                    data: {
                        productId
                    },
                    success: function(data) {
                        if (data['type'] == 'success') {
                            jQuery("#dataTemp").html(data['html']);
                            jQuery(".calculate").first().select();
                            if (jQuery("#unit_weight").val() == 0) {
                                toastr.error('PRODUCTO SIN "PESO UNITARIO"', 'Verifique');
                            }
                        }
                    },
                });
            })

            const editarMovimiento = (detalleId, bultos, producto_id, cod_fenovo, nombre, unit_package) => {
                jQuery("#detalle_id").val(detalleId);
                jQuery("#bultos_anterior").val(bultos);
                jQuery("#bultos_actual").val(bultos);
                jQuery("#producto_id").val(producto_id);
                jQuery("#unit_package").val(unit_package);
                jQuery("#cod_fenovo").html(cod_fenovo);
                jQuery("#nombre").html(nombre);
                jQuery('.movimientoPopup').addClass('offcanvas-on');
            }

            const actualizarMovimiento = () => {

                if (jQuery('#bultos_actual').val() == 0) {
                    toastr.error('La cantidad <strong>no puede ser 0 </strong>', "Cantidad");
                    jQuery('#bultos_actual').select()
                    return
                }
                if (jQuery('#bultos_anterior').val() == jQuery('#bultos_actual').val()) {
                    toastr.error('Ingrese una cantidad <strong>diferente al anteriormente registrada </strong>',
                        "Cantidad");
                    jQuery('#bultos_actual').select()
                    return
                }

                let data = jQuery("#formDataCompra").serialize();

                var url = "{{ route('ajustar.ingreso.item') }}";
                jQuery.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    beforeSend: function() {
                        jQuery('#loader').removeClass('hidden');
                    },
                    success: function(data) {
                        jQuery("#detalleCompra").html(data['html'])
                        jQuery('.movimientoPopup').removeClass('offcanvas-on');
                        jQuery('#to').val(jQuery('#to').val()).trigger('change');
                    },
                    error: function(data) {},
                    complete: function() {
                        jQuery('#loader').addClass('hidden');
                    }
                });
            }

            const cerrarModal = () => {
                jQuery('.movimientoPopup').removeClass('offcanvas-on');
            }

            const check_compra = (id) => {

                ymz.jq_confirm({
                    title: 'Compra ',
                    text: "Confirma que chequeó la  compra ?",
                    no_btn: "Cancelar",
                    yes_btn: "Confirma",
                    no_fn: function() {
                        return false;
                    },
                    yes_fn: function() {
                        let ruta = '{{ route('ingresos.checkedCerrada', ['id' => $movement->id]) }}';
                        window.location = ruta;
                    }
                });
            };

            function deleteItemSession() {

                let route = '{{ route('delete.item.compra.produc') }}';
                var arrId = [];
                jQuery('.deleteItem:checked').each(function() {
                    arrId.push(jQuery(this).val());
                })

                if (arrId.length > 0) {

                    ymz.jq_confirm({
                        title: 'Eliminar',
                        text: "confirma borrar registro/s ?",
                        no_btn: "Cancelar",
                        yes_btn: "Confirma",
                        no_fn: function() {
                            return false;
                        },
                        yes_fn: function() {
                            jQuery.ajax({
                                url: route,
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    arrId
                                },
                                success: function(data) {
                                    if (data['type'] == 'success') {
                                        jQuery("#detalleCompra").html(data['html'])
                                    }
                                }
                            });
                        }
                    });

                }
            }
        </script>
    @endsection
