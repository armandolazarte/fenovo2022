<table>
    <tr>
        <td>IDCAJA</td>
        <td>NROCOM</td>
        <td>FECHA</td>
        <td>FISCAL</td>
        <td>NOMCLI</td>
        <td>TOTVTA</td>
        <td>NETOMOV</td>
    </tr>

    @foreach($arr_elementos as $element)
        <tr>
            <td>{{ $element->IDCAJA}}</td>
            <td>{{ $element->NROCOM}}</td>
            <td>{{ $element->FECHA}}</td>
            <td>{{ $element->FISCAL}}</td>
            <td>{{ $element->NOMCLI}}</td>
            <td>{{ $element->TOTVTA}}</td>
            <td>{{ $element->netoMov}}</td>
        </tr>
    @endforeach
</table>
