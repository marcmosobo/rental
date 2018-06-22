<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Masterfile
 * @package App\Models
 * @version May 17, 2018, 5:33 pm EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection User
 * @property string full_name
 * @property string gender
 * @property string email
 * @property string phone_number
 * @property string role_id
 * @property string address
 * @property string national_id
 * @property bigInteger created_by
 */
class Masterfile extends Model
{
    use SoftDeletes;

    public $table = 'masterfiles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'full_name',
        'gender',
        'email',
        'phone_number',
        'role_id',
        'address',
        'national_id',
        'created_by',
        'client_id',
        'b_role'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'full_name' => 'string',
        'gender' => 'string',
        'email' => 'string',
        'phone_number' => 'string',
        'role_id' => 'string',
        'address' => 'string',
        'national_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
