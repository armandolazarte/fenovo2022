<?php

namespace App\Exports;

use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class VentasProveedorViewExport implements FromView
{
    protected $request;

    use Exportable;

    public function __construct(string $proveedorId, string $fechaVentaDesde, string $fechaVentaHasta)
    {
        $this->proveedorId     = $proveedorId;
        $this->fechaVentaDesde = $fechaVentaDesde;
        $this->fechaVentaHasta = $fechaVentaHasta;
    }

    public function view(): View
    {
        $proveedorId = $this->proveedorId;
        $proveedor   = Proveedor::find($proveedorId);

        $arrTipos = ['VENTA'];

        $arrMovimientos = [];

        $movimientos = DB::table('invoices as facturas')
        ->join('movements as mov', 'facturas.movement_id', '=', 'mov.id')
        ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
        ->join('products as prod', 'detalle.product_id', '=', 'prod.id')
        ->join('stores as tienda', 'mov.to', '=', 'tienda.id')
        ->select(
            'mov.date as fecha',
            'facturas.voucher_number as comprobante',
            'facturas.imp_total as importeTotal',
            'facturas.pto_vta',
            'facturas.cyo',
            'mov.observacion',
            'detalle.bultos',
            'detalle.egress as kilos',
            'detalle.unit_price as precioUnitario',
            'detalle.tasiva',
            'prod.name as producto',
            'tienda.description as destino',
        )
        ->selectRaw('detalle.egress * detalle.unit_price as neto')
        ->selectRaw('(detalle.egress * detalle.unit_price * detalle.tasiva)/100 as importeIva')
        ->where('facturas.pto_vta', '=', $proveedor->punto_venta)
        ->where('detalle.circuito', '=', 'CyO')
        ->whereDate('mov.date', '>=', $this->fechaVentaDesde)
        ->whereDate('mov.date', '<=', $this->fechaVentaHasta)
        ->where('detalle.egress', '>', 0)
        ->orderBy('facturas.created_at')
        ->get();

        foreach ($movimientos as $movimiento) {
            $objMovimiento = new stdClass();

            $objMovimiento->fecha          = date('d/m/Y', strtotime($movimiento->fecha));
            $objMovimiento->comprobante    = $movimiento->comprobante;
            $objMovimiento->ventaDirecta   = ($movimiento->observacion == 'VENTA DIRECTA') ? 'SI' : '';
            $objMovimiento->producto       = $movimiento->producto;
            $objMovimiento->bultos         = $movimiento->bultos;
            $objMovimiento->kilos          = $movimiento->kilos;
            $objMovimiento->precioUnitario = $movimiento->precioUnitario;
            $objMovimiento->tasiva         = $movimiento->tasiva;
            $objMovimiento->neto           = $movimiento->neto;
            $objMovimiento->importeIva     = $movimiento->importeIva;
            $objMovimiento->destino        = $movimiento->destino;

            array_push($arrMovimientos, $objMovimiento);
        }

        $grupos = DB::table('movements as mov')
        ->join('movement_products as mp', 'mp.movement_id', '=', 'mov.id')
        ->join('products as prod', 'mp.product_id', '=', 'prod.id')
        ->join('product_prices as price', 'price.product_id', '=', 'prod.id')
        ->select(
            'prod.cod_fenovo as cod_producto',
            'prod.name as nombre'
        )
        ->selectRaw('SUM(egress) as kgs')
        ->selectRaw('SUM(mp.egress * mp.unit_price) as neto')
        ->selectRaw('SUM(mp.egress * mp.unit_price * mp.tasiva)/100 as importeIva')
        ->where('mov.type','VENTA')
        ->where('mp.circuito', '=', 'CyO')
        ->where('prod.proveedor_id', '=', $proveedorId)
        ->whereDate('mov.date','>=',$this->fechaVentaDesde)
        ->whereDate('mov.date','<=',$this->fechaVentaHasta)
        ->groupBy('cod_producto')
        ->get();

        return view('exports.ventasProveedor', compact('arrMovimientos', 'grupos'));
    }

    private function getImporteIva($importe, $iva, $voucher)
    {
        if (strlen($voucher) == 0) {
            $iva = '0.0';
        } else {
            $iva = ($importe * json_decode($iva)) / 100;
        }
        return round($iva, 2);
    }

    private function getImporteBruto($importe, $iva)
    {
        return json_decode($importe) + json_decode($iva);
    }

    private function getCostoTotal($importe, $cantidad)
    {
        return json_decode($importe) * json_decode($cantidad);
    }

    private function getVentaTotal($importe, $cantidad)
    {
        return json_decode($importe) * json_decode($cantidad);
    }
}
