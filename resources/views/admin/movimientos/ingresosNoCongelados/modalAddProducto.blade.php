<div id="addProducto" class="addProducto offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formDataAdd">
        @csrf

        <input type="hidden" id="proveedor_idAdd" name="proveedor_idAdd" value="{{ $proveedor->id }}">
        <input type="hidden" id="unit_typeAdd" name="unit_typeAdd" value="U">
        <input type="hidden" id="unit_weightAdd" name="unit_weightAdd" value="1">
            
        <div class="row mt-3 mb-5">
            <div class="col-12">
                <h4>Nuevo producto </h4>
                <input type="text" id="nameAdd" name="nameAdd" class="form-control" required>
            </div>
        </div>
                      
        <div class="row mb-2">
            <div class="col-6">Precio proveedor</div>
            <div class="col-6">
                <input type="number" step="0.50" min="0" class="form-control border-dark" value="0" 
                name="plistproveedorAdd" id="plistproveedorAdd" onkeyup="calcularPreciosAdd()" onchange="calcularPreciosAdd()">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">% Desc proveedor </div>
            <div class="col-6">
                <input type="text" class="form-control border-dark" value="0" 
                name="descproveedorAdd" id="descproveedorAdd" onkeyup="calcularPreciosAdd()" onchange="calcularPreciosAdd()">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">Costo fenovo</div>
            <div class="col-6">
                <input type="text" class="form-control border-dark" value="0" 
                name="costfenovoAdd" id="costfenovoAdd">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">% MarkUp </div>
            <div class="col-6">
                <input type="text" class="form-control border-dark" value="0" 
                name="mupfenovoAdd" id="mupfenovoAdd" onkeyup="calcularPreciosAdd()" onchange="calcularPreciosAdd()">
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-6">Precio neto</div>
            <div class="col-6">
                <input type="text" class="form-control border-dark" 
                value="" name="plist0netoAdd" id="plist0netoAdd">
            </div>
        </div>
            

        <div class="row mb-2">
            <div class="col-6">
                <label class="text-body">Codigo fenovo</label>            
                <input type="number" name="cod_fenovo" id="cod_fenovoAdd" value="{{ $proximo }}" class="form-control">            
            </div>
        </div>

        <div class="row mt-5 mb-5">
            <div class="col-4">
                <label class="text-dark">Tipo Iva</label>
                <select id="tasivaAdd" name="tasivaAdd" class="rounded form-control bg-transparent" >                    
                    <option value="0">00.00</option>
                    <option value="0.105">10.50</option>
                    <option value="0.21" selected>21.00</option>
                    <option value="0.27">27.00</option>                    
                </select>                
            </div>   
            <div class="col-8">
                <label class="text-body">Categoría</label>            
                <select class="js-example-basic-single js-states form-control bg-transparent" name="categorie_idAdd" id="categorie_idAdd">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>   
        </div>

        <div class="row mt-5 text-center">
            <div class="col-6">
                <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="cerrar_modal()">
                    <i class="fa fa-times"></i> Cancelar
                </a>
            </div>            
            <div class="col-6">
                <button type="button" class="btn btn-primary btn-guardar" onclick="storeProducto('{{ route('product.store') }}')">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>            
        </div>
    </form>
</div>