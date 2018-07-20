<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Lease
 * @package App\Models
 * @version June 16, 2018, 9:23 am EAT
 *
 * @property \App\Models\Masterfile masterfile
 * @property \App\Models\PropertyUnit propertyUnit
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer unit_id
 * @property bigInteger tenant_id
 * @property string|\Carbon\Carbon start_date
 * @property boolean status
 * @property integer created_by
 * @property integer client_id
 */
class Lease extends Model
{
    use SoftDeletes;

    public $table = 'leases';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'unit_id',
        'tenant_id',
        'start_date',
        'status',
        'created_by',
        'client_id',
        'property_id',
        'is_reversed',
        'reversed_by',
        'state'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit_id' => 'integer',
        'status' => 'boolean',
        'is_reversed' => 'boolean',
        'created_by' => 'integer',
        'client_id' => 'integer',
        'property_id' => 'integer',
        'reversed_by' => 'integer',
        'state' => 'string',
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
    public function masterfile()
    {
        return $this->belongsTo(\App\Models\Masterfile::class,'tenant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function unit()
    {
        return $this->belongsTo(\App\Models\PropertyUnit::class,'unit_id');
    }

    public function property(){
        return $this->belongsTo(Property::class);
    }
}
