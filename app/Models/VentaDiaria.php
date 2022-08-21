<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VentaDiaria extends Model
{
	protected $table = 'ventas_diarias';

	protected $fillable = [
		'product_id',
		'store_id',
		'bultos',
		'kgrs',
		'stock_actual'
	];
}
