<?php

namespace App\Repositories;

use App\Models\PropertyType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PropertyTypeRepository
 * @package App\Repositories
 * @version July 13, 2018, 11:18 am EAT
 *
 * @method PropertyType findWithoutFail($id, $columns = ['*'])
 * @method PropertyType find($id, $columns = ['*'])
 * @method PropertyType first($columns = ['*'])
*/
class PropertyTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PropertyType::class;
    }
}
