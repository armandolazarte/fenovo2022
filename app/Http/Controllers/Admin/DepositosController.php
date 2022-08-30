<?php

namespace App\Http\Controllers\Admin;

use App\Exports\balanceViewExport;
use App\Models\Product;
use App\Models\Store;

use App\Repositories\MovimientoRepository;
use App\Repositories\StoreRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Maatwebsite\Excel\Facades\Excel;

class DepositosController extends StoreController
{
    private $movimientoRepository;

    public function __construct( MovimientoRepository $movimientoRepository, StoreRepository $storeRepository )
    {
        $this->movimientoRepository = $movimientoRepository;
        $this->storeRepository = $storeRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $store = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->where('store_type', 'D')->get();

            return Datatables::of($store)
                ->addIndexColumn()
                ->addColumn('cod_fenovo', function ($store) {
                    return str_pad($store->cod_fenovo, 4, 0, STR_PAD_LEFT);
                })
                ->addColumn('edit', function ($store) {
                    return '<a href="' . route('depositos.edit', ['id' => $store->id]) . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($store) {
                    $ruta = 'destroy(' . $store->id . ",'" . route('depositos.destroy') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['cod_fenovo', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.depositos.index');
    }

    public function balance(Request $request)
    {
        $stores = Store::where('store_type','B')->orderBy('description')->get();
        return view('admin.depositos.balance', compact('stores'));
    }

    public function balanceDetalle(Request $request)
    {
        // Obtener fechas a partir de la SEMANA y AÑO seleccionado
        $week        = $request->semana;
        $year        = $request->anio;
        $dates       = $this->movimientoRepository->getStartAndEndDate($week, $year);
        $fecha_desde = date($dates['start_date']);
        $fecha_hasta = date($dates['end_date']);

        // Obtener la tienda
        $store = Store::find($request->store_id);

        // Set de pruebas ** Pruebas descomentar **
        $products = Product::whereId(1)->whereActive(1)->select('id', 'cod_fenovo', 'name')->whereCategorieId(1)->get(); 
        $this->movimientoRepository->getSumaInicialValorizada(1, 11, $fecha_desde);
        // Fin Set de pruebas

        
        // Obtener los productos CONGELADOS
        //$products = Product::whereActive(1)->select('id', 'cod_fenovo', 'name')->whereCategorieId(1)->get();

        $productos = [];
        foreach ($products as $producto) {

            $inicial  = $this->movimientoRepository->getSumaInicial($producto->id, $store->id, $fecha_desde);
            $entradas = $this->movimientoRepository->getSumaEntradas($producto->id, $store->id, $fecha_desde, $fecha_hasta);
            $salidas  = $this->movimientoRepository->getSumaSalidas($producto->id, $store->id, $fecha_desde, $fecha_hasta);
            $actual   = $this->movimientoRepository->getSumaActual($producto->id, $store->id, $fecha_desde);

            // Valorizacion
            $inicialValorizada  = $this->movimientoRepository->getSumaInicialValorizada($producto->id, $store->id, $fecha_desde);
            $entradasValorizada = $this->movimientoRepository->getSumaEntradasValorizada($producto->id, $store->id, $fecha_desde, $fecha_hasta);
            $salidasValorizada  = $this->movimientoRepository->getSumaSalidasValorizada($producto->id, $store->id, $fecha_desde, $fecha_hasta);
            $actualValorizada   = $this->movimientoRepository->getSumaActualValorizada($producto->id, $store->id, $fecha_desde);

            $data['id']         = $producto->id;
            $data['cod_fenovo'] = $producto->cod_fenovo;
            $data['name']       = $producto->name;

            $data['inicial']    = $inicial;
            $data['entradas']   = number_format($entradas, 0, ',', '.');
            $data['salidas']    = number_format($salidas, 0, ',', '.');
            $data['resultado']  = number_format($inicial + $entradas - $salidas, 0, ',', '.');
            $data['actual']     = number_format($actual, 0, ',', '.');

            $data['inicialValorizada']    = $inicialValorizada;
            $data['entradasValorizada']   = number_format($entradasValorizada, 0, ',', '.');
            $data['salidasValorizada']    = number_format($salidasValorizada, 0, ',', '.');
            $data['resultadoValorizada']  = number_format($inicialValorizada + $entradasValorizada - $salidasValorizada, 0, ',', '.');
            $data['actualValorizada']     = number_format($actualValorizada, 0, ',', '.');
            array_push($productos, $data);
        }

        return new JsonResponse([
            'type' => 'success',
            'html' => view('admin.depositos.balanceDetalle', 
            compact('store', 'fecha_desde', 'fecha_hasta', 'productos', 'week', 'year'))->render(),
        ]);
    }

    public function exportBalance(Request $request)
    {	
        return Excel::download(new balanceViewExport($request->store_id, $request->week, $request->year), 'balance.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function add()
    {
        $value        = 9090;
        $stores_count = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->where('store_type', 'D')->count();
        $code_fenovo  = $value + $stores_count + 1;
        return  view('admin.depositos.form', compact('code_fenovo'));
    }

    public function store(Request $request)
    {
        try {
            $data               = $request->except(['_token']);
            $data['store_type'] = 'D';
            $this->storeRepository->create($data);
            return redirect()->route('depositos.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $store = $this->storeRepository->getOne($request->id);
        return  view('admin.depositos.form', compact('store'));
    }

    public function update(Request $request)
    {
        $data = $request->only(['cod_fenovo', 'description', 'razon_social', 'responsable']);
        Store::where('id', $request->input('store_id'))->update($data);
        return redirect()->route('depositos.index');
    }

    public function destroy(Request $request)
    {
        $this->storeRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
