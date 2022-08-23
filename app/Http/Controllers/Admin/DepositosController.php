<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\StoreController;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Repositories\MovimientoRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Store;
use DateTime;

class DepositosController extends StoreController
{
    private $movimientoRepository;

    public function __construct(MovimientoRepository $movimientoRepository)
    {
        $this->movimientoRepository  = $movimientoRepository;
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
                ->rawColumns(['cod_fenovo','edit', 'destroy'])
                ->make(true);
        }
        return view('admin.depositos.index');
    }

    public function balance(Request $request)
    {
        return view('admin.products.listDepositosBalance');
    }

    public function balanceDetalle(Request $request)
    {
        // Obtener fechas a partir de la SEMANA y AÑO seleccionado
        $week = $request->semana;
        $year = $request->anio;
        $dates= $this->movimientoRepository->getStartAndEndDate($week, $year);
        $fecha_desde =  $dates['start_date'];
        $fecha_hasta =  $dates['end_date'];

        // Obtener las tiendas tipo BASE
        $typeStores = ['B'];
        $stores = Store::whereIn('store_type', $typeStores)->get();

        // Obtener los productos CONGELADOS
        $productos = Product::whereActive(1)->select('id')->whereCategorieId(1)->get();

        $entradas = $this->movimientoRepository->getSumaEntradasValorizada(1, 11, $fecha_desde, $fecha_hasta);
        $salidas = $this->movimientoRepository->getSumaSalidasValorizada(1, 11, $fecha_desde, $fecha_hasta);
    }



    public function add()
    {
        $value = 9090;
        $stores_count = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->where('store_type', 'D')->count();
        $code_fenovo = $value + $stores_count + 1;
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
        $store     = $this->storeRepository->getOne($request->id);
        return  view('admin.depositos.form', compact('store'));
    }

    public function update(Request $request)
    {
        $data                = $request->only(['cod_fenovo', 'description','razon_social','responsable']);
        Store::where('id', $request->input('store_id'))->update($data);
        return redirect()->route('depositos.index');
    }

    public function destroy(Request $request)
    {
        $this->storeRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
