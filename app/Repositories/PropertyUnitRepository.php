<?php

namespace App\Repositories;

use App\Models\PropertyUnit;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PropertyUnitRepository
 * @package App\Repositories
 * @version June 14, 2018, 11:26 am EAT
 *
 * @method PropertyUnit findWithoutFail($id, $columns = ['*'])
 * @method PropertyUnit find($id, $columns = ['*'])
 * @method PropertyUnit first($columns = ['*'])
*/
class PropertyUnitRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'property_id',
        'unit_number',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PropertyUnit::class;
    }
}
