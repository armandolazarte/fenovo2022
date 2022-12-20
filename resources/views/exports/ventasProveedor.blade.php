<table>
    <tr>
        <td>Fecha</td>
        <td>Comprobante</td>
        <td>Producto</td>
        <td>Bultos</td>
        <td>Kilos</td>
        <td>PrecioUnit</td>
        <td>AlicuotaIva</td>
        <td>Neto</td>
        <td>IvaCalculado</td>

    </tr>
    @foreach ($arrMovimientos as $movimiento)
        <tr>
            <td>{{ $movimiento->fecha }}</td>
            <td>{{ $movimiento->comprobante }}</td>
            <td>{{ $movimiento->producto }}</td>
            <td>{{ $movimiento->bultos }}</td>
            <td>{{ $movimiento->kilos }}</td>
            <td>{{ $movimiento->precioUnitario }}</td>
            <td>{{ $movimiento->tasiva }}</td>
            <td>{{ $movimiento->neto }}</td>
            <td>{{ $movimiento->importeIva }}</td>
        </tr>
    @endforeach
</table>
