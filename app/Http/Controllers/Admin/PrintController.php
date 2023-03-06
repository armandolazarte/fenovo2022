<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MovementsViewExport;
use App\Exports\MoviVentasViewExport;
use App\Exports\OrdenConsolidadaViewExport;
use App\Exports\StoreViewStocks;
use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\Store;
use App\Repositories\CustomerRepository;
use App\Repositories\EnumRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SessionProductRepository;
use App\Repositories\StoreRepository;

use App\Traits\OriginDataTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrosMovimientosExport;
use App\Exports\VentasProveedorViewExport;
use App\Exports\ComprasProveedorViewExport;
use App\Exports\FletesViewExport;
use App\Exports\TrasladosProveedorViewExport;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\Proveedor;
use File;
use stdClass;

class PrintController extends Controller
{
    private $customerRepository;
    private $storeRepository;
    private $productRepository;
    private $sessionProductRepository;

    use OriginDataTrait;

    public function __construct(
        CustomerRepository $customerRepository,
        StoreRepository $storeRepository,
        ProductRepository $productRepository,
        SessionProductRepository $sessionProductRepository,
        EnumRepository $enumRepository
    ) {
        $this->productRepository        = $productRepository;
        $this->customerRepository       = $customerRepository;
        $this->storeRepository          = $storeRepository;
        $this->sessionProductRepository = $sessionProductRepository;
        $this->enumRepository           = $enumRepository;
    }

    public function menuPrint(Request $request)
    {
        $tiposalidas = $this->enumRepository->getType('movimientos');
        $stores      = $this->storeRepository->getActives();
        $proveedores = Proveedor::select('id', 'name')->where('punto_venta', '!=', 1)->orderBy('name')->get();
        $depositos   = Store::where('store_type','B')->get();
        return view('admin.print.print', compact('tiposalidas', 'stores', 'proveedores','depositos'));
    }

    public function printMovimientosPDF(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;

        $arrTipos   = ['VENTA', 'TRASLADO', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];
        $arrEntrada = ['VENTA', 'TRASLADO'];

        $movimientos = DB::table('movements as t1')
            ->join('movement_products as t2', 't1.id', '=', 't2.movement_id')
            ->join('products as t3', 't2.product_id', '=', 't3.id')
            ->join('stores as t4', 't2.entidad_id', '=', 't4.id')
            ->select('t1.id', 't1.type', 't1.date', 't1.from', 't4.cod_fenovo as cod_tienda', 't3.cod_fenovo as cod_producto', 't2.bultos', 't2.entry', 't2.egress', 't3.unit_type as unidad')
            ->whereIn('t1.type', $arrTipos)
            ->whereBetween(DB::raw('DATE(date)'), [$desde, $hasta])
            ->where('t2.entidad_tipo', '!=', 'C')
            ->get();

        $arrMovements = [];

        foreach ($movimientos as $movement) {
            $store_type = DB::table('stores')->where('id', $movement->from)->select('store_type')->pluck('store_type')->first();

            $creado = false;

            if (in_array($movement->type, $arrEntrada)) {
                // Venta o traslado

                if ($movement->entry > 0) {
                    $objMovement              = new stdClass();
                    $creado                   = true;
                    $objMovement->origen      = ($store_type == 'N') ? 'DEP_CEN' : 'DEP_PAN';
                    $objMovement->id          = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                    $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                    $objMovement->tipo        = 'E';
                    $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                    $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                    $objMovement->cantidad    = $movement->entry;
                    $objMovement->unidad      = $movement->unidad;
                }
            } else {
                // Analizar las devoluciones

                $tipo = ($movement->entry > 0) ? 'E' : 'S';

                $objMovement              = new stdClass();
                $creado                   = true;
                $objMovement->origen      = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                $objMovement->id          = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                $objMovement->tipo        = $tipo;
                $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                $objMovement->cantidad    = ($movement->entry > 0) ? $movement->entry : $movement->egress;
                $objMovement->unidad      = $movement->unidad;
            }

            if ($creado) {
                array_push($arrMovements, $objMovement);
            }
        }

        $pdf = PDF::loadView('admin.print.movimientos.entreFechas', compact('arrMovements', 'desde', 'hasta'));
        return $pdf->stream('salidas_fechas.pdf');
    }
    public function exportMovimientosCsv(Request $request)
    {
        return Excel::download(new MovementsViewExport(), 'movi.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function exportOrdenesCsv()
    {
        return Excel::download(new  OrdenConsolidadaViewExport(), 'ordenes.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function exportMoviVentasCsv(Request $request)
    {
        $mes  = $request->mes;
        $anio = $request->anio;
        return Excel::download(new MoviVentasViewExport($mes, $anio), 'MoviVentas.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function exportVentasProveedoresCsv(Request $request)
    {
        return Excel::download(new VentasProveedorViewExport($request->proveedorId, $request->fechaVentaDesde, $request->fechaVentaHasta), 'VentasProveedor.xlsx', \Maatwebsite\Excel\Excel::XLSX, ['Content-Type' => 'text/xlsx']);
    }

    public function exportComprasProveedoresCsv(Request $request)
    {
        return Excel::download(new ComprasProveedorViewExport($request->proveedorId, $request->fechaCompraDesde, $request->fechaCompraHasta), 'ComprasProveedor.xlsx', \Maatwebsite\Excel\Excel::XLSX, ['Content-Type' => 'text/xlsx']);
    }

    public function exportTrasladosProveedoresCsv(Request $request)
    {
        return Excel::download(new TrasladosProveedorViewExport($request->proveedorId, $request->fechaTrasladoDesde, $request->fechaTrasladoHasta), 'TrasladosProveedor.xlsx', \Maatwebsite\Excel\Excel::XLSX, ['Content-Type' => 'text/xlsx']);
    }

    public function exportFletesCsv(Request $request)
    {
        return Excel::download(new FletesViewExport($request->fechaFleteDesde, $request->fechaFleteHasta), 'Fletes.xlsx', \Maatwebsite\Excel\Excel::XLSX, ['Content-Type' => 'text/xlsx']);
    }

    public function exportStoreStocks(Request $request)
    {
        $store = Store::find($request->id);
        $archivo = str_pad($store->cod_fenovo, 3, '0', STR_PAD_LEFT).'_stock.csv';
        return Excel::download(new StoreViewStocks($request->id), $archivo, \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function exportarMovimientos()
    {
        return Excel::download(new RegistrosMovimientosExport(), 'registros-' . date('d-m-Y') . '.xlsx');
    }

    public function exportProductosNoStock(Request $request){
        $depositoId = $request->depositoId;
        $productos = Product::all();
        $array_productos = [];
        foreach ($productos as $p) {
            $ps = ProductStore::whereStoreId($depositoId)->whereProductId($p->id)->first();
            if($ps){
                $stock = $ps->stock_cyo + $ps->stock_f + $ps->stock_r;
                if($stock == 0 || $stock < 0){
                    array_push($array_productos,$p->cod_fenovo);
                }
            }else{
                array_push($array_productos,$p->cod_fenovo);
            }
        }

        $fileName = 'depositoId'.$depositoId. '.txt';
        $text = 'array('. implode(',',$array_productos).')';
        File::put(public_path('/exportacion/'.$fileName),$text);
        return response()->download(public_path('/exportacion/'.$fileName));
    }
}
