<?php

namespace App\Repositories;

use App\Models\EventMessage;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EventMessageRepository
 * @package App\Repositories
 * @version June 18, 2018, 10:43 am EAT
 *
 * @method EventMessage findWithoutFail($id, $columns = ['*'])
 * @method EventMessage find($id, $columns = ['*'])
 * @method EventMessage first($columns = ['*'])
*/
class EventMessageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'event',
        'code',
        'message',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EventMessage::class;
    }
}
