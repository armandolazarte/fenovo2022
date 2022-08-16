<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductStore extends Model
{
    protected $table = 'products_store';

    protected $dates = [
        'expiration_date',
        'publication_date',
    ];

    protected $fillable = [
        'product_id',
        'store_id',
        'cod_fenovo',
        'stock_f',
        'stock_r',
        'stock_cyo'
    ];

    public function stockReal()
    {
        return $this->stock_f + $this->stock_r+ $this->stock_cyo;
    }

    public function stockEnSession($unit_package = null, $entidad_id = 1)
    {
        $stock            = 0.0;
        $session_products = SessionProduct::where('product_id', $this->id)->where('store_id', $entidad_id)->get();

        foreach ($session_products as $session_product) {
            if ($this->unit_type == 'K') {
                $stock = $stock + ($session_product->unit_package * $session_product->quantity * $this->unit_weight);
            } else {
                $stock = $stock + ($session_product->unit_package * $session_product->quantity);
            }
        }

        return $stock;
    }
}
