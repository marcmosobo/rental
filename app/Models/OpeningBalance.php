<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OpeningBalance
 * @package App\Models
 * @version July 14, 2018, 11:28 am EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection propertyListings
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer landlord_id
 * @property float opening_balance
 */
class OpeningBalance extends Model
{
    use SoftDeletes;

    public $table = 'opening_balances';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'landlord_id',
        'opening_balance'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'landlord_id' => 'integer',
        'opening_balance' => 'float'
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
