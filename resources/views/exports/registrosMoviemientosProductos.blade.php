<table>
    <tr>
        <td>ID</td>
        <td>Fecha y Hora de registro</td>
        <td>Fecha Comprobante</td>
        <td>COD - NOM Depósito</td>
        <td>COD Producto</td>
        <td>COSFTK</td>
        <td>COSVEN</td>
        <td>CANT</td>
        <td>Tipo Mov</td>
        <td>Referencia</td>
        <td>Cant E</td>
        <td>Cant S</td>
        <td>Balance</td>
    </tr>
    @foreach($movimientos_productos as $mp)

    @php
        if($mp->entidad_tipo == 'S'){
            $entidad = $mp->store;
            $entidad_nom = str_pad($entidad->cod_fenovo, 3, '0', STR_PAD_LEFT).' - '.$entidad->description;
        }elseif($mp->entidad_tipo == 'C'){
            $entidad = $mp->customer;
            $entidad_nom = $entidad->razon_social;
        }
    @endphp

        <tr>
            <td>{{ $mp->id }}</td>
            <td>{{ \Carbon\Carbon::parse($mp->movement->created_at)->format('d/m/Y H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($mp->movement->date)->format('d/m/Y') }}</td>
            <td>{{ $entidad_nom }}</td>
            <td>{{ $mp->product->cod_fenovo  }}</td>
            <td>{{ $mp->cost_fenovo     }}</td>
            <td>{{ $mp->unit_price      }}</td>
            <td>
                @if($mp->entry > 0) {{$mp->entry }} @elseif($mp->egress > 0) {{$mp->egress }} @else 0.0 @endif
            </td>
            <td>
                @if($mp->entry > 0) E @elseif($mp->egress > 0) S @else E @endif
            </td>
            <td>{{ $mp->movement->type}}</td>
            <td>@if($mp->entry > 0) {{$mp->entry }} @else 0.0 @endif</td>
            <td>@if($mp->egress > 0) {{$mp->egress }} @else 0.0 @endif</td>
            <td>{{$mp->balance}}</td>
        </tr>

    @endforeach
</table>
