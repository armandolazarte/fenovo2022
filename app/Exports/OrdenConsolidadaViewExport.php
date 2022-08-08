<?php

namespace App\Exports;

use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Store;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class OrdenConsolidadaViewExport implements FromView
{
    protected $request;

    use Exportable;

    public function view(): View
    {
        // Tipos de movimientos
        $arrOtros = ['COMPRA', 'DEVOLUCION', 'DEVOLUCIONCLIENTE', 'AJUSTE'];
        $arrTypes = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];
        $arrTodos = ['VENTA', 'VENTACLIENTE', 'TRASLADO', 'COMPRA', 'DEVOLUCION', 'DEVOLUCIONCLIENTE', 'AJUSTE'];

        // Tomo los movimientos de 15 dias atras
        $fecha = Carbon::now()->subDays(15)->toDateTimeString();

        $movimientos    = Movement::all()->whereIn('type', $arrTodos)->where('created_at', '>', $fecha)->sortBy('id');
        $arrMovimientos = [];

        foreach ($movimientos as $movimiento) {
            $objMovimiento = new stdClass();

            // El destino puede venir una Tienda o un Cliente
            $destino    = Movement::find($movimiento->id)->To($movimiento->type, true);
            $destino_id = ($destino->cod_fenovo) ? $destino->cod_fenovo : 'CLI_' . $destino->id;

            if ($movimiento->invoice_fenovo()) {
                $explodes = explode('-', $movimiento->invoice_fenovo()->voucher_number);
                $ptoVta   = str_pad((int)$explodes[0], 4, '0', STR_PAD_LEFT);
                $importe  = $movimiento->invoice_fenovo()->imp_neto;
            } else {
                $importe = '0.0';
            }

            if (in_array($movimiento->type, $arrTypes)) {
                $store_from = Store::where('id', $movimiento->from)->first();
                $cip        = (is_null($store_from->cip)) ? '8889' : $store_from->cip;
            } else {
                $cip = '0000';
            }

            $panama1 = ($movimiento->hasPanama()) ? str_pad($cip, 4, '0', STR_PAD_LEFT) . '-' . str_pad($movimiento->getPanama()->orden, 7, '0', STR_PAD_LEFT) : '0.0';
            $panama2 = ($movimiento->hasFlete()) ? str_pad($cip, 4, '0', STR_PAD_LEFT) . '-' . str_pad($movimiento->getFlete()->orden, 7, '0', STR_PAD_LEFT) : '0.0';

            /* 1  */ $objMovimiento->id         = str_pad($movimiento->id, 8, '0', STR_PAD_LEFT);
            /* 2  */ $objMovimiento->fecha      = date('d/m/Y', strtotime($movimiento->date));
            /* 3  */ $objMovimiento->destino_id = str_pad($destino_id, 3, '0', STR_PAD_LEFT);
            /* 4  */ $objMovimiento->destino    = $movimiento->To($movimiento->type);
            /* 5  */ $objMovimiento->items      = count(MovementProduct::whereMovementId($movimiento->id)->where('egress', '>', 0)->get());
            /* 6  */ $objMovimiento->tipo       = ($movimiento->type == 'VENTACLIENTE') ? 'VENTA' : $movimiento->type;
            /* 7  */ $objMovimiento->kgrs       = $movimiento->totalKgrs();
            /* 8  */ $objMovimiento->bultos     = MovementProduct::whereMovementId($movimiento->id)->where('egress', '>', 0)->sum('bultos');
            /* 9  */ $objMovimiento->flete      = ($movimiento->hasFlete()) ? $movimiento->getFlete()->neto105 + $movimiento->getFlete()->neto21 : '0.0';
            /* 10 */ $objMovimiento->neto       = $importe;
            /* 11 */ $objMovimiento->factura    = ($movimiento->invoice_fenovo()) ? $ptoVta . '-' . $explodes[1] : '0.0';
            /* 12 */ $objMovimiento->panamaneto = ($movimiento->getPanama()) ? $movimiento->getPanama()->neto105 + $movimiento->getPanama()->neto21 : '0.0';
            /* 13 */ $objMovimiento->panama1    = $panama1;
            /* 14 */ $objMovimiento->panama2    = $panama2;
            /* 15 */ $objMovimiento->franquicia = ($destino->cod_fenovo) ? 'franquicia' : 'no franquicia';

            array_push($arrMovimientos, $objMovimiento);
        }

        $anio = date('Y', time());
        $mes  = date('m', time());
        $dia  = date('d', time());
        $hora = date('H', time());
        $min  = date('i', time());

        $registros = str_pad(count($arrMovimientos), 6, '0', STR_PAD_LEFT);
        $data      = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.ordenConsolidadas', compact('arrMovimientos', 'data'));
    }
}
