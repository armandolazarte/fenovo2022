<table>
    <tr>
        <td>Fecha</td>
        <td>Fecha Carga</td>
        <td>Nro Remito</td>
        <td>Cod Producto</td>
        <td>Nombre</td>
        <td>Bultos</td>
        <td>Kilos</td>
        <td>Tasiva</td>
        <td>Costo FTK</td>
        <td>Neto</td>
        <td>IVA</td>

    </tr>
    @foreach ($movimientos as $movimiento)
        <tr>
            <td>{{ $movimiento->fecha }}</td>
            <td>{{ \Carbon\Carbon::parse($movimiento->fechacarga)->format('d/m/Y') }}</td>
            <td>{{ $movimiento->nro_remito }}</td>
            <td>{{ $movimiento->cod_producto }}</td>
            <td>{{ $movimiento->nombre }}</td>
            <td>{{ $movimiento->bultos }}</td>
            <td>{{ $movimiento->cantidad }}</td>
            <td>{{ $movimiento->tasiva }}</td>
            <td>{{ $movimiento->costo_ftk }}</td>
            <td>{{ $movimiento->neto }}</td>
            <td>{{ $movimiento->importeIva }}</td>
        </tr>
    @endforeach
</table>

<table>
    <tr>
        <td colspan=11>***********************************************************</td>
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
            <td>{{ $grupo->importeIva }}</td>
        </tr>
    @endforeach
</table>
