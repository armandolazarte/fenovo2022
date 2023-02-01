<table>
    <tr>
        <td>BASE</td>
        <td>FECHA</td>
        <td>NRO ORDEN</td>
        <td>FRANQUICIA</td>
        <td>MONTO NETO MERC</td>
        <td>MONTO FLETE</td>
    </tr>
    @foreach ($arrMovimientos as $movimiento)
        <tr>
            <td>{{ $movimiento->base }}</td>
            <td>{{ $movimiento->fecha }}</td>
            <td>{{ $movimiento->nro_orden }}</td>
            <td>{{ $movimiento->franquicia }}</td>
            <td>{{ $movimiento->monto_neto_mercaderia }}</td>
            <td>{{ $movimiento->monto_flete }}</td>
        </tr>
    @endforeach
</table>
