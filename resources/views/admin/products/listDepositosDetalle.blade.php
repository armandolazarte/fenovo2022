<div class="row mt-2 ">

    <div class="col-6">
        
        <table class=" table table-striped">
            <tr>
                <th colspan="2">
                    <p>
                        @if($store->store_type == 'D') Depósito @else Local @endif :: {{ str_pad($store->cod_fenovo, 3, '0', STR_PAD_LEFT)  }} - {{ $store->description }}
                    </p>    
                </th>
                <td>
                    <a href=" {{ route('store.exportStockCSV', ['id' => $store->id]) }}" class=" btn btn-dark" target="_blank">
                        Exportar archivo <i class="fa fa-file-pdf"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    Capacidad
                </td>
                <td>
                    Ocupado
                </td>
                <td>
                    Disponible
                </td>
            </tr>
            <tr>                
                <th>
                    @if($store->stock_capacity>0)
                        {{ $store->stock_capacity }} Kgrs                        
                    @else
                    0
                    @endif
                </th>                
                <th>                    
                    @if(isset($kgrs) && ($store->stock_capacity>0) ) 
                        {{ round($kgrs,0) }} Kgrs - ({{ round(($kgrs / $store->stock_capacity)*100) }} % ) 
                    @else
                        {{ $kgrs }} Kgrs   
                    @endif                    
                </th>
                <th>                  
                    @if(isset($kgrs) && ($store->stock_capacity>0) ) 
                    ( {{ round(100 - (($kgrs / $store->stock_capacity)*100), 0) }} % )
                    @else
                        Agregue capacidad de camara
                    @endif
                </th>
            </tr>
            
                

            
        </table>
        
    </div>
</div>
<div class="table-responsive">
    <table class=" table table-hover dataTable table-condensed yajra-datatable text-center" role="grid">
        <thead>
            <tr class="bg-dark text-black-50">
                <td>Codigo</td>
                <td>Nombre del producto</td>
                <td>Stock</td>
                <td>Bultos</td>
                <td>Peso Unit.</td>
                <td>Kgrs</td>
                <td>Unidad</td>
                <td>Presentacion</td>
                <td>Historial</td>
            </tr>
        </thead>
        <tbody>
            @if (isset($productos))
                @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->cod_fenovo }}</td>
                    <td class="text-left">{{ $producto->producto }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        @if((count(explode('|', $producto->unit_package)) == 1) && ($producto->stock > 0))
                            {{ round($producto->stock / $producto->unit_package,0) }}
                        @endif
                    </td>
                    <td>{{ $producto->unit_weight }}    </td>
                    <td>{{ round($producto->kilage,2) }}</td>
                    <td>{{ $producto->unit_type }}      </td>
                    <td>
                        @if((count(explode('|', $producto->unit_package)) == 1))
                        {{ round($producto->unit_package) }}   
                        @else
                            {{ $producto->unit_package }}   
                        @endif    
                    </td>
                    <td>
                        <a href="{{ route('product.historial', ['id' => $producto->id]) }}">
                            <i class="fa fa-list" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            @endif
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
