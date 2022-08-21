<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * Class AlicoutaType
 *
 * @property int $id
 * @property int|null $afip_id
 * @property float|null $value
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereAfipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereValue($value)
 */
	class AlicoutaType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ApiToken
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $type
 * @property string $token
 * @property Carbon|null $expires_at
 * @property Carbon $created_at
 * @property User|null $user
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereUserId($value)
 */
	class ApiToken extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Base08
 *
 * @property int|null $cod_fenovo
 * @property int|null $stock
 * @method static \Illuminate\Database\Eloquent\Builder|Base08 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base08 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base08 query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base08 whereCodFenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Base08 whereStock($value)
 */
	class Base08 extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Coeficiente
 *
 * @property int $id
 * @property int|null $coeficiente
 * @method static \Illuminate\Database\Eloquent\Builder|Coeficiente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coeficiente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coeficiente query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coeficiente whereCoeficiente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coeficiente whereId($value)
 */
	class Coeficiente extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ConceptType
 *
 * @property int $id
 * @property int|null $afip_id
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType whereAfipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType whereUpdatedAt($value)
 */
	class ConceptType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Customer
 *
 * @property int         $id
 * @property string|null $cuit
 * @property int|null    $store_id
 * @property string|null $bussiness_name
 * @property string|null $razon_social
 * @property string|null $responsable
 * @property string|null $email
 * @property string|null $iva_type
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $telephone
 * @property string|null $listprice_associate
 * @property int         $active
 * @property Store|null $store
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereBussinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereIvaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereListpriceAssociate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereRazonSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereTelephone($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * Class DocumentType
 *
 * @property int $id
 * @property int|null $afip_id
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereAfipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereUpdatedAt($value)
 */
	class DocumentType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Exportaciones
 *
 * @property int $id
 * @property string|null $archivo
 * @property int|null $numero
 * @property int|null $registros
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Exportaciones newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exportaciones newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exportaciones query()
 * @method static \Illuminate\Database\Eloquent\Builder|Exportaciones whereArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exportaciones whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exportaciones whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exportaciones whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exportaciones whereRegistros($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exportaciones whereUpdatedAt($value)
 */
	class Exportaciones extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FleteSetting
 *
 * @property int $id
 * @property int $hasta
 * @property string $porcentaje
 * @property int $active
 * @method static \Illuminate\Database\Eloquent\Builder|FleteSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FleteSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FleteSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|FleteSetting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FleteSetting whereHasta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FleteSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FleteSetting wherePorcentaje($value)
 */
	class FleteSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HistorialActualizacion
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $costproveedor
 * @property float|null $plistproveedor
 * @property float|null $descproveedor
 * @property float|null $costfenovo
 * @property float|null $costdolar
 * @property float|null $mupfenovo
 * @property float|null $tasiva
 * @property float|null $plist0
 * @property float|null $plist0neto
 * @property float|null $plist0iva
 * @property float|null $contribution_fund
 * @property float|null $plist1
 * @property float|null $muplist1
 * @property float|null $plist2
 * @property float|null $muplist2
 * @property float|null $p1tienda
 * @property float|null $mup1
 * @property float|null $descp1
 * @property float|null $p1may
 * @property float|null $mupp1may
 * @property int|null $cantmay1
 * @property float|null $p2tienda
 * @property float|null $mup2
 * @property float|null $descp2
 * @property float|null $p2may
 * @property float|null $mupp2may
 * @property int|null $cantmay2
 * @property float|null $comlista1
 * @property float|null $comlista2
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion query()
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereCantmay1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereCantmay2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereComlista1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereComlista2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereContributionFund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereCostdolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereCostfenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereCostproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereDescp1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereDescp2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereDescproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereMup1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereMup2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereMupfenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereMuplist1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereMuplist2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereMupp1may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereMupp2may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereP1may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereP1tienda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereP2may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereP2tienda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion wherePlist0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion wherePlist0iva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion wherePlist0neto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion wherePlist1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion wherePlist2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion wherePlistproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereTasiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistorialActualizacion whereUpdatedAt($value)
 */
	class HistorialActualizacion extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Iibb
 *
 * @property int $id
 * @property string|null $state
 * @property float|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb query()
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb whereValue($value)
 */
	class Iibb extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Invoice
 *
 * @property int $id
 * @property int|null $cant_reg
 * @property int|null $movement_id
 * @property string|null $client_name
 * @property string|null $client_address
 * @property string|null $client_cuit
 * @property string|null $client_iva_type
 * @property string|null $voucher_number
 * @property int|null $pto_vta
 * @property int|null $cbte_tipo
 * @property int|null $concepto
 * @property int|null $doc_tipo
 * @property int|null $doc_nro
 * @property int|null $cbte_desde
 * @property int|null $cbte_hasta
 * @property int|null $cbte_fch
 * @property int|null $fch_serv_desde
 * @property int|null $fch_serv_hasta
 * @property int|null $fch_vto_pago
 * @property float|null $imp_total
 * @property float|null $imp_tot_conc
 * @property float|null $imp_neto
 * @property float|null $imp_op_ex
 * @property float|null $imp_iva
 * @property float|null $imp_trib
 * @property float|null $iibb
 * @property string|null $mon_id
 * @property int|null $mon_cotiz
 * @property string|null $ivas
 * @property string|null $cae
 * @property string|null $expiration
 * @property string|null $key
 * @property string|null $error
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @property int|null $orden
 * @property int|null $jurisdiccion
 * @property string|null $tributos
 * @property string|null $costo_fenovo_total
 * @property string|null $url
 * @property int|null $cyo
 * @property-read \App\Models\Panamas|null $flete
 * @property-read \App\Models\Panamas|null $panama
 * @property-read \App\Models\VoucherType|null $tipoFactura
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCae($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCantReg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCbteDesde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCbteFch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCbteHasta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCbteTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientIvaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereConcepto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCostoFenovoTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCyo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDocNro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDocTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereFchServDesde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereFchServHasta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereFchVtoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereIibb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpNeto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpOpEx($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpTotConc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpTrib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereIvas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereJurisdiccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereMonCotiz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereMonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereMovementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePtoVta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTributos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereVoucherNumber($value)
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InvoiceCompra
 *
 * @property int $id
 * @property int|null $movement_id
 * @property string|null $l25413
 * @property string|null $retater
 * @property string|null $retiva
 * @property string|null $retgan
 * @property string|null $nograv
 * @property string|null $percater
 * @property string|null $perciva
 * @property string|null $exento
 * @property string|null $totalIva10
 * @property string|null $totalIva21
 * @property string|null $totalIva27
 * @property string|null $totalNeto10
 * @property string|null $totalNeto21
 * @property string|null $totalNeto27
 * @property string|null $totalCompra
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Movement|null $movement
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereExento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereL25413($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereMovementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereNograv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra wherePercater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra wherePerciva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereRetater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereRetgan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereRetiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereTotalCompra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereTotalIva10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereTotalIva21($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereTotalIva27($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereTotalNeto10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereTotalNeto21($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereTotalNeto27($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceCompra whereUpdatedAt($value)
 */
	class InvoiceCompra extends \Eloquent {}
}

namespace App\Models{
/**
 * Class IvaCondition
 *
 * @property int $id
 * @property int|null $afip_id
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition whereAfipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition whereUpdatedAt($value)
 */
	class IvaCondition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Localidad
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $departamento
 * @property string|null $provincia
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ruta[] $rutas
 * @property-read int|null $rutas_count
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad buscarNombre($nombre)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereProvincia($value)
 */
	class Localidad extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Log
 *
 * @property int $id
 * @property string|null $log
 * @property string|null $origin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUserId($value)
 */
	class Log extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Movement
 *
 * @property int         $id
 * @property Carbon|null $date
 * @property string      $type
 * @property string|null $from
 * @property string|null $to
 * @property string|null $status
 * @property string|null $voucher_number
 * @property float|null  $flete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|MovementProduct[] $movement_products
 * @package App\Models
 * @property string|null $subtype
 * @property int|null $categoria
 * @property int|null $flete_invoice
 * @property int|null $orden
 * @property int|null $exported
 * @property int|null $user_id
 * @property string|null $observacion
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProduct[] $group_movement_salida_products
 * @property-read int|null $group_movement_salida_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProduct[] $group_panamas
 * @property-read int|null $group_panamas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProduct[] $group_products_egress
 * @property-read int|null $group_products_egress_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoice
 * @property-read int|null $invoice_count
 * @property-read \App\Models\InvoiceCompra|null $invoiceCompra
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProduct[] $movement_ingreso_products
 * @property-read int|null $movement_ingreso_products_count
 * @property-read int|null $movement_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProduct[] $movement_salida_products
 * @property-read int|null $movement_salida_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProduct[] $panamas
 * @property-read int|null $panamas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProduct[] $products_egress
 * @property-read int|null $products_egress_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProduct[] $salida_products_cyo
 * @property-read int|null $salida_products_cyo_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProduct[] $salida_products_no_cyo
 * @property-read int|null $salida_products_no_cyo_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Senasa[] $senasa
 * @property-read int|null $senasa_count
 * @method static \Illuminate\Database\Eloquent\Builder|Movement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereExported($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereFlete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereFleteInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereVoucherNumber($value)
 */
	class Movement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MovementProduct
 *
 * @property int $id
 * @property int|null $movement_id
 * @property int|null $entidad_id
 * @property string|null $entidad_tipo
 * @property int|null $product_id
 * @property string|null $tasiva
 * @property string|null $unit_price
 * @property string|null $cost_fenovo
 * @property float|null $unit_package
 * @property string|null $unit_type
 * @property int|null $bultos
 * @property bool|null $invoice
 * @property bool|null $cyo
 * @property string|null $circuito Cta y Orden
 * @property int|null $punto_venta
 * @property int|null $iibb
 * @property int|null $palet
 * @property int|null $deposito
 * @property float|null $entry
 * @property float|null $egress
 * @property float|null $balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Movement|null $movement
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereBultos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereCircuito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereCostFenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereCyo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereDeposito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereEgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereEntidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereEntidadTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereEntry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereIibb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereMovementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct wherePalet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct wherePuntoVenta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereTasiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereUnitPackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereUpdatedAt($value)
 */
	class MovementProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MovementProductTemp
 *
 * @property int $id
 * @property int|null $movement_id
 * @property int|null $entidad_id
 * @property string|null $entidad_tipo
 * @property int|null $product_id
 * @property int|null $exported_number
 * @property string|null $tasiva
 * @property string|null $unit_price
 * @property string|null $cost_fenovo
 * @property float|null $unit_package
 * @property string|null $unit_type
 * @property int|null $bultos
 * @property bool|null $invoice
 * @property bool|null $cyo Cta y Orden
 * @property int|null $iibb
 * @property float|null $entry
 * @property float|null $egress
 * @property float|null $balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MovementTemp|null $movement
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp query()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereBultos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereCostFenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereCyo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereEgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereEntidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereEntidadTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereEntry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereExportedNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereIibb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereMovementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereTasiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereUnitPackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProductTemp whereUpdatedAt($value)
 */
	class MovementProductTemp extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MovementTemp
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $date
 * @property string|null $type
 * @property string|null $subtype
 * @property string|null $from
 * @property string|null $to
 * @property string|null $deposito
 * @property string|null $status
 * @property string|null $voucher_number
 * @property string|null $flete
 * @property int|null $flete_invoice
 * @property int|null $orden
 * @property int|null $exported
 * @property int|null $user_id
 * @property string|null $observacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProductTemp[] $movement_ingreso_products
 * @property-read int|null $movement_ingreso_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProductTemp[] $movement_products
 * @property-read int|null $movement_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MovementProductTemp[] $movement_salida_products
 * @property-read int|null $movement_salida_products_count
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp query()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereDeposito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereExported($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereFlete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereFleteInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementTemp whereVoucherNumber($value)
 */
	class MovementTemp extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OfertaStore
 *
 * @property int $id
 * @property int|null $session_id
 * @property int|null $store_id
 * @property-read \App\Models\SessionOferta|null $session
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder|OfertaStore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfertaStore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfertaStore query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfertaStore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfertaStore whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfertaStore whereStoreId($value)
 */
	class OfertaStore extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Panamas
 *
 * @property int $id
 * @property int|null $orden
 * @property string|null $tipo
 * @property int|null $movement_id
 * @property string|null $client_name
 * @property string|null $client_address
 * @property string|null $client_cuit
 * @property string|null $client_iva_type
 * @property string|null $pto_vta
 * @property int|null $cip
 * @property int|null $emision_store
 * @property string|null $neto105
 * @property string|null $iva_neto105
 * @property string|null $neto21
 * @property string|null $iva_neto21
 * @property string|null $totalIibb
 * @property string|null $totalConIva
 * @property string|null $costo_fenovo_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas query()
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereCip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereClientAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereClientCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereClientIvaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereCostoFenovoTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereEmisionStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereIvaNeto105($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereIvaNeto21($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereMovementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereNeto105($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereNeto21($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas wherePtoVta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereTotalConIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereTotalIibb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Panamas whereUpdatedAt($value)
 */
	class Panamas extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pedido
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $date
 * @property string|null $from
 * @property string|null $status
 * @property string|null $voucher_number
 * @property int|null $user_id
 * @property int|null $movement_id
 * @property string|null $observacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PedidoProductos[] $productos
 * @property-read int|null $productos_count
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereMovementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereVoucherNumber($value)
 */
	class Pedido extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PedidoEstados
 *
 * @property int $id
 * @property int $user_id
 * @property int $pedido_id
 * @property string $estado
 * @property \Illuminate\Support\Carbon $fecha
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoEstados newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoEstados newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoEstados query()
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoEstados whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoEstados whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoEstados whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoEstados wherePedidoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoEstados whereUserId($value)
 */
	class PedidoEstados extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PedidoProductos
 *
 * @property int $id
 * @property int|null $pedido_id
 * @property int|null $entidad_id
 * @property string|null $entidad_tipo
 * @property int|null $product_id
 * @property string|null $tasiva
 * @property string|null $unit_price
 * @property string|null $cost_fenovo
 * @property float|null $unit_package
 * @property string|null $unit_type
 * @property int|null $bultos
 * @property int|null $bultos_enviados
 * @property int|null $bultos_pendientes
 * @property bool|null $invoice
 * @property int|null $iibb
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos query()
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereBultos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereBultosEnviados($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereBultosPendientes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereCostFenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereEntidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereEntidadTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereIibb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos wherePedidoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereTasiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereUnitPackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PedidoProductos whereUpdatedAt($value)
 */
	class PedidoProductos extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $cod_fenovo
 * @property string|null $name
 * @property string|null $description
 * @property string|null $barcode
 * @property string|null $cod_cuenta_compra
 * @property string|null $cod_cuenta_venta
 * @property string|null $cod_proveedor
 * @property string|null $unit_type
 * @property float|null $unit_amount
 * @property float|null $unit_weight
 * @property float|null $porcentaje_bruto
 * @property float|null $stock_min
 * @property string|null $stock_f
 * @property string|null $stock_r
 * @property string|null $stock_cyo
 * @property string|null $coeficiente_relacion_stock Este % indica la cantidad facturado el resto remito
 * @property int|null $stock_sem_min
 * @property int|null $stock_sem_max
 * @property float|null $hight
 * @property float|null $width
 * @property float|null $long
 * @property string|null $unit_package
 * @property int $package_palet
 * @property int $package_row
 * @property string|null $currency
 * @property int $online_sale
 * @property string|null $fragility
 * @property \Illuminate\Support\Carbon|null $expiration_date
 * @property \Illuminate\Support\Carbon|null $publication_date
 * @property string|null $publication_state
 * @property string|null $publication_log
 * @property int|null $proveedor_id
 * @property int|null $categorie_id
 * @property int|null $senasa_id
 * @property string|null $cod_descuento
 * @property int|null $iibb
 * @property int $active
 * @property string $palet
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\ProductCategory|null $product_category
 * @property-read \App\Models\ProductDescuento|null $product_descuento
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductImage[] $product_images
 * @property-read int|null $product_images_count
 * @property-read \App\Models\ProductNutricional|null $product_nutricional
 * @property-read \App\Models\ProductPrice|null $product_price
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductStore[] $productos_store
 * @property-read int|null $productos_store_count
 * @property-read \App\Models\Proveedor|null $proveedor
 * @property-read \App\Models\SenasaDefinition|null $senasa_definition
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SessionOferta[] $session_ofertas
 * @property-read int|null $session_ofertas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SessionPrices[] $session_prices
 * @property-read int|null $session_prices_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product codFenovo($codfenovo)
 * @method static \Illuminate\Database\Eloquent\Builder|Product name($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodCuentaCompra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodCuentaVenta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodDescuento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodFenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodProveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCoeficienteRelacionStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFragility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIibb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnlineSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePackagePalet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePackageRow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePalet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePorcentajeBruto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProveedorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePublicationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePublicationLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePublicationState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSenasaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockCyo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockSemMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockSemMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitPackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWidth($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProductCategory
 *
 * @property int $id
 * @property string|null $name
 * @property string $active
 * @property Collection|Product[] $products
 * @package App\Models
 * @property string|null $abrev
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereAbrev($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereName($value)
 */
	class ProductCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductDescuento
 *
 * @property int $id
 * @property string|null $codigo
 * @property string|null $descripcion
 * @property string|null $descuento
 * @property string|null $cantidad
 * @property string|null $tipo
 * @property string|null $fechadesde
 * @property string|null $fechahasta
 * @property int|null $active
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento whereCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento whereDescuento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento whereFechadesde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento whereFechahasta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDescuento whereTipo($value)
 */
	class ProductDescuento extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProductImage
 *
 * @property int $id
 * @property int|null $cod_fenovo
 * @property string|null $name
 * @property string $active
 * @property Product|null $product
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereCodFenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereName($value)
 */
	class ProductImage extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProductNutricional
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $ingredients
 * @property float|null $quantity_measure
 * @property string|null $unit_measure
 * @property string|null $measure_reference
 * @property string|null $energy_value
 * @property float|null $energy_porcentage
 * @property string|null $carbohydrates_value
 * @property float|null $carbohydrates_porcentage
 * @property string|null $proteins_value
 * @property float|null $proteins_porcentage
 * @property string|null $total_fat_value
 * @property float|null $total_fat_percentage
 * @property string|null $saturated_fat_value
 * @property float|null $saturated_fat_percentage
 * @property string|null $trans_fat_value
 * @property float|null $trans_fat_percentage
 * @property string|null $fiber_value
 * @property float|null $fiber_percentaje
 * @property string|null $sodioum_value
 * @property float|null $sodioum_percentage
 * @property Product|null $product
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereCarbohydratesPorcentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereCarbohydratesValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereEnergyPorcentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereEnergyValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereFiberPercentaje($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereFiberValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereIngredients($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereMeasureReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereProteinsPorcentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereProteinsValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereQuantityMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereSaturatedFatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereSaturatedFatValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereSodioumPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereSodioumValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereTotalFatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereTotalFatValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereTransFatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereTransFatValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereUnitMeasure($value)
 */
	class ProductNutricional extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProductPrice
 *
 * @property int        $id
 * @property int|null   $product_id
 * @property float|null $plistproveedor
 * @property float|null $descproveedor
 * @property float|null $costfenovo
 * @property float|null $costdolar
 * @property float|null $mupfenovo
 * @property float|null $tasiva
 * @property float|null $plist0
 * @property float|null $plist0neto
 * @property float|null $plist0iva
 * @property float|null $contribution_fund
 * @property float|null $plist1
 * @property float|null $muplist1
 * @property float|null $plist2
 * @property float|null $muplist2
 * @property float|null $p1tienda
 * @property float|null $mup1
 * @property float|null $descp1
 * @property float|null $p1may
 * @property float|null $mupp1may
 * @property int|null   $cantmay1
 * @property float|null $p2tienda
 * @property float|null $mup2
 * @property float|null $descp2
 * @property float|null $p2may
 * @property float|null $mupp2may
 * @property int|null   $cantmay2
 * @property float|null $comlista1
 * @property float|null $comlista2
 * @property Product|null $product
 * @package App\Models
 * @property string|null $costproveedor
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCantmay1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCantmay2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereComlista1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereComlista2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereContributionFund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCostdolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCostfenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCostproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereDescp1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereDescp2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereDescproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMup1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMup2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMupfenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMuplist1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMuplist2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMupp1may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMupp2may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereP1may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereP1tienda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereP2may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereP2tienda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlist0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlist0iva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlist0neto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlist1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlist2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlistproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereTasiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereUpdatedAt($value)
 */
	class ProductPrice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductStore
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $store_id
 * @property string|null $stock_f
 * @property string|null $stock_r
 * @property string|null $stock_cyo
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\Store|null $deposito
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore whereStockCyo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore whereStockF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore whereStockR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStore whereUpdatedAt($value)
 */
	class ProductStore extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Proveedor
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $responsable
 * @property string|null $email
 * @property string|null $cuit
 * @property string|null $iva_type
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $telephone
 * @property int $active
 * @property Collection|Product[] $products
 * @package App\Models
 * @property string|null $firstname
 * @property string|null $lastname
 * @property int $punto_venta
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereIvaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor wherePuntoVenta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereTelephone($value)
 */
	class Proveedor extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Regione
 *
 * @property int $id
 * @property string|null $name
 * @property bool $active
 * @property Collection|Store[] $stores
 * @package App\Models
 * @property-read int|null $stores_count
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ruta
 *
 * @property int $id
 * @property string|null $nombre
 * @property int|null $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Localidad[] $localidades
 * @property-read int|null $localidades_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transportista[] $transportistas
 * @property-read int|null $transportistas_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ruta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ruta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ruta query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ruta whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ruta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ruta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ruta whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ruta whereUpdatedAt($value)
 */
	class Ruta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RutaLocalidad
 *
 * @property int $id
 * @property int|null $ruta_id
 * @property int|null $localidad_id
 * @property-read \App\Models\Localidad|null $localidad
 * @property-read \App\Models\Ruta|null $ruta
 * @method static \Illuminate\Database\Eloquent\Builder|RutaLocalidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RutaLocalidad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RutaLocalidad query()
 * @method static \Illuminate\Database\Eloquent\Builder|RutaLocalidad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RutaLocalidad whereLocalidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RutaLocalidad whereRutaId($value)
 */
	class RutaLocalidad extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RutaTransportista
 *
 * @property int $id
 * @property int|null $ruta_id
 * @property int|null $transportista_id
 * @property-read \App\Models\Ruta|null $rutas
 * @property-read \App\Models\Transportista|null $transportistas
 * @method static \Illuminate\Database\Eloquent\Builder|RutaTransportista newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RutaTransportista newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RutaTransportista query()
 * @method static \Illuminate\Database\Eloquent\Builder|RutaTransportista whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RutaTransportista whereRutaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RutaTransportista whereTransportistaId($value)
 */
	class RutaTransportista extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Senasa
 *
 * @property int         $id
 * @property string|null $habilitacion_nro
 * @property string|null $patente_nro
 * @property string|null $precintos
 * @property string|null $destino
 * @property string|null $dias_validez
 * @property string|null $fecha
 * @property string|null $hora
 * @package App\Models
 * @property int|null $store_id
 * @property string|null $fecha_salida
 * @property string|null $hora_salida
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Movement[] $movements
 * @property-read int|null $movements_count
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa query()
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereDestino($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereDiasValidez($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereFechaSalida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereHabilitacionNro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereHoraSalida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa wherePatenteNro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa wherePrecintos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereUpdatedAt($value)
 */
	class Senasa extends \Eloquent {}
}

namespace App\Models{
/**
 * Class SenasaDefinition
 *
 * @property int $id
 * @property string|null $product_name
 * @property Collection|Product[] $products
 * @package App\Models
 * @property int|null $active
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition query()
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition whereProductName($value)
 */
	class SenasaDefinition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SessionOferta
 *
 * @property int $id
 * @property int|null $product_id
 * @property float|null $plistproveedor
 * @property float|null $descproveedor
 * @property float|null $costfenovo
 * @property float|null $costdolar
 * @property float|null $mupfenovo
 * @property float|null $tasiva
 * @property float|null $plist0
 * @property float|null $plist0neto
 * @property float|null $plist0iva
 * @property float|null $contribution_fund
 * @property float|null $plist1
 * @property float|null $muplist1
 * @property float|null $plist2
 * @property float|null $muplist2
 * @property float|null $p1tienda
 * @property float|null $mup1
 * @property float|null $descp1
 * @property float|null $p1may
 * @property float|null $mupp1may
 * @property int|null $cantmay1
 * @property float|null $p2tienda
 * @property float|null $mup2
 * @property float|null $descp2
 * @property float|null $p2may
 * @property float|null $mupp2may
 * @property int|null $cantmay2
 * @property float|null $comlista1
 * @property float|null $comlista2
 * @property string|null $fecha_desde
 * @property string|null $fecha_hasta
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\Product|null $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Store[] $stores
 * @property-read int|null $stores_count
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta query()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereCantmay1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereCantmay2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereComlista1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereComlista2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereContributionFund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereCostdolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereCostfenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereDescp1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereDescp2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereDescproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereFechaDesde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereFechaHasta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereMup1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereMup2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereMupfenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereMuplist1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereMuplist2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereMupp1may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereMupp2may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereP1may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereP1tienda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereP2may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereP2tienda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta wherePlist0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta wherePlist0iva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta wherePlist0neto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta wherePlist1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta wherePlist2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta wherePlistproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereTasiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionOferta whereUpdatedAt($value)
 */
	class SessionOferta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SessionPrices
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $costproveedor
 * @property float|null $plistproveedor
 * @property float|null $descproveedor
 * @property float|null $costfenovo
 * @property float|null $costdolar
 * @property float|null $mupfenovo
 * @property float|null $tasiva
 * @property float|null $plist0
 * @property float|null $plist0neto
 * @property float|null $plist0iva
 * @property float|null $contribution_fund
 * @property float|null $plist1
 * @property float|null $muplist1
 * @property float|null $plist2
 * @property float|null $muplist2
 * @property float|null $p1tienda
 * @property float|null $mup1
 * @property float|null $descp1
 * @property float|null $p1may
 * @property float|null $mupp1may
 * @property int|null $cantmay1
 * @property float|null $p2tienda
 * @property float|null $mup2
 * @property float|null $descp2
 * @property float|null $p2may
 * @property float|null $mupp2may
 * @property int|null $cantmay2
 * @property float|null $comlista1
 * @property float|null $comlista2
 * @property string $fecha_actualizacion
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices query()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereCantmay1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereCantmay2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereComlista1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereComlista2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereContributionFund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereCostdolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereCostfenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereCostproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereDescp1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereDescp2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereDescproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereFechaActualizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereMup1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereMup2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereMupfenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereMuplist1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereMuplist2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereMupp1may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereMupp2may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereP1may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereP1tienda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereP2may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereP2tienda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices wherePlist0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices wherePlist0iva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices wherePlist0neto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices wherePlist1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices wherePlist2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices wherePlistproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereTasiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionPrices whereUpdatedAt($value)
 */
	class SessionPrices extends \Eloquent {}
}

namespace App\Models{
/**
 * Class SessionProduct
 *
 * @property int         $id
 * @property string      $list_id
 * @property int|null    $store_id
 * @property string|null $movement_id
 * @property int|null    $product_id
 * @property string|null $product_name
 * @property string|null $unit_type
 * @property float|null  $unit_price
 * @property float|null  $tasiva
 * @property int|null    $senasa_id
 * @property string|null $senasa_name
 * @property float|null  $unit_package
 * @property float|null  $quantity
 * @property string|null $state
 * @property bool|null   $invoice
 * @property float|null  $net_weight
 * @property float|null  $gross_weight
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @property int|null $user_id
 * @property string|null $neto
 * @property string|null $costo_fenovo
 * @property int|null $iibb
 * @property string|null $nro_pedido
 * @property string|null $pausado
 * @property string|null $circuito
 * @property int|null $palet
 * @property int|null $deposito
 * @property int|null $desde_deposito
 * @property int|null $a_deposito
 * @property-read \App\Models\Product|null $producto
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereADeposito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereCircuito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereCostoFenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereDeposito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereDesdeDeposito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereIibb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereNeto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereNroPedido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct wherePalet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct wherePausado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereTasiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereUnitPackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereUserId($value)
 */
	class SessionProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StockSemanalCompra
 *
 * @property int $id
 * @property int|null $store_id
 * @property int|null $product_id
 * @property string|null $costo
 * @property string|null $fechaCaptura Fecha donde se obtuvo el movimiento
 * @property int|null $inicio
 * @property int|null $compras
 * @property int|null $salidas
 * @property int|null $actual
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereCompras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereCosto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereFechaCaptura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereSalidas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSemanalCompra whereUpdatedAt($value)
 */
	class StockSemanalCompra extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Store
 *
 * @property int $id
 * @property int $cod_fenovo
 * @property string|null $razon_social
 * @property string|null $description
 * @property string|null $responsable
 * @property string|null $email
 * @property string|null $cuit
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $telephone
 * @property string|null $print_type
 * @property string|null $iva_type
 * @property string|null $store_type
 * @property int|null $region_id
 * @property float|null $billing_amount
 * @property float|null $lat
 * @property float|null $lon
 * @property float|null $delivery_percentage
 * @property int|null $delivery_km
 * @property int|null $stock_capacity
 * @property int $online_sale
 * @property int $active
 * @property string|null $listprice_associate
 * @property string|null $logistica_express
 * @property int|null $punto_venta
 * @property int|null $habilitado_panama
 * @property int|null $recibe_traslado
 * @property float|null $comision_distribucion
 * @property int|null $cip Codigo Impresion Pananma
 * @property string|null $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read \App\Models\Region|null $region
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereBillingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCodFenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereComisionDistribucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDeliveryKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDeliveryPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereHabilitadoPanama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereIvaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereListpriceAssociate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLogisticaExpress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereOnlineSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePrintType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePuntoVenta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereRazonSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereRecibeTraslado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStockCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAt($value)
 */
	class Store extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StoreResume
 *
 * @property int $id
 * @property int|null $store_id
 * @property string|null $total_venta_diaria_bultos
 * @property string|null $total_venta_diaria_kgrs
 * @property string|null $capacidad_disponible
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereCapacidadDisponible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereTotalVentaDiariaBultos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereTotalVentaDiariaKgrs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereUpdatedAt($value)
 */
	class StoreResume extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transportista
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $cuit
 * @property string|null $contacto
 * @property string|null $direccion
 * @property string|null $telefono
 * @property string|null $email
 * @property int|null $active
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehiculo[] $vehiculos
 * @property-read int|null $vehiculos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista whereContacto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista whereCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transportista whereTelefono($value)
 */
	class Transportista extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TransportistaVehiculo
 *
 * @property-read \App\Models\Transportista $transportista
 * @property-read \App\Models\Vehiculo|null $vehiculo
 * @method static \Illuminate\Database\Eloquent\Builder|TransportistaVehiculo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransportistaVehiculo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransportistaVehiculo query()
 */
	class TransportistaVehiculo extends \Eloquent {}
}

namespace App\Models{
/**
 * Class User
 *
 * @property int         $id
 * @property string|null $name
 * @property string      $email
 * @property string|null $username
 * @property int|null    $rol_id
 * @property string|null $avatar
 * @property string|null $last_login
 * @property bool        $active
 * @property string      $password
 * @property string|null $remember_me_token
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 * @property Role|null              $role
 * @property Collection|ApiToken[]  $api_tokens
 * @property Collection|UserLocal[] $user_locals
 * @package App\Models
 * @property int|null $store_active
 * @property string|null $remember_token
 * @property-read int|null $api_tokens_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Store[] $stores
 * @property-read int|null $stores_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStoreActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserStore
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $store_id
 * @property-read \App\Models\Store|null $store
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserStore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStore query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStore whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStore whereUserId($value)
 */
	class UserStore extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Vehiculo
 *
 * @property int $id
 * @property string|null $tipo
 * @property string|null $marca
 * @property string|null $patente
 * @property int|null $capacidad
 * @property string|null $chofer
 * @property string|null $senasa
 * @property int|null $transportista_id
 * @property int|null $store_id
 * @property int|null $active
 * @property int|null $propio
 * @property-read \App\Models\Store|null $store
 * @property-read \App\Models\Transportista|null $transportista
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereCapacidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereChofer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereMarca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo wherePatente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo wherePropio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereSenasa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereTransportistaId($value)
 */
	class Vehiculo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VentaDiaria
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $store_id
 * @property string|null $bultos
 * @property string|null $kgrs
 * @property string|null $stock_actual
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria query()
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria whereBultos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria whereKgrs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria whereStockActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VentaDiaria whereUpdatedAt($value)
 */
	class VentaDiaria extends \Eloquent {}
}

namespace App\Models{
/**
 * Class VoucherType
 *
 * @property int $id
 * @property int|null $afip_id
 * @property string|null $code
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType query()
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereAfipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereUpdatedAt($value)
 */
	class VoucherType extends \Eloquent {}
}

