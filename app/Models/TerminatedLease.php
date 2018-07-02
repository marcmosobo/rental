<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TerminatedLease
 * @package App\Models
 * @version July 2, 2018, 12:56 pm EAT
 *
 * @property \App\Models\Masterfile masterfile
 * @property \App\Models\PropertyUnit propertyUnit
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer unit_id
 * @property integer property_id
 * @property bigInteger tenant_id
 * @property string|\Carbon\Carbon start_date
 * @property boolean status
 * @property integer created_by
 * @property integer client_id
 * @property boolean is_reversed
 * @property integer reversed_by
 */
class TerminatedLease extends Model
{
    use SoftDeletes;

    public $table = 'leases';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'unit_id',
        'property_id',
        'tenant_id',
        'start_date',
        'status',
        'created_by',
        'client_id',
        'is_reversed',
        'reversed_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit_id' => 'integer',
        'property_id' => 'integer',
        'status' => 'boolean',
        'created_by' => 'integer',
        'client_id' => 'integer',
        'is_reversed' => 'boolean',
        'reversed_by' => 'integer'
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
        return $this->belongsTo(\App\Models\Masterfile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function propertyUnit()
    {
        return $this->belongsTo(\App\Models\PropertyUnit::class);
    }
}
