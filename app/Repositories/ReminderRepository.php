<?php

namespace App\Repositories;

use App\Models\Reminder;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ReminderRepository
 * @package App\Repositories
 * @version May 18, 2018, 10:01 am EAT
 *
 * @method Reminder findWithoutFail($id, $columns = ['*'])
 * @method Reminder find($id, $columns = ['*'])
 * @method Reminder first($columns = ['*'])
*/
class ReminderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'days',
        'time',
        'message'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Reminder::class;
    }
}
