@extends('layouts.app-pdf')

@section('title', 'Orden en trámite')

@section('css')

<style>
    #header {
        line-height: 0.6cm;
        position: fixed;
        top: 1.2cm;
        left: 1.5cm;
        right: 1.5cm;
        height: 3cm;
    }
</style>

@endsection

@section('content')

<div id="header">
    <table style="width: 100%">
        <tr>
            <td style="width: 35%"> Página :: <strong> <span class="pagenum"></span> </strong> Confección de la Orden </td>
            <td style="width: 35%; font-size:16px" class=" text-center">Fenovo S.A. </td>
            <td style="width: 30%" class=" text-right"> Fecha {{ date(now()) }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <hr />
            </td>
        </tr>
    </table>
</div>

<table class="table table-borderless" style="font-size:10px">
    <tr>
        <td colspan="3"><br></td>
    </tr>
    <tr>
        <td>Destino : (<strong> {{ str_pad($destino->cod_fenovo, 4, '0', STR_PAD_LEFT) }} </strong> ) - {{ $destino->razon_social}} - <strong> {{ $destino->cuit}} </strong> </td>
        <td>Items <strong> {{ count($session_products) }}</strong> </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3">Dirección : <strong> {{ $destino->address }} / {{ $destino->city }}</strong></td>
    </tr>
    <tr>
        <td colspan="3">DETALLE DE LA CONFECCION DE LA ORDEN</td>
    </tr>
</table>

<table class="table table-condensed text-center table-sm">
    <tr class="">
        <th>Bultos</th>
        <th>Cantidad</th>
        <th>Nombre</th>
        <th>Present_solicitada</th>
        <th>Present_despachada</th>
        <th>Peso_U</th>
        <th>Unidad</th>
        <th>Palet</th>
    </tr>

    @php
    $total_kgrs = 0;
    @endphp

    @foreach ($session_products as $session_product)

    @php
    $total_kgrs += (float)$session_product->unit_weight * (float)$session_product->unit_package * (float)$session_product->quantity;
    @endphp

    <tr>
        <td>{{ (int)$session_product->quantity}}</td>
        <td> ........ </td>
        <td class=" text-left">{{$session_product->cod_fenovo}} {{$session_product->name}}  @if($session_product->cod_proveedor) ({{$session_product->cod_proveedor}}) @endif</td>
        <td>{{ (int) $session_product->unit_package }}</td>
        <td>
            @if(count(explode('|', $session_product->presentacion)) > 1 )

                @foreach (explode('|', $session_product->presentacion) as $item)
                    <i class=" fa fa-check "> </i> {{ $item }} &nbsp;
                @endforeach

            @endif
        </td>
        <td>{{$session_product->unit_weight }}</td>
        <td>{{$session_product->unit_type}}</td>
        <td> ...... </td>
    </tr>
    @endforeach

    <tr>
        <th colspan="8"><br></th>
    </tr>
    <tr class=" bg-info text-white">
        <th>{{ number_format($session_products->sum('quantity'),2) }} </th>
        <th>{{ $total_kgrs }} Kgrs</th>
        <th> </th>
        <th> </th>
        <th> </th>
        <th> </th>
        <th> </th>
        <th> </th>
    </tr>
</table>

<footer>
    <table class="table table-borderless table-condensed table-sm">
        <tr>
            <td>
                Página <strong> <span class="pagenum"></span> </strong> - Cod:: salpend001
            </td>
        </tr>
    </table>
</footer>

@endsection
