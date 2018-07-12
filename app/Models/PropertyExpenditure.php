<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PropertyExpenditure
 * @package App\Models
 * @version July 12, 2018, 6:22 pm EAT
 *
 * @property \App\Models\Expenditure expenditure
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer expenditure_id
 * @property integer property_id
 * @property integer landlord_id
 * @property integer created_by
 * @property float amount
 * @property date date
 */
class PropertyExpenditure extends Model
{
    use SoftDeletes;

    public $table = 'property_expenditures';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'expenditure_id',
        'property_id',
        'landlord_id',
        'created_by',
        'amount',
        'date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'expenditure_id' => 'integer',
        'property_id' => 'integer',
        'landlord_id' => 'integer',
        'created_by' => 'integer',
        'amount' => 'float',
        'date' => 'date'
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
    public function expenditure()
    {
        return $this->belongsTo(\App\Models\Expenditure::class);
    }

    public function property(){
        return $this->belongsTo(Property::class);
    }
}
