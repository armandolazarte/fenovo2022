<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\MovementProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class RegistrosMovimientosExport implements FromView
{
    protected $request;
    use Exportable;

    public function view(): View
    {
        $movimientos_productos = MovementProduct::where('movement_id', '>', 611)->with(['movement','product'])->orderBy('created_at','ASC')->get();

        return view('exports.registrosMoviemientosProductos', compact('movimientos_productos'));
    }
}
