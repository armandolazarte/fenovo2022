<?php

namespace App\Exports;

use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class StoreViewStocks implements FromView
{
    protected $id;

    use Exportable;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $store     = Store::find($this->id);
        $productos = DB::table('products as t1')->where('t1.active', 1)
            ->leftJoin('proveedors as t3', 't3.id', '=', 't1.proveedor_id')
            ->leftJoin('products_store as t4', 't1.id', '=', 't4.product_id')
            ->select(['t1.id', 't1.cod_fenovo', 't1.name as producto', 't1.unit_type', 't3.name as proveedor', 't1.unit_weight', 't1.unit_package'])
            ->selectRaw('t4.stock_f + t4.stock_r + t4.stock_cyo as stock')
            ->selectRaw('(t4.stock_f + t4.stock_r + t4.stock_cyo) * t1.unit_weight as kilage')
            ->where('t4.store_id', '=', $this->id)
            ->orderBy('t1.cod_fenovo')
            ->get();

        $kgrs  = $productos->sum('kilage');
        $fecha = date('d-m-Y H:i:s');

        return view('exports.storeStocks', compact('store', 'productos', 'kgrs', 'fecha'));
    }
}
