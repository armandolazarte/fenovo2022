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
                <div class="card-body" style="min-height: 350px">

                    <div class="row">
                        <input type="hidden" name="movement_id" id="movement_id" value={{ $movement->id }} />
                        <input type="hidden" id="voucher_number" name="voucher_number"
                            value="{{ $movement->voucher_number }}">
                        <input type="hidden" id="from" name="from" value="{{ $movement->from }}">

                        <div class="col-6">
                            <label class="text-body">Proveedor</label>
                            <input type="text" id="destino" name="destino" value="{{ $proveedor->name }}"
                                class="form-control " disabled>
                        </div>

                        <div class="col-2">
                            <label class="text-dark">Comprobante</label>
                            <input type="number" id="comprobanteNro" name="comprobanteNro"
                                value="{{ substr($movement->voucher_number, -8) }}" class="form-control text-center"
                                disabled>
                        </div>

                        <div class="col-1">
                            <label class="text-dark">Punto Vta</label>
                            <input type="number" id="puntoVenta" name="puntoVenta"
                                value="{{ substr($movement->voucher_number, 0, -8) }}" class="form-control text-center"
                                disabled>
                        </div>

                        <div class="col-2">
                            <label class="text-body">Tipo compra</label>
                            <select class="form-control" name="subtype" id="subtype" disabled>
                                <option value="FA" @if ($movement->subtype == 'FA') selected @endif>FACTURA - A
                                </option>
                                <option value="FB" @if ($movement->subtype == 'FB') selected @endif>FACTURA - B
                                </option>
                                <option value="FC" @if ($movement->subtype == 'FC') selected @endif>FACTURA - C
                                </option>
                                <option value="FM" @if ($movement->subtype == 'FM') selected @endif>FACTURA - M
                                </option>
                                <option value="CYO" @if ($movement->subtype == 'CYO') selected @endif>CYO</option>
                                <option value="REMITO" @if ($movement->subtype == 'REMITO') selected @endif>R</option>
                            </select>
                        </div>

                        <div class="col-1 text-center">
                            <label class="text-dark font-size-bold">Cerrar</label>
                            <fieldset class="form-group">
                                <button onclick="close_compra('{{ $movement->id }}')"
                                    class="btn btn-dark btn-cerrar-ingreso">
                                    <i class="fa fa-lock text-black-50"></i>
                                </button>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-2">
                            <label class="text-body">Fecha</label>
                            <input type="text" name="date" value="{{ date('d-m-Y', strtotime($movement->date)) }}"
                                class="form-control datepicker mb-3" disabled>
                        </div>
                        <div class="col-4">
                            <label class="text-body">Depósito final</label>
                            <select class="form-control" name="deposito" id="deposito" disabled>
                                @foreach ($depositos as $deposito)
                                    <option value="{{ $deposito->id }}" @if ($movement->deposito == $deposito->id) selected @endif>
                                        {{ $deposito->razon_social }} - {{ $deposito->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="col-12">
                                    <label class="text-body">
                                        Producto
                                        <a href="javascript:void(0)" onclick="agregarProducto()">
                                            ( crear <i class="fa fa-plus text-danger "></i> )
                                        </a>
                                    </label>
                                    <select id="product_id" name="product_id"
                                        class="js-example-basic-single form-control bg-transparent"
                                        placeholder='Seleccione productos ...'>
                                        <div id="divProductos">
                                            @include('admin.movimientos.ingresosNoCongelados.productos')
                                        </div>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-8">
                            <div id="dataTemp">
                                @include('admin.movimientos.ingresosNoCongelados.detalleTemp')
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card gutter-b bg-white border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div id="dataConfirm">
                                @include('admin.movimientos.ingresosNoCongelados.detalleConfirm')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('admin.movimientos.ingresosNoCongelados.modalAddProducto')

    <div id="editProducto" class="editProducto offcanvas offcanvas-right kt-color-panel p-5">
        @include('admin.movimientos.ingresosNoCongelados.modalEditProducto')
    </div>
@endsection

@section('js')
    <script>

        jQuery("#product_id").on('change', function() {
            const productId = jQuery("#product_id").val();
            jQuery.ajax({
                url: '{{ route('detalle-ingresos.check.noCongelado') }}',
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

        const storeProducto = (route) => {

            jQuery('#loader').removeClass('hidden');
            // Detalles del nuevo producto
            let name = jQuery("#nameAdd").val();
            let proveedor_id = jQuery("#proveedor_idAdd").val();
            let unit_type = jQuery("#unit_typeAdd").val();
            let unit_weight = jQuery("#unit_weightAdd").val();
            let cod_fenovo = jQuery("#cod_fenovoAdd").val();
            let tasiva = jQuery("#tasivaAdd").val();
            let categorie_id = jQuery("#categorie_idAdd").val();

            // Precios del nuevo producto
            let plistproveedor = jQuery("#plistproveedorAdd").val();
            let descproveedor = jQuery("#descproveedorAdd").val();
            let costfenovo = jQuery("#costfenovoAdd").val();
            let mupfenovo = jQuery("#mupfenovoAdd").val();
            let plist0neto = jQuery("#plist0netoAdd").val();
            
            jQuery.ajax({
                url: route,
                type: 'POST',
                data: {name, cod_fenovo, proveedor_id, unit_type, unit_weight, tasiva, categorie_id, 
                    plistproveedor, descproveedor, costfenovo, mupfenovo, plist0neto },                
                success: function(data) {

                    jQuery('#loader').addClass('hidden');

                    if (data['type'] == 'success') {
                        let producto = data['producto'];
                        document.getElementById("formDataAdd").reset();
                        jQuery('.addProducto').removeClass('offcanvas-on');
                        refresh_div(producto.id);
                    } else {
                        toastr.error(data['msj'], 'Verifique');
                    }
                },
            });
        };

        const refresh_div = (id) => {
            // Limpio zona donde muestro el producto
            jQuery("#dataTemp").html('');
            
            // Recargar los productos
            let from = jQuery('#from').val()
            jQuery.ajax({
                url: '{{ route('products.getProductosHtml') }}',
                type: 'GET',
                data: { from },
                success: function(data) {
                    if (data['type'] == 'success') {

                        jQuery("#product_id").val(id).trigger('change');
                        jQuery("#divProductos").html(data['html']);
                        jQuery("#cod_fenovoAdd").val(data['proximo'])
                    }
                }
            })
        }

        const agregarProducto = () => {
            jQuery("#name").focus()
            jQuery('.addProducto').addClass('offcanvas-on');
        }

        function calcularPreciosAdd() {

            var plistproveedor = jQuery("#plistproveedorAdd").val();

            if (plistproveedor == 0) {
                jQuery("#plistproveedorAdd").addClass('bg-danger')
                return
            } 
            
            jQuery("#plistproveedorAdd").removeClass('bg-danger')

            var descproveedor = jQuery("#descproveedorAdd").val();
            var mupfenovo = jQuery("#mupfenovoAdd").val();
            var costfenovo = jQuery("#costfenovoAdd").val();
            var contribution_fund = jQuery("#contribution_fundAdd").val();
            var product_id = jQuery("#product_idAdd").val();

            jQuery.ajax({
                url: "{{ route('calculate.product.prices') }}",
                type: 'GET',
                data: {
                    plistproveedor,
                    descproveedor,
                    mupfenovo,
                    costfenovo,
                    contribution_fund,
                    product_id
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        jQuery("#costfenovoAdd").val(data['costfenovo']);
                        jQuery("#plist0netoAdd").val(data['plist0neto']);
                    } else {
                        toastr.error(data['msj'], 'ERROR!');
                    }
                },
                error: function(data) {
                    var lista_errores = "";
                    var data = data.responseJSON;
                    jQuery.each(data.errors, function(index, value) {
                        lista_errores += value + '<br />';
                        jQuery('#' + index).addClass('is-invalid');
                    });
                    toastr.error(lista_errores, 'ERROR!');
                },
            });
        }

        const editarProducto = (id) => {
            var elements = document.querySelectorAll('.is-invalid');
            jQuery.ajax({
                url: '{{ route('ingresos.editProduct.noCongelado') }}',
                type: 'GET',
                data: {
                    id
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        jQuery("#editProducto").html(data['html']);
                        jQuery('.editProducto').addClass('offcanvas-on');
                        jQuery("#plistproveedor").select();
                    } else {
                        toastr.error(data['html'], 'Verifique');
                    }
                }
            });
        }

        const calcularPreciosEdit = () => {
            let plistproveedor = jQuery("#plistproveedorEdit").val();

            if (plistproveedor == 0) {
                jQuery("#plistproveedorEdit").addClass('bg-danger')
            } else {
                jQuery("#plistproveedorEdit").removeClass('bg-danger')
            }

            if (plistproveedor > 0) {
                calculatePricesEdit()
            }
        };

        function calculatePricesEdit() {

            var plistproveedor = jQuery("#plistproveedorEdit").val();
            var descproveedor = jQuery("#descproveedorEdit").val();
            var mupfenovo = jQuery("#mupfenovoEdit").val();
            var costfenovo = jQuery("#costfenovoEdit").val();
            var contribution_fund = jQuery("#contribution_fundEdit").val();
            var product_id = jQuery("#product_idEdit").val();

            jQuery.ajax({
                url: "{{ route('calculate.product.prices') }}",
                type: 'GET',
                data: {
                    plistproveedor,
                    descproveedor,
                    mupfenovo,
                    costfenovo,
                    contribution_fund,
                    product_id
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        jQuery("#costfenovoEdit").val(data['costfenovo']);
                        jQuery("#plist0netoEdit").val(data['plist0neto']);
                    } else {
                        toastr.error(data['msj'], 'ERROR!');
                    }
                },
                error: function(data) {
                    var lista_errores = "";
                    var data = data.responseJSON;
                    jQuery.each(data.errors, function(index, value) {
                        lista_errores += value + '<br />';
                        jQuery('#' + index).addClass('is-invalid');
                    });
                    toastr.error(lista_errores, 'ERROR!');
                },
            });
        }

        const actualizarProductoNoCongelado = () => {

            let product_id = jQuery("#product_idEdit").val();
            let plistproveedor = jQuery("#plistproveedorEdit").val();
            let descproveedor = jQuery("#descproveedorEdit").val();
            let costfenovo = jQuery("#costfenovoEdit").val();
            let mupfenovo = jQuery("#mupfenovoEdit").val();
            let plist0neto = jQuery("#plist0netoEdit").val();

            jQuery.ajax({
                url: '{{ route('ingresos.updateProduct.noCongelado') }}',
                type: 'POST',
                data: {product_id, plistproveedor, descproveedor, costfenovo, mupfenovo, plist0neto },
                success: function(data) {
                    if (data['type'] == 'success') {
                        toastr.info('Actualizado', 'Registro');
                        jQuery('.editProducto').removeClass('offcanvas-on');
                        jQuery("#dataTemp").html('');
                        jQuery("#product_id").val(product_id).trigger('change');
                    } else {
                        toastr.error(data['html'], 'Verifique');
                    }
                },
            });
        };

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
                    jQuery('#btn-guardar-producto').prop('disabled', false);
                }
                jQuery('.total').val(total.toFixed(2))
            } else {
                jQuery('#btn-guardar-producto').prop('disabled', true);
                jQuery('.total').val(0)
            }
        }

        const guardarItem = (product_id, peso_unitario) => {

            jQuery('#loader').removeClass('hidden');

            const movement_id = jQuery("#movement_id").val();
            const unit_type = jQuery("#unit_type").val();
            const store_id = 1;

            let invoice = 0;
            let cyo = 0;
            let circuito = 'R';

            // Definir subtype
            if (jQuery("#subtype").val() == 'FA' || jQuery("#subtype").val() == 'FB' || jQuery("#subtype").val() ==
                'FC' || jQuery("#subtype").val() == 'FM') {
                invoice = 1;
                circuito = 'F';
            } else {
                if (jQuery("#subtype").val() == 'CYO') {
                    cyo = 1;
                    circuito = 'F';
                }
            }

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
                url: '{{ route('detalle-ingresos.store.noCongelado') }}',
                type: 'POST',
                data: {
                    datos: arrMovimientos
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        jQuery("#dataTemp").html('');
                        jQuery("#dataConfirm").html(data['html']);
                    }
                    if (data['type'] !== 'success') {
                        toastr.error(data['msj'], 'Verifique');
                    }
                }
            })

            jQuery('#loader').addClass('hidden');
        }

        const borrarDetalle = (movement_id, product_id) => {
            const route = '{{ route('detalle-ingresos.destroy.noCongelado') }}';

            ymz.jq_confirm({
                title: 'Atención',
                text: "Ud eliminará el producto y todas sus presentaciones ?",
                no_btn: "Cancelar",
                yes_btn: "Confirma",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {
                    jQuery.ajax({
                        url: route,
                        type: 'POST',
                        data: {
                            movement_id,
                            product_id
                        },
                        success: function(data) {
                            if (data['type'] == 'success') {
                                jQuery("#dataConfirm").html(data['html']);
                                toastr.options = {
                                    "progressBar": true,
                                    "showDuration": "300",
                                    "timeOut": "1000"
                                };
                                toastr.info("Eliminado ... ");
                            }
                        }
                    })
                }
            })
        }

        const close_compra = (id) => {

            ymz.jq_confirm({
                title: 'Compra ',
                text: "Confirma el cierre de la compra ?",
                no_btn: "Cancelar",
                yes_btn: "Confirma",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {

                    // Activo el spinner
                    jQuery('#loader').removeClass('hidden');

                    const movement_id = jQuery("#movement_id").val();
                    const product_id = jQuery("#product_id").val();

                    // Guardo los datos a enviar
                    let Detalle = new Object();
                    Detalle.id = movement_id;
                    Detalle.product_id = product_id;
                    Detalle.l25413 = jQuery("#l25413").val();
                    Detalle.retater = jQuery("#retater").val();
                    Detalle.retiva = jQuery("#retiva").val();
                    Detalle.retgan = jQuery("#retgan").val();
                    Detalle.nograv = jQuery("#nograv").val();
                    Detalle.percater = jQuery("#percater").val();
                    Detalle.perciva = jQuery("#perciva").val();
                    Detalle.exento = jQuery("#exento").val();
                    Detalle.totalIva10 = jQuery("#totalIva10").val();
                    Detalle.totalIva21 = jQuery("#totalIva21").val();
                    Detalle.totalIva27 = jQuery("#totalIva27").val();
                    Detalle.totalNeto10 = jQuery("#totalNeto10").val();
                    Detalle.totalNeto21 = jQuery("#totalNeto21").val();
                    Detalle.totalNeto27 = jQuery("#totalNeto27").val();
                    Detalle.totalCompra = jQuery("#totalCompra").val();

                    jQuery.ajax({
                        url: '{{ route('ingresos.closeNocongelados') }}',
                        type: 'POST',
                        data: {
                            Detalle
                        },
                        success: function(data) {
                            if (data['type'] == 'success') {
                                window.location = "{{ route('ingresos.indexCerradas') }}";
                            } else {
                                toastr.error(data['msj'], 'Verifique');
                            }
                        }
                    })

                    // Descativo el spinner
                    jQuery('#loader').addClass('hidden');
                }
            });
        };

        function cerrar_modal() {
            jQuery('.addProducto').removeClass('offcanvas-on');
            jQuery('.editProducto').removeClass('offcanvas-on');
        }
    </script>
@endsection
