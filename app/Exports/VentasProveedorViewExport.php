<?php

namespace App\Exports;

use App\Models\Movement;
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

    public function __construct(string $proveedorId)
    {
        $this->proveedorId  = $proveedorId;
    }

    public function view(): View
    {
        $proveedorId    = $this->proveedorId;
        $proveedor      =  Proveedor::find($proveedorId);

        $arrTipos = ['VENTA'];

        $arrMovimientos = [];

        $movimientos = DB::table('invoices as t1')
        ->join('movements as t2', 't1.movement_id', '=', 't2.id')
        ->join('movement_products as t3', 't3.movement_id', '=', 't2.id')
        ->join('products as t4', 't3.product_id', '=', 't4.id')
        ->select(
            't1.created_at',
            't1.voucher_number as comprobante',
            't1.imp_total as importeTotal',
            't1.pto_vta',
            't1.cyo',
            't3.bultos',
            't3.egress as kilos',
            't3.unit_price as precioUnitario',
            't3.tasiva',
            't4.name as producto',
        )
        ->selectRaw('t3.egress * t3.unit_price as neto')
        ->selectRaw('(t3.egress * t3.unit_price * t3.tasiva)/100 as importeIva')
        ->where('t1.pto_vta', '=', $proveedor->punto_venta)
        ->where('t3.circuito', '=', 'CyO')
       // ->where('t3.cyo', '=', 1)
        ->where('t3.egress', '>', 0)
        ->orderBy('t1.created_at')
        ->get();

        foreach ($movimientos as $movimiento) {
            $objMovimiento = new stdClass();

            $objMovimiento->fecha           = date('d/m/Y', strtotime($movimiento->created_at));
            $objMovimiento->comprobante     = $movimiento->comprobante;
            $objMovimiento->producto        = $movimiento->producto;
            $objMovimiento->bultos          = $movimiento->bultos;
            $objMovimiento->kilos           = $movimiento->kilos;
            $objMovimiento->precioUnitario  = $movimiento->precioUnitario;
            $objMovimiento->tasiva          = $movimiento->tasiva;
            $objMovimiento->neto            = $movimiento->neto;
            $objMovimiento->importeIva      = $movimiento->importeIva;

            array_push($arrMovimientos, $objMovimiento);
        }

        return view('exports.ventasProveedor', compact('arrMovimientos'));
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
