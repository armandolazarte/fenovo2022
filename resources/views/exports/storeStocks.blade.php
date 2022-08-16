<table>
    <tr>
        <td colspan="8">{{ $store->cod_fenovo }} - {{ $store->description }} :: {{ $fecha }}</td>
    </tr>
    <tr>
        <td>Codigo</td>
        <td>Producto</td>
        <td>Stock</td>
        <td>Bultos</td>
        <td>Kgrs</td>
        <td>Presentacion</td>
        <td>Unidad</td>
        <td>Peso</td>        
    </tr>
    @if (isset($productos))
        @foreach ($productos as $producto)
        <tr>
            <td>{{ $producto->cod_fenovo }} </td>
            <td>{{ $producto->producto }}   </td>
            <td>{{ $producto->stock }}      </td>
            <td>
                @if((count(explode('|', $producto->unit_package)) == 1) && ($producto->stock > 0))
                    {{ round($producto->stock / $producto->unit_package) }}
                @endif
            </td>
            <td>{{ $producto->kilage }}     </td>
            <td>{{ $producto->unit_package }} </td>
            <td>{{ $producto->unit_type }}  </td>
            <td>{{ $producto->unit_weight }}</td>
        </tr>
        @endforeach
    @endif
    
</table>