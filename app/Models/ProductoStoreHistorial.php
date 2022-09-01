<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoStoreHistorial extends Model
{
    protected $table = 'products_store_historial';

    protected $fillable = [
        'product_id',
        'store_id',
        'cod_fenovo',
        'prev_stock_f',
        'prev_stock_r',
        'prev_stock_cyo',
        'pos_stock_f',
        'pos_stock_r',
        'pos_stock_cyo',
        'movement_id',
        'movement_type'
    ];
}
