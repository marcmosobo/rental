<?php

namespace App\Repositories;

use App\Models\Property;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PropertyRepository
 * @package App\Repositories
 * @version June 14, 2018, 10:17 am EAT
 *
 * @method Property findWithoutFail($id, $columns = ['*'])
 * @method Property find($id, $columns = ['*'])
 * @method Property first($columns = ['*'])
*/
class PropertyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'code',
        'location',
        'property_type',
        'units',
        'landlord_id',
        'created_by',
        'client_id',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Property::class;
    }
}
