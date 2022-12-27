<table>
    <tr>
        <td>Fecha</td>
        <td>Comprobante</td>
        <td>Tipo de comprobante</td>
        <td>VtaDirecta</td>
        <td>Producto</td>
        <td>Bultos</td>
        <td>Kilos</td>
        <td>PrecioUnit</td>
        <td>AlicuotaIva</td>
        <td>Neto</td>
        <td>IvaCalculado</td>
        <td>Destino</td>
        <td>Provincia</td>

    </tr>
    @foreach ($arrMovimientos as $movimiento)
        <tr>
            <td>{{ $movimiento->fecha }}</td>
            <td>{{ $movimiento->comprobante }}</td>
            <td>{{ $movimiento->tipoFactura }}</td>
            <td>{{ $movimiento->ventaDirecta }}</td>
            <td>{{ $movimiento->producto }}</td>
            <td>{{ $movimiento->bultos }}</td>
            <td>{{ $movimiento->kilos }}</td>
            <td>{{ $movimiento->precioUnitario }}</td>
            <td>{{ $movimiento->tasiva }}</td>
            <td>{{ $movimiento->neto }}</td>
            <td>{{ round($movimiento->importeIva, 2) }}</td>
            <td>{{ $movimiento->destino }}</td>
            <td>{{ $movimiento->provincia }}</td>
        </tr>
    @endforeach
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
        <td>*********************</td>
    </tr>
</table>

<table>
    <tr>
        <td>Cod Producto</td>
        <td>Nombre</td>
        <td>Kilos</td>
        <td>Neto</td>
        <td>IVA</td>
    </tr>
    @foreach ($grupos as $grupo)
        <tr>
            <td>{{ $grupo->cod_producto }}</td>
            <td>{{ $grupo->nombre }}</td>
            <td>{{ $grupo->kgs }}</td>
            <td>{{ $grupo->neto }}</td>
            <td>{{ round($grupo->importeIva,2) }}</td>
        </tr>
    @endforeach
</table>
