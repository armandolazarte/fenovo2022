<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\Movement;
use App\Models\Proveedor;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class FletesViewExport implements FromView
{
    protected $request;

    use Exportable;

    public function __construct(string $fechaFleteDesde, string $fechaFleteHasta){
        $this->fechaFleteDesde = $fechaFleteDesde;
        $this->fechaFleteHasta = $fechaFleteHasta;
    }

    public function view(): View{
        $arrMovimientos = [];

        $movimientos = Movement::where('type','VENTA')->where('from','!=',1)->whereDate('date', '>=', $this->fechaFleteDesde)->whereDate('date', '<=', $this->fechaFleteHasta)->get();
        foreach ($movimientos as $movimiento) {
            $storeFrom             = Store::where('id',$movimiento->from)->first();
            $comision_distribucion = (!is_null($storeFrom->comision_distribucion)) ? $storeFrom->comision_distribucion : 0;
            $storeTo               = Store::where('id',$movimiento->to)->first();

            $objMovimiento = new stdClass();

            $monto_neto_mercaderia = $movimiento->netoTotal($storeFrom->id);
            $panama                = $movimiento->getPanama();
            $monto_neto_mercaderia += ($panama )? $panama->neto105 + $panama->neto21:0;
            $fecha                 = Carbon::parse($movimiento->date)->format('d-m-Y');
            $nro_orden             = $movimiento->id;
            $valor_frac            = number_format(($comision_distribucion * $monto_neto_mercaderia) / 100, 2, ',', '.');

            $objMovimiento->nro_orden               = $nro_orden;
            $objMovimiento->fecha                   = $fecha;
            $objMovimiento->base                    = $storeFrom->cod_fenovo . ' - '. $storeFrom->description;
            $objMovimiento->franquicia              = $storeTo->cod_fenovo . ' - '. $storeTo->description;
            $objMovimiento->monto_neto_mercaderia   = number_format($monto_neto_mercaderia,2,',', '.');
            $objMovimiento->monto_flete             = $valor_frac;

            array_push($arrMovimientos, $objMovimiento);
        }

        return view('exports.fletes', compact('arrMovimientos'));
    }

}
