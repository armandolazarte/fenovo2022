<?php

namespace App\Repositories;

use DateTime;
use Illuminate\Support\Facades\DB;

class MovimientoRepository extends BaseRepository
{
    public function getModel()
    {
    }

    public function getSumaInicialValorizada($product_id, $store_id, $date_from)
    {
        $registro = DB::table('movement_products')
            ->where('entidad_id', $store_id)
            ->where('product_id', $product_id)
            ->select('id', 'unit_price', 'balance')
            ->where('created_at', '<', $date_from)
            ->orderByDesc('created_at')
            ->first();

        return ($registro) ? $registro->unit_price * $registro->balance : 0;
    }

    public function getSumaEntradasValorizada($product_id, $store_id, $date_from, $date_to)
    {
        return DB::table('movement_products')
            ->where('entidad_id', $store_id)
            ->where('product_id', $product_id)
            ->where('entry', '>', 0)
            ->whereBetween('created_at', [$date_from, $date_to])
            ->selectRaw('(bultos * unit_package * cost_fenovo) as suma')
            ->get()
            ->sum('suma');
    }

    public function getSumaSalidasValorizada($product_id, $store_id, $date_from, $date_to)
    {
        return DB::table('movement_products')
            ->where('entidad_id', $store_id)
            ->where('product_id', $product_id)
            ->where('egress', '>', 0)
            ->whereBetween('created_at', [$date_from, $date_to])
            ->selectRaw('(bultos * unit_package * unit_price) as suma')
            ->get()
            ->sum('suma');
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
