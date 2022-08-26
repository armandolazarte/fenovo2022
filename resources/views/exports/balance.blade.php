<table>
    <thead>
        <tr>
            <td>Codigo</td>
            <td>Producto</td>
            <td>Inicial</td>
            <td>Entradas</td>
            <td>Salidas</td>
            <td>Resultado</td>
            <td>Actual</td>
            <td>Dif</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto)
            <tr>
                <td>{{ $producto['cod_fenovo'] }}</td>
                <td class=" text-left">{{ $producto['name'] }}</td>
                <td>{{ $producto['inicialValorizada'] }}</td>
                <td>{{ $producto['entradasValorizada'] }}</td>
                <td>{{ $producto['salidasValorizada'] }}</td>
                <th class=" text-danger">{{ $producto['resultadoValorizada'] }}</th>
                <th class=" text-success">{{ $producto['actualValorizada'] }}</th>
                <td>
                    @if ($producto['resultadoValorizada'] > 0 && $producto['actualValorizada'] > 0)
                        {{ number_format(($producto['resultadoValorizada'] / $producto['actualValorizada'] - 1) * 100, 2) }}
                    @else
                        0
                    @endif
                    
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
