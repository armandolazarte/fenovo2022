<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DescuentosViewExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $desde = $this->request->desde;
        $hasta = $this->request->hasta;

        $descuentos = DB::table('product_descuentos')
            ->select('codigo', 'descripcion', 'descuento', 'cantidad')
            ->where('active', 1)
            ->get();

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($descuentos), 4, '0', STR_PAD_LEFT);
        $data = $anio . $mes . $dia . $hora . $min . $registros;    

        return view('exports.descuentos', compact('descuentos', 'data'));
    }
}
