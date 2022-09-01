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
        $movimientos = MovementProduct::with('movement')->orderBy('created_at','DESC')->get();

        return view('exports.registrosMoviemientosProductos', compact('movimientos'));
    }
}
