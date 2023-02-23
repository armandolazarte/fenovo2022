<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\Coeficiente;
use App\Models\FleteSetting;
use App\Models\InvoiceCompra;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\MovementProductTemp;
use App\Models\MovementTemp;
use App\Models\OfertaStore;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductStore;
use App\Models\Proveedor;
use App\Models\SessionOferta;
use App\Models\Store;

use App\Repositories\DescuentoRepository;
use App\Repositories\EnumRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProveedorRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class IngresosController extends Controller
{
    private $proveedorRepository;
    private $productRepository;
    private $productCategoryRepository;
    private $enumRepository;
    private $descuentoRepository;

    public function __construct(
        ProveedorRepository $proveedorRepository,
        ProductRepository $productRepository,
        ProductCategoryRepository $productCategoryRepository,
        EnumRepository $enumRepository,
        DescuentoRepository $descuentoRepository
    ) {
        $this->proveedorRepository       = $proveedorRepository;
        $this->productRepository         = $productRepository;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->enumRepository            = $enumRepository;
        $this->descuentoRepository       = $descuentoRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $movement = MovementTemp::where('type', 'COMPRA')
                ->where('user_id', Auth::user()->id)
                ->whereStatus('CREATED')
                ->with('movement_ingreso_products')
                ->orderBy('date', 'DESC')
                ->get();

            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('id', function ($movement) {
                    return $movement->id;
                })
                ->editColumn('date', function ($movement) {
                    return date('d-m-Y', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    return '<span class="badge badge-primary">' . count($movement->movement_ingreso_products) . '</span>';
                })
                ->addColumn('voucher', function ($movement) {
                    return  $movement->voucher_number;
                })
                ->addColumn('edit', function ($movement) {
                    //if ($movement->categoria == 1) {
                    return '<a href="' . route('ingresos.edit', ['id' => $movement->id]) . '"> <i class="fa fa-pencil-alt"></i></a>';
                    //}
                    //return '<a href="' . route('ingresos.editNocongelados', ['id' => $movement->id]) . '"> <i class="fa fa-pencil-alt"></i></a>' . $movement->categoria;
                })
                ->addColumn('show', function ($movement) {
                    return '<a href="' . route('ingresos.show', ['id' => $movement->id, 'is_cerrada' => false]) . '"> <i class="fa fa-eye"></i> </a>';
                })
                ->addColumn('borrar', function ($movement) {
                    $ruta = 'destroy(' . $movement->id . ",'" . route('ingresos.destroyTemp') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['id', 'origen', 'date', 'items', 'voucher', 'show', 'edit', 'borrar'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.index');
    }

    public function indexCerradas(Request $request)
    {
        // if ($request->ajax()) {
        //     if (\Auth::user()->rol() == 'superadmin' || \Auth::user()->rol() == 'admin') {
        //         $movement = Movement::where('type', 'COMPRA')
        //             ->whereStatus('FINISHED')
        //             ->with('movement_ingreso_products')
        //             ->orderBy('date', 'DESC')
        //             ->orderBy('id', 'DESC')
        //             ->get();
        //     } else {
        //         $movement = Movement::where('type', 'COMPRA')
        //             ->where('user_id', Auth::user()->id)
        //             ->whereStatus('FINISHED')
        //             ->with('movement_ingreso_products')
        //             ->orderBy('date', 'DESC')
        //             ->orderBy('id', 'DESC')
        //             ->get();
        //     }

        //     return Datatables::of($movement)
        //         ->addIndexColumn()
        //         ->addColumn('origen', function ($movement) {
        //             return $movement->origenData($movement->type);
        //         })
        //         ->editColumn('date', function ($movement) {
        //             return date('d-m-Y', strtotime($movement->date));
        //         })
        //         ->addColumn('items', function ($movement) {
        //             return '<span class="badge badge-primary">' . $movement->cantidad_ingresos() . '</span>';
        //         })
        //         ->addColumn('voucher', function ($movement) {
        //             return  $movement->voucher_number;
        //         })
        //         ->addColumn('show', function ($movement) {
        //             return '<a href="' . route('ingresos.show', ['id' => $movement->id, 'is_cerrada' => true]) . '"> <i class="fa fa-eye"></i> </a>';
        //         })
        //         ->rawColumns(['origen', 'date', 'items', 'voucher', 'show'])
        //         ->make(true);
        // }
        return view('admin.movimientos.ingresos.indexCerradas');
    }

    public function getCompras(Request $request)
    {
        $totalFilteredRecord = $totalDataRecord = $draw = '';
        $status = ['CHECKED'];
        $totalDataRecord = Movement::where('type', 'COMPRA')
            ->whereIn('status',$status)
            ->with('movement_ingreso_products')
            ->orderBy('date', 'DESC')
            ->orderBy('id', 'DESC')
            ->count();
        $totalFilteredRecord = $totalDataRecord;

        $start_val = ($request->input('start')) ? $request->input('start') : 0;
        $limit_val = ($request->input('length')) ? $request->input('length') : 10;

        if (empty($request->input('search.value'))) {
            if (\Auth::user()->rol() == 'superadmin' || \Auth::user()->rol() == 'admin') {
                $movimientos = Movement::where('type', 'COMPRA')
                    ->whereIn('status',$status)
                    ->offset($start_val)
                    ->limit($limit_val)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
            } else {
                $movimientos = Movement::where('type', 'COMPRA')
                    ->where('user_id', Auth::user()->id)
                    ->whereIn('status',$status)
                    ->offset($start_val)
                    ->limit($limit_val)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
            }
        } else {
            $search_text = $request->input('search.value');

            $movimientos = Movement::where('type', 'COMPRA')->whereIn('status',$status)
                ->join('proveedors', 'movements.from', '=', 'proveedors.id')
                ->select('movements.*')
                ->selectRaw('CONCAT(movements.id," ", movements.subtype," ", proveedors.name) as txtMovimiento')
                ->having('txtMovimiento', 'LIKE', "%{$search_text}%")
                ->offset($start_val)
                ->limit($limit_val)
                ->orderBy('date', 'desc')
                ->orderBy('movements.id', 'DESC')
                ->get();

            $totalFilteredRecord = Movement::where('type', 'COMPRA')->whereIn('status',$status)
                ->join('proveedors', 'movements.from', '=', 'proveedors.id')
                ->select('movements.*')
                ->selectRaw('CONCAT(movements.id," ", movements.subtype," ", proveedors.name) as txtMovimiento')
                ->having('txtMovimiento', 'LIKE', "%{$search_text}%")
                ->count();
        }

        $data = [];
        if (!empty($movimientos)) {
            foreach ($movimientos as $movement) {
                $dataIngreso['id']      = str_pad($movement->id, 6, '0', STR_PAD_LEFT);
                $dataIngreso['origen']  = $movement->origenData($movement->type);
                $dataIngreso['subtype'] = $movement->subtype;
                $dataIngreso['date']    = date('d-m-Y', strtotime($movement->date));
                $dataIngreso['items']   = '<span class="badge badge-primary">' . $movement->cantidad_ingresos() . '</span>';
                $dataIngreso['voucher'] = $movement->voucher_number;
                $dataIngreso['show']    = '<a href="' . route('ingresos.show', ['id' => $movement->id, 'is_cerrada' => true]) . '"> <i class="fa fa-eye"></i> </a>';
                $data[]                 = $dataIngreso;
            }
        }
        $draw          = $request->input('draw');
        $get_json_data = [
            'draw'            => intval($draw),
            'recordsTotal'    => intval($totalDataRecord),
            'recordsFiltered' => intval($totalFilteredRecord),
            'data'            => $data,
        ];

        print json_encode($get_json_data);
    }

    public function indexChequeadas(Request $request)
    {
        if ($request->ajax()) {
            $movement = Movement::where('type', 'COMPRA')->whereStatus('CHECKED')->with('movement_ingreso_products')->orderBy('date', 'DESC')->orderBy('id', 'DESC')->get();

            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('d-m-Y', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    return '<span class="badge badge-primary">' . $movement->cantidad_ingresos() . '</span>';
                })
                ->addColumn('voucher', function ($movement) {
                    return  $movement->voucher_number;
                })
                ->addColumn('show', function ($movement) {
                    return '<a href="' . route('ingresos.show', ['id' => $movement->id, 'is_cerrada' => true]) . '"> <i class="fa fa-eye"></i> </a>';
                })
                ->rawColumns(['origen', 'date', 'items', 'voucher', 'show'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.indexChequeadas');
    }

    public function add()
    {
        $productos   = Product::where('categorie_id', '=', 1)->pluck('proveedor_id');
        $proveedores = Proveedor::orderBy('name')->whereIn('id', $productos)->pluck('name', 'id');
        return view('admin.movimientos.ingresos.add', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $data            = $request->all();
        $data['user_id'] = \Auth::user()->id;
        $movement        = MovementTemp::create($data);
        if(Movement::where('from',$data['from'])->where('voucher_number',$data['voucher_number'])->exists()){
            $request->session()->flash('error', 'El número de remito con el proveedor ya fue cargado!');
            return redirect()->back();
        }
        return redirect()->route('ingresos.edit', ['id' => $movement->id]);
    }

    public function edit(Request $request)
    {
        $depositos   = null;
        $movement    = MovementTemp::find($request->id);
        $productos   = $this->productRepository->getByProveedorIdPluck($movement->from);
        $stores      = Store::orderBy('description', 'asc')->where('active', 1)->get();
        $proveedor   = Proveedor::find($movement->from);
        $movimientos = MovementProductTemp::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
        if (\Auth::user()->rol() == 'contable') {
            $depositos = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->where('store_type', 'D')->get();
        }
        return view('admin.movimientos.ingresos.edit', compact('movement', 'proveedor', 'productos', 'movimientos', 'stores', 'depositos'));
    }

    public function editIngreso(Request $request)
    {
        try {
            $movement  = MovementTemp::find($request->id);
            $proveedor = Proveedor::find($movement->from);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.insertByAjaxIngreso', compact('movement', 'proveedor'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updateIngreso(Request $request)
    {
        try {
            MovementTemp::find($request->movement_id)->update($request->all());
            return new JsonResponse(['msj' => 'Actualización correcta !', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function editProduct(Request $request)
    {
        try {
            $product      = Product::find($request->id);
            $unit_package = explode('|', $product->unit_package);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.insertByAjax', compact('product', 'unit_package'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            $data['unit_package'] = implode('|', $request->unit_package);
            $data['unit_weight']  = $request->unit_weight;
            Product::find($request->product_id)->update($data);
            return new JsonResponse(['msj' => 'Actualización correcta !', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function close(Request $request)
    {
        $tienda = ($request->tienda != 0) ? $request->tienda : null;

        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            // Obtengo los datos del movimiento
            $movement_temp = MovementTemp::where('id', $request->id)->with('movement_ingreso_products')->first();

            $count = Movement::where('to', 1)->where('type', 'COMPRA')->count();
            $orden = ($count) ? $count + 1 : 1;

            // Completo los datos del movimiento de COMPRA
            $data['type']           = 'COMPRA';
            $data['subtype']        = $movement_temp->subtype;
            $data['to']             = ($movement_temp->deposito) ? $movement_temp->deposito : 1;
            $data['date']           = $movement_temp->date;
            $data['from']           = $movement_temp->from;
            $data['orden']          = $orden;
            $data['status']         = 'FINISHED';
            $data['voucher_number'] = $movement_temp->voucher_number;
            $data['flete']          = 0;
            $data['observacion']    = $movement_temp->observacion;
            $data['user_id']        = \Auth::user()->id;
            $data['flete_invoice']  = 0;
            $movement_compra        = Movement::create($data);

            $circuito = '';
            if ($movement_temp->subtype == 'FACTURA') {
                $circuito = 'F';
            }
            if ($movement_temp->subtype == 'REMITO') {
                $circuito = 'R';
            }
            if ($movement_temp->subtype == 'CYO') {
                $circuito = 'CyO';
            }

            // Generar la venta directa si viene el Id de Store
            if ($tienda) {
                // Obtengo el orden
                $count = Movement::where('from', 1)->whereIn('type', ['VENTA'])->count();
                $orden = ($count) ? $count + 1 : 1;

                // Completo los datos del movimiento de VENTA
                $insert_data['date']           = now();
                $insert_data['type']           = 'VENTA';
                $insert_data['from']           = 1;
                $insert_data['to']             = $tienda;
                $insert_data['orden']          = $orden;
                $insert_data['status']         = 'FINISHED';
                $insert_data['voucher_number'] = 1;
                $insert_data['flete']          = 0;
                $insert_data['observacion']    = 'VENTA DIRECTA';
                $insert_data['user_id']        = \Auth::user()->id;
                $insert_data['flete_invoice']  = 1;
                //Guardo la VENTA
                $movement_venta = Movement::create($insert_data);
            }

            $totalVta = 0;

            // Considerar cada uno de los movimientos
            foreach ($movement_temp->movement_ingreso_products as $movimiento) {
                // Ajusto el STOCK DEL PRODUCTO luego de la compra
                $product        = Product::find($movimiento['product_id']);
                $latest         = $product->stockReal();
                $balance_compra = ($latest) ? $latest + $movimiento['entry'] : $movimiento['entry'];
                //

                if ($movimiento['cyo'] == 1) {
                    $product->stock_cyo = $product->stock_cyo + $movimiento['entry'];
                } elseif ($movimiento['invoice'] == 1) {
                    $product->stock_f = $product->stock_f + $movimiento['entry'];
                } else {
                    $product->stock_r = $product->stock_r + $movimiento['entry'];
                }
                $product->save();
                $entidad_tipo = 'S';

                if (!is_null($movement_temp->deposito)) {
                    $stock_cyo  = $stock_f = $stock_r = 0;
                    $prod_store = ProductStore::where('product_id', $movimiento['product_id'])->where('store_id', $movement_temp->deposito)->first();
                    //$stock_inicial_store = ($prod_store) ? $prod_store->stock_f + $prod_store->stock_r + $prod_store->stock_cyo : 0;
                    //$balance_compra = ($stock_inicial_store) ? $stock_inicial_store + $movimiento['entry'] : $movimiento['entry'];

                    if ($movimiento['cyo']) {
                        ($prod_store) ? $prod_store->stock_cyo = $prod_store->stock_cyo + $movimiento['entry'] : $stock_cyo = $movimiento['entry'];
                    } elseif ($movimiento['invoice']) {
                        ($prod_store) ? $prod_store->stock_f = $prod_store->stock_f + $movimiento['entry'] : $stock_f = $movimiento['entry'];
                    } else {
                        ($prod_store) ? $prod_store->stock_r = $prod_store->stock_r + $movimiento['entry'] : $stock_r = $movimiento['entry'];
                    }
                    if ($prod_store) {
                        $prod_store->save();
                    } else {
                        ProductStore::create([
                            'product_id' => $movimiento['product_id'],
                            'store_id'   => $movement_temp->deposito,
                            'stock_cyo'  => $stock_cyo,
                            'stock_f'    => $stock_f,
                            'stock_r'    => $stock_r,
                        ]);
                    }

                    $entidad_tipo = 'D';
                }

                // Registro el detalle de la compra
                MovementProduct::create([
                    'entidad_id'   => Auth::user()->store_active,
                    'movement_id'  => $movement_compra->id,
                    'entidad_tipo' => $entidad_tipo,
                    'product_id'   => $movimiento['product_id'],
                    'unit_package' => $movimiento['unit_package'],
                    'unit_type'    => $movimiento['unit_type'],
                    'tasiva'       => $movimiento['tasiva'],
                    'cost_fenovo'  => $movimiento['cost_fenovo'],
                    'unit_price'   => $movimiento['unit_price'],
                    'invoice'      => $movimiento['invoice'],
                    'circuito'     => $circuito,
                    'bultos'       => $movimiento['bultos'],
                    'entry'        => $movimiento['entry'],
                    'egress'       => $movimiento['egress'],
                    'balance'      => $balance_compra,
                    'deposito'     => $movement_temp->deposito,
                ]);

                // Generar la venta directa si viene el Id de Store
                if ($tienda) {
                    // Ajusto STOCK DE NAVE - "RESTO ENTRADA"
                    if ($movimiento['cyo'] == 1) {
                        $product->stock_cyo = $product->stock_cyo - $movimiento['entry'];
                    } elseif ($movimiento['invoice'] == 1) {
                        $product->stock_f = $product->stock_f - $movimiento['entry'];
                    }

                    $product->save();
                    $balance_nave = $product->stockReal();

                    // Ajusto STOCK TIENDA DESTINO - "SUMO ENTRADA"
                    $prod_store = ProductStore::where('product_id', $product->id)->where('store_id', $tienda)->first();

                    if ($prod_store) {
                        $prod_store->stock_f += $movimiento['entry'];
                        $prod_store->save();
                        //
                        $balance_tienda = $prod_store->stock_f + $prod_store->stock_r + $prod_store->stock_cyo;
                    } else {
                        $data_prod_store['product_id'] = $product->product_id;
                        $data_prod_store['store_id']   = $tienda;
                        $data_prod_store['stock_f']    = $movimiento['entry'];
                        $data_prod_store['stock_r']    = 0;
                        $data_prod_store['stock_cyo']  = 0;
                        ProductStore::create($data_prod_store);
                        //
                        $balance_tienda = $movimiento['entry'];
                    }

                    $excepcion = false;

                    // busco el producto en session oferta ordenados asc para tomar el primero
                    $session_oferta = SessionOferta::where('fecha_desde', '<=', Carbon::parse(now())->format('Y-m-d'))
                        ->where('product_id', $product->id)
                        ->orderBy('fecha_hasta', 'ASC')
                        ->first();

                    if ($session_oferta) {
                        // si existe una oferta busco si esa oferta es una excepcion
                        $ofertaStore = OfertaStore::where('session_id', $session_oferta->id)->first();

                        if ($ofertaStore) {
                            // si la oferta esta en oferta_store es porque es una excepcion y solo se aplica a la store vinculada
                            $excepcion = true;
                            if ($ofertaStore->store_id == $tienda) {
                                // si la store a la que envio esta en la oferta_store aplica la oferta
                                $prices = $session_oferta;
                            } else {
                                // si la store a la que envio NO esta en la oferta_store NO s aplica la oferta
                                $prices = $product->product_price;
                            }
                        } else {
                            // como existe la oferta y no esta en oferta_store (excepcion) los precios son de la oferta
                            $prices = $session_oferta;
                        }
                    } else {
                        $prices = $product->product_price;
                    }

                    // $invoice = 1; Lo comento , no se porque lo puso siempre facturado
                    $invoice = ($circuito == 'CyO') ? 1 : $movimiento['invoice'];
                    // Movimiento SALIDA FENOVO
                    MovementProduct::create([
                        'movement_id'  => $movement_venta->id,
                        'entidad_id'   => 1,
                        'entidad_tipo' => 'S',
                        'product_id'   => $movimiento['product_id'],
                        'unit_package' => $movimiento['unit_package'],
                        'invoice'      => $invoice,
                        'iibb'         => $product->iibb,
                        'unit_price'   => $prices->plist0neto,       //
                        'cost_fenovo'  => $prices->costfenovo,
                        'tasiva'       => $prices->tasiva,
                        'unit_type'    => $movimiento['unit_type'],
                        'entry'        => 0,
                        'bultos'       => $movimiento['bultos'],
                        'egress'       => $movimiento['entry'],
                        'balance'      => $balance_nave,
                        'punto_venta'  => ($circuito == 'CyO') ? $product->proveedor->punto_venta : 18,
                        'circuito'     => $circuito,
                        'cyo'          => ($circuito == 'CyO') ? 1 : 0,

                    ]);

                    // MOVIMIENTO ENTRADA TIENDA DESTINO
                    MovementProduct::create([
                        'movement_id'  => $movement_venta->id,
                        'entidad_id'   => $tienda,
                        'entidad_tipo' => 'S',
                        'product_id'   => $movimiento['product_id'],
                        'unit_package' => $movimiento['unit_package'],
                        'invoice'      => $invoice,
                        'cost_fenovo'  => $prices->costfenovo,
                        'unit_price'   => $prices->plist0neto,       //
                        'tasiva'       => $prices->tasiva,
                        'unit_type'    => $product->unit_type,
                        'bultos'       => $movimiento['bultos'],
                        'entry'        => $movimiento['entry'],
                        'egress'       => 0,
                        'balance'      => $balance_tienda,
                        'punto_venta'  => ($circuito == 'CyO') ? $product->proveedor->punto_venta : 18,
                        'circuito'     => $circuito,
                        'cyo'          => ($circuito == 'CyO') ? 1 : 0,
                    ]);

                    // Acumulo el total de ventas
                    $totalVta += $prices->plist0neto * $movimiento['entry'];
                }
            }

            if ($tienda) {
                // Calculo de Flete // En caso de corresponder
                $flete      = 0;
                $porcentaje = 0;
                $store      = Store::find($tienda);
                $km         = $store->delivery_km;
                if ($km) {
                    $fleteSetting = FleteSetting::where('hasta', '>=', $km)->orderBy('hasta', 'ASC')->first();
                    $porcentaje   = $fleteSetting->porcentaje;
                    $flete        = round((($porcentaje * $totalVta) / 100), 2);
                }

                // Actualizo valor del flete y guardo

                // $movement_venta->flete = $flete;
                // $movement_venta->save();
            }

            // Elimino el Movimiento temporal
            MovementTemp::find($request->id)->delete();
            MovementProductTemp::whereMovementId($request->id)->delete();

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return redirect()->route('ingresos.index');
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
    public function checkedCerrada(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            // Obtengo los datos del movimiento
            $movement         = Movement::find($request->id);
            $movement->status = 'CHECKED';
            $movement->save();

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return redirect()->route('ingresos.indexCerradas');
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
    public function show(Request $request)
    {
        $movement = (!$request->is_cerrada)
            ? MovementTemp::query()->where('id', $request->id)->with('movement_ingreso_products')->first()
            : Movement::query()->where('id', $request->id)->with('movement_ingreso_products')->first();
        $ajustes = $this->enumRepository->getType('ajustes');

        $productos   = $this->productRepository->getByProveedorIdPluck($movement->from);
        $movimientos = $movement->movement_ingreso_products;

        return view('admin.movimientos.ingresos.show', compact('movement', 'movimientos', 'ajustes', 'productos'));
    }
    public function destroy(Request $request)
    {
        Movement::find($request->id)->update(['status' => 'CANCELED']);
        return new JsonResponse(
            [
                'msj'  => 'Eliminado ... ',
                'type' => 'success',
            ]
        );
    }
    public function destroyTemp(Request $request)
    {
        MovementTemp::find($request->id)->delete();
        return new JsonResponse(
            ['msj'     => 'Eliminado ... ',
                'type' => 'success', ]
        );
    }
    public function getProveedorIngreso(Request $request)
    {
        $term        = $request->term ?: '';
        $valid_names = [];

        $proveedors = $this->proveedorRepository->search($term);
        foreach ($proveedors as $proveedor) {
            $valid_names[] = ['id' => $proveedor->id, 'text' => $proveedor->displayName()];
        }

        return new JsonResponse($valid_names);
    }
    public function indexAjustarStock(Request $request)
    {
        if ($request->ajax()) {
            $movement = MovementTemp::whereType('AJUSTE')->orderBy('date', 'DESC')->get();

            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->From($movement->type);
                })
                ->addColumn('destino', function ($movement) {
                    return $movement->To($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('d-m-Y', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    return '<span class="badge badge-primary">' . count($movement->movement_ingreso_products) . '</span>';
                })
                ->addColumn('voucher', function ($movement) {
                    return  $movement->voucher_number;
                })
                ->addColumn('accion', function ($movement) {
                    return ($movement->status == 'FINISHED')
                    ? '<a href="' . route('ingresos.ajustarStockDepositos.show', ['id' => $movement->id]) . '"> <i class="fa fa-eye"></i> </a>'
                    : '<a href="' . route('ingresos.ajustarStockDepositos.edit', ['id' => $movement->id]) . '"> <i class="fa fa-pencil-alt"></i> </a>';
                })
                ->addColumn('borrar', function ($movement) {
                    $ruta = 'destroy(' . $movement->id . ",'" . route('ingresos.destroyTemp') . "')";
                    return ($movement->status == 'CREATED') ? '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>' : null;
                })

                ->rawColumns(['origen', 'destino', 'date', 'items', 'voucher', 'accion', 'borrar'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.indexAjustes');
    }
    public function ajustarStockDepositos(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();
            $number   = date('d') . date('m') . date('y') . date('H') . date('i');
            $movement = MovementTemp::create([
                'date'           => now(),
                'type'           => 'AJUSTE',
                'from'           => 0,
                'to'             => 0,
                'user_id'        => \Auth::user()->id,
                'status'         => 'CREATED',
                'voucher_number' => $number,
            ]);

            $voucher_number           = $number . '-' . $movement->id;
            $movement->voucher_number = $voucher_number;
            $movement->save();

            DB::commit();
            Schema::enableForeignKeyConstraints();
            return redirect()->route('ingresos.ajustarStockDepositos.edit', ['id' => $movement->id]);
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
    public function ajustarStockDepositosEdit(Request $request)
    {
        $movement    = MovementTemp::find($request->id);
        $productos   = Product::selectRaw('id, CONCAT(name," - ",cod_fenovo) as nombreCompleto')->orderBy('name')->pluck('nombreCompleto', 'id');
        $stores      = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->get();
        $movimientos = MovementProductTemp::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
        return view('admin.movimientos.ingresos.ajustar', compact('movement', 'productos', 'stores', 'movimientos'));
    }
    public function ajustarStockDepositosShow(Request $request)
    {
        $movement    = Movement::query()->where('id', $request->id)->with('movement_ingreso_products')->first();
        $movimientos = $movement->movement_ingreso_products;
        return view('admin.movimientos.ingresos.showAjustes', compact('movement', 'movimientos'));
    }
    public function ajustarStockStoreDetalle(Request $request)
    {
        try {
            $hoy = Carbon::parse(now())->format('Y-m-d');

            foreach ($request->datos as $key => $movimiento) {
                // Actualizo Origen y Destino del Ajuste
                if ($key == 0) {
                    $movement_temp       = MovementTemp::find($movimiento['movement_id']);
                    $movement_temp->from = $movimiento['tiendaEgreso'];
                    $movement_temp->to   = $movimiento['tiendaIngreso'];
                    $movement_temp->save();
                }

                $product = Product::find($movimiento['product_id']);

                // Buscar si el producto tiene oferta del proveedor
                $oferta = DB::table('products as t1')
                    ->join('session_ofertas as t2', 't1.id', '=', 't2.product_id')
                    ->select('t2.costfenovo', 't2.plist0neto')
                    ->where('t1.id', $movimiento['product_id'])
                    ->where('t2.fecha_desde', '<=', $hoy)
                    ->where('t2.fecha_hasta', '>=', $hoy)
                    ->first();
                $costo_fenovo = (!$oferta) ? $product->product_price->costfenovo : $oferta->costfenovo;
                $unit_price   = (!$oferta) ? $product->product_price->plist0neto : $oferta->plist0neto;

                MovementProductTemp::firstOrCreate(
                    [
                        'entidad_id'   => $movimiento['tiendaEgreso'],
                        'entidad_tipo' => 'S',
                        'movement_id'  => $movimiento['movement_id'],
                        'product_id'   => $movimiento['product_id'],
                        'tasiva'       => $product->product_price->tasiva,
                        'cost_fenovo'  => $costo_fenovo,
                        'unit_price'   => $unit_price,
                        'unit_package' => $movimiento['unit_package'],
                        'unit_type'    => $movimiento['unit_type'],
                    ],
                    $movimiento
                );
            }
            return new JsonResponse(['msj' => 'Guardado', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function getMovements(Request $request)
    {
        try {
            $movimientos = MovementProductTemp::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
            return new JsonResponse([
                'data' => $movimientos,
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleConfirmAjuste', compact('movimientos'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function check(Request $request)
    {
        try {
            $productId      = $request->productId;
            $producto       = Product::find($productId);
            $presentaciones = explode('|', $producto->unit_package);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleTemp', compact('producto', 'presentaciones'))->render(),

            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function ajustarStockDepositosClose(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            $movement_id   = $request->id;
            $tiendaIngreso = $request->tiendaIngreso;
            $tiendaEgreso  = $request->tiendaEgreso;

            // Obtengo los datos del movimiento
            $movement_temp = MovementTemp::where('id', $movement_id)->with('movement_products')->first();

            $count = Movement::where('to', $tiendaIngreso)->where('type', 'AJUSTE')->count();
            $orden = ($count) ? $count + 1 : 1;

            // Guardo el nuevo movimiento
            $data['type']           = 'AJUSTE';
            $data['to']             = $tiendaIngreso;
            $data['from']           = $tiendaEgreso;
            $data['date']           = $movement_temp->date;
            $data['orden']          = $orden;
            $data['status']         = 'FINISHED';
            $data['voucher_number'] = $movement_temp->voucher_number;
            $data['flete']          = $movement_temp->flete;
            $data['observacion']    = 'Aj. depósitos desde ' . str_pad($tiendaEgreso, 3, '0', STR_PAD_LEFT) . ' hacia ' . str_pad($tiendaIngreso, 3, '0', STR_PAD_LEFT);
            $data['user_id']        = \Auth::user()->id;
            $data['flete_invoice']  = 0;
            $movement_new           = Movement::create($data);

            $hoy = Carbon::parse(now())->format('Y-m-d');

            // Recorro el arreglo y voy guardando
            foreach ($movement_temp->movement_products as $movimiento) {
                $cantidad = $movimiento['entry'];

                $latest_tienda_egreso  = 0;
                $latest_tienda_ingreso = 0;

                // Ajustar tiendaEgreso
                if ($tiendaEgreso == 1) {
                    $product          = Product::find($movimiento['product_id']);
                    $product->stock_f = $product->stock_f - $cantidad;
                    $product->save();
                    $latest_tienda_egreso = $product->stockReal();
                } else {
                    $product_store = ProductStore::whereProductId($movimiento['product_id'])->whereStoreId($tiendaEgreso)->first();

                    if ($product_store) {
                        // Si la cantidad a devolver es suficiente
                        if ($product_store->stock_f >= $cantidad) {
                            $product_store->stock_f = $product_store->stock_f - $cantidad;
                        } else {
                            $nuevaCantidad          = ($cantidad - $product_store->stock_f);
                            $product_store->stock_f = 0;
                            if ($product_store->stock_r >= $nuevaCantidad) {
                                $product_store->stock_r = $product_store->stock_r - $nuevaCantidad;
                            }
                        }

                        $product_store->save();
                        $latest_tienda_egreso = $product_store->stock_f + $product_store->stock_r + $product_store->stock_cyo;
                    } else {
                        $latest_tienda_egreso          = 0 - $cantidad;
                        $data_prod_store['product_id'] = $movimiento['product_id'];
                        $data_prod_store['store_id']   = $tiendaEgreso;
                        $data_prod_store['stock_f']    = $latest_tienda_egreso;
                        $data_prod_store['stock_r']    = 0;
                        $data_prod_store['stock_cyo']  = 0;
                        ProductStore::create($data_prod_store);
                    }
                }

                // Ingreso el movimiento
                MovementProduct::create([
                    'entidad_id'   => $tiendaEgreso,
                    'movement_id'  => $movement_new->id,
                    'entidad_tipo' => 'S',
                    'product_id'   => $movimiento['product_id'],
                    'unit_package' => $movimiento['unit_package'],
                    'unit_type'    => $movimiento['unit_type'],
                    'tasiva'       => $movimiento['tasiva'],
                    'cost_fenovo'  => $movimiento['cost_fenovo'],
                    'unit_price'   => $movimiento['unit_price'],
                    'invoice'      => $movimiento['invoice'],
                    'circuito'     => 'F',
                    'cyo'          => $movimiento['cyo'],
                    'bultos'       => $movimiento['bultos'],
                    'entry'        => 0,
                    'egress'       => $cantidad,
                    'balance'      => $latest_tienda_egreso,
                ]);

                // Ajustar tiendaIngreso
                if ($tiendaIngreso == 1) {
                    $product          = Product::find($movimiento['product_id']);
                    $product->stock_f = $product->stock_f + $cantidad;
                    $product->save();
                    $latest_tienda_ingreso = $product->stockReal();
                } else {
                    $product_store = ProductStore::whereProductId($movimiento['product_id'])->whereStoreId($tiendaIngreso)->first();
                    if ($product_store) {
                        $product_store->stock_f = $product_store->stock_f + $cantidad;
                        $product_store->save();
                        $latest_tienda_ingreso = $product_store->stock_f + $product_store->stock_r + $product_store->stock_cyo;
                    } else {
                        $latest_tienda_ingreso         = $cantidad;
                        $data_prod_store['product_id'] = $movimiento['product_id'];
                        $data_prod_store['store_id']   = $tiendaIngreso;
                        $data_prod_store['stock_f']    = $latest_tienda_ingreso;
                        $data_prod_store['stock_r']    = 0;
                        $data_prod_store['stock_cyo']  = 0;
                        ProductStore::create($data_prod_store);
                    }
                }

                MovementProduct::create([
                    'entidad_id'   => $tiendaIngreso,
                    'movement_id'  => $movement_new->id,
                    'entidad_tipo' => 'S',
                    'product_id'   => $movimiento['product_id'],
                    'unit_package' => $movimiento['unit_package'],
                    'unit_type'    => $movimiento['unit_type'],
                    'tasiva'       => $movimiento['tasiva'],
                    'cost_fenovo'  => $movimiento['cost_fenovo'],
                    'unit_price'   => $movimiento['unit_price'],
                    'invoice'      => $movimiento['invoice'],
                    'circuito'     => 'F',
                    'cyo'          => $movimiento['cyo'],
                    'bultos'       => $movimiento['bultos'],
                    'entry'        => $cantidad,
                    'egress'       => 0,
                    'balance'      => $latest_tienda_ingreso,
                ]);
            }

            // Elimino el Movimiento temporal
            MovementTemp::find($request->id)->delete();
            MovementProductTemp::whereMovementId($request->id)->delete();

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return new JsonResponse([
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
    public function ajustarIngresoItem(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            $cantidad = $request->bultos_actual * $request->unit_package;

            // Actualizo el movimiento mal ingresado
            MovementProduct::where('id', $request->detalle_id)->update([
                'bultos' => $request->bultos_actual,
                'entry'  => $cantidad,
            ]);

            // Actualizar los movimientos
            $movements_products = MovementProduct::where('movement_id', '>', 611)
                ->where('product_id', $request->producto_id)
                ->where('entidad_id', Auth::user()->store_active)
                ->orderBy('movement_id', 'ASC')
                ->get();

            // Voy actualizando los stocks desde los mas viejos a los mas recientes
            for ($i = 0; $i < count($movements_products); $i++) {
                $mp = $movements_products[$i];
                $m  = Movement::where('id', $mp->movement_id)->first();

                if ($i == 0) {
                    $balance_orig = $new_balance = $mp->balance;
                }

                if ($i > 0) {
                    $cantidad = $mp->bultos * $mp->unit_package;

                    if ($mp->entry > 0) {
                        $new_balance  = $balance_orig + $cantidad;
                        $balance_orig = $new_balance;

                        MovementProduct::where('id', $mp->id)->update([
                            'balance' => $new_balance,
                            'entry'   => $cantidad,
                        ]);
                    } elseif ($mp->egress > 0) {
                        $new_balance  = $balance_orig - $cantidad;
                        $balance_orig = $new_balance;

                        MovementProduct::where('id', $mp->id)->update([
                            'balance' => $new_balance,
                            'egress'  => $cantidad,
                        ]);
                    }
                }
            }

            // Obtengo el Stock de los movimientos
            $produ = MovementProduct::whereEntidadId(Auth::user()->store_active)
                ->whereProductId($request->producto_id)
                ->orderBy('id', 'DESC')->limit(1)->first();
            $stock = ($produ) ? $produ->balance : 0;

            // Obtengo el producto
            $producto = Product::find($request->producto_id);

            // Obtengo el coeficiente de Stock
            $parametro = Coeficiente::find($request->producto_id);

            // Reviso los stocks y actualizo
            $producto->stock_f = $stock          * ($parametro->coeficiente / 100);
            $producto->stock_r = $stock - $stock * ($parametro->coeficiente / 100);
            $producto->save();

            // Fin actualizacion
            DB::commit();
            Schema::enableForeignKeyConstraints();

            //
            $movement    = Movement::query()->where('id', $request->movimiento_id)->with('movement_ingreso_products')->first();
            $movimientos = $movement->movement_ingreso_products;

            return new JsonResponse([
                'html' => view('admin.movimientos.ingresos.detalleIngresoShow', compact('movement', 'movimientos'))->render(),
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    // NO CONGELADOS

    public function checkVoucher(Request $request)
    {
        $compra = Movement::whereVoucherNumber($request->voucher)->whereFrom($request->proveedorId)->whereSubtype($request->subtype)->first();
        if ($compra) {
            return new JsonResponse(['msj' => 'Compra registrada ...', 'type' => 'success']);
        }
        return new JsonResponse(['msj' => 'Compra no registrada ...', 'type' => 'error']);
    }
    public function addNoCongelados()
    {
        $proveedores = Proveedor::orderBy('name')->pluck('name', 'id');
        $depositos   = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->where('store_type', 'D')->get();
        $states      = $this->enumRepository->getType('state');
        $ivaType     = $this->enumRepository->getType('iva');

        return view('admin.movimientos.ingresosNoCongelados.add', compact('proveedores', 'depositos', 'states', 'ivaType'));
    }
    public function storeNoCongelados(Request $request)
    {
        $data            = $request->all();
        $data['user_id'] = \Auth::user()->id;
        $movement        = MovementTemp::create($data);
        return redirect()->route('ingresos.editNocongelados', ['id' => $movement->id]);
    }
    public function editNoCongelados(Request $request)
    {
        $movement    = MovementTemp::find($request->id);
        $proveedor   = Proveedor::find($movement->from);
        $movimientos = MovementProductTemp::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
        $depositos   = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->where('store_type', 'D')->get();

        $productos  = Product::where('proveedor_id', '=', $movement->from)->orderBy('name')->get();
        $proximo    = (int)Product::where('categorie_id', '!=', 1)->max('cod_fenovo') + 1;
        $categories = $this->productCategoryRepository->getActives('name', 'ASC');
        $descuentos = $this->descuentoRepository->getActives('descripcion', 'ASC');

        return view(
            'admin.movimientos.ingresosNoCongelados.edit',
            compact('movement', 'proveedor', 'productos', 'movimientos', 'depositos', 'categories', 'descuentos', 'proximo')
        );
    }
    public function checkNoCongelados(Request $request)
    {
        $movement    = Movement::find($request->id);
        $productos   = $this->productRepository->getByProveedorIdPluck($movement->from);
        $proveedor   = Proveedor::find($movement->from);
        $movimientos = MovementProduct::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
        $depositos   = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->where('store_type', 'D')->get();
        $comprobante = InvoiceCompra::where('movement_id', $request->id)->first();
        return view(
            'admin.movimientos.ingresosNoCongelados.check',
            compact('movement', 'proveedor', 'productos', 'movimientos', 'depositos', 'comprobante')
        );
    }
    public function editProductNoCongelados(Request $request)
    {
        try {
            $product = Product::find($request->id);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresosNoCongelados.modalEditProducto', compact('product'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function updateProductNoCongelados(Request $request)
    {
        try {
            $dataprice['plistproveedor'] = $request->plistproveedor;
            $dataprice['descproveedor']  = $request->descproveedor;
            $dataprice['costfenovo']     = $request->costfenovo;
            $dataprice['mupfenovo']      = $request->mupfenovo;
            $dataprice['plist0neto']     = $request->plist0neto;
            ProductPrice::whereProductId($request->product_id)->update($dataprice);

            return new JsonResponse(['msj' => 'Actualización correcta !', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function closeNoCongelados(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            // Obtengo los datos del movimiento
            $movement_temp = MovementTemp::where('id', $request->Detalle['id'])->with('movement_ingreso_products')->first();

            $count = Movement::where('to', 1)->where('type', 'COMPRA')->count();
            $orden = ($count) ? $count + 1 : 1;

            // Completo los datos del movimiento de COMPRA
            $data['type']           = 'COMPRA';
            $data['subtype']        = $movement_temp->subtype;
            $data['categoria']      = 2;
            $data['to']             = ($movement_temp->deposito) ? $movement_temp->deposito : 1;
            $data['date']           = $movement_temp->date;
            $data['from']           = $movement_temp->from;
            $data['orden']          = $orden;
            $data['status']         = 'FINISHED';
            $data['voucher_number'] = $movement_temp->voucher_number;
            $data['flete']          = 0;
            $data['observacion']    = $movement_temp->observacion;
            $data['user_id']        = \Auth::user()->id;
            $data['flete_invoice']  = 0;
            $movement_compra        = Movement::create($data);

            // Guardar detalle de compra
            $dataCompra['movement_id'] = $movement_compra->id;
            $dataCompra['l25413']      = $request->Detalle['l25413'];
            $dataCompra['retater']     = $request->Detalle['retater'];
            $dataCompra['retiva']      = $request->Detalle['retiva'];
            $dataCompra['retgan']      = $request->Detalle['retgan'];
            $dataCompra['nograv']      = $request->Detalle['nograv'];
            $dataCompra['percater']    = $request->Detalle['percater'];
            $dataCompra['perciva']     = $request->Detalle['perciva'];
            $dataCompra['exento']      = $request->Detalle['exento'];
            $dataCompra['totalIva10']  = $request->Detalle['totalIva10'];
            $dataCompra['totalIva21']  = $request->Detalle['totalIva21'];
            $dataCompra['totalIva27']  = $request->Detalle['totalIva27'];
            $dataCompra['totalNeto10'] = $request->Detalle['totalNeto10'];
            $dataCompra['totalNeto21'] = $request->Detalle['totalNeto21'];
            $dataCompra['totalNeto27'] = $request->Detalle['totalNeto27'];
            $dataCompra['totalCompra'] = $request->Detalle['totalCompra'];
            InvoiceCompra::create($dataCompra);
            //

            $circuito = '';
            if (in_array($movement_temp->subtype, ['FA', 'FB', 'FC', 'FM'])) {
                $circuito = 'F';
            }
            if ($movement_temp->subtype == 'REMITO') {
                $circuito = 'R';
            }
            if ($movement_temp->subtype == 'CYO') {
                $circuito = 'CyO';
            }

            // Considerar cada uno de los movimientos
            foreach ($movement_temp->movement_ingreso_products as $movimiento) {
                // Ajusto el STOCK DEL PRODUCTO luego de la compra
                $product        = Product::find($movimiento['product_id']);
                $latest         = $product->stockReal();
                $balance_compra = ($latest) ? $latest + $movimiento['entry'] : $movimiento['entry'];
                //
                if ($movimiento['cyo']) {
                    $product->stock_cyo = $product->stock_cyo + $movimiento['entry'];
                } elseif ($movimiento['invoice']) {
                    $product->stock_f = $product->stock_f + $movimiento['entry'];
                } else {
                    $product->stock_r = $product->stock_r + $movimiento['entry'];
                }
                $product->save();
                $entidad_tipo = 'S';

                if (!is_null($movement_temp->deposito)) {
                    $stock_cyo  = $stock_f = $stock_r = 0;
                    $prod_store = ProductStore::where('product_id', $movimiento['product_id'])->where('store_id', $movement_temp->deposito)->first();

                    if ($movimiento['cyo']) {
                        ($prod_store) ? $prod_store->stock_cyo = $prod_store->stock_cyo + $movimiento['entry'] : $stock_cyo = $movimiento['entry'];
                    } elseif ($movimiento['invoice']) {
                        ($prod_store) ? $prod_store->stock_f = $prod_store->stock_f + $movimiento['entry'] : $stock_f = $movimiento['entry'];
                    } else {
                        ($prod_store) ? $prod_store->stock_r = $prod_store->stock_r + $movimiento['entry'] : $stock_r = $movimiento['entry'];
                    }
                    if ($prod_store) {
                        $prod_store->save();
                    } else {
                        ProductStore::create([
                            'product_id' => $movimiento['product_id'],
                            'store_id'   => $movement_temp->deposito,
                            'stock_cyo'  => $stock_cyo,
                            'stock_f'    => $stock_f,
                            'stock_r'    => $stock_r,
                        ]);
                    }

                    $entidad_tipo = 'D';
                }

                // Registro el detalle de la compra
                MovementProduct::create([
                    'entidad_id'   => Auth::user()->store_active,
                    'movement_id'  => $movement_compra->id,
                    'entidad_tipo' => $entidad_tipo,
                    'product_id'   => $movimiento['product_id'],
                    'unit_package' => $movimiento['unit_package'],
                    'unit_type'    => $movimiento['unit_type'],
                    'tasiva'       => $movimiento['tasiva'],
                    'cost_fenovo'  => $movimiento['cost_fenovo'],
                    'unit_price'   => $movimiento['unit_price'],
                    'invoice'      => $movimiento['invoice'],
                    'circuito'     => $circuito,
                    'bultos'       => $movimiento['bultos'],
                    'entry'        => $movimiento['entry'],
                    'egress'       => $movimiento['egress'],
                    'balance'      => $balance_compra,
                    'deposito'     => $movement_temp->deposito,
                ]);
            }

            // Elimino el Movimiento temporal
            MovementTemp::find($request->Detalle['id'])->delete();
            MovementProductTemp::whereMovementId($request->Detalle['id'])->delete();

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return new JsonResponse(['msj' => 'Compra guardada', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    // No congelados Chequeo de Compra
    public function editProductNoCongeladosCheck(Request $request)
    {
        try {
            $product      = Product::find($request->id);
            $unit_package = explode('|', $product->unit_package);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresosNoCongelados.insertByAjaxCheck', compact('product', 'unit_package'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function updateProductNoCongeladosCheck(Request $request)
    {
        try {
            $data['unit_package'] = implode('|', $request->unit_package);
            $data['unit_weight']  = $request->unit_weight;
            Product::find($request->product_id)->update($data);

            $dataprice['plistproveedor']    = $request->plistproveedor;
            $dataprice['descproveedor']     = $request->descproveedor;
            $dataprice['costfenovo']        = $request->costfenovo;
            $dataprice['mupfenovo']         = $request->mupfenovo;
            $dataprice['contribution_fund'] = $request->contribution_fund;
            $dataprice['plist0neto']        = $request->plist0neto;
            ProductPrice::whereProductId($request->product_id)->update($dataprice);

            return new JsonResponse(['msj' => 'Actualización correcta !', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function closeNoCongeladosCheck(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            $movement_id = $request->Detalle['id'];

            // Actualizo el movimiento para cerrarlo
            $movement = Movement::find($movement_id)->update(['status' => 'CHECKED']);

            // Actualizar detalle de compra
            $dataCompra['l25413']      = $request->Detalle['l25413'];
            $dataCompra['retater']     = $request->Detalle['retater'];
            $dataCompra['retiva']      = $request->Detalle['retiva'];
            $dataCompra['retgan']      = $request->Detalle['retgan'];
            $dataCompra['nograv']      = $request->Detalle['nograv'];
            $dataCompra['percater']    = $request->Detalle['percater'];
            $dataCompra['perciva']     = $request->Detalle['perciva'];
            $dataCompra['exento']      = $request->Detalle['exento'];
            $dataCompra['totalIva10']  = $request->Detalle['totalIva10'];
            $dataCompra['totalIva21']  = $request->Detalle['totalIva21'];
            $dataCompra['totalIva27']  = $request->Detalle['totalIva27'];
            $dataCompra['totalNeto10'] = $request->Detalle['totalNeto10'];
            $dataCompra['totalNeto21'] = $request->Detalle['totalNeto21'];
            $dataCompra['totalNeto27'] = $request->Detalle['totalNeto27'];
            $dataCompra['totalCompra'] = $request->Detalle['totalCompra'];

            InvoiceCompra::where('movement_id', $movement_id)->update($dataCompra);
            //

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return new JsonResponse(['msj' => 'Compra guardada', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
}
