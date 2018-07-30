<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LoanPayment
 * @package App\Models
 * @version July 29, 2018, 9:35 am EAT
 *
 * @property \App\Models\Masterfile masterfile
 * @property \App\Models\Loan loan
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection propertyListings
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer loan_id
 * @property bigInteger landlord_id
 * @property string reference
 * @property string transaction_type
 * @property float amount
 * @property string|\Carbon\Carbon date
 */
class LoanPayment extends Model
{
    use SoftDeletes;

    public $table = 'landlord_accounts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'loan_id',
        'landlord_id',
        'reference',
        'transaction_type',
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
        'loan_id' => 'integer',
        'reference' => 'string',
        'transaction_type' => 'string',
        'amount' => 'float'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function loan()
    {
        return $this->belongsTo(\App\Models\Loan::class);
    }
}
