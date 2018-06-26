<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LandlordSettlement
 * @package App\Models
 * @version June 26, 2018, 1:24 pm EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer landlord_id
 * @property string|\Carbon\Carbon date
 * @property float amount_collected
 * @property float commission_percentage
 * @property float commission_amount
 * @property float overdraft
 */
class LandlordSettlement extends Model
{
    use SoftDeletes;

    public $table = 'landlord_settlements';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'landlord_id',
        'date',
        'amount_collected',
        'commission_percentage',
        'commission_amount',
        'overdraft'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'landlord_id' => 'integer',
        'amount_collected' => 'float',
        'commission_percentage' => 'float',
        'commission_amount' => 'float',
        'overdraft' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
