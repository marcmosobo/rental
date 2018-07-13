<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SoldProperty
 * @package App\Models
 * @version July 13, 2018, 12:42 pm EAT
 *
 * @property \App\Models\PropertyListing propertyListing
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection propertyListings
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer listing_id
 * @property integer buyer_id
 * @property float amount_bought
 * @property float commission_percentage
 * @property float commission_charged
 * @property float less_commission
 */
class SoldProperty extends Model
{
    use SoftDeletes;

    public $table = 'sold_properties';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'listing_id',
        'buyer_id',
        'amount_bought',
        'commission_percentage',
        'commission_charged',
        'less_commission'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'listing_id' => 'integer',
        'buyer_id' => 'integer',
        'amount_bought' => 'float',
        'commission_percentage' => 'float',
        'commission_charged' => 'float',
        'less_commission' => 'float'
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
    public function listing()
    {
        return $this->belongsTo(\App\Models\PropertyListing::class,'listing_id');
    }

    public function buyer(){
        return $this->belongsTo(Masterfile::class,'buyer_id');
    }
}
