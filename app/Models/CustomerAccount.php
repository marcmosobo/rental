<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CustomerAccount
 * @package App\Models
 * @version June 16, 2018, 1:40 pm EAT
 *
 * @property \App\Models\Masterfile masterfile
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property bigInteger tenant_id
 * @property integer lease_id
 * @property integer unit_id
 * @property integer bill_id
 * @property integer payment_id
 * @property string ref_number
 * @property string transaction_type
 * @property float amount
 */
class CustomerAccount extends Model
{
    use SoftDeletes;

    public $table = 'customer_accounts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'tenant_id',
        'lease_id',
        'unit_id',
        'bill_id',
        'payment_id',
        'ref_number',
        'transaction_type',
        'amount',
        'balance',
        'date',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'lease_id' => 'integer',
        'unit_id' => 'integer',
        'bill_id' => 'integer',
        'payment_id' => 'integer',
        'ref_number' => 'string',
        'transaction_type' => 'string',
        'amount' => 'float',
        'balance'=>'float',
//        'date'=>'dateTime',
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
}
