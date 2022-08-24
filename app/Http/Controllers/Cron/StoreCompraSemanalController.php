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
        $hoy       = Carbon::parse(now())->format('Y-m-d');

        DB::table('store_compra_semanal')->truncate();

        $store_id = 1;
        if (!empty($productos)) {
            foreach ($productos as $producto) {
                $data['store_id']     = $store_id;
                $data['product_id']   = $producto->id;
                $oferta               = SessionOferta::whereProductId($producto->id)->select('costfenovo')->where('fecha_desde', '<=', $hoy)->where('fecha_hasta', '>=', $hoy)->first();
                $costo                = (!$oferta) ? $producto->product_price->costfenovo : $oferta->costfenovo;
                $costo                = number_format($costo, 2);
                $data['costo']        = $costo;
                $data['fechaCaptura'] = ($producto->stockInicioSemana()) ? $producto->stockInicioSemana()->created_at : null;
                $data['inicio']       = ($producto->stockInicioSemana()) ? $producto->stockInicioSemana()->balance : 0;
                $data['compras']      = $producto->ingresoSemana();
                $data['salidas']      = $producto->salidaSemana();
                $data['actual']       = $producto->stockFinSemana();
                StoreCompraSemanal::create($data);
            }
        }
    }
}
