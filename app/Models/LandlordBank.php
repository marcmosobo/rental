<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LandlordBank
 * @package App\Models
 * @version July 31, 2018, 8:21 am EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection landlordAccounts
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection propertyListings
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string name
 * @property bigInteger landlord_id
 * @property string account_number
 */
class LandlordBank extends Model
{
    use SoftDeletes;

    public $table = 'landlord_bank_accounts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'landlord_id',
        'account_number'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'account_number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function landlord(){
        return $this->belongsTo(Masterfile::class,'landlord_id');
    }

    
}
