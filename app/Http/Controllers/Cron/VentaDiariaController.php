<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\Store;
use App\Models\StoreResume;
use App\Models\VentaDiaria;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VentaDiariaController extends Controller
{
    public function init()
    {
        VentaDiaria::truncate();
        $stores   = Store::where('active', 1)->whereIn('store_type', ['B'])->get();
        $products = Product::where('categorie_id', 1)->where('active', 1)->get();

        foreach ($stores as $store) {
            foreach ($products as $product) {
                $venta_diaria      = $this->getVentaDiaria($product->id, $store->id);
                $venta_diaria_kgrs = $venta_diaria * $product->unit_weight;
                $stock_actual      = ProductStore::where('product_id', $product->id)->where('store_id', $store->id)->sum('stock_f', 'stock_r', 'stock_cyo');

                $dataVentaDiaria = [
                    'product_id'   => $product->id,
                    'store_id'     => $store->id,
                    'bultos'       => $venta_diaria,
                    'kgrs'         => $venta_diaria_kgrs,
                    'stock_actual' => $stock_actual,
                ];
                VentaDiaria::create($dataVentaDiaria);
            }

            $total_venta_bultos = DB::table('ventas_diarias')->where('store_id', $store->id)->sum('bultos');
            $total_venta_kgrs   = DB::table('ventas_diarias')->where('store_id', $store->id)->sum('kgrs');
            $total_venta        = (is_null($total_venta_bultos)) ? 0 : (float)$total_venta_bultos;
            $stock_capacity     = round($store->stock_capacity - $total_venta, 2);
            StoreResume::create([
                'store_id'             => $store->id,
                'total_venta_diaria_bultos'   => $total_venta_bultos,
                'total_venta_diaria_kgrs'   => $total_venta_kgrs,
                'capacidad_disponible' => $stock_capacity,
            ]);
        }
    }

    //Venta diaria por producto y store
    private function getVentaDiaria($product_id, $store_id)
    {
        $WEEKS = 4;
        $total = $sem = 0;

        for ($w = 0; $w < $WEEKS; $w++) {
            $days_from = $w       * 7;
            $days_to   = ($w + 1) * 7;
            $date_from = Carbon::now()->subDays($days_from)->format('Y-m-d');
            $date_to   = Carbon::now()->subDays($days_to)->format('Y-m-d');
            $sum       = $this->getSumaSalidas($product_id, $store_id, $date_from, $date_to);

            if ($sum && $sum > 0) {
                $total += $sum;
                $sem++;
            }
        }
        $daily_sale = $total > 0 ? $total / (7 * $sem) : 0;
        return round($daily_sale, 2);
    }

    // Obtiene el total de ventas semanal del producto y de la store
    private function getSumaSalidas($product_id, $store_id, $date_from, $date_to)
    {
        $suma = DB::table('movement_products')
            ->where('product_id', $product_id)
            ->where('entidad_id', $store_id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date_to, $date_from])
            ->sum('egress');
        return (is_null($suma)) ? 0 : (float)$suma;
    }

}
