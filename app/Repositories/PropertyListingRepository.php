<?php

namespace App\Repositories;

use App\Models\PropertyListing;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PropertyListingRepository
 * @package App\Repositories
 * @version July 13, 2018, 11:34 am EAT
 *
 * @method PropertyListing findWithoutFail($id, $columns = ['*'])
 * @method PropertyListing find($id, $columns = ['*'])
 * @method PropertyListing first($columns = ['*'])
*/
class PropertyListingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'seller_id',
        'property_type_id',
        'location',
        'description',
        'price',
        'sale_commission',
        'status',
        'created_by'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PropertyListing::class;
    }
}
