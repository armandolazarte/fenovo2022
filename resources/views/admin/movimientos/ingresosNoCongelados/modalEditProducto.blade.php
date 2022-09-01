@isset($product)
    <form id="formDataEdit">
        @csrf

        <div class="form-group">
            <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
                <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
                    Editar producto
                </h4>
            </div>
        </div>

        <div class="form-group">
            <p class=" font-weight-bold">{{ $product->cod_fenovo }} - {{ $product->name }}</p>
        </div>

        <div class="form-group">
            <table>
                <tr class=" bg-dark text-black-50">
                    <td class=" text-center" colspan="2">Actualizar precio</td>
                </tr>
                <tr>
                    <td class="w-50">Precio proveedor</td>
                    <td class="w-50">
                        <input type="number" step="0.50" min="0" class="form-control border-dark"
                            value="{{ $product->product_price->plistproveedor }}" 
                            name="plistproveedorEdit" id="plistproveedorEdit" onkeyup="calcularPreciosEdit()" onchange="calcularPreciosEdit()">
                    </td>
                </tr>
                <tr>
                    <td>% Desc proveedor </td>
                    <td>
                        <input type="text" class="form-control border-dark"
                            value="{{ $product->product_price->descproveedor }}" name="descproveedorEdit"
                            id="descproveedorEdit" onkeyup="calcularPreciosEdit()" onchange="calcularPreciosEdit()">
                    </td>
                </tr>
                <tr>
                    <td>Costo fenovo</td>
                    <td>
                        <input type="text" class="form-control border-dark"
                        value="{{ $product->product_price->costfenovo }}" name="costfenovoEdit" id="costfenovoEdit">
                    </td>
                </tr>
                <tr>
                    <td>% MarkUp </td>
                    <td>
                        <input type="text" class="form-control border-dark"
                            value="{{ $product->product_price->mupfenovo }}" name="mupfenovoEdit" id="mupfenovoEdit"
                            onkeyup="calcularPreciosEdit()" onchange="calcularPreciosEdit()">
                    </td>
                </tr>
                <tr>
                    <td>Precio neto</td>
                    <td>
                        <input type="text" class="form-control border-dark"
                            value="{{ $product->product_price->plist0neto }}" name="plist0netoEdit" id="plist0netoEdit">
                    </td>
                </tr>
            </table>
        </div>

        <input type="hidden" id="product_idEdit" name="product_idEdit" value="{{ $product->id }}" />

        <div class="row">
            <div class="col-6">
                <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="cerrar_modal()">
                    <i class="fa fa-times"></i> Cancelar
                </a>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-primary btn-actualizar" onclick="actualizarProductoNoCongelado()">
                    <i class="fa fa-save"></i> Actualizar
                </button>
            </div>
        </div>
    </form>
@endisset
