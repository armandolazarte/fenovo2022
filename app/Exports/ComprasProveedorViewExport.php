<?php

namespace App\Exports;

use App\Models\Movement;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class ComprasProveedorViewExport implements FromView
{
    protected $request;

    use Exportable;

    public function __construct(string $proveedorId,$fechaCompraDesde,$fechaCompraHasta) {
        $this->proveedorId  = $proveedorId;
        $this->fechaCompraDesde  = $fechaCompraDesde;
        $this->fechaCompraHasta  = $fechaCompraHasta;
    }

    public function view(): View{
        $proveedorId    = $this->proveedorId;
        $arrMovimientos = [];

        $movimientos = DB::table('movements as mov')
                            ->join('movement_products as mp', 'mp.movement_id', '=', 'mov.id')
                            ->join('products as prod', 'mp.product_id', '=', 'prod.id')
                            ->join('product_prices as price', 'price.product_id', '=', 'prod.id')
                            ->select(
                                'mov.date as fecha',
                                'mov.voucher_number as nro_remito',
                                'prod.cod_fenovo as cod_producto',
                                'prod.name as nombre',
                                'mp.bultos',
                                'mp.entry as cantidad',
                                'price.tasiva',
                                'mp.unit_price as precio',
                                'mp.cost_fenovo as costo_ftk',
                            )
                            ->selectRaw('mp.entry * mp.cost_fenovo as neto')
                            ->selectRaw('(mp.entry * mp.cost_fenovo * mp.tasiva)/100 as importeIva')
                            ->where('mov.type','COMPRA')
                            ->where('mov.subtype','CyO')
                            ->where('prod.proveedor_id', '=', $proveedorId)
                            ->whereDate('mov.date','>=',$this->fechaCompraDesde)
                            ->whereDate('mov.date','<=',$this->fechaCompraHasta)
                            ->get();

        $grupos = DB::table('movements as mov')
                            ->join('movement_products as mp', 'mp.movement_id', '=', 'mov.id')
                            ->join('products as prod', 'mp.product_id', '=', 'prod.id')
                            ->join('product_prices as price', 'price.product_id', '=', 'prod.id')
                            ->select(
                                'prod.cod_fenovo as cod_producto',
                                'prod.name as nombre'
                            )
                            ->selectRaw('SUM(entry) as kgs')
                            ->selectRaw('SUM(mp.entry * mp.cost_fenovo) as neto')
                            ->selectRaw('SUM((mp.entry * mp.cost_fenovo * mp.tasiva)/100) as importeIva')
                            ->where('mov.type','COMPRA')
                            ->where('mov.subtype','CyO')
                            ->where('prod.proveedor_id', '=', $proveedorId)
                            ->whereDate('mov.date','>=',$this->fechaCompraDesde)
                            ->whereDate('mov.date','<=',$this->fechaCompraHasta)
                            ->groupBy('cod_producto')
                            ->get();

        return view('exports.comprasProveedor', compact('movimientos','grupos'));
    }
}
