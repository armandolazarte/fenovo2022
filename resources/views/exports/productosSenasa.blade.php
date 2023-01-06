<table>
    <tr>
        <td>Nombre</td>
        <td>Proveedor</td>
        <td>Senasa Definición</td>
    </tr>
    @foreach($productos as $producto)

    <tr>
        <td>{{ $producto->name    }}</td>
        <td>{{ $producto->proveedor->name    }}</td>
        <td>{{ $producto->senasa_definition->product_name    }}</td>
    </tr>

    @endforeach
</table>
