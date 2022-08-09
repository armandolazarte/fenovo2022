<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\InvoiceCompra;
use App\Models\MovementProduct;
use App\Models\MovementProductTemp;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

                MovementProduct::firstOrCreate(
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

            $subtotalIva  = round($costo_fenovo * $movimiento->unit_package * $movimiento->bultos * ($movimiento->tasiva / 100),2);
            $subtotalNeto = round($costo_fenovo * $movimiento->unit_package * $movimiento->bultos,2);

            // Descontar Iva y Neto del movimiento al comprobante
            $comprobante = InvoiceCompra::where('movement_id', $request->movement_id)->first();

            switch ($movimiento->tasiva) {
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
            $movimiento   = MovementProduct::where('movement_id', $request->movement_id)->where('product_id', $request->product_id)->first();
            $subtotalIva  = round($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos * ($movimiento->tasiva / 100),2);
            $subtotalNeto = round($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos,2);

            // Descontar Iva y Neto del movimiento al comprobante
            $comprobante = InvoiceCompra::where('movement_id', $request->movement_id)->first();

            switch ($movimiento->tasiva) {
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
            MovementProduct::where('movement_id', $request->movement_id)->where('product_id', $request->product_id)->delete();

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
