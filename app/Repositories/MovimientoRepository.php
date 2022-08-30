<?php

namespace App\Repositories;

use DateTime;
use Illuminate\Support\Facades\DB;

class MovimientoRepository extends BaseRepository
{
    public function getModel()
    {
    }

    public static function getSumaInicial($product_id, $store_id, $date_from)
    {
        return $registro = DB::table('movements as mov')
            ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
            ->where('detalle.entidad_id', $store_id)
            ->where('detalle.product_id', $product_id)
            ->selectRaw('detalle.balance as total')
            ->where('detalle.created_at', '<', $date_from)
            ->orderByDesc('detalle.created_at')
            ->get();
        return ($registro) ? $registro->total : 0;
    }

    public static function getSumaActualValorizada($product_id, $store_id, $date_from)
    {
        $registro = DB::table('movements as mov')
            ->join('movement_products as detalle', 'detalle.movement_id', '=', 'mov.id')
            ->where('detalle.entidad_id', $store_id)
            ->where('detalle.product_id', $product_id)
            ->selectRaw('detalle.unit_price * detalle.balance as total')
            ->where('detalle.created_at', '<', $date_from)
            ->orderByDesc('detalle.created_at')
            ->first();
        return ($registro) ? (int)$registro->total : 0;
    }



    public static function getSumaInicialValorizada($product_id, $store_id, $date_from)
    {
        $registro = DB::table('movement_products')
            ->join('product_prices', 'product_prices.product_id', '=', 'movement_products.product_id')
            ->where('movement_products.entidad_id', $store_id)
            ->where('movement_products.product_id', $product_id)
            ->selectRaw('movement_products.unit_price * movement_products.balance as total')
            ->where('movement_products.created_at', '<', $date_from)
            ->orderByDesc('movement_products.created_at')
            ->first();
        return ($registro) ? (int)$registro->total : 0;
    }

    public static function getSumaEntradasValorizada($product_id, $store_id, $date_from, $date_to)
    {
        return (int) DB::table('movement_products')
            ->join('product_prices', 'product_prices.product_id', '=', 'movement_products.product_id')
            ->where('movement_products.entidad_id', $store_id)
            ->where('movement_products.product_id', $product_id)
            ->where('movement_products.entry', '>', 0)
            ->whereBetween('movement_products.created_at', [$date_from, $date_to])
            ->selectRaw('movement_products.unit_price * movement_products.entry as total')
            ->get()
            ->sum('total');
    }

    public static function getSumaSalidasValorizada($product_id, $store_id, $date_from, $date_to)
    {
        return (int) DB::table('movement_products')
            ->join('product_prices', 'product_prices.product_id', '=', 'movement_products.product_id')
            ->where('movement_products.entidad_id', $store_id)
            ->where('movement_products.product_id', $product_id)
            ->where('movement_products.egress', '>', 0)
            ->whereBetween('movement_products.created_at', [$date_from, $date_to])
            ->selectRaw('movement_products.unit_price * movement_products.egress as total')
            ->get()
            ->sum('total');        
    }

    public static function getSumaActual($product_id, $store_id, $date_from)
    {
        $registro = DB::table('movement_products')
            ->join('product_prices', 'product_prices.product_id', '=', 'movement_products.product_id')
            ->where('movement_products.entidad_id', $store_id)
            ->where('movement_products.product_id', $product_id)
            ->selectRaw('movement_products.balance as total')
            ->where('movement_products.created_at', '<', $date_from)
            ->orderByDesc('movement_products.created_at')
            ->first();
        return ($registro) ? $registro->total : 0;
    }

    public static function getSumaEntradas($product_id, $store_id, $date_from, $date_to)
    {
        return DB::table('movement_products')
            ->join('product_prices', 'product_prices.product_id', '=', 'movement_products.product_id')
            ->where('movement_products.entidad_id', $store_id)
            ->where('movement_products.product_id', $product_id)
            ->where('movement_products.entry', '>', 0)
            ->whereBetween('movement_products.created_at', [$date_from, $date_to])
            ->selectRaw('movement_products.entry as total')
            ->get()
            ->sum('total');
    }

    public static function getSumaSalidas($product_id, $store_id, $date_from, $date_to)
    {
        return DB::table('movement_products')
            ->join('product_prices', 'product_prices.product_id', '=', 'movement_products.product_id')
            ->where('movement_products.entidad_id', $store_id)
            ->where('movement_products.product_id', $product_id)
            ->where('movement_products.egress', '>', 0)
            ->whereBetween('movement_products.created_at', [$date_from, $date_to])
            ->selectRaw('movement_products.egress as total')
            ->get()
            ->sum('total');        
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
