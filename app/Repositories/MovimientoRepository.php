<?php

namespace App\Repositories;

use DateTime;

use Illuminate\Support\Facades\DB;

class MovimientoRepository extends BaseRepository
{
    public function getModel()
    {
    }

    public function getSumaEntradasValorizada($store_id, $date_from, $date_to)
    {
        

        $registros = $registros = DB::table('movement_products')
            ->where('entidad_id', $store_id)
            ->whereBetween('created_at', [$date_from, $date_to])
            ->selectRaw('(bultos * unit_package * cost_fenovo) as suma')
            ->get();

        return $registros->sum('suma');
    }

    public function getSumaSalidasValorizada($store_id, $date_from, $date_to)
    {
        $suma = DB::table('movement_products')
            ->where('entidad_id', $store_id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date_to, $date_from])
            ->sum('egress');
        return (is_null($suma)) ? 0 : (float)$suma;
    }

    public function getSumaSalidas($product_id, $store_id, $date_from, $date_to)
    {
        $suma = DB::table('movement_products')
            ->where('product_id', $product_id)
            ->where('entidad_id', $store_id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date_to, $date_from])
            ->sum('egress');
        return (is_null($suma)) ? 0 : (float)$suma;
    }

    public function getSumaEntradas($product_id, $store_id, $date_from, $date_to)
    {
        $suma = DB::table('movement_products')
            ->where('product_id', $product_id)
            ->where('entidad_id', $store_id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date_to, $date_from])
            ->sum('entry');
        return (is_null($suma)) ? 0 : (float)$suma;
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
