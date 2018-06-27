<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CustomerMessage
 * @package App\Models
 * @version June 22, 2018, 12:33 pm EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection leases
 * @property \Illuminate\Database\Eloquent\Collection roleRoute
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string phone_number
 * @property string name
 * @property bigInteger user_id
 * @property bigInteger tenant_id
 * @property bigInteger schedule_id
 * @property bigInteger days
 * @property bigInteger loan_id
 * @property string message_type
 * @property boolean sent
 * @property string message
 * @property string|\Carbon\Carbon execution_time
 */
class CustomerMessage extends Model
{
    use SoftDeletes;

    public $table = 'customer_messages';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'phone_number',
        'name',
        'user_id',
        'tenant_id',
        'schedule_id',
        'days',
        'loan_id',
        'message_type',
        'sent',
        'message',
        'execution_time',
        'message_id',
        'smsCount',
        'status',
        'delivery_checked',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone_number' => 'string',
        'name' => 'string',
        'message_type' => 'string',
        'sent' => 'boolean',
        'message' => 'string',
        'delivery_checked' => 'boolean',
        'status' => 'string',
        'message_id' => 'string',
        'smsCount' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
