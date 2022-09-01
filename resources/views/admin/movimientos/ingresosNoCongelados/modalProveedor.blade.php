<div id="editpopup" class="editpopup offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formData">
        @csrf
        <div class="row mb-3">
            <div class="col-12 text-center">
                <h5>
                    Agregar proveedor
                </h5>                
            </div>
        </div>
            
        <div class="row mb-5">
            <div class="col-12">
                <label class="text-dark">Razon social </label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-4">
                <label class="text-dark">Tipo Iva</label>
                <select class="rounded form-control bg-transparent" name="iva_type">
                    @foreach ($ivaType as $iva)
                    <option value="{{$iva['type']}}">
                        {{$iva['type'] }}
                    </option>
                    @endforeach
                </select>                
            </div>
            <div class="col-8">
                <label class="text-dark">Cuit</label>
                <input type="text" id="cuit" name="cuit" class="form-control">
            </div>        
        </div>

        <div class="row mt-5 text-center">
            <div class="col-6">
                <button type="reset" class="btn btn-outline-primary close_modal"><i class="fa fa-times"></i> Cerrar</button>
            </div>            
            <div class="col-6">
                <button type="button" class="btn btn-primary btn-guardar" onclick="storeProveedor('{{ route('proveedors.store') }}')">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>            
        </div>
    </form>
</div>