<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Property
 * @package App\Models
 * @version June 14, 2018, 10:17 am EAT
 *
 * @property \App\Models\Masterfile masterfile
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string name
 * @property string code
 * @property string location
 * @property string property_type
 * @property integer units
 * @property bigInteger landlord_id
 * @property integer created_by
 * @property integer client_id
 * @property boolean status
 */
class Property extends Model
{
    use SoftDeletes;

    public $table = 'properties';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'code',
        'location',
        'property_type',
        'units',
        'landlord_id',
        'created_by',
        'client_id',
        'commission',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'location' => 'string',
        'property_type' => 'string',
        'units' => 'integer',
        'created_by' => 'integer',
        'commission' => 'float',
        'client_id' => 'integer',
        'status' => 'boolean'
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
        return $this->belongsTo(\App\Models\Masterfile::class,'landlord_id');
    }
}
