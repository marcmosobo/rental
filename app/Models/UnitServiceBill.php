<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UnitServiceBill
 * @package App\Models
 * @version June 15, 2018, 5:29 pm EAT
 *
 * @property \App\Models\PropertyUnit propertyUnit
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer unit_id
 * @property integer service_bill_id
 * @property float amount
 * @property string period
 * @property boolean status
 */
class UnitServiceBill extends Model
{
//    use SoftDeletes;

    public $table = 'unit_service_bills';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'unit_id',
        'service_bill_id',
        'amount',
        'period',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit_id' => 'integer',
        'service_bill_id' => 'integer',
        'amount' => 'float',
        'period' => 'string',
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
    public function propertyUnit()
    {
        return $this->belongsTo(\App\Models\PropertyUnit::class);
    }

    public function bill(){
        return $this->belongsTo(ServiceOption::class,'service_bill_id');
    }
}
