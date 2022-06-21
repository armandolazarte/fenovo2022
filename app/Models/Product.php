<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'products';

    protected $casts = [
        'cod_fenovo'       => 'int',
        'unit_amount'      => 'float',
        'unit_weight'      => 'float',
        'porcentaje_bruto' => 'float',
        'stock_min'        => 'float',
        'stock_actual'     => 'int',
        'stock_sem_min'    => 'int',
        'stock_sem_max'    => 'int',
        'hight'            => 'float',
        'width'            => 'float',
        'long'             => 'float',
        'package_palet'    => 'int',
        'package_row'      => 'int',
        'online_sale'      => 'int',
        'proveedor_id'     => 'int',
        'categorie_id'     => 'int',
        'type_id'          => 'int',
        'senasa_id'        => 'int',
        'iibb'             => 'int',
        'active'           => 'int',
    ];

    protected $dates = [
        'expiration_date',
        'publication_date',
    ];

    protected $fillable = [
        'cod_fenovo',
        'name',
        'description',
        'barcode',
        'cod_cuenta_compra',
        'cod_cuenta_venta',
        'cod_proveedor',
        'unit_type',
        'unit_amount',
        'unit_weight',
        'porcentaje_bruto',
        'stock_f',
        'stock_r',
        'stock_cyo',
        'stock_min',
        'stock_sem_min',
        'stock_sem_max',
        'hight',
        'width',
        'long',
        'unit_package',
        'package_palet',
        'package_row',
        'currency',
        'online_sale',
        'fragility',
        'expiration_date',
        'publication_date',
        'publication_state',
        'publication_log',
        'proveedor_id',
        'categorie_id',
        'cod_descuento',
        'senasa_id',
        'iibb',
        'active',
        'coeficiente_relacion_stock'
    ];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'categorie_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function senasa_definition()
    {
        return $this->belongsTo(SenasaDefinition::class, 'senasa_id');
    }

    public function senasa()
    {
        $senasa = SenasaDefinition::find($this->senasa_id);
        return ($senasa) ? $senasa->product_name : null;
    }

    public function product_descuento()
    {
        return $this->belongsTo(ProductDescuento::class, 'cod_descuento');
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'cod_fenovo');
    }

    public function product_nutricional()
    {
        return $this->hasOne(ProductNutricional::class);
    }

    public function product_price()
    {
        return $this->hasOne(ProductPrice::class);
    }

    public function product_oferta()
    {
        return $this->hasOne(ProductOferta::class);
    }

    public function session_prices()
    {
        return $this->hasMany(SessionPrices::class)->groupBy('fecha_actualizacion');
    }

    public function session_ofertas()
    {
        return $this->hasMany(SessionOferta::class);
    }

    public function stock($unit_package = null, $entidad_id = 1, $entidad_tipo = 'S')
    {
        $stock = 0.0;
        // Buscar el ultimo movimiento
        $movement_product = MovementProduct::where('product_id', $this->id)
            ->where('entidad_id', $entidad_id)
            ->where('entidad_tipo', $entidad_tipo)
            ->when($unit_package, function ($q, $unit_package) {
                $q->where('unit_package', $unit_package);
            })
            ->orderBy('id', 'DESC')
            ->first();

        if ($movement_product) {
            $stock = (float)$movement_product->balance;
        }

        // Buscar en la session iniciadas
        $subtotal         = 0.0;
        $session_products = SessionProduct::where('product_id', $this->id)->where('store_id', $entidad_id)->get();

        foreach ($session_products as $session_product) {
            if ($this->unit_type == 'K') {
                $subtotal = $subtotal + ($session_product->unit_package * $session_product->quantity * $this->unit_weight);
            } else {
                $subtotal = $subtotal + ($session_product->unit_package * $session_product->quantity);
            }
        }

        if ($session_products) {
            $stock = $stock - $subtotal;
        }
        return $stock;
    }

    public function stockReal($unit_package = null, $entidad_id = 1, $entidad_tipo = 'S')
    {
        return $this->stock_f + $this->stock_r + $this->stock_cyo;
    }

    public function stockEnSession($unit_package = null, $entidad_id = 1, $entidad_tipo = 'S')
    {
        $stock = 0.0;
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

    public function stockInicioSemana()
    {
        $registro = MovementProduct::whereEntidadId(1)
            ->where('created_at', '>', Carbon::now()->subDays(7))
            ->whereProductId($this->id)
            ->orderBy('created_at')
            ->first();

        return ($registro) ? number_format($registro->balance, 0, '', '') : 0;
    }

    public function ingresoSemana()
    {
        $suma = MovementProduct::whereEntidadId(1)
            ->where('created_at', '>', Carbon::now()->subDays(7))
            ->whereProductId($this->id)
            ->orderBy('created_at')
            ->get()->skip(1)->sum('entry');

        return number_format($suma, 0, '', '');
    }

    public function salidaSemana()
    {
        $suma = MovementProduct::whereEntidadId(1)
            ->where('created_at', '>', Carbon::now()->subDays(7))
            ->whereProductId($this->id)
            ->orderBy('created_at')
            ->get()->skip(1)->sum('egress');

        return number_format($suma, 0, '', '');
    }

    public function stockFinSemana()
    {
        $registro = MovementProduct::whereEntidadId(1)->whereProductId($this->id)->orderByDesc('id')->first();
        return ($registro)?number_format($registro->balance, 0, '', ''):0;
    }

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->orWhere('name', 'like', $name . '%');
        }
    }

    public function scopeCodFenovo($query, $codfenovo)
    {
        if ($codfenovo) {
            return $query->orWhere('cod_fenovo', $codfenovo);
        }
    }
}
