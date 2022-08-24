<table class="table table-borderless table-primary mt-5 w-50">
    <tr>
        <td>
            #{{ $store->id }} - <strong> ( {{ $store->cod_fenovo }}) {{ $store->description }} </strong>
        </td>
        <td>Desde</td>
        <th>{{ date('d-m-Y',strtotime($fecha_desde)) }}</th>
        <td>Hasta</td>
        <th>{{ date('d-m-Y',strtotime($fecha_hasta)) }}</th>
    </tr>
</table>


<div class="table-responsive">
    <table class=" table table-hover dataTable table-condensed yajra-datatable text-center" role="grid">
        <thead>
            <tr class="bg-dark text-black-50">
                <td>Codigo</td>
                <td>Producto</td>
                <td>Inicial</td>
                <td>Entradas</td>
                <td>Salidas</td>
                <td>Resultado</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto['cod_fenovo'] }}</td>
                    <td class=" text-left">{{ $producto['name'] }}</td>
                    <td>{{ $producto['inicial'] }}</td>
                    <td>{{ $producto['entradas'] }}</td>
                    <td>{{ $producto['salidas'] }}</td>
                    <td>{{ $producto['resultado'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script>
    var dataTable = jQuery(".yajra-datatable").DataTable({
        scrollY: 300,
        paging: false,
        ordering: false,
        iDisplayLength: -1,
    });
</script>
