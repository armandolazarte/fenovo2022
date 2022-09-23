<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SessionOferta;
use App\Models\StoreCompraSemanal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StoreCompraSemanalController extends Controller
{
    public function init()
    {
        $productos = Product::whereCategorieId(1)->whereActive(1)->get();
        // $productos = Product::whereIn('id', [1, 2, 3, 4, 5])->get(); DESCOMENTAR CUANDO SE HACEN PRUEBAS PARA POCOS PRODUCTOS
        $hoy = Carbon::parse(now())->format('Y-m-d');

        DB::table('store_compra_semanal')->truncate();

        $store_id = 1;
        if (!empty($productos)) {
            foreach ($productos as $producto) {
                $movimiento     = $producto->stockInicioSemana();
                $balance_inicio = ($movimiento) ? $movimiento->balance : 0;

                $data['store_id']     = $store_id;
                $data['product_id']   = $producto->id;
                $oferta               = SessionOferta::whereProductId($producto->id)->select('costfenovo')->where('fecha_desde', '<=', $hoy)->where('fecha_hasta', '>=', $hoy)->first();
                $data['costo']        = (!$oferta) ? $producto->product_price->costfenovo : $oferta->costfenovo;
                $data['fechaCaptura'] = ($movimiento) ? $movimiento->created_at : null;
                $data['inicio']       = $balance_inicio;
                $data['compras']      = ($movimiento) ? $producto->ingresoSemana($movimiento->id) : 0;
                $data['salidas']      = ($movimiento) ? $producto->salidaSemana($movimiento->id) : 0;
                $data['actual']       = $balance_inicio + $data['compras'] - $data['salidas'];
                StoreCompraSemanal::create($data);
            }
        }
    }
}
