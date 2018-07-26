<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DepositRefund
 * @package App\Models
 * @version July 26, 2018, 2:54 pm EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection propertyListings
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer lease_id
 * @property float amount
 * @property integer refunded_by
 * @property string|\Carbon\Carbon refund_date
 */
class DepositRefund extends Model
{
    use SoftDeletes;

    public $table = 'deposit_refunds';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'lease_id',
        'amount',
        'refunded_by',
        'refund_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'lease_id' => 'integer',
        'amount' => 'float',
        'refunded_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
