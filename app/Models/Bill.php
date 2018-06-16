<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bill
 * @package App\Models
 * @version June 16, 2018, 1:38 pm EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection BillDetail
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer lease_id
 * @property integer tenant_id
 * @property integer property_id
 * @property string description
 * @property string ref_number
 * @property float total
 */
class Bill extends Model
{
    use SoftDeletes;

    public $table = 'bills';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'lease_id',
        'tenant_id',
        'property_id',
        'description',
        'ref_number',
        'total'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'lease_id' => 'integer',
        'tenant_id' => 'integer',
        'property_id' => 'integer',
        'description' => 'string',
        'ref_number' => 'string',
        'total' => 'float'
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
    public function billDetails()
    {
        return $this->hasMany(\App\Models\BillDetail::class);
    }
}
