<div id="addProducto" class="addProducto offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formData">
        @csrf

        <input type="hidden" id="proveedor_id" name="proveedor_id" value="{{ $proveedor->id }}">
            
        <div class="row mb-2">
            <div class="col-12">
                <label class="text-dark">Nombre del nuevo producto </label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
        </div>
                      
        <div class="row mb-2">
            <div class="col-6">Precio proveedor</div>
            <div class="col-6">
                <input type="number" step="0.50" min="0" class="form-control border-dark"
                    value="0" name="plistproveedor" id="plistproveedor" onkeyup="calcularPrecios()" onchange="calcularPrecios()">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">% Desc proveedor </div>
            <div class="col-6">
                <input type="text" class="form-control border-dark" value="0" name="descproveedor" id="descproveedor" onkeyup="calcularPrecios()" onchange="calcularPrecios()">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">Costo fenovo</div>
            <div class="col-6">
                <input type="text" class="form-control border-dark" value="0" name="costfenovo" id="costfenovo">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">% MarkUp </div>
            <div class="col-6">
                <input type="text" class="form-control border-dark" value="0" name="mupfenovo" id="mupfenovo" onkeyup="calcularPrecios()" onchange="calcularPrecios()">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">% F.Contribución </div>
            <div class="col-6">
                <input type="text" class="form-control border-dark" value="" name="contribution_fund" id="contribution_fund" onkeyup="calcularPrecios()" onchange="calcularPrecios()">
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-6">Precio neto</div>
            <div class="col-6">
                <input type="text" class="form-control border-dark" value="" name="plist0neto" id="plist0neto">
            </div>
        </div>
            

        <div class="row mb-2">
            <div class="col-4">
                <label class="text-body">Cod.fenovo</label>            
                <input type="number" name="cod_fenovo" id="cod_fenovo" class="form-control">            
            </div>       

            <div class="col-8">
                <label class="text-body">Cod.barras</label>
                <input type="text" class="form-control border-dark" name="barcode" id="barcode" class="form-control">            
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-6">
                <label class="text-body">Descuento</label>
                <select class="js-example-basic-single js-states form-control bg-transparent" name="cod_descuento"
                    id="cod_descuento">
                    <option value="">Seleccione ... </option>
                    @foreach ($descuentos as $descuento)
                        <option value="{{ $descuento->codigo }}" @if (isset($product) && $product->cod_descuento == $descuento->codigo) selected @endif>
                            {{ $descuento->descripcion }}
                        </option>
                    @endforeach
                </select>            
            </div>
            <div class="col-6">
                <label class="text-body">Categoría</label>            
                <select class="js-example-basic-single js-states form-control bg-transparent" name="categorie_id" id="categorie_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-5 mb-5">
            <div class="col-6">
                <label class="text-dark">Tipo Iva</label>
                <select id="tasiva" name="tasiva" class="rounded form-control bg-transparent" >                    
                    <option value="0">0</option>
                    <option value="10.5">10.5</option>
                    <option value="21" selected>21</option>
                    <option value="27">27</option>                    
                </select>                
            </div>      
        </div>

        <div class="row mt-5 text-center">
            <div class="col-6">
                <button type="reset" class="btn btn-outline-primary close_modal"><i class="fa fa-times"></i> Cerrar</button>
            </div>            
            <div class="col-6">
                <button type="button" class="btn btn-primary btn-guardar" onclick="storeProducto('{{ route('product.store') }}')">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>            
        </div>
    </form>
</div>