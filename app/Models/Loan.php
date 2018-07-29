<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Loan
 * @package App\Models
 * @version July 29, 2018, 8:09 am EAT
 *
 * @property \App\Models\Masterfile masterfile
 * @property \Illuminate\Database\Eloquent\Collection LandlordAccount
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection propertyListings
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property bigInteger landlord_id
 * @property float principle
 * @property float rate
 * @property string|\Carbon\Carbon loan_date
 * @property integer created_by
 * @property boolean status
 */
class Loan extends Model
{
    use SoftDeletes;

    public $table = 'loans';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'landlord_id',
        'principle',
        'rate',
        'loan_date',
        'created_by',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'principle' => 'float',
        'rate' => 'float',
        'created_by' => 'integer',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function landlordAccounts()
    {
        return $this->hasMany(\App\Models\LandlordAccount::class);
    }
}
