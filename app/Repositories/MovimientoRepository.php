<?php

namespace App\Repositories;

use DateTime;
use Illuminate\Support\Facades\DB;

class MovimientoRepository extends BaseRepository
{
    public function getModel()
    {
    }

    public function getSumaActualValorizada($product_id, $store_id)
    {
        $registro = DB::table('products_store')
            ->join('product_prices', 'product_prices.product_id', '=', 'products_store.product_id')
            ->where('products_store.store_id', $store_id)
            ->where('products_store.product_id', $product_id)
            ->selectRaw('((products_store.stock_f + products_store.stock_r + products_store.stock_cyo)*product_prices.costfenovo) as total')
            ->first();
        return ($registro) ? $registro->total : 0;
    }

    public function getSumaInicialValorizada($product_id, $store_id, $date_from)
    {
        $registro = DB::table('movement_products')
            ->where('entidad_id', $store_id)
            ->where('product_id', $product_id)
            ->selectRaw('cost_fenovo * balance as total')
            ->where('created_at', '<', $date_from)
            ->orderByDesc('created_at')
            ->first();
        return ($registro) ? $registro->total : 0;
    }

    public function getSumaEntradasValorizada($product_id, $store_id, $date_from, $date_to)
    {
        return DB::table('movement_products')
            ->join('product_prices', 'product_prices.product_id', '=', 'movement_products.product_id')
            ->where('movement_products.entidad_id', $store_id)
            ->where('movement_products.product_id', $product_id)
            ->where('movement_products.entry', '>', 0)
            ->whereBetween('movement_products.created_at', [$date_from, $date_to])
            ->selectRaw('movement_products.entry * product_prices.costfenovo as total')
            ->get()
            ->sum('total');
    }

    public function getSumaSalidasValorizada($product_id, $store_id, $date_from, $date_to)
    {
        return DB::table('movement_products')
            ->join('product_prices', 'product_prices.product_id', '=', 'movement_products.product_id')
            ->where('movement_products.entidad_id', $store_id)
            ->where('movement_products.product_id', $product_id)
            ->where('movement_products.egress', '>', 0)
            ->whereBetween('movement_products.created_at', [$date_from, $date_to])
            ->selectRaw('movement_products.egress * product_prices.costfenovo as total')
            ->get()
            ->sum('total');
        
    }

    public function getSumaSalidas($product_id, $store_id, $date_from, $date_to)
    {
        return DB::table('movement_products')
            ->where('product_id', $product_id)
            ->where('entidad_id', $store_id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date_to, $date_from])
            ->sum('egress');
    }

    public function getSumaEntradas($product_id, $store_id, $date_from, $date_to)
    {
        return DB::table('movement_products')
            ->where('product_id', $product_id)
            ->where('entidad_id', $store_id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date_to, $date_from])
            ->sum('entry');
    }

    public function getStartAndEndDate($week, $year)
    {
        $dateTime = new DateTime();
        $dateTime->setISODate($year, $week);
        $result['start_date'] = $dateTime->format('Y-m-d');
        $dateTime->modify('+6 days');
        $result['end_date'] = $dateTime->format('Y-m-d');
        return $result;
    }
}
