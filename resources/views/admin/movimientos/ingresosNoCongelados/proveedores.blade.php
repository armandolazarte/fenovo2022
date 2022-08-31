<label class="text-body">
    Proveedor 
    <a href="javascript:void(0)" onclick="agregarProveedor()">
        ( crear <i class="fa fa-plus text-danger "></i> )
    </a>
</label>
{{ Form::select('from', $proveedores, null, ['id' => 'from', 'class' => 'js-example-basic-single form-control bg-transparent proveedor', 'placeholder' => 'seleccione ...', 'required' => 'true']) }}