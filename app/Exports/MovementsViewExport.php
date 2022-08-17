<?php

namespace App\Exports;

use App\Models\Movement;
use App\Models\MovementProduct;
use App\Traits\OriginDataTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class MovementsViewExport implements FromView
{
    use OriginDataTrait;

    protected $request;

    use Exportable;

    public function view(): View
    {
        
        $arrTipos   = ['COMPRA', 'VENTA', 'VENTACLIENTE', 'TRASLADO', 'DEVOLUCION', 'DEVOLUCIONCLIENTE', 'AJUSTE'];
        $arrEntrada = ['COMPRA', 'VENTA', 'VENTACLIENTE', 'TRASLADO'];

        // Actualizo los movimientos como exportados
        Movement::whereExported(0)->whereIn('type', $arrTipos)->update(['exported' => 1]);

        // Tomo los movimientos de 15 dias atras
       //$fecha = Carbon::now()->subDays(15)->toDateTimeString();
       $fecha = '2022-06-30';

        // Obtener los Movimientos exportables
        $movimientos = DB::table('movements as t1')
            ->join('movement_products as t2', 't1.id', '=', 't2.movement_id')
            ->join('products as t3', 't2.product_id', '=', 't3.id')
            ->join('stores as t4', 't2.entidad_id', '=', 't4.id')
            ->join('product_prices as t5', 't5.product_id', '=', 't3.id')
            ->select(
                't1.id', 't1.created_at', 't1.type', 't1.date', 't1.to', 't1.from',
                't2.id as movement_products_id', 't2.unit_price', 't2.cost_fenovo', 't2.bultos', 't2.entry', 't2.egress', 't2.unit_package', 't2.circuito',
                't3.cod_fenovo as cod_producto', 't3.unit_type as unidad',
                't4.cod_fenovo as cod_tienda',
                't5.costfenovo as costo_fenovo', 't5.plist0neto as neto_fenovo'
            )
            ->whereIn('t1.type', $arrTipos)
            ->where('t2.entidad_tipo', '!=', 'C')
            ->where('t1.exported', '=', 1)
            ->whereDate('t1.date', '>', $fecha)
            //->whereDate('t1.created_at', '>', $fecha)
            //->where('t1.id', '=', 3372) // Consulta puntualmente este movimiento
            ->orderBy('t1.date')->orderBy('t1.id')->orderBy('t3.cod_fenovo')
            ->get();

        $arrMovements = [];

        foreach ($movimientos as $movement) {

            if ($movement->type == 'COMPRA' or $movement->type == 'AJUSTE') {
                $store_type = DB::table('stores')->where('id', $movement->to)->select('store_type')->pluck('store_type')->first();
            } else {
                $store_type = DB::table('stores')->where('id', $movement->from)->select('store_type')->pluck('store_type')->first();
            }

            $creado = false;

            if (in_array($movement->type, $arrEntrada)) {

                if ($movement->entry > 0) {
                    if ($movement->type == 'COMPRA') {
                        $objMovement = new stdClass();
                        $creado      = true;
                        $objMovement->origen      = 'PROVEED';
                        $objMovement->id          = 'O' . str_pad($movement->movement_products_id, 8, '0', STR_PAD_LEFT);
                        $objMovement->orden       = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                        $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                        $objMovement->tipo        = 'E';
                        $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                        $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                        $objMovement->cantidad    = $movement->entry;
                        $objMovement->unidad      = $movement->unidad;
                        $objMovement->cosftk      = (!$movement->cost_fenovo)?$movement->costo_fenovo:$movement->cost_fenovo;
                        $objMovement->cosven      = $movement->neto_fenovo;
                        $objMovement->circuito    = ($movement->circuito) ? $movement->circuito : 'F';
                    } else {
                        // Venta o traslado
                        $objMovement              = new stdClass();
                        $creado                   = true;
                        $objMovement->origen      = ($store_type == 'N') ? 'DEP_CEN' : 'DEP_PAN';
                        $objMovement->id          = 'O' . str_pad($movement->movement_products_id, 8, '0', STR_PAD_LEFT);
                        $objMovement->orden       = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                        $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                        $objMovement->tipo        = 'E';
                        $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                        $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                        $objMovement->cantidad    = $movement->entry;
                        $objMovement->unidad      = $movement->unidad;
                        $objMovement->cosftk      = (!$movement->cost_fenovo)?$movement->costo_fenovo:$movement->cost_fenovo;
                        $objMovement->cosven      = $movement->unit_price;
                        $objMovement->circuito    = ($movement->circuito) ? $movement->circuito : 'F';
                    }
                }

                if ($movement->type == 'VENTACLIENTE') {
                    $objMovement = new stdClass();
                    $creado      = true;
                    $objMovement->origen      = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                    $objMovement->id          = 'O' . str_pad($movement->movement_products_id, 8, '0', STR_PAD_LEFT);
                    $objMovement->orden       = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                    $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                    $objMovement->tipo        = 'S';
                    $objMovement->codtienda   = str_pad(0, 3, '0', STR_PAD_LEFT);
                    $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                    $objMovement->cantidad    = $movement->egress;
                    $objMovement->unidad      = $movement->unidad;
                    $objMovement->cosftk      = $movement->cost_fenovo;
                    $objMovement->cosven      = $movement->unit_price;
                    $objMovement->circuito    = ($movement->circuito) ? $movement->circuito : 'F';
                }
            } else {
                // Analizar las devoluciones / ajustes

                $cod_fenovo = DB::table('stores')->where('id', $movement->to)->select('cod_fenovo')->pluck('cod_fenovo')->first();

                if (($movement->type == 'AJUSTE')) {

                    if (($movement->entry > 0)) {
                        $objMovement = new stdClass();
                        $creado      = true;
                        $objMovement->origen      = 'AJUSTE';
                        $objMovement->id          = 'O' . str_pad($movement->movement_products_id, 8, '0', STR_PAD_LEFT);
                        $objMovement->orden       = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                        $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                        $objMovement->tipo        = 'E';
                        $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                        $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                        $objMovement->cantidad    = $movement->entry;
                        $objMovement->unidad      = $movement->unidad;
                        $objMovement->cosftk      = (!$movement->cost_fenovo)?$movement->costo_fenovo:$movement->cost_fenovo;
                        $objMovement->cosven      = $movement->neto_fenovo;
                        $objMovement->circuito    = ($movement->circuito) ? $movement->circuito : 'F';
                    }
                    //
                } else {
                    if ($movement->entry > 0) {
                        $objMovement = new stdClass();
                        $creado      = true;
                        $objMovement->origen      = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                        $objMovement->id          = 'O' . str_pad($movement->movement_products_id, 8, '0', STR_PAD_LEFT);
                        $objMovement->orden       = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                        $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                        $objMovement->tipo        = 'S';
                        $objMovement->codtienda   = str_pad($cod_fenovo, 3, '0', STR_PAD_LEFT);
                        $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                        $objMovement->cantidad    = $movement->entry;
                        $objMovement->unidad      = $movement->unidad;
                        $objMovement->cosftk      = (!$movement->cost_fenovo)?$movement->costo_fenovo:$movement->cost_fenovo;
                        $objMovement->cosven      = $movement->unit_price;
                        $objMovement->circuito    = ($movement->circuito) ? $movement->circuito : 'F';
                    }
                }
            }

            if ($creado) {
                array_push($arrMovements, $objMovement);
            }
        }

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($arrMovements), 6, '0', STR_PAD_LEFT);

        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.movimientos', compact('arrMovements', 'data'));
    }
}
