<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Movement;

class InvoiceCompra extends Model
{
	protected $table = 'invoices_compra';

	protected $fillable = [
		'id',
		'movement_id', 
		'l25413', 
		'retater', 
		'retiva', 
		'retgan', 
		'nograv', 
		'percater', 
		'perciva', 
		'exento', 
		'totalIva10', 
		'totalIva21', 
		'totalIva27', 
		'totalNeto10', 
		'totalNeto21', 
		'totalNeto27', 
		'totalCompra', 
	];

	public function movement()
    {
        return $this->belongsTo(Movement::class, 'movement_id');
    }


}
