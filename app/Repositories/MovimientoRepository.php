<?php

namespace App\Repositories;

use App\Models\ProductStore;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MovimientoRepository extends BaseRepository
{
    public function getModel()
    {
    }

    public static function getSumaInicial($product_id, $store_id, $date_from)
    {
        $registro = DB::table('movements as mov')
            ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
            ->where('detalle.entidad_id', $store_id)
            ->where('detalle.product_id', $product_id)
            ->select('detalle.id')
            ->selectRaw('detalle.balance as total')                         // Obtiene el total
            ->where('detalle.created_at', '<', $date_from)
            ->orderByDesc('detalle.created_at')
            ->orderByDesc('detalle.id')
            ->first();
        return ($registro) ? $registro->total : 0;
    }

    public static function getSumaInicialValorizada($product_id, $store_id, $date_from)
    {
        $registro = DB::table('movements as mov')
            ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
            ->where('detalle.entidad_id', $store_id)
            ->where('detalle.product_id', $product_id)
            ->where('detalle.created_at', '<', $date_from)
            ->select('detalle.id')
            ->selectRaw('detalle.balance * detalle.unit_price as total')  // Obtiene la multiplicacion del total x precio
            ->orderByDesc('detalle.created_at')
            ->orderByDesc('detalle.id')
            ->first();
        return ($registro) ? (int)$registro->total : 0;
    }

    public static function getSumaEntradas($product_id, $store_id, $date_from, $date_to)
    {
        $registro = DB::table('movements as mov')
            ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
            ->where('detalle.entidad_id', $store_id)
            ->where('detalle.product_id', $product_id)
            ->where('detalle.entry', '>', 0)
            ->whereBetween('detalle.created_at', [$date_from, $date_to])
            ->selectRaw('detalle.entry as total')
            ->get();

        return ($registro) ? $registro->sum('total') : 0;
    }

    public static function getSumaEntradasValorizada($product_id, $store_id, $date_from, $date_to)
    {
        $registro = DB::table('movements as mov')
            ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
            ->where('detalle.entidad_id', $store_id)
            ->where('detalle.product_id', $product_id)
            ->where('detalle.entry', '>', 0)
            ->whereBetween('detalle.created_at', [$date_from, $date_to])
            ->selectRaw('detalle.entry * detalle.unit_price as total')
            ->get();
        return ($registro) ? $registro->sum('total') : 0;
    }

    public static function getSumaSalidas($product_id, $store_id, $date_from, $date_to)
    {
        $registro = DB::table('movements as mov')
            ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
            ->where('detalle.entidad_id', $store_id)
            ->where('detalle.product_id', $product_id)
            ->where('detalle.egress', '>', 0)
            ->whereBetween('detalle.created_at', [$date_from, $date_to])
            ->selectRaw('detalle.egress as total')
            ->get();

        return ($registro) ? $registro->sum('total') : 0;
    }

    public static function getSumaSalidasValorizada($product_id, $store_id, $date_from, $date_to)
    {
        $registros = DB::table('movements as mov')
            ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
            ->where('detalle.entidad_id', $store_id)
            ->where('detalle.product_id', $product_id)
            ->where('detalle.egress', '>', 0)
            ->whereBetween('mov.created_at', [$date_from, $date_to])
            ->selectRaw('(detalle.egress * detalle.unit_price) as total')
            ->get();

        return ($registros) ? $registros->sum('total') : 0;

    }

    public static function getSumaActual($product_id, $store_id, $date_from, $date_to)
    {
        if ((Carbon::now() >= $date_from) && ($date_to > Carbon::now())) {
            $registro = ProductStore::whereProductId($product_id)->whereStoreId($store_id)->first();
            return ($registro) ? $registro->stock_f + $registro->stock_r + $registro->stock_cyo : 0;
        }

        $registro = DB::table('movements as mov')
            ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
            ->where('detalle.entidad_id', $store_id)
            ->where('detalle.product_id', $product_id)
            ->select('detalle.id')
            ->selectRaw('detalle.balance as total')
            ->whereBetween('detalle.created_at', [$date_from, $date_to])
            ->orderByDesc('detalle.created_at')
            ->orderByDesc('detalle.id')
            ->first();
        return ($registro) ? $registro->total : 0;
    }

    public static function getSumaActualValorizada($product_id, $store_id, $date_from, $date_to)
    {
        if ((Carbon::now() >= $date_from) && ($date_to > Carbon::now())) {
            $registro = DB::table('products_store')
            ->join('product_prices as precios', 'precios.product_id', '=', 'products_store.product_id')
            ->where('products_store.product_id', $product_id)
            ->where('products_store.store_id', $store_id)
            ->selectRaw('precios.plist0Neto * (products_store.stock_f + products_store.stock_r + products_store.stock_cyo) as total')
            ->first();

            return ($registro) ? $registro->total : 0;
        }

        $registro = DB::table('movements as mov')
            ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
            ->where('detalle.entidad_id', $store_id)
            ->where('detalle.product_id', $product_id)
            ->select('detalle.id')
            ->selectRaw('detalle.unit_price * detalle.balance as total')
            ->whereBetween('detalle.created_at', [$date_from, $date_to])
            ->orderByDesc('detalle.created_at')
            ->orderByDesc('detalle.id')
            ->first();
        return ($registro) ? (int)$registro->total : 0;
    }

    public static function getStartAndEndDate($week, $year)
    {
        $dateTime = new DateTime();
        $dateTime->setISODate($year, $week);
        $result['start_date'] = $dateTime->format('Y-m-d');
        $dateTime->modify('+6 days');
        $result['end_date'] = $dateTime->format('Y-m-d');
        return $result;
    }
}
