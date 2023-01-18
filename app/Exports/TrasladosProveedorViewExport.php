<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\Proveedor;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class TrasladosProveedorViewExport implements FromView
{
    protected $request;

    use Exportable;

    public function __construct(string $proveedorId, string $fechaTrasladoaDesde, string $fechaTrasladoaHasta)
    {
        $this->proveedorId     = $proveedorId;
        $this->fechaTrasladoaDesde = $fechaTrasladoaDesde;
        $this->fechaTrasladoaHasta = $fechaTrasladoaHasta;
    }

    public function view(): View
    {
        $proveedorId = $this->proveedorId;
        $proveedor   = Proveedor::find($proveedorId);

        $arrTipos = ['TRASLADO'];

        $arrMovimientos = [];

        $movimientos = DB::table('movements as mov')
                        ->join('movement_products as mp', 'mp.movement_id', '=', 'mov.id')
                        ->join('products as prod', 'mp.product_id', '=', 'prod.id')
                        ->join('product_prices as price', 'price.product_id', '=', 'prod.id')
                        ->select(
                            'mov.date as fecha',
                            'mov.type as tipo',
                            'mov.from',
                            'mov.to',
                            'mov.voucher_number as nro_remito',
                            'mp.bultos',
                            'mp.egress as kilos',
                            'mp.unit_price as precioUnitario',
                            'mp.tasiva',
                            'prod.name as producto',
                            'mp.cost_fenovo as costo_ftk',
                        )
                        ->selectRaw('mp.egress * mp.unit_price as neto')
                        ->selectRaw('(mp.egress * mp.unit_price * mp.tasiva)/100 as importeIva')
                        ->whereIn('mov.type', $arrTipos)
                        ->where('mp.entidad_id', '=', 1)
                        ->where('mp.egress', '>', 0)
                        ->where('mp.circuito', '=', 'CyO')
                        ->where('prod.proveedor_id', '=', $proveedorId)
                        ->whereDate('mov.date', '>=', $this->fechaTrasladoaDesde)
                        ->whereDate('mov.date', '<=', $this->fechaTrasladoaHasta)
                        ->get();


        foreach ($movimientos as $movimiento) {
            $objMovimiento = new stdClass();

            $destino   = ($movimiento->tipo == 'TRASLADO') ? Store::find($movimiento->to)->description : Customer::find($movimiento->to)->razon_social;
            $origen    = Store::find($movimiento->from)->description;
            $provincia = ($movimiento->tipo == 'TRASLADO') ? Store::find($movimiento->to)->state : Customer::find($movimiento->to)->state;

            $objMovimiento->fecha          = date('d/m/Y', strtotime($movimiento->fecha));
            $objMovimiento->comprobante    = $movimiento->nro_remito;
            $objMovimiento->producto       = $movimiento->producto;
            $objMovimiento->bultos         = $movimiento->bultos;
            $objMovimiento->kilos          = $movimiento->kilos;
            $objMovimiento->precioUnitario = $movimiento->precioUnitario;
            $objMovimiento->tasiva         = $movimiento->tasiva;
            $objMovimiento->neto           = $movimiento->neto;
            $objMovimiento->importeIva     = $movimiento->importeIva;
            $objMovimiento->origen         = $origen;
            $objMovimiento->destino        = $destino;
            $objMovimiento->provincia      = $provincia;
            $objMovimiento->costo_ftk      = $movimiento->costo_ftk;

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
            ->whereIn('mov.type', $arrTipos)
            ->where('mp.entidad_id', '=', 1)
            ->where('mp.egress', '>', 0)
            ->where('mp.circuito', '=', 'CyO')
            ->where('prod.proveedor_id', '=', $proveedorId)
            ->whereDate('mov.date', '>=', $this->fechaTrasladoaDesde)
            ->whereDate('mov.date', '<=', $this->fechaTrasladoaHasta)
            ->groupBy('cod_producto')
            ->get();

        return view('exports.trasladosProveedor', compact('arrMovimientos', 'grupos'));
    }

    private function getFactura($cbteTipo){
        switch ($cbteTipo) {
            case '1':
                return 'Factura A';
                break;
            case '2':
                return 'Nota Debito A';
                break;
            case '3':
                return 'Nota Credito A';
                break;
            case '6':
                return 'Factura B';
                break;
            case '7':
                return 'Nota Debito B';
                break;
            case '8':
                return 'Nota Credito B';
                break;
        }
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
