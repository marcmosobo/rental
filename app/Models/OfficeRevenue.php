<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OfficeRevenue
 * @package App\Models
 * @version July 27, 2018, 12:17 pm EAT
 *
 * @property \App\Models\OfficeExpenditure officeExpenditure
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection propertyListings
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer office_expenditure_id
 * @property string transaction_type
 * @property string ref_number
 * @property float amount
 * @property date date
 * @property integer created_by
 */
class OfficeRevenue extends Model
{
    use SoftDeletes;

    public $table = 'office_revenue';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'office_expenditure_id',
        'transaction_type',
        'ref_number',
        'amount',
        'date',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'office_expenditure_id' => 'integer',
        'transaction_type' => 'string',
        'ref_number' => 'string',
        'amount' => 'float',
        'date' => 'date',
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
    public function officeExpenditure()
    {
        return $this->belongsTo(\App\Models\OfficeExpenditure::class);
    }
}
