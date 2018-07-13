<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Customer
 * @package App\Models
 * @version July 13, 2018, 11:40 am EAT
 *
 * @property \App\Models\Client client
 * @property \Illuminate\Database\Eloquent\Collection CustomerAccount
 * @property \Illuminate\Database\Eloquent\Collection LandlordRemittance
 * @property \Illuminate\Database\Eloquent\Collection Lease
 * @property \Illuminate\Database\Eloquent\Collection Property
 * @property \Illuminate\Database\Eloquent\Collection PropertyListing
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection User
 * @property string full_name
 * @property string national_id
 * @property string gender
 * @property string phone_number
 * @property string email
 * @property string b_role
 * @property integer created_by
 * @property integer client_id
 */
class Customer extends Model
{
    use SoftDeletes;

    public $table = 'masterfiles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'full_name',
        'national_id',
        'gender',
        'phone_number',
        'email',
        'b_role',
        'created_by',
        'client_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'full_name' => 'string',
        'national_id' => 'string',
        'gender' => 'string',
        'phone_number' => 'string',
        'email' => 'string',
        'b_role' => 'string',
        'created_by' => 'integer',
        'client_id' => 'integer'
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
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function customerAccounts()
    {
        return $this->hasMany(\App\Models\CustomerAccount::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function landlordRemittances()
    {
        return $this->hasMany(\App\Models\LandlordRemittance::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function leases()
    {
        return $this->hasMany(\App\Models\Lease::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function properties()
    {
        return $this->hasMany(\App\Models\Property::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function propertyListings()
    {
        return $this->hasMany(\App\Models\PropertyListing::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
