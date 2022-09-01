<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProductProveedor extends Model
{
    protected $table   = 'product_proveedor';
    public $timestamps = false;

    protected $casts = [
        'product_id'  => 'int',
        'proveedor_id' => 'int',
    ];

    protected $fillable = [
        'product_id',
        'proveedor_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
