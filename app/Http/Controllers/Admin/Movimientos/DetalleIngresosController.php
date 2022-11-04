<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\InvoiceCompra;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\MovementProductTemp;
use App\Models\Product;
use App\Models\ProductStore;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DetalleIngresosController extends Controller
{
    public function store(Request $request)
    {
        try {
            $hoy = Carbon::parse(now())->format('Y-m-d');

            foreach ($request->datos as $movimiento) {
                $product               = Product::find($movimiento['product_id']);
                $latest                = $product->stockReal(null, Auth::user()->store_active);
                $balance               = ($latest) ? $latest + $movimiento['entry'] : $movimiento['entry'];
                $movimiento['balance'] = $balance;

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

                MovementProductTemp::Create(
                    [
                        'movement_id'  => $movimiento['movement_id'],
                        'entidad_id'   => Auth::user()->store_active,
                        'entidad_tipo' => 'S',
                        'product_id'   => $movimiento['product_id'],
                        'tasiva'       => $product->product_price->tasiva,
                        'cost_fenovo'  => $costo_fenovo,
                        'unit_price'   => $unit_price,
                        'bultos'       => $movimiento['bultos'],
                        'entry'        => $movimiento['entry'],
                        'balance'      => $balance,
                        'egress'       => 0,
                        'unit_package' => $movimiento['unit_package'],
                        'unit_type'    => $movimiento['unit_type'],
                        'invoice'      => $movimiento['invoice'],
                        'cyo'          => $movimiento['cyo'],
                    ],
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
                'html' => view('admin.movimientos.ingresos.detalleConfirm', compact('movimientos'))->render(),
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

    public function destroy(Request $request)
    {
        try {
            MovementProductTemp::where('movement_id', $request->movement_id)->where('product_id', $request->product_id)->delete();
            $movimientos = MovementProductTemp::where('movement_id', $request->movement_id)->orderBy('id', 'desc')->get();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleConfirm', compact('movimientos'))->render(),
            ]);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleTemp', compact('producto', 'presentaciones'))->render(),

            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function storeCerrada(Request $request)
    {
        try {
            $hoy = Carbon::parse(now())->format('Y-m-d');

            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            foreach ($request->datos as $movimiento) {
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

                MovementProduct::Create(
                    [
                        'movement_id'  => $movimiento['movement_id'],
                        'entidad_id'   => 1,
                        'entidad_tipo' => 'S',
                        'product_id'   => $movimiento['product_id'],
                        'tasiva'       => $product->product_price->tasiva,
                        'cost_fenovo'  => $costo_fenovo,
                        'unit_price'   => $unit_price,
                        'bultos'       => $movimiento['bultos'],
                        'entry'        => $movimiento['entry'],
                        'balance'      => 0,
                        'egress'       => 0,
                        'circuito'     => $movimiento['circuito'],
                        'unit_package' => $movimiento['unit_package'],
                        'unit_type'    => $movimiento['unit_type'],
                        'invoice'      => $movimiento['invoice'],
                        'cyo'          => $movimiento['cyo'],
                    ],
                );

                // Actualizo el producto
                if ($movimiento['circuito'] == 'F') {
                    $product->stock_f = $product->stock_f + $movimiento['entry'];
                } elseif ($movimiento['circuito'] == 'R') {
                    $product->stock_r = $product->stock_r + $movimiento['entry'];
                } else {
                    $product->stock_cyo = $product->stock_cyo + $movimiento['entry'];
                }
                $product->save();

                // Obtengo los movimientos
                $movements_products = MovementProduct::where('movement_id', '>', 611)
                    ->where('product_id', $movimiento['product_id'])
                    ->where('entidad_id', 1)
                    ->orderBy('id', 'ASC')
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
            }
            
            // Busco rearmar el detalle luego de borrar los registros
            $movement    = Movement::query()->where('id', $movimiento['movement_id'])->with('movement_ingreso_products')->first();
            $movimientos = $movement->movement_ingreso_products;

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return new JsonResponse([
                'html' => view('admin.movimientos.ingresos.detalleIngresoShow', compact('movement', 'movimientos'))->render(),
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            return  new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function deleteCompraItems(Request $request)
    {
        try {
            $arrIds = $request->arrId;

            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            foreach ($arrIds as $id) {
                // Obtengo el movimiento
                $movi = MovementProduct::find($id);

                // Obtengo los datos del movimiento
                $circuito = $movi->circuito;
                $product  = Product::find($movi->product_id);

                // Actualizo el producto
                if ($circuito == 'F') {
                    $product->stock_f = $product->stock_f - $movi->entry;
                } else {
                    $product->stock_r = $product->stock_r - $movi->entry;
                }
                $product->save();

                // Elimino el movimiento
                $movi->delete();

                // Obtengo los movimientos
                $movements_products = MovementProduct::where('movement_id', '>', 611)
                    ->where('product_id', $movi->product_id)
                    ->where('entidad_id', 1)
                    ->orderBy('id', 'ASC')
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
            }

            // Busco rearmar el detalle luego de borrar los registros
            $movement    = Movement::query()->where('id', $movi->movement_id)->with('movement_ingreso_products')->first();
            $movimientos = $movement->movement_ingreso_products;

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return new JsonResponse([
                'html' => view('admin.movimientos.ingresos.detalleIngresoShow', compact('movement', 'movimientos'))->render(),
                'type' => 'success',
                'msj'  => 'ok',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            return  new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    // No congelados

    public function checkNoCongelados(Request $request)
    {
        try {
            $productId      = $request->productId;
            $producto       = Product::find($productId);
            $presentaciones = explode('|', $producto->unit_package);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresosNoCongelados.detalleTemp', compact('producto', 'presentaciones'))->render(),

            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function checkNoCongeladosCheck(Request $request)
    {
        try {
            $productId      = $request->productId;
            $producto       = Product::find($productId);
            $presentaciones = explode('|', $producto->unit_package);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresosNoCongelados.detalleTempCheck', compact('producto', 'presentaciones'))->render(),

            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function storeNoCongelados(Request $request)
    {
        try {
            $hoy         = Carbon::parse(now())->format('Y-m-d');
            $movement_id = $request->datos[0]['movement_id'];

            foreach ($request->datos as $movimiento) {
                $product               = Product::find($movimiento['product_id']);
                $latest                = $product->stockReal(null, Auth::user()->store_active);
                $balance               = ($latest) ? $latest + $movimiento['entry'] : $movimiento['entry'];
                $movimiento['balance'] = $balance;

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
                        'entidad_id'   => Auth::user()->store_active,
                        'movement_id'  => $movimiento['movement_id'],
                        'product_id'   => $movimiento['product_id'],
                        'tasiva'       => $product->product_price->tasiva,
                        'cost_fenovo'  => $costo_fenovo,
                        'unit_price'   => $unit_price,
                        'unit_package' => $movimiento['unit_package'],
                        'unit_type'    => $movimiento['unit_type'],
                        'invoice'      => $movimiento['invoice'],
                        'cyo'          => $movimiento['cyo'],
                    ],
                    $movimiento
                );
            }

            $movimientos = MovementProductTemp::where('movement_id', $movement_id)->orderBy('id', 'desc')->get();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresosNoCongelados.detalleConfirm', compact('movimientos'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function storeNoCongeladosCheck(Request $request)
    {
        try {
            $hoy         = Carbon::parse(now())->format('Y-m-d');
            $movement_id = $request->datos['movement_id'];
            $movimiento  = $request->datos;

            // Actualizo el Stock del producto
            $product = Product::find($movimiento['product_id']);
            $latest  = $product->stockReal(null, Auth::user()->store_active);
            $balance = ($latest) ? $latest + $movimiento['entry'] : $movimiento['entry'];

            if ($movimiento['circuito'] == 'F') {
                $product->stock_f += $balance;
            } elseif ($movimiento['circuito'] == 'R') {
                $product->stock_r += $balance;
            }
            $product->save();

            // Actualizo el Stock del producto en Product_store
            if (!is_null($movimiento['deposito'])) {
                $stock_cyo  = $stock_f = $stock_r = 0;
                $prod_store = ProductStore::where('product_id', $movimiento['product_id'])->where('store_id', $movimiento['deposito'])->first();
                if ($prod_store) {
                    if ($movimiento['circuito'] == 'F') {
                        $prod_store->stock_f = $prod_store->stock_f + $movimiento['entry'];
                    } else {
                        $prod_store->stock_r = $prod_store->stock_r + $movimiento['entry'];
                    }
                    $prod_store->save();
                } else {
                    ProductStore::create([
                        'product_id' => $movimiento['product_id'],
                        'store_id'   => $movimiento['deposito'],
                        'stock_f'    => ($movimiento['circuito'] == 'F') ? $movimiento['entry'] : 0,
                        'stock_r'    => ($movimiento['circuito'] == 'R') ? $movimiento['entry'] : 0,
                        'stock_cyo'  => $stock_cyo,
                    ]);
                }
            }

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

            $movimiento['balance'] = $product->stockReal(null, Auth::user()->store_active);

            MovementProduct::firstOrCreate(
                [
                    'entidad_id'   => Auth::user()->store_active,
                    'movement_id'  => $movimiento['movement_id'],
                    'product_id'   => $movimiento['product_id'],
                    'circuito'     => $movimiento['circuito'],
                    'tasiva'       => $product->product_price->tasiva,
                    'cost_fenovo'  => $costo_fenovo,
                    'unit_price'   => $unit_price,
                    'unit_package' => $movimiento['unit_package'],
                    'unit_type'    => $movimiento['unit_type'],
                    'invoice'      => $movimiento['invoice'],
                    'cyo'          => $movimiento['cyo'],
                    'balance'      => $movimiento['balance'],
                ],
                $movimiento
            );

            $subtotalIva  = round($costo_fenovo * $movimiento['unit_package'] * $movimiento['bultos'] * ($product->product_price->tasiva / 100), 2);
            $subtotalNeto = round($costo_fenovo * $movimiento['unit_package'] * $movimiento['bultos'], 2);

            // Descontar Iva y Neto del movimiento al comprobante
            $comprobante = InvoiceCompra::where('movement_id', $movement_id)->first();

            switch ($product->product_price->tasiva) {
                case '0.00':
                    $comprobante->exento += $subtotalNeto;
                    break;
                case '10.50':
                    $comprobante->totalIva10  += $subtotalIva;
                    $comprobante->totalNeto10 += $subtotalNeto;
                    break;
                case '21.00':
                    $comprobante->totalIva21  += $subtotalIva;
                    $comprobante->totalNeto21 += $subtotalNeto;
                    break;
                case '27.00':
                    $comprobante->totalIva27  += $subtotalIva;
                    $comprobante->totalNeto27 += $subtotalNeto;
                    break;
            }

            // Guardar
            $comprobante->totalCompra += $subtotalIva + $subtotalNeto;
            $comprobante->save();

            $movimientos = MovementProduct::where('movement_id', $movement_id)->orderBy('id', 'desc')->get();

            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresosNoCongelados.detalleConfirmCheck', compact('movimientos', 'comprobante'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroyNoCongelados(Request $request)
    {
        try {
            MovementProductTemp::where('movement_id', $request->movement_id)->where('product_id', $request->product_id)->delete();
            $movimientos = MovementProductTemp::where('movement_id', $request->movement_id)->orderBy('id', 'desc')->get();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresosNoCongelados.detalleConfirm', compact('movimientos'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroyNoCongeladosCheck(Request $request)
    {
        try {
            // Obtener el subtotal
            $movimiento = MovementProduct::where('movement_id', $request->movement_id)->where('product_id', $request->product_id)->first();

            // Actualizo el Stock del producto
            $producto = Product::where('id', $request->product_id)->first();
            if ($movimiento->circuito == 'F') {
                $producto->stock_f -= $movimiento->entry;
            } elseif ($movimiento->circuito == 'R') {
                $producto->stock_r -= $movimiento->entry;
            }
            $producto->save();

            // Actualizo el Stock del producto en Product_store
            if (!is_null($movimiento->deposito)) {
                $stock_cyo  = $stock_f = $stock_r = 0;
                $prod_store = ProductStore::where('product_id', $request->product_id)->where('store_id', $movimiento->deposito)->first();
                if ($movimiento->circuito == 'F') {
                    $prod_store->stock_f = $prod_store->stock_f - $movimiento->entry;
                } else {
                    $prod_store->stock_r = $prod_store->stock_r - $movimiento->entry;
                }
            }
            $prod_store->save();

            $subtotalIva  = round($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos * ($movimiento->tasiva / 100), 2);
            $subtotalNeto = round($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos, 2);

            // Descontar Iva y Neto del movimiento al comprobante
            $comprobante = InvoiceCompra::where('movement_id', $request->movement_id)->first();

            switch ($movimiento->tasiva) {
                case '0.00':
                    $comprobante->exento -= $subtotalNeto;
                    break;
                case '10.50':
                    $comprobante->totalIva10  -= $subtotalIva;
                    $comprobante->totalNeto10 -= $subtotalNeto;
                    break;
                case '21.00':
                    $comprobante->totalIva21  -= $subtotalIva;
                    $comprobante->totalNeto21 -= $subtotalNeto;
                    break;
                case '27.00':
                    $comprobante->totalIva27  -= $subtotalIva;
                    $comprobante->totalNeto27 -= $subtotalNeto;
                    break;
            }

            // Guardar
            $comprobante->save();

            // Eliminar el movimiento
            $movimiento->delete();

            $movimientos = MovementProduct::where('movement_id', $request->movement_id)->orderBy('id', 'desc')->get();

            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresosNoCongelados.detalleConfirmCheck', compact('movimientos', 'comprobante'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
}
