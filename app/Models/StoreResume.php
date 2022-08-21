<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StoreResume extends Model
{
	protected $table = 'store_resumes';

	protected $fillable = [
		'store_id',
		'total_venta_diaria_bultos',
		'total_venta_diaria_kgrs',
		'capacidad_disponible'
	];
}
