<?php

namespace App\Exports;

use App\Models\Movement;
use App\Models\MovementProduct;
use App\Traits\OriginDataTrait;
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
        $max        = DB::table('movement_products')->where('exported_number', '>', 0)->max('exported_number');
        $numeracion = ($max) ? $max + 1 : 1;
        $arrTipos   = ['VENTA', 'TRASLADO', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];
        $arrEntrada = ['VENTA', 'TRASLADO'];

        // Actualizo los Detalles de Movimientos como exportados
        $movimientos = DB::table('movements as t1')
            ->join('movement_products as t2', 't1.id', '=', 't2.movement_id')
            ->join('products as t3', 't2.product_id', '=', 't3.id')
            ->join('stores as t4', 't2.entidad_id', '=', 't4.id')
            ->select('t1.id', 't2.id as movement_products_id', 't1.type', 't1.date', 't1.from', 't4.cod_fenovo as cod_tienda', 't3.cod_fenovo as cod_producto', 't2.bultos', 't2.entry', 't2.egress', 't3.unit_type as unidad')
            ->whereIn('t1.type', $arrTipos)
            ->where('t2.entidad_tipo', '!=', 'C')
            ->where('t2.exported_number', '=', 0)
            ->orderBy('t1.date')->orderBy('t1.id')->orderBy('t3.cod_fenovo')
            ->get();

        foreach ($movimientos as $movement) {
            $creado = false;
            if (in_array($movement->type, $arrEntrada)) {
                // Venta o traslado
                if ($movement->entry > 0) {
                    $creado = true;
                }
            } else {
                // Analizar las devoluciones
                $creado = true;
            }

            if ($creado) {
                MovementProduct::find($movement->movement_products_id)->update(['exported_number' => $numeracion]);
                $numeracion++;
            }
        }

        // Actualizo los movimientos como exportados
        Movement::whereExported(0)->whereIn('type', $arrTipos)->update(['exported' => 1]);

        // Obtener los Movimientos exportables
        $movimientos = DB::table('movements as t1')
            ->join('movement_products as t2', 't1.id', '=', 't2.movement_id')
            ->join('products as t3', 't2.product_id', '=', 't3.id')
            ->join('stores as t4', 't2.entidad_id', '=', 't4.id')
            ->select('t1.id', 't2.id as movement_products_id', 't2.exported_number', 't1.type', 't1.date', 't1.from', 't4.cod_fenovo as cod_tienda', 't3.cod_fenovo as cod_producto', 't2.bultos', 't2.entry', 't2.egress', 't3.unit_type as unidad')
            ->whereIn('t1.type', $arrTipos)
            ->where('t2.entidad_tipo', '!=', 'C')
            ->where('t2.exported_number', '>', 0)
            ->orderBy('t2.exported_number', 'asc')
            ->get();

        $arrMovements = [];

        foreach ($movimientos as $movement) {
            $store_type = DB::table('stores')->where('id', $movement->from)->select('store_type')->pluck('store_type')->first();

            $creado = false;

            if (in_array($movement->type, $arrEntrada)) {
                // Venta o traslado
                if ($movement->entry > 0) {
                    $objMovement              = new stdClass();
                    $creado                   = true;
                    $objMovement->origen      = ($store_type == 'N') ? 'DEP_CEN' : 'DEP_PAN';
                    $objMovement->id          = 'O' . str_pad($movement->exported_number, 8, '0', STR_PAD_LEFT);
                    $objMovement->orden       = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                    $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                    $objMovement->tipo        = 'E';
                    $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                    $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                    $objMovement->cantidad    = $movement->entry;
                    $objMovement->unidad      = $movement->unidad;
                }
            } else {
                // Analizar las compras y devoluciones
                $tipo                     = ($movement->entry > 0) ? 'E' : 'S';
                $objMovement              = new stdClass();
                $creado                   = true;
                $objMovement->origen      = ($movement->type == 'COMPRA') ? 'PROVEEDOR' : str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                $objMovement->id          = 'O' . str_pad($movement->exported_number, 8, '0', STR_PAD_LEFT);
                $objMovement->orden       = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                $objMovement->tipo        = $tipo;
                $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                $objMovement->cantidad    = ($movement->entry > 0) ? $movement->entry : $movement->egress;
                $objMovement->unidad      = $movement->unidad;
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
        $registros = str_pad(count($arrMovements), 4, '0', STR_PAD_LEFT);

        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.movimientos', compact('arrMovements', 'data'));
    }
}
