<?php

namespace App\Repositories;

use App\Models\CustomerMessage;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CustomerMessageRepository
 * @package App\Repositories
 * @version June 22, 2018, 12:33 pm EAT
 *
 * @method CustomerMessage findWithoutFail($id, $columns = ['*'])
 * @method CustomerMessage find($id, $columns = ['*'])
 * @method CustomerMessage first($columns = ['*'])
*/
class CustomerMessageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        'execution_time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CustomerMessage::class;
    }
}
