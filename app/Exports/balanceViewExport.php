<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Store;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use App\Repositories\MovimientoRepository;

class balanceViewExport implements FromView
{
    protected $request;

    use Exportable;

    public function __construct(string $store_id, string $week, string $year)
    {
        $this->store_id = $store_id;
        $this->week     = $week;
        $this->year     = $year;
    }

    public function view(): View
    {
        $store_id = $this->store_id;
        $week = $this->week;
        $year = $this->year;

        $dates       = MovimientoRepository::getStartAndEndDate($week, $year);
        $fecha_desde = date($dates['start_date']);
        $fecha_hasta = date($dates['end_date']);

        // Obtener la tienda
        $store = Store::find($store_id);

        // Obtener los productos CONGELADOS
        //$products = Product::whereId(4)->whereActive(1)->select('id', 'cod_fenovo', 'name')->whereCategorieId(1)->get(); // ** Pruebas descomentar **

        $products = Product::whereActive(1)->select('id', 'cod_fenovo', 'name')->whereCategorieId(1)->get();

        $productos = [];
        foreach ($products as $producto) {
            $inicial  = MovimientoRepository::getSumaInicial($producto->id, $store->id, $fecha_desde);
            $entradas = MovimientoRepository::getSumaEntradas($producto->id, $store->id, $fecha_desde, $fecha_hasta);
            $salidas  = MovimientoRepository::getSumaSalidas($producto->id, $store->id, $fecha_desde, $fecha_hasta);
            $actual   = MovimientoRepository::getSumaActual($producto->id, $store->id);

            // Valorizacion
            $inicialValorizada  = MovimientoRepository::getSumaInicialValorizada($producto->id, $store->id, $fecha_desde);
            $entradasValorizada = MovimientoRepository::getSumaEntradasValorizada($producto->id, $store->id, $fecha_desde, $fecha_hasta);
            $salidasValorizada  = MovimientoRepository::getSumaSalidasValorizada($producto->id, $store->id, $fecha_desde, $fecha_hasta);
            $actualValorizada   = MovimientoRepository::getSumaActualValorizada($producto->id, $store->id);

            $data['id']         = $producto->id;
            $data['cod_fenovo'] = $producto->cod_fenovo;
            $data['name']       = $producto->name;

            $data['inicial']   = $inicial;
            $data['entradas']  = number_format($entradas, 0, ',', '.');
            $data['salidas']   = number_format($salidas, 0, ',', '.');
            $data['resultado'] = number_format($inicial + $entradas - $salidas, 0, ',', '.');
            $data['actual']    = number_format($actual, 0, ',', '.');

            $data['inicialValorizada']   = $inicialValorizada;
            $data['entradasValorizada']  = $entradasValorizada;
            $data['salidasValorizada']   = $salidasValorizada;
            $data['resultadoValorizada'] = $inicialValorizada + $entradasValorizada - $salidasValorizada;
            $data['actualValorizada']    = $actualValorizada;
            array_push($productos, $data);
        }

        return view('exports.balance', compact('store', 'fecha_desde', 'fecha_hasta', 'productos'));
    }
}
