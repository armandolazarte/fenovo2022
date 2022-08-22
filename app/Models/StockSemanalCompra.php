<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StockSemanalCompra extends Model
{
	protected $table = 'stock_semanal_compra';

	protected $fillable = [
		'store_id',
		'product_id',
		'costo',
		'fechaCaptura',
		'inicio',
		'compras',
		'salidas',
		'actual',
	];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

	public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
