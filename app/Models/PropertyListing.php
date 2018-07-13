<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PropertyListing
 * @package App\Models
 * @version July 13, 2018, 11:34 am EAT
 *
 * @property \App\Models\PropertyType propertyType
 * @property \App\Models\Masterfile masterfile
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property bigInteger seller_id
 * @property integer property_type_id
 * @property string location
 * @property string description
 * @property float price
 * @property float sale_commission
 * @property boolean status
 * @property integer created_by
 */
class PropertyListing extends Model
{
    use SoftDeletes;

    public $table = 'property_listings';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'seller_id',
        'property_type_id',
        'location',
        'description',
        'price',
        'sale_commission',
        'status',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'property_type_id' => 'integer',
        'location' => 'string',
        'description' => 'string',
        'price' => 'float',
        'sale_commission' => 'float',
        'status' => 'boolean',
        'created_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function type()
    {
        return $this->belongsTo(\App\Models\PropertyType::class,'property_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function masterfile()
    {
        return $this->belongsTo(\App\Models\Masterfile::class,'seller_id');
    }
}
