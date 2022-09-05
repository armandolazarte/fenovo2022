<table>
    <tr>
        <td>ID</td>
        <td>Fecha y Hora de registro</td>
        <td>Fecha Comprobante</td>
        <td>COD - NOM Depósito</td>
        <td>COD Producto</td>
        <td>COSFTK</td>
        <td>COSVEN</td>
        <td>Bultos</td>
        <td>Pres</td>
        <td>Unidad</td>
        <td>Cant E</td>
        <td>Cant S</td>
        <td>Balance</td>
        <td>Tipo Mov</td>
        <td>Referencia</td>
    </tr>
    @foreach($movimientos_productos as $mp)

    @php
        $from = $mp->movement->From($mp->movement->type,false);
        $to   = $mp->movement->To($mp->movement->type,false);
    @endphp

        <tr>
            <td>{{ $mp->id }}</td>
            <td>{{ \Carbon\Carbon::parse($mp->movement->created_at)->format('d/m/Y H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($mp->movement->date)->format('d/m/Y') }}</td>
            <td>@if($mp->egress > 0) {{$from}} @elseif($mp->entry > 0) {{$to}} @endif</td>
            <td>{{ $mp->product->cod_fenovo  }}</td>
            <td>{{ $mp->cost_fenovo     }}</td>
            <td>{{ $mp->unit_price      }}</td>
            <td>{{ $mp->bultos      }}</td>
            <td>{{ $mp->unit_package      }}</td>
            <td>{{ $mp->unit_type      }}</td>
            <td>@if($mp->entry > 0) {{$mp->entry }} @else 0.0 @endif</td>
            <td>@if($mp->egress > 0) {{$mp->egress }} @else 0.0 @endif</td>
            <td>{{$mp->balance}}</td>
            <td>@if($mp->egress > 0) S @elseif($mp->entry > 0) E @endif</td>
            <td>{{ $mp->movement->type}}</td>
        </tr>

    @endforeach
</table>
