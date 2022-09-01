<select id="product_id" name="product_id" class="js-example-basic-single js-states form-control bg-transparent" onchange="cargarDetalle()">
<option value="" disabled selected>Seleccione ...</option>
@foreach ($productos as $producto)
    <option value="{{ $producto->id }}">
        {{ $producto->cod_fenovo }} {{ $producto->name }}
    </option>
@endforeach
</select>
