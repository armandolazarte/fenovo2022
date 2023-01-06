<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ProductosSenasaExport implements FromView
{
    protected $request;

    use Exportable;

    public function view(): View
    {
        $productos    = Product::whereNotNull('senasa_id')->with(['senasa_definition','proveedor'])->get();
        return view('exports.productosSenasa', compact('productos'));
    }
}
