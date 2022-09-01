<option value="" disabled>Seleccione ...</option>
@foreach ($productos as $producto)
    <option value="{{ $producto->id }}">
        {{ $producto->cod_fenovo }} {{ $producto->name }}
    </option>
@endforeach
