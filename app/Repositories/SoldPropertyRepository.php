<?php

namespace App\Repositories;

use App\Models\SoldProperty;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SoldPropertyRepository
 * @package App\Repositories
 * @version July 13, 2018, 12:42 pm EAT
 *
 * @method SoldProperty findWithoutFail($id, $columns = ['*'])
 * @method SoldProperty find($id, $columns = ['*'])
 * @method SoldProperty first($columns = ['*'])
*/
class SoldPropertyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'listing_id',
        'buyer_id',
        'amount_bought',
        'commission_percentage',
        'commission_charged',
        'less_commission'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SoldProperty::class;
    }
}
