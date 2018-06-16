<?php

namespace App\Repositories;

use App\Models\ServiceOption;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ServiceOptionRepository
 * @package App\Repositories
 * @version June 15, 2018, 11:09 am EAT
 *
 * @method ServiceOption findWithoutFail($id, $columns = ['*'])
 * @method ServiceOption find($id, $columns = ['*'])
 * @method ServiceOption first($columns = ['*'])
*/
class ServiceOptionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status',
        'created_by',
        'client_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ServiceOption::class;
    }
}
