<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StoreVentaDiaria extends Model
{
	protected $table = 'store_venta_diaria';

	protected $fillable = [
		'product_id',
		'store_id',
		'bultos',
		'kgrs',
		'stock_actual'
	];
}
