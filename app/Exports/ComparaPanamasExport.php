<?php

namespace App\Exports;

use App\Models\SessionPrices;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Panamas;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Customer;
use App\Models\Store;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use stdClass;

class ComparaPanamasExport implements FromView {

    use Exportable;

    public function __construct(){}

    public function view(): View{
        $arr_elementos = [];
        $panamas = Panamas::orderBy('id','ASC')->get();
        $i = 0;
        foreach ($panamas as $panama) {
            $element         = new stdClass();
            $movement_id = $panama->movement_id;

            if($panama->tipo == 'PAN'){
                $id_caja = 'PANAMA';
                $netoFormMov = $this->getNetoPanama($movement_id);
            }elseif($panama->tipo == 'FLE'){
                $id_caja = 'FLETE T';
                $netoFormMov = $this->getNetoPanamaFlete($movement_id);
            }else{
                $id_caja = $panama->tipo;
                $netoFormMov = $this->getNetoPanamaFlete($movement_id);
            }

            $cip             = (is_null($panama->cip))?'8889':$panama->cip;

            $element->IDCAJA = $id_caja;
            $element->NROCOM = $panama->orden;
            $element->FECHA  = Carbon::parse($panama->created_at)->format('d/m/Y');
            $element->FISCAL = $cip . '-' . str_pad($panama->orden, 8, '0', STR_PAD_LEFT);;
            $element->NOMCLI = str_replace ( ',', '', $panama->client_name);
            $element->TOTVTA = $panama->neto21 + $panama->neto105;
            $element->netoMov =  $netoFormMov;
            $i++;
            array_push($arr_elementos, $element);
        }

        return view('exports.comparaPanamas', compact('arr_elementos'));
    }

    private function getNetoPanama($movement_id)
    {
        $movement = Movement::query()->where('id', $movement_id)->with('panamas')->first();

        $neto            = 0;
        if ($movement) {
            $array_productos = [];
            $productos       = $movement->group_panamas;
            foreach ($productos as $producto) {
                $neto += $producto->bultos * $producto->unit_price * $producto->unit_package;
            }
        }

        return $neto;
    }

    private function getNetoPanamaFlete($movement_id)
    {
        $movement = Movement::query()->where('id', $movement_id)->where('flete_invoice', false)->first();

        $neto  = 0;
        if ($movement) {
            $neto  = $movement->flete;
        }

        return $neto;
    }
}
